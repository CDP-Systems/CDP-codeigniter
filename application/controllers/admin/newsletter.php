<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')) redirect('admin/login');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('email');
		$this->load->helper('download');
		$this->load->model('admin/M_newsletter');
		$this->load->model('admin/M_subscribers');
		$this->load->model('admin/M_website');
		$this->load->model('admin/M_administrator');
		session_start();
	}

	function index($offset = 0)
	{
		//set pagination
		$perpage = 10;
		$this->pagination($perpage);
		//set page data
		$data['newsletters'] = $this->M_newsletter->get_all($perpage, $offset);
		$data['title'] = 'Newsletter';
		$data['content'] = 'admin/newsletter/newsletter';
		$data['sitename'] = $this->M_website->getName();
		//actions settled
		if(isset($_SESSION['noSelected'])){
			$data['noSelected'] = $_SESSION['noSelected']; unset($_SESSION['noSelected']);
		}
		if(isset($_SESSION['action'])){
			$data['action'] = $_SESSION['action']; unset($_SESSION['action']);
			if(isset($_SESSION['actionsSuccess'])){
				$data['actionsSuccess'] = $_SESSION['actionsSuccess'];
				unset($_SESSION['actionsSuccess']);
			}
			if(isset($_SESSION['actionsFailed'])){
				$data['actionsFailed'] = $_SESSION['actionsFailed']; unset($_SESSION['actionsFailed']);
			}
		}
		//parse template
		$this->parser->parse('admin/template', $data);
	}

	function add(){
		//set page data
		$data['title'] = 'Add Newsletter';
		$data['content'] = 'admin/newsletter/newsletter_add';
		$data['sitename'] = $this->M_website->getName();
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	
	function save(){
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('body', 'Body', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			//set page data
			$data['title'] = 'Add Newsletter';
			$data['content'] = 'admin/newsletter/newsletter_add';
			$data['sitename'] = $this->M_website->getName();
			//parse template
			$this->parser->parse('admin/template', $data);
		}
		else
		{
			//FILE ATTACHMENT
			$uploadError = FALSE;
			if($_FILES['attachment']['name'] != ''){
				$attachFile = $this->attach_file('attachment');
				if(isset($attachFile['error'])){
					$_SESSION['attachFailed'] = $attachFile['error'];
					$uploadError = TRUE;
				}
			}
			
			if(!$uploadError){
				if($this->M_newsletter->insert($_POST)){
					//get newsletter insert id
					$newsletter_id = $this->db->insert_id();
					//if attach file occur
					if(isset($attachFile['data'])){
						$this->M_newsletter->attach($newsletter_id, $attachFile['data']['file_name']);
					}
					$_SESSION['saved'] = TRUE;
					redirect('admin/newsletter');
				}else{
					$_SESSION['saved'] = FALSE;
				}
			}else{
				//set page data
				$data['title'] = 'Add Newsletter';
				$data['content'] = 'admin/newsletter/newsletter_add';
				$data['sitename'] = $this->M_website->getName();
				//parse template
				$this->parser->parse('admin/template', $data);
			}
		}
	}
	
	function view($id){
		//set page data
		$data['newsletter'] = $this->M_newsletter->get($id);
		$data['title'] = 'View Newsletter';
		$data['content'] = 'admin/newsletter/newsletter_view';
		$data['sitename'] = $this->M_website->getName();
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function edit($id){
		//set page data
		$data['newsletter'] = $this->M_newsletter->get($id);
		$data['title'] = 'Edit Newsletter';
		$data['content'] = 'admin/newsletter/newsletter_edit';
		$data['sitename'] = $this->M_website->getName();
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function update(){
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('body', 'Body', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			//set page data
			$data['newsletter'] = $this->M_newsletter->get($this->input->post('id_newsletter'));
			$data['title'] = 'Edit Newsletter';
			$data['content'] = 'admin/newsletter/newsletter_edit';
			$data['sitename'] = $this->M_website->getName();
			//parse template
			$this->parser->parse('admin/template', $data);
		}
		else
		{
			//FILE ATTACHMENT
			$uploadError = FALSE;
			if($_FILES['attachment']['name'] != ''){
				$attachFile = $this->attach_file('attachment');
				if(isset($attachFile['error'])){
					$_SESSION['attachFailed'] = $attachFile['error'];
					$uploadError = TRUE;
				}
			}
			
			if(!$uploadError){
				if($this->M_newsletter->update($_POST)){
					//get newsletter insert id
					$newsletter_id = $this->input->post('id_newsletter');
					//if attach file occur
					if(isset($attachFile['data'])){
						$this->M_newsletter->attach($newsletter_id, $attachFile['data']['file_name']);
						//remove file from uploads folder
						$this->removeAttachment($this->input->post('attachment'));
					}
					$_SESSION['saved'] = TRUE;
					redirect('admin/newsletter');
				}else{
					$_SESSION['saved'] = FALSE;
				}
			}else{
				//set page data
				$data['newsletter'] = $this->M_newsletter->get($this->input->post('id_newsletter'));
				$data['title'] = 'Edit Newsletter';
				$data['content'] = 'admin/newsletter/newsletter_edit';
				$data['sitename'] = $this->M_website->getName();
				//parse template
				$this->parser->parse('admin/template', $data);
			}
		}	
	}
	
	function delete($id){
		//remove file attachment from uploads folder
		$newsletter = $this->M_newsletter->get($id);
		if($newsletter['attachment']) $this->removeAttachment($newsletter['attachment']);
		//delete from database
		if($this->M_newsletter->delete($id)){
			$_SESSION['deleted'] = TRUE;	
			redirect('admin/newsletter');
		}else{
			$_SESSION['deleted'] = FALSE;
		}
	}
	
	function send($newsletterId){
		$msg_fail = 0;
		$sitename = $this->M_website->getName();
		$admin = $this->M_administrator->getSuperAdmin();
		$subscribers = $this->M_subscribers->get_subscribers();
		$subs_rows = count($subscribers);
		$newsletter = $this->M_newsletter->get($newsletterId);
		
		//get admin outgoing email
		$this->load->model('default/m_settings');
                $admin_email = $this->m_settings->get('admin_outgoing_email')->setting_value;
                
		if($subs_rows){
			foreach($subscribers as $row){
				$this->email->clear(TRUE);
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
				$this->email->from($admin_email, $sitename);
				$this->email->to($row['email']);
				$this->email->subject($newsletter['title']);
				$this->email->message(sprintf($newsletter['body'], base_url(), $row['subscription_key']));
				if(!empty($newsletter['attachment'])){
					$file = str_replace('system/','',BASEPATH).'uploads/'.$newsletter['attachment'];
					$this->email->attach($file);
				}
				
				if(!$this->email->send()){
					$msg_fail++;
					$_SESSION['sendingFailed'] = $msg_fail;
				}else{
					$_SESSION['sendingFailed'] = FALSE;
				}
			
			}
		}else{
			$_SESSION['noSubscribers'] = TRUE;
		}
		redirect('admin/newsletter');
	}
	
	function attach_file($field_name){
		$config['upload_path'] = str_replace('system/','',BASEPATH).'uploads/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls|xlsx|ppt|txt|zip|rar';
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload($field_name)){
			$upload = array('error' => $this->upload->display_errors('<p class="red">','</p>'));
			return $upload;
		}else{
			$upload = array('data' => $this->upload->data());
			return $upload;
		}
	}
	
	function detach_file($id){
		$newsletter = $this->M_newsletter->get($id);
		if(count($newsletter)){
			if(!$this->removeAttachment($newsletter['attachment']) || !$this->M_newsletter->detach($newsletter['id_newsletter'])){
				$_SESSION['detachFailed'] = TRUE;
			}else{
				$_SESSION['detachFailed'] = FALSE;
			}
		}
		redirect('admin/newsletter/edit/'.$id);
	}
	
	function removeAttachment($file){
		$filePath = str_replace('system/','',BASEPATH).'uploads/'.$file;
		if(file_exists($filePath)){
			if(is_file($filePath))unlink($filePath);
			return TRUE;
		}
		return FALSE;
	}
	
	function download($id){
		$newsletter = $this->M_newsletter->get($id);
		if(count($newsletter)){
			$filePath = str_replace('system/','',BASEPATH).'uploads/'.$newsletter['attachment'];
			$name = $newsletter['attachment'];
			force_download($name, file_get_contents($filePath));
			return TRUE;
		}
		return FALSE;
	}
	
	function pagination($perpage){
		/*PAGINATION SETTING*/
		$config['base_url'] = base_url().index_page().'admin/newsletter/index/';
		$config['total_rows'] = $this->M_newsletter->get_count(); 
		$config['per_page'] = $perpage; 
		$config['uri_segment'] = 4;
		$config['num_links'] = 4;
		//first and last links
		$config['first_link'] = '&laquo; First';
		$config['last_link'] = 'Last &raquo;';
		//first link tags
		$config['first_tag_open'] = '<li style="margin-right:20px;">';
		$config['first_tag_close'] = '</li>';
		//last link tags
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '<li>';
		//next link tags
		$config['next_link'] = 'Next &raquo;';
		$config['next_tag_open'] = '<li style="margin-right:20px;margin-left:10px;"">';
		$config['next_tag_close'] = '</li>';
		//previous link tags
		$config['prev_link'] = '&laquo; Previous';
		$config['prev_tag_open'] = '<li style="margin-right:10px;">';
		$config['prev_tag_close'] = '</li>';
		//current link tags
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		//links tags
		$config['num_tag_open'] = '<li class="pages">';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
	}
	
	function action(){ 
		$uri_4 = $this->input->post('uri_4');
		$failCtr = 0;
		$successCtr = 0;
		if(!$this->input->post('newsletters')){
			$_SESSION['noSelected'] = TRUE;
		}else{
			switch($this->input->post('selectAction')){
				case 'delete':
					//DELETE
					$_SESSION['action'] = TRUE;
					foreach($this->input->post('newsletters') as $row){
						if(!$this->M_newsletter->delete($row)){
							$failCtr++;
							$_SESSION['actionsFailed'] = $failCtr;
						}else{
							$successCtr++;
							$_SESSION['actionsSuccess'] = $successCtr;
						}
					}
					break;
			}
		}
		redirect('admin/newsletter/index/'.$uri_4);
	}
	
}

/* End of file newsletter.php */
/* Location: ./application/controllers/admin/newsletter.php */