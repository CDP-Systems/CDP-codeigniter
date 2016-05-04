<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Seminars controller for user view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-25
 */
class Seminars extends MY_Controller {

    protected $_form_data;

    function __construct()
    {
        parent::__construct();

        $this->load->helper('form');

        // Load the model and assign it to "seminars" object.
        $this->load->model('default/m_seminars', 'seminars');
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
        $url_key = $this->get_current_module();
        $seminars = $this->seminars->fetch_all();
       

        $this->view_data['page'] = 'default/page/inner_page';

        if ($seminars->num_rows() > 0)
        {
            $pagination['per_page'] = 10;
            $pagination['total_rows'] = $seminars->num_rows();
			$pagination['base_url'] = $this->_get_current_page_url() . '/index/';
            $this->paginate($pagination);

            $results = $this->seminars->fetch_all($pagination['per_page'], $page);

            $this->view_data['seminars'] = $results->result();
        }
			
			//some page data
			$this->load->model('default/M_page');
			
			$page = $this->M_page->get($url_key);
			$this->load->model('admin/M_website');
			$website = $this->M_website->getWebsite();
				
			$data['content'] = $page['content'];
			$data['class'] = $page['class'];
			$data['current_url'] = $this->_get_current_page_url();
			$data['robots'] = $website['meta_robots'];
			$data['keywords'] = $page['keywords'];
			$data['desc'] = $page['desc'];
			
			//set global meta data if page meta data is blank
			if($page['keywords'] == ''){
				$data['keywords'] = $website['default_metakeywords'];
			}
			if($page['desc'] == ''){
				$data['desc'] = $website['default_metadesc'];
			}
			
			
			$this->view_data = array_merge($data, $this->view_data);
			
        // Display the form.
        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
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

        // This helper contains all functions that generate the dropdowns.
        $this->load->helper('cs_dropdown');

        $this->load->model('default/m_seminar_attendees');

        $this->view_data['recaptcha'] = '';

        // Check if recaptcha has been enabled in admin settings.
        if ($this->get_setting('seminars_enable_captcha')->setting_value)
        {            
            $this->view_data['recaptcha'] = $this->load->view('recaptcha', array('recaptcha'=> $this->recaptcha->get_html()), TRUE);
            // Add captcha validation to config.
            enable_recaptcha('validation_seminar_registration');
        }

        $total_attendees = $this->m_seminar_attendees->get_attendee_count($seminar_id);               

        $this->view_data['seminar_is_full'] = ($seminar->is_full || ($total_attendees >= $seminar->max_num_attendees));

        $this->_prep_form_values('validation_seminar_registration');

        if ($this->input->post('submit'))
        {
        	
            if ($this->view_data['seminar_is_full'])
            {
                redirect (current_url());
            }
            
            
            //add specialty field for saving
            
//		$ctr = 0; $specialties = count($this->input->post('specialty')); $specialty = '';
//		foreach($this->input->post('specialty') as $item){
//			$ctr++;
//			$comma = ($ctr >= $specialties) ? '' : ', ';
//			$specialty .= $item . $comma;	
//		}
//		
//            $this->_form_data['specialty'] = $specialty;
		
            
            // Merge primary and secondary phone array data.

            $this->_form_data['phone1'] = implode('-', $_POST['phone1']);
            $this->_form_data['phone2'] = implode('-', $_POST['phone2']);
            
            unset( $this->_form_data['phone1[]']);
            unset( $this->_form_data['phone2[]']);
            
            if ($this->_save('validation_seminar_registration', $this->m_seminar_attendees))
            {
                // subscribe email to mailing list.
                if($this->input->post('subscribe') == 1){
                    $this->load->helper('cs_newsletter_helper'); 
                    subscribe_for_mailing_list(
                        array(
                            'fname' => $this->input->post('first_name'),
                            'lname' => $this->input->post('last_name'),
                            'email' => $this->input->post('email'),
                            )
                    );
                }
                
                // Send email to admin and person.
                $this->load->helper('cs_emails');                                
		
                $mail_data = array_merge($this->_form_data, (array) $seminar);    
                
                //include seminar date into email				
		$mail_data['seminar_date'] = date('M d, Y', strtotime($seminar->seminar_date));
		            
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
                
                //include date of birth into email				
		$bday_str = $this->_form_data['month'] . '/' . $this->_form_data['date'] . '/' . $this->_form_data['year'];
		$mail_data['date_of_birth'] = date('M d, Y', strtotime($bday_str));

                // Send an email to the registrant.
                $x = send_email_template(
                        'seminars_email_patient',
                        $this->_form_data['email'],
                        null,
                        $mail_data
                    );

                // Send email to admin.
                send_email_template('seminars_email_admin', $this->get_setting('seminars_email_recipient'), null, $mail_data);

                if ($x)
                {
                    $this->session->set_flashdata('message', 'Registration Successful!');
                    redirect (current_url());
                    exit();
                }
            }
        }  
        
        $url_key = $this->get_current_module();
       
        $this->view_data['seminar_title']     = $seminar->title;
        $this->view_data['seminar_location']  = $seminar->location;
        $this->view_data['seminars_dropdown'] = $this->seminars->get_dates_dropdown();
        
        $this->view_data['content'] = '';
		$this->view_data['page'] = 'default/page/inner_page';

			//some page data
			$this->load->model('default/M_page');
			$page = $this->M_page->get($url_key);
			$this->load->model('admin/M_website');
			$website = $this->M_website->getWebsite();
				
			$data['class'] = $page['class'];
			$data['current_url'] = $this->_get_current_page_url();
			$data['robots'] = '';
			$data['keywords'] = $page['keywords'];
			$data['desc'] = $page['desc'];
			
			//set global meta data if page meta data is blank
			if($page['keywords'] == ''){
				$data['keywords'] = $website['default_metakeywords'];
			}
			if($page['desc'] == ''){
				$data['desc'] = $website['default_metadesc'];
			}
			
			$this->view_data = array_merge($data, $this->view_data);
		
        // Display the form.
        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
    }

    // --------------------------------------------------------------------
}
/* End of file seminars.php */
/* Location: ./application/controllers/default/seminars.php */
