<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('security');
		$this->load->model('admin/M_website');
		$this->load->model('admin/M_login');
	}

	function index()
	{
		if($this->session->userdata('logged_in')) redirect('admin/dashboard');
		//set page data
		$data['title'] = 'Administrator Login';
		$data['website'] = $this->M_website->getWebsite();
		//parse template
		$this->parser->parse('admin/login/login', $data);
	}
	
	function do_login(){
		//set page data
		$data['title'] = 'Administrator Login';
		$data['website'] = $this->M_website->getWebsite();
		//process 
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);
		$admin = $this->M_login->login($username, do_hash($password));
		if(count($admin)){
			$admin_data = array(
				'id_admin' => $admin['id_admin'],
				'username' => $admin['username'],
				'email' => $admin['email'],
				'super_admin' => $admin['super_admin'],
				'logged_in' => TRUE
			);
			$this->session->set_userdata($admin_data);
			redirect('admin/dashboard');
		}else{
			if($username && $password){
				$data['error'] = TRUE;
			}
			//parse template
			$this->parser->parse('admin/login/login', $data);
		}
	}
	
	function logout(){
		$admin_items = array('username' => '', 'email' => '', 'logged_in' => FALSE);
		$this->session->unset_userdata($admin_items);
		redirect('admin/administrator');
	}
	
}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */