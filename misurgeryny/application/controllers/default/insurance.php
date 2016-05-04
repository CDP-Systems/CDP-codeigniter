<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Insurance controller for user view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-06-09
 */
class Insurance extends MY_Controller {

    protected $_form_data;

    function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
    }

    // --------------------------------------------------------------------

    /**
     * Default action. Insurance verification form.
     */
    function index()
    {
        $this->load->helper('cs_dropdown');    
                           
	$this->_prep_form_values('validation_insurance_verification_form');    

        if ($this->input->post('submit') || $this->isAjax())
        {
            $this->load->model('default/m_insurance');
            
            $id = $this->_save('validation_insurance_verification_form', $this->m_insurance);
            
            if ($id)
            {
                // Send email to admin and person.
                $this->load->helper('cs_emails');
                
                if($this->_form_data['have_insurance'] == 1) {
                	$have_insurance = 'Yes';
                }else {
                	$have_insurance = 'No';
                }
                
                $this->_form_data['have_insurance'] = $have_insurance;
                // Send email to admin.
                $this->_form_data['date'] = date('F d, Y');
                
                send_email_template('insurance_admin_notification', $this->get_setting('insurance_email_recipient')->setting_value, null, $this->_form_data);
                // Send email to patient.
                send_email_template('insurance_patient_confirmation',$this->_form_data['email'], null, $this->_form_data);                
            
                if ($this->isAjax())
                {
                    echo $id;
                    exit();
                }
                
                $this->session->set_flashdata('message', 'Your insurance verification request has been submitted.');
                
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
        	                     
                           
	$this->view_data['page'] = 'default/insurance/edit';

    	$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
    }

    // --------------------------------------------------------------------
}
/* End of file insurance.php */
/* Location: ./application/controllers/default/insurance.php */