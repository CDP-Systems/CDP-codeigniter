<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testimonials extends MY_Controller {

    // Count number of pending so we can display.
    public $pending_testimonials;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('default/m_testimonials');

        $this->pending_testimonials = $this->m_testimonials->fetch_all_pending()->num_rows();
    }

    function index()
    {
        $data['content'] = 'admin/testimonials/list';
        $data['title'] = 'Testimonials Manager';

        $testimonials = $this->m_testimonials->fetch_all_approved();

        if ($testimonials->num_rows() > 0)
        {
            $page = $this->uri->segment(4);
            
            $pagination['total_rows'] = $testimonials->num_rows();

            $this->paginate($pagination);

            $results = $this->m_testimonials->fetch_all_approved(10, $page);

            $data['testimonials'] = $results->result();
        }
        $data['sitename'] = $this->view_data['sitename'];
        //parse template
        $this->parser->parse('admin/template', $data);
    }

    /**
     * Action for adding a new testimonial.
     */
    function add()
    {
        if ($this->input->post('submit') == 'Save')
        {
            // Redirect so we can show the message, @TODO: redirect somewhere else.            
            if ($this->_save_testimonial())
            {
                redirect ('admin/testimonials/');
                exit();
            }
        }
        
        $data['sitename'] = $this->view_data['sitename'];
        // Use set_value to retrieve the post data instead of form->input, for security.        
        $data['first_name'] = set_value('first_name');
        $data['last_name']  = set_value('last_name');
        $data['body']       = set_value('body');
        $data['email']      = set_value('email');

        $data['status']['pending']  = set_select('status', '1');
        $data['status']['approved'] = set_select('status', '2');

        $data['publish'][0]  = set_select('publish', '0');
        $data['publish'][1]  = set_select('publish', '1');

        //set page data
        $data['title'] = 'Add Testimonial';
        $data['content'] = 'admin/testimonials/edit';
                
        //parse template
        $this->parser->parse('admin/template', $data);
    }

    /**
     * Edit testimonial.
     */
    function edit($id)
    {        
        if ($this->input->post('submit') == 'Save')
        {
            // Redirect so we can show the message, @TODO: redirect somewhere else.
            if ($this->_save_testimonial())
            {
                redirect ('admin/testimonials/edit/' . $id);
                exit();
            }
        }
        $testi = $this->m_testimonials->get($id);

        $data['sitename'] = $this->view_data['sitename'];
        // Use set_value to retrieve the post data instead of form->input, for security.
        $data['first_name'] = set_value('first_name', $testi->first_name);
        $data['last_name']  = set_value('last_name', $testi->last_name);
        $data['body']       = set_value('body', $testi->body);
        $data['email']      = set_value('email', $testi->email);
        
        $data['status']['pending']  = set_select('status', '1', $testi->status);
        $data['status']['approved'] = set_select('status', '2', $testi->status);
        
        $data['publish'][0]  = set_select('publish', '0', $testi->publish);
        $data['publish'][1]  = set_select('publish', '1', $testi->publish);

        $data['testi_id'] = $id;
        
        //set page data
        $data['title'] = 'Edit Testimonial';
        $data['content'] = 'admin/testimonials/edit';

        //parse template
        $this->parser->parse('admin/template', $data);
    }

    function email_settings()
    {
        $this->load->model('default/m_settings');
                
        $testimonials_email_recipient = $this->m_settings->get('testimonials_email_recipient');
        // Email content.
        $testimonials_patient_confirmation = $this->m_settings->get('testimonials_patient_confirmation');
        $testimonials_patient_approval = $this->m_settings->get('testimonials_patient_approval');
        $testimonials_admin_notification = $this->m_settings->get('testimonials_admin_notification');
        // Email Subject.
        $testimonials_patient_confirmation_subject = $this->m_settings->get('testimonials_patient_confirmation_subject');
        $testimonials_patient_approval_subject = $this->m_settings->get('testimonials_patient_approval_subject');
        $testimonials_admin_notification_subject = $this->m_settings->get('testimonials_admin_notification_subject');

        $data['sitename'] = $this->view_data['sitename'];
        
        $data['title'] = 'Testimonial Manager | Email settings';
        $data['testimonials_email_recipient'] = set_value('testimonials_email_recipient', $testimonials_email_recipient->setting_value);

        $data['testimonials_patient_confirmation'] = set_value('testimonials_patient_confirmation', $testimonials_patient_confirmation->setting_value);
        $data['testimonials_patient_confirmation_subject'] = set_value('testimonials_patient_confirmation_subject', $testimonials_patient_confirmation_subject->setting_value);

        $data['testimonials_patient_approval'] = set_value('testimonials_patient_approval', $testimonials_patient_approval->setting_value);
        $data['testimonials_patient_approval_subject'] = set_value('testimonials_patient_approval_subject', $testimonials_patient_approval_subject->setting_value);

        $data['testimonials_admin_notification'] = set_value('testimonials_admin_notification', $testimonials_admin_notification->setting_value);
        $data['testimonials_admin_notification_subject'] = set_value('testimonials_admin_notification_subject', $testimonials_admin_notification_subject->setting_value);

        if ($this->input->post('submit') == 'Save')
        {
            if ($this->m_settings->save_settings($data))
            {
                $this->session->set_flashdata('message', 'Settings saved!');

                redirect ('admin/testimonials/email_settings');
            }
        }
        
        $data['content'] = 'admin/testimonials/email_settings';
        //parse template
        $this->parser->parse('admin/template', $data);
    }

    /**
     * Lists all pending testimonials.
     */
    function pending()
    {
        $data['sitename'] = $this->view_data['sitename'];
        $data['title'] = 'Pending Testimonials';
        $data['content'] = 'admin/testimonials/pending';

        $testimonials = $this->m_testimonials->fetch_all_pending();

        if ($testimonials->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['uri_segment'] = 4;
            $pagination['total_rows'] = $testimonials->num_rows();

            $this->paginate($pagination);

            $results = $this->m_testimonials->fetch_all_pending(10, $page);

            $data['testimonials'] = $results->result();
        }

        //parse template
        $this->parser->parse('admin/template', $data);
    }

    /**
     * Deletes a row/rows from the testimonials table.
     *
     * @param int $id Testimonial ID.
     */
    function delete($id)
    {        
    	if($id != ''){
	        if ($this->m_testimonials->delete($id))
	        {
	            $this->session->set_flashdata('message', 'Testimonial/s successfully deleted.');
	        }
	        else
	        {
	            $this->session->set_flashdata('message', 'Could not delete the testimonial. Please contact the administrator.');
	        }
        }else{
		$this->session->set_flashdata('message', '<p class="red bold">No testimonial(s) selected.</p>');
	}
        
        redirect('admin/testimonials/');
    }

    /**
     * Approve a pending testimonial.
     *
     * @param int $id
     */
    function approve($id)
    {
        if (!is_array($id))
        {
            $id = array($id);
        }

        $this->m_testimonials->approve_testimonials($id);
        // Send email to person/s.
        $this->load->helper('cs_emails');

        foreach ($id as $value)
        {
            $testi = $this->m_testimonials->get($value);


            if (!send_email_template('testimonials_patient_approval', $testi->email , null, (array) $testi))
            {
                show_error('mailer error:' . $this->email->print_debugger());
            } 
        }

        // Auto-publish depending on configuration.
        if ($this->config->item('testimonial_auto_publish'))
        {
            $this->publish($id);
            exit();
        }

        $this->session->set_flashdata('message', 'Testimonial/s approved.');

        redirect ('admin/testimonials'); 
    }

    /**
     * Publish an approved testimonial.
     *
     * @param int $id
     */
    function publish($id)
    {
        $this->m_testimonials->publish_testimonials($id);

        $this->session->set_flashdata('message', 'Testimonial/s successfully published.');

        redirect ('admin/testimonials');
    }

    /**
     * Unpublish a previously published testimonial.
     *
     * @param int $id
     */
    function unpublish($id)
    {
        $this->m_testimonials->unpublish_testimonials($id);

        $this->session->set_flashdata('message', 'Testimonial/s successfully unpublished.');

        redirect ('admin/testimonials');
    }

    /**
     * Saves form data. 
     *
     * @return Boolean TRUE on success
     */
    private function _save_testimonial()
    {
        $this->require_validation();

        // Sanitize and validate.
        $this->form_validation->set_rules('body', 'Message', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean');
        $this->form_validation->set_rules('first_name', 'First name', 'trim|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last name', 'trim|xss_clean');
        // Use the hidden input field which contains the name of the FILE to validate.
        $this->form_validation->set_rules('field_before_picture', 'Before picture', 'callback_handle_file_upload');
        $this->form_validation->set_rules('field_after_picture', 'After picture', 'callback_handle_file_upload');

        if ($this->form_validation->run()) {
            $this->load->model('default/m_testimonials');

            $id = $this->m_testimonials->get_primary_key();

            if ($this->input->post($id) > 0)
            {
                $form_data[$id] = $this->input->post($id);
            }

            $form_data['first_name'] = $this->input->post('first_name');
            $form_data['last_name']  = $this->input->post('last_name');
            $form_data['body']       = $this->input->post('body');
            $form_data['email']      = $this->input->post('email');
            $form_data['status']     = $this->input->post('status');
            $form_data['publish']    = $this->input->post('publish');

            if (trim($this->session->userdata('file_before_picture')) != '')
            {
                $form_data['before_picture'] = $this->session->userdata('file_before_picture');
            }

            if (trim($this->session->userdata('file_after_picture')) != '')
            {
                $form_data['after_picture']  = $this->session->userdata('file_after_picture');
            }

            // Save to the database.
            if ($this->m_testimonials->do_save($form_data))
            {
                $message = 'Testimonal saved!';

                // Unset the filenames.
                $this->session->unset_userdata('file_before_picture');
                $this->session->unset_userdata('file_after_picture');
                $this->session->set_flashdata('message', $message);

                return TRUE;
            }
            else
            {
                $message = 'Failed to save the testimonial. Please contact the administrators.';
                $this->session->set_flashdata('message', $message);

                return FALSE;
            }            
        }

        return FALSE;
    }

    /**
     * Control action for bulk selections.
     */
    function action()
    {
        $testimonials = $this->input->post('testimonials');

        $action = $this->input->post('selectAction');

        $this->$action($testimonials);
    }
}

/* End of file testimonials.php */
/* Location: ./application/controllers/admin/testimonials.php */
