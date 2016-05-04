<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_us extends MY_Controller{

	function __consctruct(){
		parent::__construct();
        $this->require_validation();
	}
	
	function index()
    {
		//load objects
		$this->load->helper('text');
		$this->load->model('admin/M_website');
		$this->load->model('default/M_page');
		$this->load->model('default/M_newsletter');
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = end($this->uri->segment_array()); 
		//get page data
		$page = $this->M_page->get($url_key);
		//session start
		session_start();

        // Check if recaptcha has been enabled in admin settings.
        if ($this->get_setting('contact_us_enable_captcha')->setting_value)
        {            
            $this->view_data['recaptcha'] = $this->load->view('recaptcha', array('recaptcha'=> $this->recaptcha->get_html()), TRUE);
        }
        

		//set page data
		if(count($page)){ 
			$url_key = $this->view_data['url_key'];
			$data['class'] = $page['class'];
			$data['sitename'] = $website['name'];
			$data['title'] = $page['page_title'];
			$data['content'] = $page['content'];
			$data['page'] = 'default/page/inner_page';
			$data['keywords'] = $page['keywords'];
			$data['desc'] = $page['desc'];
			$data['robots'] = $website['meta_robots'];
			$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
			if(isset($_SESSION['contact_msg_sent'])){
				$data['contact_msg_sent'] = $_SESSION['contact_msg_sent']; 
				unset($_SESSION['contact_msg_sent']);
			}
			
			//set global meta data if page meta data is blank
			if($page['keywords'] == ''){
				$data['keywords'] = $website['default_metakeywords'];
			}
			if($page['desc'] == ''){
				$data['desc'] = $website['default_metadesc'];
			}
		}
		else{
			//Page Not Found
			redirect('Page_not_found');
		}

		//parse template
        $data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);		
	}

	function send(){
		//load objects
		$this->load->model('default/m_settings');
        $this->require_validation();
		$this->load->library('email');
		$this->load->helper('text');
		$this->load->model('admin/M_transactional_emails');
		$this->load->model('admin/M_administrator');
		$this->load->model('admin/M_website');
		$this->load->model('default/M_page');
		$this->load->model('default/M_newsletter');
		$this->load->model('default/M_contact_us');

		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->view_data['url_key'];
		//get page data
		$page = $this->M_page->get($url_key);
		//session start
		session_start();
		//validate form
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('number', 'Number', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('time_to_contact', 'Time to Contact', 'required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
        // Check if recaptcha has been enabled in admin settings.
        if ($this->get_setting('contact_us_enable_captcha')->setting_value) 
        {
            $this->form_validation->set_rules('recaptcha_response_field', 'lang:recaptcha_field_name', 'required|callback_check_captcha');
            $this->view_data['recaptcha'] = $this->load->view('recaptcha', array('recaptcha'=> $this->recaptcha->get_html()), TRUE);
        }

		if($this->form_validation->run() == FALSE){
			//set page data
				$data['url_key'] = $url_key; 
				$data['class'] = $page['class'];
				$data['sitename'] = $website['name'];
				$data['title'] = $page['page_title'];
				$data['content'] = $page['content'];
				$data['page'] = 'default/page/inner_page';
				$data['keywords'] = $page['keywords'];
				$data['desc'] = $page['desc'];
				$data['robots'] = $website['meta_robots'];
				$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
				
				//set global meta data if page meta data is blank
				if($page['keywords'] == ''){
					$data['keywords'] = $website['default_metakeywords'];
				}
				if($page['desc'] == ''){
					$data['desc'] = $website['default_metadesc'];
				}
		}else{
			//insert contact log
			$this->M_contact_us->insert($_POST);
			//get admin data
			$admin = $this->M_administrator->getSuperAdmin();
			//get transactional emails
			$email_recipient = $this->m_settings->get('contact_us_email_recipient');
			$email_confirmation = $this->m_settings->get('contact_us_email_confirmation');
			$email_confirmation_subj = $this->m_settings->get('contact_us_email_confirmation_subject');
			$email_admin_notification = $this->m_settings->get('contact_us_admin_notificaion');
			$email_admin_notification_subj = $this->m_settings->get('contact_us_admin_notificaion_subject');
			//send contact us email
			
			//get admin email
                        $admin_email = $this->m_settings->get('admin_outgoing_email')->setting_value;
                        $email_sender_from = ($admin_email) ? $admin_email : 'no-reply@'.strtolower(preg_replace('/\s/', '-',$website['name']));
                        
			//for sender
			$closing = $this->m_settings->get('global_email_footer')->setting_value;
			$email_sender_subj = $email_confirmation_subj->setting_value;
			$email_sender_msg = $email_confirmation->setting_value;
			$email_sender_msg = str_replace('%%NAME%%', $this->input->post('name'), $email_sender_msg);
   			$email_sender_msg = str_replace('%%CLOSING%%', $closing, $email_sender_msg);
   		
			$this->email->clear();
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
                        $this->email->from($email_sender_from, $website['name']);
			$this->email->to($this->input->post('email'));
			$this->email->bcc('jamaica@creatingskies.com');
			$this->email->subject('['.$website["name"].'] ' . $email_sender_subj);
			$this->email->message($email_sender_msg);
			$this->email->send();
			
			
			//for administrator
			$admin_notif_from = 'no-reply@'.strtolower(preg_replace('/\s/', '-',str_replace(',','',$website['name'])));
			$admin_notif_subj = $email_admin_notification_subj->setting_value;
			$admin_notif_msg = str_replace('%%NAME%%', $this->input->post('name') ,$email_admin_notification->setting_value);
			$admin_notif_msg = str_replace('%%SPECIALTY%%', $this->input->post('specialty'), $admin_notif_msg);
			$admin_notif_msg = str_replace('%%NUMBER%%', $this->input->post('number'), $admin_notif_msg);
			$admin_notif_msg = str_replace('%%EMAIL%%', $this->input->post('email'), $admin_notif_msg);
			$admin_notif_msg = str_replace('%%TIME_TO_CONTACT%%', $this->input->post('time_to_contact'), $admin_notif_msg);
			$admin_notif_msg = str_replace('%%MESSAGE%%', $this->input->post('message') , $admin_notif_msg);
   			$admin_notif_msg = str_replace('%%CLOSING%%', $closing, $admin_notif_msg);
   			
			
			$this->email->clear();
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
                        $this->email->from($email_sender_from, $website['name']);
			$this->email->to($email_recipient->setting_value);
			$this->email->bcc('jamaica@creatingskies.com');
			$this->email->subject('['.$website["name"].'] '. $admin_notif_subj);
			$this->email->message($admin_notif_msg);
			$this->email->send();
			//redirect page
			$_SESSION['contact_msg_sent'] = TRUE;
			redirect($url_key);
		}
		//parse template
        $data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
	}
	
	
}


/* End of file contact_us.php */
/* Location: ./application/controllers/default/contact_us.php */