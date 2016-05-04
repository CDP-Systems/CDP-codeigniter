<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')) redirect('admin/login');
		$this->load->model('admin/M_administrator');
		$this->load->model('admin/M_website');
		$this->load->model('admin/M_modules');
	}

	function index()
	{
		//set page data
		$data['title'] = 'Dashboard';
		$data['content'] = 'admin/dashboard/home';
		$data['sitename'] = $this->M_website->getName();
		$data['modules'] = $this->M_modules->getActivatedModules();
		$data['dashboard'] = TRUE;
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	
}

/* End of file subscribers.php */
/* Location: ./application/controllers/admin/subscribers.php */