<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Virtual_consultation controller for user view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-05-24
 */
class Virtual_consultation extends MY_Controller {

    protected $_form_data;

    function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
    }

    // --------------------------------------------------------------------

    /**
     * Default action. Virtual_consultation form.
     */
    function index()
    {
        $this->load->helper('cs_dropdown');    
        
        $this->_prep_form_values('validation_consultation_form');

        // Check if recaptcha has been enabled in admin settings.
        if ($this->get_setting('virtual_consultation_enable_captcha')->setting_value)
        {            
            $this->view_data['recaptcha'] = $this->load->view('recaptcha', array('recaptcha'=> $this->recaptcha->get_html()), TRUE);
            // Add captcha validation to config.
            enable_recaptcha('validation_consultation_form');
        }
        
        if ($this->input->post('submit') || $this->isAjax())
        {
            $this->load->model('default/m_virtual_consultation');
            
            $id = $this->_save('validation_consultation_form', $this->m_virtual_consultation);
            
            if ($id)
            {
//                // Send email to admin and person.
                $this->load->helper('cs_emails');
                
                // Send email to admin.
                send_email_template('virtual_consultation_admin_notification', $this->get_setting('virtual_consultation_email_recipient')->setting_value, null, $this->_form_data, TRUE);
                // Send email to patient.
                send_email_template('virtual_consultation_patient_confirmation',$this->_form_data['email'], null, $this->_form_data);                
            
                if ($this->isAjax())
                {
                    echo $id;
                    exit();
                }
                
                $this->session->set_flashdata('message', 'Your virtual consultation request has been submitted.');
                
                redirect (current_url());            
            }
        }
        
        $url_key = $this->get_current_module();
        $this->load->model('default/M_page'); 
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
        
        $this->view_data['page'] = 'default/virtual_consultation/edit';

    	$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
    }

    // --------------------------------------------------------------------
}
/* End of file virtual_consultation.php */
/* Location: ./application/controllers/default/virtual_consultation.php */