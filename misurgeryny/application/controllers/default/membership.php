<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membership extends MY_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('default/m_membership', 'membership');
    }
	
	function index()
    {
		$exemptedMember = FALSE;
		
		if($_POST){
			// Check if recaptcha has been enabled in admin settings.
			if ($this->get_setting('membership_enable_captcha')->setting_value) 
			{
				$this->form_validation->set_rules('recaptcha_response_field', 'lang:recaptcha_field_name', 'required|callback_check_captcha');
			}
			
			$this->_form_data['specialty'] = ($this->input->post('specialty_other')) ? $this->input->post('specialty_other'): $this->input->post('specialty');
			
			if($this->input->post('specialty') == 'Student' || $this->input->post('specialty') == 'Fellow' || $this->input->post('specialty') == 'Resident'){
				$exemptedMember = TRUE;
				$this->_form_data['paid'] = 1;
			}
			
			/*form submit*/
			$this->_prep_form_values('validation_membership');
			if ($this->_save('validation_membership', $this->membership))
            {
				/*SEND EMAIL NOTIFICATIONS*/
                $this->load->helper('cs_emails'); 
				$mail_data = $this->_form_data;
				
				// Send an email to the registrant.
                $sent = send_email_template(
                   'membership_email',
                    $this->_form_data['email'],
                    $this->get_setting('membership_email_subject'), 
                    $mail_data
                );
				
				// Send email to admin.
                send_email_template(
					'membership_email_admin', 
					$this->get_setting('membership_email_recipient'), 
					$this->get_setting('membership_email_admin_subject'), 
					$mail_data
				);
				
				if($sent){
					$this->session->set_flashdata('message', '<div class="green bold">Registration successful.</div>');
					
					if($exemptedMember){
						redirect(current_url());
					}else{
						redirect(current_url().'/payment');
					}
					exit();
				}
            }
		}
		
		// Check if recaptcha has been enabled in admin settings.
        if ($this->get_setting('membership_enable_captcha')->setting_value)
        {            
            $this->view_data['recaptcha'] = $this->load->view('recaptcha', array('recaptcha'=> $this->recaptcha->get_html()), TRUE);
        }
        
        $this->load->model('default/M_page');
        $url_key = $this->get_current_module(); 
	$page = $this->M_page->get($url_key);
	$this->load->model('admin/M_website');
	$website = $this->M_website->getWebsite();
	
	$this->view_data['robots'] = $website['meta_robots'];
	$this->view_data['keywords'] = $page['keywords'];
	$this->view_data['desc'] = $page['desc'];
	
	//set global meta data if page meta data is blank
	if($page['keywords'] == ''){
		$this->view_data['keywords'] = $website['default_metakeywords'];
	}
	if($page['desc'] == ''){
		$this->view_data['desc'] = $website['default_metadesc'];
	}
		
		$this->load->helper('cs_dropdown');
		$this->load->model('default/M_states');
		$this->view_data['states'] = state_dropdown();
		$this->view_data['page'] = 'default/page/inner_page'; 
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
		
	}
	
	public function payment(){
		
		$this->view_data['content'] = '';
		$this->view_data['page'] = 'default/page/inner_page'; 
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
		
	}
	

	
	
}