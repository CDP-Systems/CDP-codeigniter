<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in')) redirect('admin/dashboard');
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->library('encrypt');
		$this->load->helper('security');
		$this->load->helper('string');
		$this->load->model('admin/M_website');
		$this->load->model('admin/M_administrator');
	}
	
	function index(){
		//set page data
		$data['title'] = 'Administrator Forgot Password';
		$data['sitename'] = $this->M_website->getName();
		//parse template
		$this->parser->parse('admin/forgot_password/forgot_password', $data);
	}	
	
	function retrieve(){
		//set page data
		$data['title'] = 'Administrator Forgot Password';
		$data['sitename'] = $this->M_website->getName();
		//process
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		if($this->form_validation->run() == FALSE){
			$data['error'] = validation_errors();
		}else{
			$email = $this->input->post('email', TRUE);
			$super_admin = $this->M_administrator->getSuperAdmin();
			$admin = $this->M_administrator->getAdminByEmail($email);
			if(count($admin)){
				//set new password
				$new_password = $this->set_new_password();
				$encoded_password = str_replace('/',':',$this->encrypt->encode($new_password));
				
				//set reset key
				$reset_key = do_hash($this->set_reset_key($admin['id_admin']));
				
				//create email message
				$message = "<h4>Dear ".$admin['username'].",</h4>
				<p>You received this email because the Forgot Password form has been submitted.</p>
				
				<p>
					Your access details are:
					<div style='background: #f9f9f9; border: 1px solid silver; padding: 20px; margin: 0'>
					<strong>Username:</strong> ".$admin['username']." <br />
					<strong>New password:</strong> ".$new_password."
					</div>
				</p>
				<p>
					Please note that this new password won't be activated unless 
					you click this <a href='".base_url().index_page()."admin/login/index/".$admin['id_admin']."/".$encoded_password."/".$reset_key."'>login</a> link
					or you may copy-paste the link below to your browser:<br />
					".base_url().index_page()."admin/login/index/".$admin['id_admin']."/".$encoded_password."/".$reset_key."
				</p>
				<p>
					Thank you.
				</p>
				<p>
					".$data['sitename']."<br />
					".base_url()."
				</p>";
				//send email
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
				$this->email->from('noreply@'.$_SERVER['HTTP_HOST'], $data['sitename']);
				$this->email->to($admin['email']);
				$this->email->subject('['.$data['sitename'].'] New password for '.$admin['username']);
				$this->email->message($message);
				$this->email->send();
				
				$data['msg'] = 'A new password was sent to your email address. 
Please check your email.';
			}else{
				$data['error'] = "Cannot find the email address.";
			}	
		}
		//parse template
		$this->parser->parse('admin/forgot_password/forgot_password', $data);
	}
	
	function set_reset_key($id){
		$reset_key = random_string('alnum', 7);
		$this->M_administrator->setResetKey($id, do_hash($reset_key));
		return $reset_key;
	}
	
	function set_new_password(){
		$new_password = random_string('alnum', 7);
		return $new_password;
	}
	

}


/* End of file forgot_password.php */
/* Location: ./application/controllers/admin/forgot_password.php */