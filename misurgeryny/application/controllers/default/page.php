<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends MY_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('text');
		$this->load->model('admin/M_website');
		$this->load->model('default/M_page');
		$this->load->model('default/M_newsletter');                
	}
	
	function index(){
	       
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->get_current_module(); 
		//get page data
		$page = $this->M_page->getHomePage();
		
		// Check if recaptcha has been enabled in admin settings.
	        if ($this->get_setting('appointment_enable_captcha')->setting_value) 
	        {
	            $this->view_data['recaptcha'] = $this->load->view('recaptcha', array('recaptcha'=> $this->recaptcha->get_html()), TRUE);
	             
	        }               
                
		//set page data
		if(!count($page)){
			//DEFAULT HOME DATA
			$data['sitename'] = $website['name'];
			$data['title'] = 'Home';
			$data['content'] =  '';
			$data['page'] = 'default/page/home';
			$data['keywords'] = $website['default_metakeywords'];
			$data['desc'] = $website['default_metadesc'];
			$data['robots'] = $website['meta_robots'];
		}else{
			$data['sitename'] = $website['name'];
			$data['title'] = $page['page_title'];
			$data['content'] =  $page['content'];
			$data['page'] = 'default/page/home';
			$data['keywords'] = $page['keywords'];
			$data['desc'] = $page['desc'];
			$data['robots'] = $website['meta_robots'];
			
			//set global meta data if page meta data is blank
			if($page['keywords'] == ''){
				$data['keywords'] = $website['default_metakeywords'];
			}
			if($page['desc'] == ''){
				$data['desc'] = $website['default_metadesc'];
			}
		}
		
    	$data['downloads'] = $this->M_download->get_downloads($page['id_page']);		
		//parse template
        $data = array_merge($this->view_data, $data);

		$this->parser->parse('default/templates/' . $this->get_setting('home_template'), $data);
	}
	
	function view(){ 
	
		 // Check if recaptcha has been enabled in admin settings.
	        if ($this->get_setting('appointment_enable_captcha')->setting_value) 
	        {
	            $this->view_data['recaptcha'] = $this->load->view('recaptcha', array('recaptcha'=> $this->recaptcha->get_html()), TRUE);
	        }
	        
		$this->load->helper('cs_template');
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->get_current_module(); 
		//get page data
		$page = $this->M_page->get($url_key);

                if (isset($this->view_data['related_pages']))
                {
                    $data['related_pages'] = $this->view_data['related_pages'];
                }
		//set page data
		if(count($page)){ 
			$data['url_key'] = $url_key; 
			$data['class'] = $page['class'];
			$data['sitename'] = $website['name'];
			$data['title'] = $page['page_title'];
			$data['content'] = $page['content'];
			$data['page'] = 'default/page/inner_page';
			$data['keywords'] = $page['keywords'];
			$data['desc'] = $page['desc'];
			$data['robots'] = $website['meta_robots'];
			$data['includes_sidebar2'] = 'default/includes/sidebar2';
			$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
			
			//set global meta data if page meta data is blank
			if($page['keywords'] == ''){
				$data['keywords'] = $website['default_metakeywords'];
			}
			if($page['desc'] == ''){
				$data['desc'] = $website['default_metadesc'];
			}			
		}
		else{
			//Page Not Found
			redirect('Page_not_found');
		}
		//parse template
        	$data = array_merge($this->view_data, $data);
        
        	if($url_key == 'article-template'){
        		//set the template
			$template = 'default/templates/1column.php';
        	}else{
			//set the template
			$template = set_template($url_key);
		}
		
		
		$this->parser->parse($template, $data);
	}	
	
	function save_page(){
		
		$this->load->model('default/m_page');
		
		$data = array(
			'url_key' => $this->input->post('url_key'),
			'content' => $this->input->post('content')
		);
		
		if($this->M_page->update_page_content($data)){
		
			echo $data['content'];
		
		}
	}
}

/* End of file page.php */
/* Location: ./application/controllers/default/page.php */
