<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Podcast extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('download');
		$this->load->helper('file');
		$this->load->model('default/M_podcast');
	}
	
	function index(){
		//load objects
		$this->load->model('admin/M_website');
		$this->load->model('default/M_page');
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->get_current_module(); 
		//get page data
		$page = $this->M_page->get($url_key);
		if(count($page)){ 
			//set page data
			$data['podcasts'] = $this->M_podcast->get_all_for_podcast(); 
			$data['subscription_text'] = $this->m_settings->get('podcast_subscription_text')->setting_value;
			$data['url_key'] = $url_key; 
			$data['class'] = $page['class'];
			$data['sitename'] = $website['name'];
			$data['title'] = $page['page_title'];
			$data['content'] = $page['content'];
			$data['page'] = 'default/page/inner_page';
			$data['keywords'] = $page['keywords'];
			$data['desc'] = $page['desc'];
			$data['robots'] = $website['meta_robots'];
			$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
			
			//set global meta data if page meta data is blank
			if($page['keywords'] == ''){
				$data['keywords'] = $website['default_metakeywords'];
			}
			if($page['desc'] == ''){
				$data['desc'] = $website['default_metadesc'];
			}

		}else{
			//Page Not Found
			redirect('Page_not_found');
		}
		//parse template
        $data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);	
	}
	

}

/* End of file podcast.php */
/* Location: ./application/controllers/default/podcast.php */
