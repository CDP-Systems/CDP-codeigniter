<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * News controller for user view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-29
 */
class News extends MY_Controller {

    protected $_form_data;

    function __construct()
    {
        parent::__construct();

        // Load the model and assign it to "news" object.
        $this->load->model('default/m_news', 'news');
		$this->load->model('default/M_page');
		$this->load->helper('cs_news');
    }

    // --------------------------------------------------------------------

    /**
     * Default action. This action displays all news which are available.
     */
    function index($page = 0)
    {
        // Get all news so we know how to paginate.
        $news = $this->news->fetch_all();

         $this->view_data['page'] = 'default/page/inner_page'; 

        if ($news->num_rows() > 0)
        {
            $pagination['per_page'] = 10;
            $pagination['total_rows'] = $news->num_rows();

            $this->paginate($pagination);

            $results = $this->news->fetch_all($pagination['per_page'], $page);

            $this->view_data['news'] = $results->result();
        }

		//some page data
			$url_key = $this->get_current_module();
			
			$page = $this->M_page->get($url_key);
			$this->load->model('admin/M_website');
			$website = $this->M_website->getWebsite();

			$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
			$data['content'] = $page['content'];
			$data['class'] = $page['class'];
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
     * Display a single news item.     
     * 
     * @param string
     */
    function view($news_title = NULL, $news_id = FALSE)
    {

        if (is_null($news_title))
        {
            redirect('page_not_found');
        }
        // Replace the dashes on the title so we can use it in our query.
       // $news_title = str_replace('-', ' ', $news_title);
		
        $news = $this->news->get_by_id($news_id);
		
        if ($news == FALSE)
        {
            redirect('page_not_found');
        }

        $this->view_data['page'] = 'default/news/view';
        $this->view_data['news_title'] = $news->title;
        $this->view_data['news_body'] = $news->body;
        
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
}
/* End of file news.php */
/* Location: ./application/controllers/default/news.php */
