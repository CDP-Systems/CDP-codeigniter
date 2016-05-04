<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ask_the_expert extends MY_Controller{

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
        if ($this->get_setting('ask_the_expert_enable_captcha')->setting_value)
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
			if(isset($_SESSION['msg_sent'])){
				$data['msg_sent'] = $_SESSION['msg_sent']; 
				unset($_SESSION['msg_sent']);
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
		$this->load->model('default/M_ask_the_expert', 'AskTheExpert');

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
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('subject', 'Subject', 'required|xss_clean');
		$this->form_validation->set_rules('question', 'Question', 'trim|required');
        // Check if recaptcha has been enabled in admin settings.
        if ($this->get_setting('ask_the_expert_enable_captcha')->setting_value) 
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
			//insert log
			$this->AskTheExpert->insert($_POST);
			//get admin data
			$admin = $this->M_administrator->getSuperAdmin();
			//get transactional emails
			$email_recipient = $this->m_settings->get('ask_the_expert_email_recipient');
			$email_confirmation = $this->m_settings->get('ask_the_expert_email_confirmation');
			$email_confirmation_subj = $this->m_settings->get('ask_the_expert_email_confirmation_subject');
			$email_admin_notification = $this->m_settings->get('ask_the_expert_admin_notificaion');
			$email_admin_notification_subj = $this->m_settings->get('ask_the_expert_admin_notificaion_subject');
			//send email
			
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
			$this->email->subject('['.$website["name"].'] ' . $email_sender_subj);
			$this->email->message($email_sender_msg);
			$this->email->send();
			

			//for administrator
			$admin_notif_from = 'no-reply@'.strtolower(preg_replace('/\s/', '-',str_replace(',','',$website['name'])));
			$admin_notif_subj = $email_admin_notification_subj->setting_value;
			$admin_notif_msg = str_replace('%%NAME%%', $this->input->post('name') ,$email_admin_notification->setting_value);
			$admin_notif_msg = str_replace('%%EMAIL%%', $this->input->post('email'), $admin_notif_msg);
			$admin_notif_msg = str_replace('%%SUBJECT%%', $this->input->post('subject'), $admin_notif_msg);
			$admin_notif_msg = str_replace('%%QUESTION%%', $this->input->post('question'), $admin_notif_msg);
   			$admin_notif_msg = str_replace('%%CLOSING%%', $closing, $admin_notif_msg);
			
			$this->email->clear();
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($email_sender_from, $website['name']);
			$this->email->to($email_recipient->setting_value);
			$this->email->subject('['.$website["name"].'] '. $admin_notif_subj);
			$this->email->message($admin_notif_msg);
			$this->email->send();
			//redirect page
			$_SESSION['contact_msg_sent'] = TRUE;
			
			/*get true link*/
			$this->load->library('CS_Url_Tree', null, 'tree');
			$this->tree->clear();
			$this->tree->id_page = $this->view_data['id_page'];
			$link = $this->tree->get_link();
			
			$this->session->set_flashdata('msg_sent', 'Your question was submitted and will be responded to as soon as possible. Thank you.');
			redirect($link);
		}
		//parse template
        $data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
	}
	
	
}


/* End of file ask_the_expert.php */
/* Location: ./application/controllers/default/ask_the_expert.php */