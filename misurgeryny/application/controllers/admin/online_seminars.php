<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Online_seminars extends MY_Controller {    

    // Holds values of form fields.
    protected $_form_data;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('default/m_online_seminars', 'seminars');
        $this->load->model('default/m_online_seminar_attendees', 'seminar_attendees');

        $this->load->helper('cs_dropdown');
    }

    // --------------------------------------------------------------------

    /**
     * Default action, lists all available seminars.
     */
    function index()
    {
		/*As of now, Online seminar has only one record, 
		thats why we have to redirect the index page into edit seminar*/
		redirect('admin/online_seminars/edit/1'); exit();
		
		
        //$this->view_data['content'] = 'admin/online_seminars/list';

        $seminars = $this->seminars->fetch_all_admin();

        if ($seminars->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['total_rows'] = $seminars->num_rows();            

            $this->paginate($pagination);

            $results = $this->seminars->fetch_all_admin(10, $page);

            $this->view_data['seminars'] = $results->result();
        }

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Create a new seminar.
     */
    function add()
    {
        $this->view_data['content'] = 'admin/online_seminars/edit';

        $this->_prep_form_values('validation_online_seminar_form');
		
        if ($this->input->post('submit'))
        {
			
            if ($this->_save_seminar())
            {
                $this->session->set_flashdata('message', 'Online seminar has been saved.');

                redirect (current_url());
            }
        }

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Edit a single seminar.
     */
    function edit()
    {
        $this->view_data['content'] = 'admin/online_seminars/edit';

        $seminar = $this->seminars->get($this->uri->segment(4));        

        $this->view_data['seminar_id'] = $seminar->seminar_id;
        $this->_form_data['seminar_id'] = $seminar->seminar_id;

        $this->_prep_form_values('validation_online_seminar_form', $seminar);

        if ($this->input->post('submit'))
        {	

            if ($this->_save('validation_online_seminar_form', $this->seminars))
            {
                $this->session->set_flashdata('message', 'Online seminar has been saved.');

                redirect (current_url());
            }
        }

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * View records of seminar attendees.
     */
    function logs()
    {
        $this->view_data['content'] = 'admin/online_seminars/log';

        $attendees = $this->seminar_attendees->get_all_attendee_seminar();

        if ($attendees->num_rows() > 0)
        {
        
            $page = $this->uri->segment(4);

            $pagination['total_rows'] = $attendees->num_rows();            

            $this->paginate($pagination);

            $results = $this->seminar_attendees->get_all_attendee_seminar(10, $page);
            

            $this->view_data['attendees'] = $results->result();
        }       

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * View an attendees record.
     */
    function view_attendee($id)
    {
        $this->view_data['content'] = 'admin/online_seminars/view_attendee';
        $attendee = $this->seminar_attendees->get_attendee_seminar($id);

        $this->view_data['attendee'] = (array) $attendee->row();

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Deletes a row/rows from the seminars table.
     *
     * @param mixed $id ID.
     */
    function delete_seminar($id)
    {
        if ($this->seminars->delete($id))
        {
            $this->session->set_flashdata('message', 'Online seminar(s) successfully deleted.');
        }
        else
        {
            $this->session->set_flashdata('message', 'Could not delete the online seminar. Please contact the administrator.');
        }

        redirect('admin/online_seminars/index');
    }

    // --------------------------------------------------------------------

    /**
     * Deletes a row/rows from the seminar attendees table.
     *
     * @param mixed $id ID.
     */
    function delete_attendee($id)
    {
    	if($id != ''){
	        if ($this->seminar_attendees->delete($id))
	        {
	            $this->session->set_flashdata('message', 'Attendees(s) successfully deleted.');
	        }
	        else
	        {
	            $this->session->set_flashdata('message', 'Could not delete the attendee. Please contact the administrator.');
	        }
        }else{
        	$this->session->set_flashdata('message', '<span style="color:red;">No Seminar Log(s) selected.</span>');
        }

        redirect('admin/online_seminars/logs');
    }

    function email_settings()
    {
        $this->load->model('default/m_settings');

        $seminars_email_recipient = $this->m_settings->get('online_seminars_email_recipient');
        // Email content.
        $seminars_patient_confirmation = $this->m_settings->get('online_seminars_email_patient');
        $seminars_admin_notification = $this->m_settings->get('online_seminars_email_admin');
        // Email Subject.
        $seminars_patient_confirmation_subject = $this->m_settings->get('online_seminars_email_patient_subject');
        $seminars_admin_notification_subject = $this->m_settings->get('online_seminars_email_admin_subject');
        
        $this->_form_data['online_seminars_email_recipient'] = set_value('online_seminars_email_recipient', $seminars_email_recipient->setting_value);

        $this->_form_data['online_seminars_email_patient'] = set_value('online_seminars_email_patient', $seminars_patient_confirmation->setting_value);
        $this->_form_data['online_seminars_email_patient_subject'] = set_value('online_seminars_email_patient_subject', $seminars_patient_confirmation_subject->setting_value);
       
        $this->_form_data['online_seminars_email_admin'] = set_value('online_seminars_email_admin', $seminars_admin_notification->setting_value);
        $this->_form_data['online_seminars_email_admin_subject'] = set_value('online_seminars_email_admin_subject', $seminars_admin_notification_subject->setting_value);

        $this->view_data = array_merge($this->view_data, $this->_form_data);

        if ($this->input->post('submit') == 'Save')
        {
            $this->load->config('validations');

            $this->require_validation($this->config->item('online_seminars_email_settings'));

            if ($this->form_validation->run())
            {
                if ($this->m_settings->save_settings($this->_form_data))
                {
                    $this->session->set_flashdata('message', 'Settings saved!');

                    redirect ('admin/online_seminars/email_settings');
                }
            }
        }

        $this->view_data['content'] = 'admin/online_seminars/email_settings';
        //parse template
        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Save form data after validation.
     *
     * @return bool
     */
    private function _save_seminar()
    {
        // Load fields from config.
        $this->load->config('validations');
        $config = $this->config->item('validation_online_seminar_form');

        $this->require_validation($config);

        if ($this->form_validation->run())
        {
            $this->seminars->do_save($this->_form_data);

            return TRUE;
        }

        return FALSE;
    }
	
	
	function action($record){ 
		$uri_4 = $this->input->post('uri_4');
		$failCtr = 0;
		$successCtr = 0;
		
		$post_data = ($record == 'seminars') ? $this->input->post('seminars'): $this->input->post('seminar_attendees');
		$redirect = ($record == 'seminars') ? 'index' : 'logs';
		
		if(!$post_data){
			$_SESSION['noSelected'] = TRUE;
			$this->session->set_flashdata('message', '<span style="color:red;">No Seminar Log(s) selected.</span>');
		}else{
			switch($this->input->post('selectAction')){
				case 'delete':
					//DELETE
					$_SESSION['action'] = 1;
					foreach($post_data as $row){
						
						if($record == 'seminars'){
						
							if(!$this->seminars->delete($row)){
								$failCtr++;
								$this->session->set_flashdata('message', $failCtr . " seminar(s) failed to delete.");
							}else{
								$successCtr++;
								$this->session->set_flashdata('message', $successCtr . " seminar(s) successfully deleted.");
							}
						
						}else{
						
							if(!$this->seminar_attendees->delete($row)){
								$failCtr++;
								$this->session->set_flashdata('message', $failCtr . " seminar attendees(s) failed to delete.");
							}else{
								$successCtr++;
								$this->session->set_flashdata('message', $successCtr . " seminar attendees(s) successfully deleted.");
							}
							
						}
						
					}
					break;
					
			}
		}
		redirect('admin/online_seminars/'.$redirect.'/'.$uri_4);
	}
	
	function export(){
		$this->load->helper('csv');
		$website = $this->M_website->getName();
		$sql = "SELECT l.*, s.title AS 'seminar title', s.link AS 'seminar url' FROM ci_online_seminar_attendees l LEFT JOIN ci_online_seminars s
			ON l.seminar_id = s.seminar_id";
		$query = $this->db->query($sql);
		query_to_csv($query, TRUE, $website.'-Online-Seminar-Log.csv');
	}
}

/* End of file seminars.php */
/* Location: ./application/controllers/admin/seminars.php */
