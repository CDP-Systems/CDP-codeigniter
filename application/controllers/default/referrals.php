<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Referral controller for user view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-05-04
 */
class Referrals extends MY_Controller {

    protected $_form_data;

    function __construct()
    {
        parent::__construct();

        // Load the model and assign it to "referrals" object.
        $this->load->model('default/m_referrals', 'referrals');
    }

    // --------------------------------------------------------------------

    /**
     * Default action.
     */
    function index($page = 0)
    {
        $this->view_data['page'] = 'default/referrals/edit'; 

        $this->_prep_form_values('referrals_new_form');

        if ($this->input->post('submit'))
        {
            // Try to save the form.
            if ($this->_save('referrals_new_form', $this->referrals))
            {
                $this->session->set_flashdata('message', 'Referral form successfully sent.');
        
                // Send email to admin and person.
                $this->load->helper('cs_emails');
                
                send_email_template('referrals_patient_email', $this->_form_data['referral_email'], null, $this->_form_data);
                send_email_template('referrals_admin_email', $this->get_setting('referrals_email_recipient'), null, $this->_form_data);                

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

        // Display the form.
        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);                	  
    }
}
/* End of file referrals.php */
/* Location: ./application/controllers/default/referrals.php */
