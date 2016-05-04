<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Statistics {
    
    private $_ci = null;
    // This array contains folders that must not be regarded as page views.
    private $_blacklist = array ('images', 'styles', 'js');    
    
    public function __construct()
    {
        // We need an instance of CI as we will be using some CI classes    
        $this->_ci =& get_instance();
    }

    public function log_activity() 
    {
        // Start off with the session stuff we know
        $data = array();        
        $data['page'] = current_url();
        $data['date_time'] = date('Y-m-d, H:i:s');
        $data['ip_address'] = $this->_ci->session->userdata('ip_address');
        $data['user_agent'] = $this->_ci->session->userdata('user_agent');        
        $data['request_method'] = $_SERVER['REQUEST_METHOD'];
        $data['request_params'] = serialize($this->_ci->input->get_post(NULL, TRUE));        
        $data['uri_string'] = $this->_ci->uri->uri_string();        
                        
        if ($this->_verify_activity()) 
        {        
            // And write it to the database        
            $this->_ci->db->insert('statistics', $data);
        }
    }
    
    /**
     * Perform checks on whether or not to log the activity.
     *
     * @return boolean
     */
    private function _verify_activity()
    {   
        $uri_array = $this->_ci->uri->segment_array();

        // Don't count ajax calls, admin pages, calls to $_blacklist.
        if ($this->_ci->input->is_ajax_request() || (count($uri_array) > 0 && in_array($uri_array[1], $this->_blacklist)))
        {
            return FALSE;        
        }

        if (method_exists($this->_ci, 'is_in_admin'))
        {
            if ($this->_ci->is_in_admin())
            {
                return FALSE;
            }
        }

        // Check for crawlers.
        if ($this->check_if_spider())
        {
            return FALSE;
        }
        
        $session_id = $this->_ci->session->userdata('session_id');
        
        // Get the last page viewed of this person, if the page was refreshed don't log.        
        if (1==1) {}
        return TRUE;
    }
    
    function check_if_spider()  
    {  
        // Add as many spiders you want in this array  
        $spiders    = array(  
                        'Googlebot', 'Yammybot', 'Openbot', 'Yahoo', 'Slurp', 'msnbot',  
                        'ia_archiver', 'Lycos', 'Scooter', 'AltaVista', 'Teoma', 'Gigabot',                         
                        'Googlebot-Mobile' , 'Baiduspider', 'YandexBot','bingbot' 
                    );  
  
        // Loop through each spider and check if it appears in  
        // the User Agent  
        foreach ($spiders as $spider)  
        {  
            if (stristr($_SERVER['HTTP_USER_AGENT'], $spider))  
            {  
                return TRUE;  
            }  
        }  
        return FALSE;  
    }    
}
