<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_not_found extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/M_website');
	}

	function index()
	{
		//get site data
		$website = $this->M_website->getWebsite();
        $page = $this->m_page->get('404');
	
	if (!$page)
        {
            $page['content'] = 'Sorry the page you requested could not be found.';
            $page['page_title']   = 'Page Not Found';
	    $page['class'] 			   = '404';
	    $page['url_key']		   = 'page-not-found';	
	    $data['id_page']             = 0;
        }

		//set page data
		
		$data['sitename']          = $website['name'];
		$data['page']              = 'default/page/page_not_found';
		$data['keywords']          = $website['default_metakeywords'];
		$data['desc']              = $website['default_metadesc'];
		$data['robots']            = $website['meta_robots'];
		$data['includes_sidebar2'] = 'default/includes/blank';
		
		$data['class'] 			   = $page['class'];
		$data['url_key']		   = $page['url_key'];
        	$data['content']           = $page['content'];

       
		//parse template
        $data = array_merge($data, $this->view_data);

        $data['title']             = $page['page_title'];
        $data['content'] = 'Sorry the page you requested could not be found.';

		$this->parser->parse('default/templates/2columns_right', $data);
	}
}

/* End of file page_not_found.php */
/* Location: ./application/controllers/page_not_found.php */
