<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Testimonials controller for user view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-15
 */
class Testimonials extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        
        // Load the validation library.
        $this->require_validation();

        $this->load->helper('form');
		$this->load->model('default/M_page');
    }

    // --------------------------------------------------------------------
    
    /**
     * Default action, list all testimonials.
     */
    function index($page = 0, $category_id = null)
    {
			
        if ($this->get_setting('testimonials_enable_category')->setting_value == 1)
        {
            $this->load->model('default/m_testimonial_categories');

            $this->view_data['page'] = 'default/testimonials/cats';
            $this->view_data['categories'] = $this->m_testimonial_categories->fetch_all()->result();

            $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
        }
        else
        {
            $this->list_testimonials($category_id = null, $page);
        }
    }

    // --------------------------------------------------------------------

    function list_testimonials($category_id = null, $page = 0)
    {

        $this->load->model('default/m_testimonials');     

        $testimonials = $this->m_testimonials->fetch_all_published('', '', $category_id);

        //$this->view_data['page'] = 'default/testimonials/list';        
		$this->view_data['page'] = 'default/page/inner_page';        

                              
        if ($this->get_setting('testimonials_enable_category')->setting_value == 1)
        {
            $this->load->model('default/m_testimonial_categories');            
            $category = $this->m_testimonial_categories->get($category_id);
	 
	        $this->view_data['categories'] = $this->m_testimonial_categories->fetch_all()->result();
	        $this->view_data['cat_image']  = $category->image;
	        $this->view_data['current_cat'] = $category_id;
        }  
            
        if ($testimonials->num_rows() > 0)
        {                                                            
            $pagination['per_page'] = 4;
            $pagination['total_rows'] = $testimonials->num_rows();
            
            $this->load->library('CS_Url_Tree', null, 'tree');

            $this->tree->id_page = $this->view_data['id_page'];
           
            	if($this->uri->segment(2) == 'index'){
	        	$pagination['base_url']   = '../../' . $this->tree->get_link() . '/' . $this->get_current_action() . '/' . $category_id;
	        }else{
	        	$pagination['base_url']   = $this->tree->get_link() . '/' . $this->get_current_action() . '/' . $category_id;
	        }
	        $pagination['uri_segment'] = '3';
           
            $this->paginate($pagination);

            $results = $this->m_testimonials->fetch_all_published($pagination['per_page'], $page, $category_id);
            
            $this->view_data['testimonials'] = $results->result();
        }
		
		//some page data
			$url_key = $this->get_current_module(); 
			$page = $this->M_page->get($url_key);

			$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
			$data['content'] = $page['content'];
			$data['class'] = $page['class'];
			
			$this->load->model('admin/M_website');
			$website = $this->M_website->getWebsite();
			
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
			
        // Display the form.
		$this->view_data = array_merge($this->view_data, $data);
        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * View a single testimonial.
     */
    function view($testimonial_id = null) 
    {
    	$this->load->model('default/m_testimonials', 'testimonial');

    	if (is_null($testimonial_id) || !$testimonial = $this->testimonial->get($testimonial_id))
    	{
    		redirect (base_url());
    	}
    	    	
        if ($this->get_setting('testimonials_enable_category')->setting_value == 1)
        {
            $this->load->model('default/m_testimonial_categories');            
            $category = $this->m_testimonial_categories->get($testimonial->category);
	 
	   	    $this->view_data['categories'] = $this->m_testimonial_categories->fetch_all()->result();
      		$this->view_data['cat_image']  = $category->image;
      		$this->view_data['cat_id']     = $category->cat_id;
      		$this->view_data['cat_name']   = $category->category_name;
      	}                    
                	    	
        $this->view_data['page'] = 'default/testimonials/view';
        
        if ($testimonial->first_name[strlen($testimonial->first_name)-1] == 's')
        {
        	$first_name = $testimonial->first_name . '&rsquo;';
        }
        else
        {
        	$first_name = $testimonial->first_name . '&rsquo;s';
        }
        
        $dir = getcwd() . '/uploads/testimonials/';
        
        if (trim($testimonial->after_picture) != '' && file_exists($dir . $testimonial->after_picture))
        {
        	$this->view_data['after_picture'] = $testimonial->after_picture;
        }
        
        if (trim($testimonial->before_picture) != '' && file_exists($dir . $testimonial->before_picture))
        {
        	$this->view_data['before_picture'] = $testimonial->before_picture;
        }        
        
        // Get previous testimonial.
        $previous = $this->testimonial->get_previous($testimonial_id);
        
        if ($previous)
        {
        	$this->view_data['previous_id'] = $previous->testi_id;
        }
        // Get next testimonial.
        $next = $this->testimonial->get_next($testimonial_id);

        if ($next)
        {
        	$this->view_data['next_id'] = $next->testi_id;
        }        
        
        $this->view_data['first_name'] = $first_name;
	    $this->view_data['testimonial_body'] = $testimonial->body;
	    
	$this->load->model('default/M_page');
        $url_key = $this->get_current_module(); 
	$page = $this->M_page->get($url_key);
	$this->load->model('admin/M_website');
	$website = $this->M_website->getWebsite();
	
	$this->view_data['robots'] = '';			
	$this->view_data['keywords'] = $page['keywords'];
	$this->view_data['desc'] = $page['desc'];
	
	//set global meta data if page meta data is blank
	if($page['keywords'] == ''){
		$this->view_data['keywords'] = $website['default_metakeywords'];
	}
	if($page['desc'] == ''){
		$this->view_data['desc'] = $website['default_metadesc'];
	}

        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Action for adding a new testimonial.
     */
    function add() 
    {        
		//get url key
		$url_key = $this->get_current_module(); 
		
		//get page
		$page = $this->M_page->get($url_key);
		
        if ($this->input->post('submit') == 'submit')
        {
            // Redirect so we can show the message, @TODO: redirect somewhere else.
            if ($this->_save_testimonial())
            {
                // Send email to admin and person.
                $this->load->helper('cs_emails');

                $testimonials_email_recipient = $this->m_settings->get('testimonials_email_recipient');

                // Send email to admin.
                send_email_template('testimonials_admin_notification', $testimonials_email_recipient->setting_value, null, $this->_form_data);
                // Send email to patient.
                send_email_template('testimonials_patient_confirmation',$this->_form_data['email'], null, $this->_form_data);

                redirect (current_url());
                exit();
            }
        }

        // Use set_value to retrieve the post data instead of form->input, for security.
        //$this->view_data['page']       = 'default/testimonials/edit';
		$this->view_data['class'] = $page['class'];
		$this->view_data['page']       = 'default/page/inner_page';
		$this->view_data['content']       = $page['content'];
        $this->view_data['first_name'] = set_value('first_name');
        $this->view_data['last_name']  = set_value('last_name');
        $this->view_data['body']       = set_value('body');
        $this->view_data['email']      = set_value('email');

        if ($this->get_setting('testimonials_enable_category')->setting_value == 1)
        {
            $this->load->model('default/m_testimonial_categories');

            $dropdown = $this->m_testimonial_categories->get_category_dropdown();

            $this->view_data['category_dropdown'] = form_dropdown('category', $dropdown);

            $this->view_data['category'] = set_value('category');
        }
		
		
        // Check if recaptcha has been enabled in admin settings.
        if ($this->get_setting('testimonials_enable_captcha')->setting_value)
        {         
            $this->view_data['recaptcha'] = $this->load->view('recaptcha', array('recaptcha'=> $this->recaptcha->get_html()), TRUE);
        }
		
		$this->load->model('admin/M_website');
		$website = $this->M_website->getWebsite();
		
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
			
		//downloads
			$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
			$this->view_data = array_merge($this->view_data, $data);
		
        // Display the form
        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
    }

    // --------------------------------------------------------------------
    
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
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('first_name', 'First name', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('weight_lost', 'Weight lost', 'trim|required|numeric|xss_clean');        
        $this->form_validation->set_rules('last_name', 'Last name', 'trim|xss_clean');
        // Use the hidden input field which contains the name of the FILE to validate.
        $this->form_validation->set_rules('field_before_picture', 'Before picture', 'callback_handle_file_upload');
        $this->form_validation->set_rules('field_after_picture', 'After picture', 'callback_handle_file_upload');

        if ($this->get_setting('testimonials_enable_captcha')->setting_value)
        {
            
            $this->form_validation->set_rules('recaptcha_response_field', 'lang:recaptcha_field_name', 'required|callback_check_captcha');
            $this->view_data['recaptcha'] = $this->load->view('recaptcha', array('recaptcha'=> $this->recaptcha->get_html()), TRUE);
        }
		
		


        if ($this->form_validation->run())
        {
            $this->load->model('default/m_testimonials');

            $id = $this->m_testimonials->get_primary_key();

            if ($this->input->post($id) > 0)
            {
                $this->_form_data[$id] = $this->input->post($id);
            }

            if ($this->get_setting('testimonials_enable_category')->setting_value == 1)
            {
                $this->_form_data['category'] = $this->input->post('category');
            }

            $this->_form_data['first_name']     = $this->input->post('first_name');
            $this->_form_data['last_name']      = $this->input->post('last_name');
            $this->_form_data['body']           = $this->input->post('body');
            $this->_form_data['email']          = $this->input->post('email');
            $this->_form_data['before_picture'] = $this->session->userdata('file_before_picture');
            $this->_form_data['after_picture']  = $this->session->userdata('file_after_picture');
            $this->_form_data['publish']     = 1;
            $this->_form_data['weight_lost']     = '';

            // Save to the database.
            if ($this->m_testimonials->do_save($this->_form_data))
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
}
/* End of file testimonials.php */
/* Location: ./application/controllers/default/testimonials.php */
