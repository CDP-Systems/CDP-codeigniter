<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in'))redirect('admin/login');

        $this->require_validation();
		$this->load->helper('cs_dropdown');
		$this->load->helper('security');
		$this->load->model('admin/M_administrator');
		$this->load->model('admin/M_website');
                
		session_start();
	}
	
	function index()
    {
        $this->load->helper('cs_dropdown');

		//set page data
		$data['title']        = 'Admin Settings';
		$data['admin']        = $this->M_administrator->getAdmin($this->session->userdata('id_admin'));
		$data['website']      = $this->website_data;
		$data['sitename']     = (count($data['website'])? $data['website']['name']: '');
        $data['email_footer'] = $this->get_setting('global_email_footer');
		$data['content']      = 'admin/administrator/administrator';               
		$data['saved']        = $this->session->flashdata('saved');
		
        // Merge the settings array so we have automatic access to all settings.
        $data = array_merge($data, $this->get_settings());
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function save(){
		
		if(!$_POST){
			redirect('admin/administrator');
			exit();
		}
		
		$settings = array();
		
		$this->form_validation->set_rules('sitename', 'Site Name', 'required');
		$this->form_validation->set_rules('admin_name', 'Administrator\'s Name', 'required');
		$this->form_validation->set_rules('admin_email', 'Administrator\'s Email', 'required|valid_email');
		$this->form_validation->set_rules('admin_outgoing_email', 'Outgoing Email Sender Address', 'required|valid_email');
		if ($this->form_validation->run() == FALSE){ 
			//parse template
			$this->parser->parse('admin/template', $this->setPageData());
			
		}else{
		
			if($this->session->userdata('super_admin')) 
			{
				//templates
				$settings['home_template'] = $this->input->post('home_template');
				$settings['inner_template'] = $this->input->post('inner_template');
				
					$settings['global_email_footer'] = $this->input->post('global_email_footer');
					
					
					// Seminar settings.            
					$settings['seminars_show_full']       = $this->input->post('seminars_show_full');
					$settings['seminars_show_ended']      = $this->input->post('seminars_show_ended');		    		    
					$settings['seminars_enable_captcha']  = $this->input->post('seminars_enable_captcha');
					
					// Online Seminar settings.            		    		    
					$settings['online_seminars_enable_captcha']  = $this->input->post('online_seminars_enable_captcha');
		
					// Contact Us settings.
					$settings['contact_us_enable_captcha']  = $this->input->post('contact_us_enable_captcha');
		
					// Calendar settings.
					$settings['calendar_enable_recurring_events']  = $this->input->post('calendar_enable_recurring_events');
					
					// Appointment settings.
					$settings['appointment_enable_captcha']  = $this->input->post('appointment_enable_captcha');            
					
					// Page manager settings.
					$settings['page_enable_scratchpad']  = $this->input->post('page_enable_scratchpad'); 
					
					// Appointment settings.
					$settings['testimonials_enable_captcha']  = $this->input->post('testimonials_enable_captcha');   
			}
			
			// Outgoing Email Sender Address settings.
			$settings['admin_outgoing_email']  = $this->input->post('admin_outgoing_email');  
			
			//LOGO UPLOAD
			$uploadError = FALSE;
			if($_FILES['site_logo']['name'] != ''){ 
				$uploaded_logo = $this->upload_logo();
				if(isset($uploaded_logo['error'])){
					$uploadError = TRUE;
				}
			}
			
			if($uploadError){  
				$logo_error = $uploaded_logo['error'];
				$this->parser->parse('admin/template', $this->setPageData($logo_error, $settings));
			}else{
			
				$_POST['site_logo'] = (isset($uploaded_logo['data']))? $uploaded_logo['data']['file_name'] : $_POST['site_logo'];
				
				if($this->M_administrator->updateAdmin($_POST, $this->session->userdata('id_admin')) && $this->M_website->updateWebsite($_POST))
				{             
					
					$this->m_settings->save_settings($settings);
				
					$this->session->set_flashdata('saved', TRUE);
					//redirect page
					redirect('admin/administrator');
				}
			}
		}
	}	

	function setPageData($logo_error = '', $settings = NULL){
		//set page data
		$data['title'] = 'Admin Settings';
		$data['admin'] = $this->M_administrator->getAdmin($this->session->userdata('id_admin'));
		$data['website'] = $this->M_website->getWebsite();
		$data['content'] = 'admin/administrator/administrator';
		$data['sitename'] = (count($data['website'])? $data['website']['name']: '');
		$data['logo_error'] = $logo_error; 

			if($settings) $data = array_merge($settings, $data);
			// Merge the settings array so we have automatic access to all settings.
        	$data = array_merge($data, $this->get_settings());
			
		return $data;
	}
	
	function password(){
		//set page data
		$data['title'] = 'Change Password';
		$data['admin'] = $this->M_administrator->getAdmin($this->session->userdata('id_admin'));
		$data['sitename'] = $this->M_website->getName();
		$data['content'] = 'admin/administrator/administrator_password';
		
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function change_password(){
		$this->form_validation->set_rules('old_password', 'Old password', 'required|xss_clean|callback_oldPasswordCheck');
		$this->form_validation->set_rules('new_password', 'New password', 'required|min_length[7]|xss_clean|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|min_length[7]|xss_clean');
		if($this->form_validation->run() == FALSE){
			//set page data
			$data['title'] = 'Change Password';
			$data['admin'] = $this->M_administrator->getAdmin($this->session->userdata('id_admin'));
			$data['sitename'] = $this->M_website->getName();
			$data['content'] = 'admin/administrator/administrator_password';
			
			//parse template
			$this->parser->parse('admin/template', $data);
		}else{
			if($this->M_administrator->changePassword($_POST['id_admin'], do_hash($_POST['new_password']))){
				//redirect page
				$this->session->set_flashdata('saved', TRUE);
				redirect('admin/administrator');	
			}
		}
	}
	
	function oldPasswordCheck($submitted_pass){
		$old_pass = $this->M_administrator->getPassword($this->input->post('id_admin'));
		if($old_pass == do_hash($submitted_pass)){
			return TRUE;
		}else{
			$this->form_validation->set_message('oldPasswordCheck', 'The %s field is wrong.');
			return FALSE;
		}
	}
	
	function upload_logo(){
		$config['upload_path'] = str_replace('system/','',BASEPATH).'uploads/admin/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '2048';
		$config['max_width']  = '350';
		$config['max_height']  = '90';
		$config['file_name'] = 'logo';
		$config['overwrite'] = TRUE;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('site_logo')){
			$logo = array('error' => $this->upload->display_errors('<div class="red">','</div>'));
		}
		else{
			$logo = array('data' => $this->upload->data());
		}
		return $logo;
	}
	
	function remove_logo(){
		$website = $this->M_website->getWebsite();
		if($this->M_website->removeLogo($website['id_website'])){
			$filePath = str_replace('system/','',BASEPATH).'uploads/admin/'.$website['site_logo'];
			if(file_exists($filePath)){
				if(is_file($filePath)){
					unlink($filePath);
					$this->session->set_flashdata('saved', TRUE);
				}
			}
		}
		redirect('admin/administrator');
	}
	
	function modules()
	{
	    // Allow access to super_admin only.
		if(!$this->session->userdata('super_admin')) {redirect('admin');}

        $this->load->model('default/m_modules', 'modules');
		
		//set page data
		$data['title'] = 'Module Settings';
		$data['admin'] = $this->M_administrator->getAdmin($this->session->userdata('id_admin'));
		$data['sitename'] = $this->M_website->getName();
		$data['content'] = 'admin/administrator/modules';
		$data['modules'] = $this->modules->fetch_all()->result();
		
		//parse template
		$this->parser->parse('admin/template', $data);	
	}
	
	function toggle_module($id = null)
	{
	    $this->load->model('default/m_modules', 'module');

	    if (is_null($id) || !$module = $this->module->get($id))
	    {
	        show_error('Invalid or no ID specified');
	    }
	    
	    if ($module->activated == 1)
	    {
	        $toggle = 0;
	    }
	    else
	    {
	        $toggle = 1;
	    }
	    
	    if ($this->module->do_save(array ($this->module->get_primary_key() => $id, 'activated' => $toggle)))
	    {
	        $this->session->set_flashdata('message', ucwords($module->url_key) . ' module status updated');
	    }
	    
	    redirect ('admin/administrator/modules');
	}	
	
}


/* End of file administrator.php */
/* Location: ./application/controllers/admin/administrator.php */