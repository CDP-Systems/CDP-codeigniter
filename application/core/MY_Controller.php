<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Place application wide pre-configuration/auth/initialization on this file.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-15
 */

class MY_Controller extends CI_Controller {
    
    private $_validate_fields = FALSE;
    private $_current_module;
    private $_current_action;
    private $_settings;

    protected $_form_data;

    // Content From CMS.
    private $_page;
    
    public $view_data;
    public $website_data;

    // --------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();

        $this->load->config('cs_preferences');

	$this->load->model('default/m_modules', 'modules');
	
	if (!$this->modules->is_enabled($this->router->class))
	{
		show_404();
	}	

        if ($this->is_in_admin() && !$this->session->userdata('logged_in'))
        {
            $this->session->set_userdata('redirect', current_url());
            redirect ('admin/login');
        }
        
        $this->load->library('session');
        
        $this->load->model('default/m_settings');
        $this->load->model('admin/M_website');
        $this->load->model('default/m_page');

        // Load reCAPTCHA.
        $this->load->library('recaptcha');
        $this->lang->load('recaptcha');

        $this->load->helper('cs_functions');

        // Load the settings from the database so we only have to call them once.
        $this->_settings = $this->m_settings->get_settings();

        // Define what module is being used, via the url.
        $this->_define_current_module();    
        
        // Loads module packages.
        $this->_load_module_packages();
                            
        //get site data
        $this->website_data = $this->M_website->getWebsite();

        $this->_prep_view_data();
		
		//breadcrumb library
		$this->load->library('CS_Url_Tree', null, 'breadcrumbs');
		
        // Populate our config.
        $this->config->set_item('SITE_NAME', site_url());
        $this->config->set_item('CLOSING', $this->website_data['name']);
        
