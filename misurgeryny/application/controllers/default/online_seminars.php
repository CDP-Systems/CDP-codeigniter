<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Online_seminars extends MY_Controller {

    protected $_form_data;

    function __construct()
    {
        parent::__construct();

        $this->load->helper('form');

        // Load the model and assign it to "seminars" object.
        $this->load->model('default/m_online_seminars', 'seminars');
    }

    // --------------------------------------------------------------------

    /**
     * Default action. This action displays all seminars which are available.
     */
    function index($page = 0)
    {
        $this->display($page);
    }

    // --------------------------------------------------------------------

    function display($page = 0)
    {
		/*As of now, Online seminar has only one record, 
		thats why we have to set the index page into register page*/
		
		$this->register(1);
    }

    // --------------------------------------------------------------------
    
    /**
     * Registration page.
     */
    function register($seminar_id = null)
    { 
        if (is_null($seminar_id) || !$seminar = $this->seminars->get($seminar_id))
        {
            redirect('Page_not_found');                                  
        }
        $this->_prep_form_values('validation_online_seminar_registration');
        
        // Check if recaptcha has been enabled in admin settings.
        if ($this->get_setting('online_seminars_enable_captcha')->setting_value)
        {            
            $this->view_data['recaptcha'] = $this->load->view('recaptcha', array('recaptcha'=> $this->recaptcha->get_html()), TRUE);
            // Add captcha validation to config.
            enable_recaptcha('validation_online_seminar_registration');
        }
     

        // This helper contains all functions that generate the dropdowns.
        $this->load->helper('cs_dropdown');

        $this->load->model('default/m_online_seminar_attendees');
        
        
        if ($this->input->post('submit'))
        {
			
            // Merge primary and secondary phone array data.
            $this->_form_data['phone1'] = implode('-', $_POST['phone1']);
            $this->_form_data['phone2'] = implode('-', $_POST['phone2']);
            
            unset($this->_form_data['phone1[]']);
            unset($this->_form_data['phone2[]']);
            if ($this->_save('validation_online_seminar_registration', $this->m_online_seminar_attendees))
            {

                // Send email to admin and person.
                $this->load->helper('cs_emails');                                
				
                $mail_data = array_merge($this->_form_data, (array) $seminar);   
				//include date of birth into email				
				$bday_str = $this->_form_data['month'] . '/' . $this->_form_data['date'] . '/' . $this->_form_data['year'];
				$mail_data['date_of_birth'] = date('M d, Y', strtotime($bday_str));
				
                // Get registrant age.
                $mail_data['age'] = get_age($this->_form_data['month'] . '-' . $this->_form_data['date'] . '-' . $this->_form_data['year']);
                // Get country.
                $this->load->model('default/m_country');
                $country              = $this->m_country->get($this->_form_data['country_id']);
                $mail_data['country'] = $country->name;
                
                // Get state.
                $this->load->model('default/m_states');
                $state             = $this->m_states->get($this->_form_data['state']);
                $mail_data['state'] = $state->state_name;
    
                // Send an email to the registrant.
                $x = send_email_template(
                        'online_seminars_email_patient',
                        $this->_form_data['email'],
                        null,
                        $mail_data
                    );

                // Send email to admin.
                send_email_template('online_seminars_email_admin', $this->get_setting('online_seminars_email_recipient'), null, $mail_data, TRUE);

                if ($x)
                {
                    $this->session->set_flashdata('message', 'Registration Successful!');
			//redirect to seminar Link assigned in admin 
			//get online seminar URL
			$online_seminar_url = $this->seminars->get(1)->link . '&fn='.$this->_form_data['first_name'].'&ln='.$this->_form_data['last_name'].'&em='.$this->_form_data['email'];
			redirect($online_seminar_url);
                    exit();
                }
            }
        }           
		
		//get url key
		$url_key = $this->get_current_module(); 
		//some page data
			$this->load->model('default/M_page');
			$page = $this->M_page->get($url_key);
			$this->view_data['class'] = $page['class'];
			$this->view_data['id_page'] = $page['id_page'];
			$this->view_data['content'] = $page['content'];
			
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
			
        $this->view_data['seminar_title']     = $seminar->title;
		$this->view_data['seminar_id']     = $seminar->seminar_id;
        $this->view_data['page'] = 'default/page/inner_page';
		$this->view_data['url_key'] = $url_key;

        // Display the form.
        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
    }

    // --------------------------------------------------------------------
}
/* End of file seminars.php */
/* Location: ./application/controllers/default/seminars.php */
