<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends MY_Controller{

	function __construct(){
		parent::__construct();           
	}
	
	function index(){
		//load objects
		$this->load->library('pagination');
		$this->load->model('admin/M_website');
		$this->load->model('default/M_page');
		$this->load->model('default/M_faq');
		$this->load->model('default/M_faq_category');
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->get_current_module(); 
		//get page data
		$page = $this->M_page->get($url_key);
		if(count($page)){ 
			//set pagination
			/*$config['base_url'] = base_url().index_page().'faq/index/';
			$config['total_rows'] = $this->M_faq->get_count();
			$config['per_page'] = '10';
			$this->pagination->initialize($config); */

			//set page data
			$category = $this->M_faq_category->get_min();
			$data['categories'] = $this->M_faq_category->get_categories();
			$data['faq'] = $this->M_faq->get_by_category($category['id_faq_category']);
			
			foreach ($data['categories'] as $cat) {
				$data['faqs_per_category'][$cat['id_faq_category']] = $this->M_faq->get_by_category($cat['id_faq_category']);
			}

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
		}
		else{
			//Page Not Found
			redirect('Page_not_found');
		}
		//parse template
        	$data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);	
	}
	
	function category($id){
		//load objects
		$this->load->library('pagination');
		$this->load->model('admin/M_website');
		$this->load->model('default/M_page');
		$this->load->model('default/M_faq');
		$this->load->model('default/M_faq_category');
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->get_current_module(); 
		//get page data
		$page = $this->M_page->get($url_key);
		if(count($page)){ 
			//set pagination
			/*$config['base_url'] = base_url().index_page().'faq/index/';
			$config['total_rows'] = $this->M_faq->get_count();
			$config['per_page'] = '10';
			$this->pagination->initialize($config); */

			//set page data
			$data['categories'] = $this->M_faq_category->get_categories();
			$data['faq'] = $this->M_faq->get_by_category($id);
			
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
		}
		else{
			//Page Not Found
			redirect('Page_not_found');
		}
		//parse template
        $data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);	
	}
	
	
}


/* End of file faq.php */
/* Location: ./application/controllers/default/faq.php */