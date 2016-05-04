<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Referrals extends MY_Controller {

    // Holds values of form fields.
    protected $_form_data;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('default/m_referrals', 'referrals');       
    }

    // --------------------------------------------------------------------

    /**
    * Default action, lists all referrals created.
    */
    function index()
    {
        $this->view_data['content'] = 'admin/referrals/list';

        $referrals = $this->referrals->fetch_all();

        if ($referrals->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['total_rows'] = $referrals->num_rows();
            $pagination['per_page'] = 10;

            $this->paginate($pagination);

            $results = $this->referrals->fetch_all(10, $page);

            $this->view_data['referrals'] = $results->result();
        }

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
    * View single referrals item.
    */
    function view($referral_id = NULL)
    {
        $referral = $this->referrals->get($referral_id);

        if (is_null($referral_id) || $referral == FALSE)
        {
            redirect ('admin/referrals/');
        }       

        $this->view_data['content'] = 'admin/referrals/view';

        $this->view_data = array_merge($this->view_data, (array) $referral);

        $this->parser->parse('admin/template', $this->view_data);
    }
    
    // --------------------------------------------------------------------

    /**
    * Add a single referrals item.
    */
    function add()
    {
        $this->view_data['content'] = 'admin/referrals/edit';

        $this->_prep_form_values('referrals_edit_form');

        if ($this->input->post('submit'))
        {
            if ($this->_save('referrals_edit_form', $this->referrals))
            {
                $this->session->set_flashdata('message', 'referrals item added!');

                redirect (current_url());
            }
        }
        
        $this->parser->parse('admin/template', $this->view_data);
    }    

    // --------------------------------------------------------------------

    /**
     * Set email settings on this page.
     *
     */
    function email_settings()
    {
        $this->load->model('default/m_settings');
                
        $referrals_email_recipient = $this->m_settings->get('referrals_email_recipient');
        // Email content.
        $referrals_patient_email = $this->m_settings->get('referrals_patient_email');
        $referrals_admin_email   = $this->m_settings->get('referrals_admin_email');
        // Email Subject.
        $referrals_patient_email_subject = $this->m_settings->get('referrals_patient_email_subject');
        $referrals_admin_email_subject   = $this->m_settings->get('referrals_admin_email_subject');

        $this->view_data['sitename'];
                
        $data['referrals_email_recipient'] = set_value('referrals_email_recipient', $referrals_email_recipient->setting_value);

        $data['referrals_patient_email']         = set_value('referrals_patient_email', $referrals_patient_email->setting_value);
        $data['referrals_patient_email_subject'] = set_value('referrals_patient_email_subject', $referrals_patient_email_subject->setting_value);

        $data['referrals_admin_email']         = set_value('referrals_admin_email', $referrals_admin_email->setting_value);
        $data['referrals_admin_email_subject'] = set_value('referrals_admin_email_subject', $referrals_admin_email_subject->setting_value);

        $this->require_validation();

        $this->form_validation->set_rules('referrals_email_recipient', 'Email Recipient', 'required|valid_emails');
        $this->form_validation->set_rules('referrals_patient_email', 'Referral email', 'required');
        $this->form_validation->set_rules('referrals_patient_email_subject', 'Referral email subject', 'required');
        $this->form_validation->set_rules('referrals_admin_email', 'Admin email', 'required');
        $this->form_validation->set_rules('referrals_admin_email_subject', 'Admin email subject',  'required');

        if ($this->input->post('submit') == 'Save')
        {
            if ($this->form_validation->run() && $this->m_settings->save_settings($data))
            {
                $this->session->set_flashdata('message', 'Settings saved!');

                redirect ('admin/referrals/email_settings');
            }
        }
        
        $this->view_data['content'] = 'admin/referrals/email_settings';
        //parse template
        $this->view_data = array_merge($this->view_data, $data);

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Deletes a row/rows from the referrals table.
     *
     * @param mixed $id ID.
     */
    function delete($id)
    {
    	if($id != ''){
	        if ($this->referrals->delete($id))
	        {
	            $this->session->set_flashdata('message', 'Referral successfully deleted.');
	        }
	        else
	        {
	            $this->session->set_flashdata('message', 'Could not delete the referral. Please contact the administrator.');
	        }
	}else{
        	$this->session->set_flashdata('message', '<span style="color:red;">No Referral(s) selected.</span>');
        }
        redirect('admin/referrals/');
    }

    // --------------------------------------------------------------------

    /**
     * Export to CSV.
     *
     */
	function export()
    {
        $this->load->helper('csv');
		$website = $this->website_data['name'];
		$query = $this->db->get('contact_us');
		query_to_csv($query, TRUE, $website.'-referrals.csv');
	}

    // --------------------------------------------------------------------

    /**
     * Control action for bulk selections.
     */
    function action()
    {
        $referrals = $this->input->post('referrals');

        $action = $this->input->post('selectAction');

        $this->$action($referrals);
    }
}

/* End of file referrals.php */
/* Location: ./application/controllers/admin/referrals.php */
