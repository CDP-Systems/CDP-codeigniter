<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter extends MY_Controller{
	
	function __construct(){
		parent::__construct();
                
	}

	function index() {
		$this->load->helper('text');
		$this->load->model('admin/M_website');		
		$this->load->model('default/M_newsletter');
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->get_current_module(); 
		//get page data
		$page = $this->get_page();
                
		//set page data
		if(count($page)){ 
			$data['url_key'] = $url_key;
			$data['class'] = $page['class']; 
			$data['sitename'] = $website['name'];
			$data['title'] = $page['page_title'];
			$data['newsletters'] = $this->M_newsletter->get_all();
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
		}
		else{
			//Page Not Found
			redirect('Page_not_found');
		}
		//parse template
        	$data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
	}
	
	function unsubscribe_form(){
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->get_current_module(); 
		//get page data
		$page = $this->get_page();
                
		//set page data
		if(count($page)){ 
			$data['url_key'] = $url_key;
			$data['class'] = $page['class']; 
			$data['sitename'] = $website['name'];
			$data['title'] = $page['page_title'];
			$data['content'] = $page['content'];
			$data['page'] = 'default/newsletter/newsletter_form_unsubscribe';
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
		}
		else{
			//Page Not Found
			redirect('Page_not_found');
		}
		//parse template
        	$data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
	}
	
	function view($id){ 
		$this->load->helper('text');
		$this->load->model('admin/M_website');
		$this->load->model('default/M_page');
		$this->load->model('default/M_newsletter');
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->uri->segment(1); 
		
		//get page data
		$page = $this->M_page->get($url_key);
		//set page data
		if(count($page)){
			$data['url_key'] = $url_key;
			$data['class'] = $page['class'];
			$data['sitename'] = $website['name'];
			$data['title'] = $page['page_title'];
			$data['newsletter'] = $this->M_newsletter->get($id);
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
			//Page Not Found
			redirect('Page_not_found');
		}
		//parse template
		
        $data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
	}
	
	function subscribe($subscription_key = ''){ 
		//load objects
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->helper('security');
		$this->load->model('admin/M_website');
		$this->load->model('default/M_page');
		$this->load->model('admin/M_transactional_emails');
		$this->load->model('admin/M_administrator');
		$this->load->model('default/M_subscribers');
		$this->load->model('default/m_settings');
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->get_current_module(); 
		//get page data
		$page = $this->M_page->get($url_key);
		//if subscription came from the email, goto subscribe
		if(!empty($subscription_key)){
			$subscriber = $this->M_subscribers->getBySubscriptionKey($subscription_key);
			if(count($subscriber)){
				$email = $subscriber['email'];
				//-OPTIONAL-
				//NOTE:The goto operator is available as of PHP 5.3.
				//check phpinfo() if the version is 5.3 or higher, just comment out the goto next to this line.
				//goto subscribe; 
				$this->subscribeAgain($email, $_POST);
			}else{
				die( 'Hack attempt.' );
			}
		}else{
			$email = $this->input->post('email');
		}
		//validate email
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		if ($this->form_validation->run() == FALSE)
		{
			//set page data
			$data['url_key'] = $url_key;
			$data['class'] = $page['class'];
			$data['sitename'] = $website['name'];
			$data['title'] = $page['page_title'];
			$data['keywords'] = $page['keywords'];
			$data['desc'] = $page['desc'];
			$data['robots'] = $website['meta_robots'];
			$data['page'] = 'default/newsletter/newsletter_failed';
			$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
			
			//set global meta data if page meta data is blank
			if($page['keywords'] == ''){
				$data['keywords'] = $website['default_metakeywords'];
			}
			if($page['desc'] == ''){
				$data['desc'] = $website['default_metadesc'];
			}   
			
			//parse template
			$data = array_merge($data, $this->view_data);
			$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
		}
		else
		{
			//subscribe:
			//get transactional emails
			$subscription = $this->M_transactional_emails->get('subscription');
			
			$closing = $this->m_settings->get('global_email_footer')->setting_value;
			$subscription_msg = str_replace('%%CLOSING%%', $closing, $subscription['message']);
			
			
			//get admin data
			$admin = $this->M_administrator->getSuperAdmin();
			//save subscriber into database
			$subscriberExists = $this->M_subscribers->getByEmail($email);
			if(count($subscriberExists)){
				if($subscriberExists['active'] == 1){
					redirect($url_key.'/subscriber_exists');
				}else{
					$this->M_subscribers->subscribe($subscriberExists['subscription_key']);
					$subscriber = $subscriberExists;
				}	
			}else{
				$_POST['subscription_key'] = do_hash($email);
				$this->M_subscribers->insert($_POST);
				$subscriber_insert_id = $this->db->insert_id();
				$subscriber = $this->M_subscribers->get($subscriber_insert_id);
			}
			
			 //get admin email
                        $admin_email = $this->m_settings->get('admin_outgoing_email')->setting_value;
                        $email_sender_from = ($admin_email) ? $admin_email : 'no-reply@'.strtolower(preg_replace('/\s/', '-',$website['name']));
                        
			//send subscription email
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($email_sender_from, $website['name']);
			$this->email->to($email);
			$this->email->subject('['.$website['name'].'] Newsletter Confirmation');
			$this->email->message($subscription_msg);
			$this->email->send();
			//redirect page
			redirect($url_key.'/success');
		}
	}
	
	function subscribeAgain($email, $post){
			$this->load->model('default/m_settings');
			
			//get sitename
			$sitename = $this->M_website->getName();
			//get transactional emails
			$subscription = $this->M_transactional_emails->get('subscription');
			//get admin data
			$admin = $this->M_administrator->getSuperAdmin();
			//save subscriber into database
			$subscriberExists = $this->M_subscribers->getByEmail($email);
			if(count($subscriberExists)){
				if($subscriberExists['active'] == 1){
					redirect('newsletter/subscriber_exists');
				}else{
					$this->M_subscribers->subscribe($subscriberExists['subscription_key']);
					$subscriber = $subscriberExists;
				}	
			}else{
				$_POST['subscription_key'] = do_hash($email);
				$this->M_subscribers->insert($post);
				$subscriber_insert_id = $this->db->insert_id();
				$subscriber = $this->M_subscribers->get($subscriber_insert_id);
			}
			//send subscription email
			$closing = $this->m_settings->get('global_email_footer')->setting_value;
			$subscription_msg = str_replace('%%CLOSING%%', $closing, $subscription['message']);
			
			//get admin email
			$this->load->model('admin/M_administrator');
                        $admin_email = $this->m_settings->get('admin_outgoing_email')->setting_value;
                        $email_sender_from = ($admin_email) ? $admin_email : 'no-reply@'.strtolower(preg_replace('/\s/', '-',$sitename));
                        
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($email_sender_from, $sitename);
			$this->email->to($email);
			$this->email->subject('['.$sitename.'] Newsletter Confirmation');
			$this->email->message($subscription_msg);
			
			$this->email->send();
			//redirect page
			redirect('newsletter/success');
	}
	
	function success(){
		//load objects
		$this->load->model('admin/M_website');
		$this->load->model('default/M_page');
		//get url key
		$url_key = $this->uri->segment(1); 
		//get page data
		$page = $this->M_page->get($url_key);
		//get site data
		$website = $this->M_website->getWebsite();
		//set page data
		$data['url_key'] = $url_key;
		$data['class'] = $page['class'];
		$data['sitename'] = $website['name'];
		$data['title'] = $page['page_title'];
		$data['keywords'] = $page['keywords'];
		$data['desc'] = $page['desc'];
		$data['robots'] = $website['meta_robots'];
		$data['page'] = 'default/newsletter/newsletter_success';
		$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
		
		//set global meta data if page meta data is blank
		if($page['keywords'] == ''){
			$data['keywords'] = $website['default_metakeywords'];
		}
		if($page['desc'] == ''){
			$data['desc'] = $website['default_metadesc'];
		}   
			
		//parse template
        $data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
	}
	
	function unsubscribe($subscription_key = NULL){
		//load objects
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->helper('security');
		$this->load->model('admin/M_website');
		$this->load->model('admin/M_transactional_emails');
		$this->load->model('admin/M_administrator');
		$this->load->model('default/M_subscribers');
		$this->load->model('default/M_page');
		$this->load->model('default/m_settings');
		//get site data
		$website = $this->M_website->getWebsite();
		//get admin data
		$admin = $this->M_administrator->getSuperAdmin();
		//get url key
		$url_key = $this->uri->segment(1); 
		//get page data
		$page = $this->M_page->get($url_key);
		
		//get subscription key
		if($_POST){
		
			$subscriber = $this->M_subscribers->getByEmail($this->input->post('email'));
			
		}else{
		
			$subscriber = $this->M_subscribers->getBySubscriptionKey($subscription_key);
		}
		
		//validate email
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		if ($this->form_validation->run()){
		
			//get transactional emails
			$unsubscription = $this->M_transactional_emails->get('unsubscription');
			//send unsubscription email
			if(count($subscriber)){
				if($subscriber['active'] == 1){
					$this->M_subscribers->unsubscribe($subscriber['subscription_key']);
					$email = $subscriber['email'];
					
					$closing = $this->m_settings->get('global_email_footer')->setting_value;
					$unsubscription_msg = str_replace('%%CLOSING%%', $closing, $unsubscription['message']);
					$unsubscription_msg = str_replace('%%EMAIL%%', $email, $unsubscription_msg);
					$unsubscription_msg = str_replace('%%SITE_URL%%', base_url().index_page(), $unsubscription_msg);
					$unsubscription_msg = str_replace('%%KEY%%', $subscriber['subscription_key'], $unsubscription_msg);
					
                                        //get admin email
                                        $admin_email = $this->m_settings->get('admin_outgoing_email')->setting_value;
                                        $email_sender_from = ($admin_email) ? $admin_email : 'no-reply@'.strtolower(preg_replace('/\s/', '-',$website['name']));
		
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
					$this->email->from($email_sender_from, $website['name']);
					$this->email->to($email);
					$this->email->subject('['.$website['name'].'] Newsletter Unsubscription');
					//$this->email->message("Newsletter unsubscription success");
					$this->email->message($unsubscription_msg);
					$this->email->send();
					
					$data['page'] = 'default/newsletter/newsletter_unsubscription';
				}else{
					$data['page'] = 'default/newsletter/newsletter_unsubscription_invalid.php';
				}
				
			}else{
				//die(' Hack attempt. ');
				$data['page'] = 'default/newsletter/newsletter_unsubscription_invalid.php';
			}
			
			
		
		}else{
			$data['page'] = 'default/newsletter/newsletter_unsubscription_failed.php';
		}
		
		//set page data
		$data['url_key'] = $url_key;
		$data['class'] = $page['class'];
		$data['sitename'] = $website['name'];
		$data['title'] = $page['page_title'];
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
			
		//parse template
        $data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
	}
	
	function subscriber_exists(){
		//load objects
		$this->load->model('admin/M_website');
		$this->load->model('default/M_page');
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->uri->segment(1); 
		//get page data
		$page = $this->M_page->get($url_key);
		//set page data
		$data['url_key'] = $url_key;
		$data['class'] = $page['class'];
		$data['sitename'] = $website['name'];
		$data['title'] = $page['page_title'];
		$data['keywords'] = $page['keywords'];
		$data['desc'] = $page['desc'];
		$data['robots'] = $website['meta_robots'];
		$data['page'] = 'default/newsletter/newsletter_subscriber_exists';
		$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
		
		//set global meta data if page meta data is blank
		if($page['keywords'] == ''){
			$data['keywords'] = $website['default_metakeywords'];
		}
		if($page['desc'] == ''){
			$data['desc'] = $website['default_metadesc'];
		}   
			
		//parse template
        $data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
	}
	
	
	
}

/* End of file newsletter.php */
/* Location: ./application/controllers/default/newsletter.php */