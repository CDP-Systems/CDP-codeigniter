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
		}
		
    	$data['downloads'] = $this->M_download->get_downloads($page['id_page']);		
		//parse template
        $data = array_merge($this->view_data, $data);
		$this->parser->parse('default/templates/main', $data);
	}
	
	function view(){ 
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
		}
		else{
			//Page Not Found
			redirect('Page_not_found');
		}
		//parse template
        $data = array_merge($this->view_data, $data);
		$this->parser->parse('default/templates/2columns_left', $data);
	}	
	
	function test_email(){
		$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from('jurerick_porras@yahoo.com.ph');
			$this->email->to('jurerick.porras@gmail.com');
			$this->email->subject('test Subject');
			$this->email->message('Test Message');
			$this->email->send();
	}
}

/* End of file page.php */
/* Location: ./application/controllers/default/page.php */
