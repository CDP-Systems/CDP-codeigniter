<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Appointment controller for admin view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-05-24
 */
class Appointment extends MY_Controller {

    protected $_form_data;

    function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->model('default/m_appointment', 'appointments');
        
        $this->view_data['title'] = 'Appointment Manager';        
    }

    // --------------------------------------------------------------------

    /**
     * Default action. List all appointment requests.
     */
    function index()
    {
        $appointments = $this->appointments->fetch_all();
        
        $this->view_data['content'] = 'admin/appointment/list';        

        if ($appointments->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['total_rows'] = $appointments->num_rows();

            $this->paginate($pagination);

            $results = $this->appointments->fetch_all(10, $page);

            $this->view_data['appointments'] = $results->result();
        }

    	$this->parser->parse('admin/template', $this->view_data);         
    }

    // --------------------------------------------------------------------
    
    /**
     * View.
     */
    function view($id = null)
    {
        if (is_null($id) || !$appointment = $this->appointments->get($id))
        {
            show_error('Invalid or no id specified');
        }
        
        $this->view_data['content'] = 'admin/appointment/view';
        
        $this->view_data = array_merge($this->view_data, (array) $appointment);
        
    	$this->parser->parse('admin/template', $this->view_data);        
    }

    // --------------------------------------------------------------------

    /**
     * Set email settings on this page.
     *
     */
    function email_settings()
    {
        $appointment_email_recipient = $this->get_setting('appointment_email_recipient')->setting_value;
        // Email content.
        $appointment_patient_confirmation = $this->get_setting('appointment_patient_confirmation')->setting_value;
        $appointment_admin_notification   = $this->get_setting('appointment_admin_notification')->setting_value;
        // Email Subject.
        $appointment_patient_confirmation_subject = $this->get_setting('appointment_patient_confirmation_subject');
        $appointment_admin_notification_subject   = $this->get_setting('appointment_admin_notification_subject')->setting_value;

        $data['appointment_email_recipient'] = set_value('appointment_email_recipient', $appointment_email_recipient);

        $data['appointment_patient_confirmation'] = set_value('appointment_patient_confirmation', $appointment_patient_confirmation);
        $data['appointment_admin_notification'] = set_value('appointment_admin_notification', $appointment_admin_notification);

        $data['appointment_admin_notification_subject'] = set_value('appointment_admin_notification_subject', $appointment_admin_notification_subject);
        $data['appointment_patient_confirmation_subject'] = set_value('appointment_patient_confirmation_subject', $appointment_patient_confirmation_subject);

        $this->require_validation();

        $this->form_validation->set_rules('appointment_email_recipient', 'Email Recipient', 'required|valid_emails');
        $this->form_validation->set_rules('appointment_patient_confirmation', 'Patient Email', 'required');
        $this->form_validation->set_rules('appointment_patient_confirmation_subject', 'Patient email subject', 'required');
        $this->form_validation->set_rules('appointment_admin_notification', 'Admin email', 'required');
        $this->form_validation->set_rules('appointment_admin_notification_subject', 'Admin email subject',  'required');

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

                redirect ('admin/appointment/email_settings');
            }
        }
        
        $this->view_data['content'] = 'admin/appointment/email_settings';
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
	        if ($this->appointments->delete($id))
	        {
	            $message = 'Appointment/s successfully deleted.';
	        }
	        else
	        {
	            $message = 'Could not delete the appointment. Please contact the administrator.';
	        }
        }else{
        	$message = '<span style="color:red;">No Appointment(s) selected.</span>';
        }
        if ($this->isAjax())
        {
            echo $message; exit();
        }
        else
        {
            $this->session->set_flashdata('message', $message);
            redirect('admin/appointment/index');
        }
    }                  
    
    // --------------------------------------------------------------------
    
    /**
     * Control action for bulk selctions.
     */
    function action()
    {
        $data = $this->input->post('data');

        $action = $this->input->post('selectAction');
	
	if (trim($action) == '')
	{
		$action = 'index';
	}
	
        $this->$action($data);
    }          
    
    // --------------------------------------------------------------------
}
/* End of file appointment.php */
/* Location: ./application/controllers/admin/appointment.php */