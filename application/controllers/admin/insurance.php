<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Appointment controller for admin view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-05-24
 */
class Insurance extends MY_Controller {

    protected $_form_data;

    function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('csv');
        $this->load->model('default/m_insurance', 'insurance');
        
        $this->view_data['title'] = 'Insurance Manager';        
    }

    // --------------------------------------------------------------------

    /**
     * Default action. List all appointment requests.
     */
    function index()
    {
        $insurances = $this->insurance->fetch_all();
        
        $this->view_data['content'] = 'admin/insurance/list';        

        if ($insurances->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['total_rows'] = $insurances->num_rows();

            $this->paginate($pagination);

            $results = $this->insurance->fetch_all(10, $page);

            $this->view_data['insurances'] = $results->result();
        }

    	$this->parser->parse('admin/template', $this->view_data);         
    }

    // --------------------------------------------------------------------
    
    /**
     * View.
     */
    function view($id = null)
    {
        if (is_null($id) || !$insurance = $this->insurance->get($id))
        {
            show_error('Invalid or no id specified');
        }
        
        $this->view_data['content'] = 'admin/insurance/view';
        
        $this->view_data = array_merge($this->view_data, (array) $insurance);
        
    	$this->parser->parse('admin/template', $this->view_data);        
    }

    // --------------------------------------------------------------------

    /**
     * Set email settings on this page.
     *
     */
    function email_settings()
    {
        $insurance_email_recipient = $this->get_setting('insurance_email_recipient')->setting_value;
        // Email content.
        $insurance_patient_confirmation = $this->get_setting('insurance_patient_confirmation')->setting_value;
        $insurance_admin_notification   = $this->get_setting('insurance_admin_notification')->setting_value;
        // Email Subject.
        $insurance_patient_confirmation_subject = $this->get_setting('insurance_patient_confirmation_subject');
        $insurance_admin_notification_subject   = $this->get_setting('insurance_admin_notification_subject')->setting_value;

        $data['insurance_email_recipient'] = set_value('insurance_email_recipient', $insurance_email_recipient);

        $data['insurance_patient_confirmation'] = set_value('insurance_patient_confirmation', $insurance_patient_confirmation);
        $data['insurance_admin_notification'] = set_value('insurance_admin_notification', $insurance_admin_notification);

        $data['insurance_admin_notification_subject'] = set_value('insurance_admin_notification_subject', $insurance_admin_notification_subject);
        $data['insurance_patient_confirmation_subject'] = set_value('insurance_patient_confirmation_subject', $insurance_patient_confirmation_subject);

        $this->require_validation();

        $this->form_validation->set_rules('insurance_email_recipient', 'Email Recipient', 'required|valid_emails');
        $this->form_validation->set_rules('insurance_patient_confirmation', 'Patient Email', 'required');
        $this->form_validation->set_rules('insurance_patient_confirmation_subject', 'Patient email subject', 'required');
        $this->form_validation->set_rules('insurance_admin_notification', 'Admin email', 'required');
        $this->form_validation->set_rules('insurance_admin_notification_subject', 'Admin email subject',  'required');

        if ($this->input->post('submit') == 'Save' || $this->isAjax())
        {
            if ($this->form_validation->run() && $this->m_settings->save_settings($data))
            {
                if ($this->isAjax())
                {
                    echo "1";
                    exit();
                }
                
                $this->session->set_flashdata('message', 'Settings saved!');

                redirect ('admin/insurance/email_settings');
            }
        }
        
        $this->view_data['content'] = 'admin/insurance/email_settings';
        //parse template
        $this->view_data = array_merge($this->view_data, $data);

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------
    
    /**
     * Delete
     */
    function delete($id)
    {
	if($id != ''){
	        if ($this->insurance->delete($id))
	        {
	            $message = 'Insurance verification request/s successfully deleted.';
	        }
	        else
	        {
	            $message = 'Could not delete the insurance request. Please contact the administrator.';
	        }
	}else{
        	$message = '<span style="color:red;">No Insurance Verification Request(s) selected.</span>';
        }
        if ($this->isAjax())
        {
            echo $message; exit();
        }
        else
        {
            $this->session->set_flashdata('message', $message);
            redirect('admin/insurance/index');
        }
    }               
    
    // --------------------------------------------------------------------
    
    /**
     * Control action for bulk selections.
     */
    function action()
    {
        $insurances = $this->input->post('insurances');

        $action = $this->input->post('selectAction');

	if (trim($action) == '')
	{
		$action = 'index';
	}

        $this->$action($insurances);
    }       
    
    // --------------------------------------------------------------------
    /**
     * Export data
     */
    function export(){
		$website = $this->M_website->getName();
		$query = $this->db->get('insurance');
		query_to_csv($query, TRUE, $website.'-Insurance.csv');
	}
}
/* End of file insurance.php */
/* Location: ./application/controllers/admin/insurance.php */