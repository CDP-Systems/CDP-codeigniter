<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MY_Controller{

	function __construct()
        {
		parent::__construct();

        $this->load->helper('text');
		$this->load->model('default/m_page');
	}
	
	function index($search_key = '', $page = 0)
    	{
		//set page data
	        $data['page'] = 'default/search/search_form';
		$this->view_data['search_key'] = $search_key;

	        if ($search_key != '')
	        {
	            $search_key = urldecode($search_key);
	
	            $results = $this->m_page->fulltext_search(array('content', 'page_title'), $search_key);
	            
	            $pagination['per_page']    = 10;
	            $pagination['total_rows']  = $results->num_rows();
	            $pagination['uri_segment'] = 4;    
	            $pagination['base_url']    = base_url() . 'search/index/' . $search_key;
	
	            $this->paginate($pagination);
	
	            $results = $this->m_page->fulltext_search(array('content', 'page_title'), $search_key, $pagination['per_page'], $page);
	
	            $this->view_data['total_rows'] = $pagination['total_rows'];
	            $this->view_data['search_key'] = $search_key;
	
	            // Get the URLs.
	            foreach ($results->result() as $result)
	            {
	                
	            }
	
	            $this->view_data['search_results'] = $results->result(); 
	
	            $data['page'] = 'default/search/search_result';           
	        }

		//parse template
		
		$url_key = $this->get_current_module(); 
		$page = $this->m_page->get($url_key);
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
		
        	$data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/'. $this->get_setting('inner_template'), $data);
	}

    // --------------------------------------------------------------------

    /**
     * Converts the POST data to URI segment format.
     */
    function construct()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('search', 'Search', 'trim|xss_clean|urlencode');

        if ($this->form_validation->run())
        {
            $query_string = set_value('search');

            redirect (site_url('search/index/' . $query_string));
        }
        else
        {
            show_error('Nice try! Your IP has been logged and we are notifying proper authorities');
        }
    }
	
    // --------------------------------------------------------------------

	function result(){ 
		//set search key
		$search_key = ($this->uri->segment(4))? trim($this->uri->segment(4)) : trim($this->input->post('search', TRUE));
		//get url key
		$url_key = $this->uri->segment(1); 

		/*PAGINATION SETTING*/
		$config['base_url'] = base_url().index_page().$url_key.'/result/index/'.$search_key;
		$config['total_rows'] = $this->M_page->get_search_count($search_key);  
		$config['per_page'] = $perpage = '5'; 
		$config['uri_segment'] = 5;
		$this->pagination->initialize($config);
		
		//get site data
		$website = $this->M_website->getWebsite();
		//get page data
		$page = $this->M_page->get($url_key); 
		//do search
		$offset = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$search_results = (empty($search_key)) ? 0 : $this->M_page->search($search_key, $perpage, $offset);
		//set page data
		if(!count($page)){
			//DEFAULT DATA
			$data['class'] = 'search';
			$data['url_key'] = 'search';
			$data['sitename'] = $website['name'];
			$data['title'] = 'Search';
			$data['content'] =  '';
			$data['search_key'] = $search_key;
			$data['search_results'] = $search_results;
			$data['total_rows'] = $config['total_rows'];
			$data['page'] = 'default/search/search_result';
			$data['keywords'] = $website['default_metakeywords'];
			$data['desc'] = $website['default_metadesc'];
			$data['robots'] = $website['meta_robots'];
		}else{
			$data['class'] = $page['class'];
			$data['url_key'] = $page['url_key'];
			$data['sitename'] = $website['name'];
			$data['title'] = $page['page_title'];
			$data['content'] =  $page['content'];
			$data['search_key'] = $search_key;
			$data['search_results'] = $search_results;
			$data['total_rows'] = $config['total_rows'];
			$data['page'] = 'default/page/inner_page';
			$data['keywords'] = $page['keywords'];
			$data['desc'] = $page['desc'];
			$data['robots'] = $website['meta_robots'];
			$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
		}
		
		//set global meta data if page meta data is blank
		if($page['keywords'] == ''){
			$data['keywords'] = $website['default_metakeywords'];
		}
		if($page['desc'] == ''){
			$data['desc'] = $website['default_metadesc'];
		}
		//parse template
        $data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
	}
	

}

/* End of file search.php */
/* Location: ./application/controllers/default/search.php */