        // Caching.
        //$this->output->cache(60);
    }

    // --------------------------------------------------------------------    
    
    /**
     * Have to remap the call to the controller in case there are some uri segments issues.
     */    
    function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            if (isset($params[0]) && $method == $params[0])
            {
                unset($params[0]);
            }
            
            return call_user_func_array(array($this, $method), $params);
        }
    }

    
    // --------------------------------------------------------------------    
    
    /**
     * Loads the dir of all modules that we have.
     */      
    function _load_module_packages()
    {
        $this->load->config('modules');
        
        $modules = $this->config->item('modules');
        
        foreach ($modules as $module)
        {
            $this->load->add_package_path(MODPATH . $module);
        }
    }
    
    // --------------------------------------------------------------------        

    function _get_current_page_url()
    {
        $page = $this->get_page();
        
        if ($this->get_current_module() == '')
        {
            return base_url();
        }
        
        if (!$page)
        {
            return site_url($this->get_current_module() . '/' . $this->get_current_action());
        }
        else
        {
            if (!method_exists($this, 'tree'))
            {
                $this->load->library('CS_Url_Tree', null, 'tree');
                $this->tree->clear();
                $this->tree->id_page = $page['id_page'];
                
                return site_url($this->tree->get_link());
            }
        }
    }    

    // --------------------------------------------------------------------

    /**
     * Start populating $this->view_data which will contain the parameters to be parsed
     * on the template.
     */
    private function _prep_view_data()
    {
        $this->view_data = array();
        
        $this->_page = $this->get_page();

        $this->view_data['title'] = 'Welcome';

        if ($this->_page)
        {
            $this->view_data['title'] = $this->_page['page_title'];
            $this->view_data['page_title'] = $this->_page['page_title'];
            $this->view_data['page_content'] = $this->_page['content'];
            $this->view_data['url_key'] = $this->_current_module;
            $this->view_data['id_page'] = $this->_page['id_page'];
			$this->view_data['class'] = $this->_page['class'];
			$this->view_data['content'] = $this->_page['content'];
			
            $related_pages = json_decode($this->_page['related_pages']);
            
            if (!is_null($related_pages) && is_array($related_pages))
            {
                $this->view_data['related_pages'] = $this->m_page->get_by_id($related_pages);
                // Check if we got a single row, because if so we have to add it to an array for the view to parse properply.
                if (is_object($this->view_data['related_pages']))
                {
                    $this->view_data['related_pages'] = array ($this->view_data['related_pages']);
                }
            }
        }

        $this->view_data['sitename'] = $this->website_data['name'];
        $this->view_data['image_dir'] = base_url().'images';
        $this->view_data['css_dir'] = base_url().'styles';
        $this->view_data['js_dir'] = base_url().'js';

        $this->view_data = array_merge($this->view_data, $this->website_data);
    }

    // --------------------------------------------------------------------

    public function is_in_admin()
    {
        return $this->uri->segment(1) == 'admin';
    }

    // --------------------------------------------------------------------

    /**
     * Get setting from $_setting.
     *
     * @param string $setting_name
     * @return string
     */
    public function get_setting($setting_name)
    { 
        if (isset($this->_settings[$setting_name]))
        {
            return new Setting($this->_settings[$setting_name]);
        }
        else
        {
            show_error('Could not find the setting specified: ' . $setting_name);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Return the $_setting array.
     *
     * @return array
     */
    public function get_settings()
    {
        return  $this->_settings;
    }

    // --------------------------------------------------------------------

    /**
     * Get all data about the current page.
     *
     * @return object
     */
    public function get_page()
    {
        if (isset($this->_page))
        {
            return $this->_page;
        }

        $page = $this->m_page->getPage($this->_current_module);

        if (isset($page['parent_id']) && $page['parent_id'] > 0)
        {
        }

        if (count($page) > 0)
        {
            return $page;
        }
        else
        {
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Returns the current module being accessed.
     * 
     * @return string.
     */
    public function get_current_module()
    {
        return $this->_current_module;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the current action being accessed.
     * 
     * @return string.
     */
    public function get_current_action()
    {
        return $this->_current_action;
    }  

    // --------------------------------------------------------------------

    /**
     * Initialize the pagination.
     *
     * @param array $params Array of configuration params
     */
    public function paginate($params = null)
    {
        $this->load->library('pagination');

        $config = $params;

        if ($this->is_in_admin())
        {
            $base_url = site_url('admin/' . $this->_current_module . '/' . $this->_current_action . '/');

            //first and last links
            $config['first_link'] = '&laquo; First';
            $config['last_link'] = 'Last &raquo;';
            //first link tags
            $config['first_tag_open'] = '<li style="margin-right:20px;">';
            $config['first_tag_close'] = '</li>';
            //last link tags
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '<li>';
            //next link tags
            $config['next_link'] = 'Next &raquo;';
            $config['next_tag_open'] = '<li style="margin-right:20px;margin-left:10px;"">';
            $config['next_tag_close'] = '</li>';
            //previous link tags
            $config['prev_link'] = '&laquo; Previous';
            $config['prev_tag_open'] = '<li style="margin-right:10px;">';
            $config['prev_tag_close'] = '</li>';
            //current link tags
            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            //links tags
            $config['num_tag_open'] = '<li class="pages">';
            $config['num_tag_close'] = '</li>';
        }
        else
        {
            if (isset($params['base_url']))
            {
                $base_url = $params['base_url'];
            }
            else if ($this->get_page() == FALSE)
            {
                $base_url = current_url();
            }
            else
            {
                $base_url = site_url($this->uri->segment(1) . '/' . $this->get_current_action());
            }
        }

        $config['base_url'] = $base_url;
        $config['per_page'] = isset($params['per_page']) ? $params['per_page'] : 10;        

        // Get the uri_segment for pagination, it's usually the segment after the current action.
        $uri_segment = array_keys($this->uri->segment_array(), $this->get_current_action());

        if (isset($uri_segment[0]) && !isset($params['uri_segment']))
        {
            $config['uri_segment'] = $uri_segment[0] + 1;
        }

        $this->pagination->initialize($config);
    }

    // --------------------------------------------------------------------

    /**
     * Tell the controller to load the form validation library and set delimiter.
     *
     * @param array $rules
     */
    function require_validation($rules = null)
    {     
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<label class="error">', '</label>');

        if (is_array($rules))
        {
            $this->form_validation->set_rules($rules);
        }

        $this->_validate_fields = TRUE;
    }

    // --------------------------------------------------------------------

    /**
     *
     * Handles file upload for all controllers, returns the encrypted name.
     *
     * @param string $filename    
     * @return mixed FALSE on error, the name of the uploaded file on success.
     */
    public function handle_file_upload($filename)
    {
        // Load the configuration of upload paths per module.
        $this->load->config('upload_path');
        $this->load->config('upload_config');
    
        $upload_paths = $this->config->item('upload_path');

        if (!isset($_FILES[$filename]) || $_FILES[$filename]['error'] == 4) // No file was uploaded.
        {        
            $this->session->set_userdata('file_' . $filename, ' ');
            return TRUE;
        }
		
        $config = $this->config->item($this->get_current_module() . '/' . $this->get_current_action());
        $config['upload_path'] = './uploads/';

        // Is there a set upload path for this module?
        // $this->router->fetch_class() gets the current controller, not the current module/page.
        if (isset($upload_paths[$this->router->fetch_class()]))
        {
            $upload_path = $config['upload_path'] . $upload_paths[$this->router->fetch_class()];
            
            if (!is_dir($upload_path)) // Create dir if it does not exist.
            {
                if (!mkdir($upload_path))
                {
                    $upload_path = $config['upload_path'];
                }
            }
            
            $config['upload_path'] = $upload_path;
        }
		
	$config['allowed_types'] = '*';
        $this->load->library('upload', $config);

        // Upload and validate.
        if (!$this->upload->do_upload($filename))
        {
            $this->form_validation->set_message('handle_file_upload', $this->upload->display_errors());

            return FALSE;
        }
        else
        {
            // Save the encrypted file name to a session. DO NOT FORGET TO UNSET THIS.
            $this->session->set_userdata('file_' . $filename, $this->upload->file_name);
            
            $this->session->set_userdata('orig_file_' . $filename, $_FILES[$filename]['name']);            
            return TRUE; // Upload successful.
        }
    }

    // --------------------------------------------------------------------
    
        
//    private function _define_current_module()
//    {
//         $this->_current_action = $this->router->method;
//
//        $key = $this->uri->total_segments();
//
//        if (array_key_exists($this->uri->uri_string(), $this->router->routes))
//        {
//            $this->_current_module = $this->uri->segment($key);
//
//            if ($this->_current_module == $this->_current_action)
//            {
//                $this->_current_module = $this->uri->segment($key - 1);
//            }
//            return TRUE;
//        }
//        
//        if ($this->uri->segment(1) == 'default' || $this->uri->segment(1) == 'admin')
//        {
//            $this->_current_module = $this->uri->segment(2);
//        }
//        else
//        {
//            $this->_current_module = $this->uri->segment(1);            
//        }
//    }
    
    private function _define_current_module()
    {
        $this->_current_action = $this->router->method;

        $key = $this->uri->total_segments();
                
	$regex_routes = array_keys($this->router->routes);
	
	$match = FALSE;
	foreach ($regex_routes as $possible_route)
	{
		if (preg_match('/' . str_replace('/', '\/', $possible_route) . '/', $this->uri->uri_string()))
		{
			$match = TRUE;
			break;
		}
		
		if ($match == TRUE)
		{
			break;
		}
	}
	
        if ($match)
        {
            $this->_current_module = $this->uri->segment($key);
            
            if ($this->_current_module == $this->_current_action || !$this->get_page())
            {            	
            	$ctr = 1;
            	while(!$this->get_page())
            	{
                	$this->_current_module = $this->uri->segment($key - $ctr++);             
                }
            }
   
   	    if (!$this->is_in_admin())
   	    {
            	return TRUE;
            }
        }        
        
        if ($this->uri->segment(1) == 'default' || $this->uri->segment(1) == 'admin')
        {
            $this->_current_module = $this->uri->segment(2);
        }
        else
        {
            $this->_current_module = $this->uri->segment(1);            
        }        
    }

    // --------------------------------------------------------------------

    /**
     * Repopulate form values.
     *
     * @param string $config
     * @param object $defaults
     *
     * @return null
     */
    public function _prep_form_values($config, $defaults = null)
    {	
        // Load fields from config.
        $this->load->config('validations');
        $config = $this->config->item($config);
		
        foreach ($config as $field)
        {
			
            if (!is_null($defaults) && is_object($defaults))
            {
                if (isset($defaults->{$field['field']}))
                {
                    $this->_form_data[$field['field']] = set_value($field['field'], $defaults->{$field['field']});
                }
            }
            else
            {
                // Check if defined field is an array.
                if (stripos($field['field'], '[]') === TRUE)
                {
                    $field['field'] = trim($field['field'], '[]');

                    $this->_form_data[$field['field']] = $this->input->post($field['field']);
                }
                else
                { 
                   // $this->_form_data[$field['field']] = set_value($field['field']);                
				    $this->_form_data[$field['field']] = $this->input->post($field['field']);                
                }
				
            }
        }
        // Merge form data to view data so we can use it in the view.
        $this->view_data = array_merge($this->view_data, $this->_form_data);
    }

    // --------------------------------------------------------------------

    /**
     * Save form data after validation.
     *
     * @param string $validation The name of the config item in cs_preferences.php
     * @param obj $model Instance of model to be used, must inherit MY_Model.
     * @return bool
     */
    public function _save($validation, $model)
    {
        // Load fields from config.
        $this->load->config('validations');
        $config = $this->config->item($validation);

        $this->require_validation($config);
      

        if ($this->form_validation->run())
        {
            return $model->do_save($this->_form_data);
        }

        return FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * reCaptcha validaton.
     *
     * @param string $val Input value.
     *
     * @return bool
     */
	function check_captcha($val) 
    {
	  if ($this->recaptcha->check_answer($this->input->ip_address(),$this->input->post('recaptcha_challenge_field'),$val)) {
        unset($this->_form_data['recaptcha_response_field']);
	    return TRUE;
	  } else {
	    $this->form_validation->set_message('check_captcha',$this->lang->line('recaptcha_incorrect_response'));
	    return FALSE;
	  }
	}

    /**
     * Check if request is called via ajax.
     *
     * @return bool
     */
    function isAjax ()
    {
        if (
            isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest")
        return true;
    
        return false;
    }

}

// --------------------------------------------------------------------
// 
// 
//
// --------------------------------------------------------------------

/**
 * This class is a dummy to mimic old calls to get_setting.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-05-18
 */
class Setting
{
    public $setting_value;

    public function __construct($setting)
    {
        $this->setting_value = $setting;
    }
          
    public function __toString()
    {
        return $this->setting_value;
    }
}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */