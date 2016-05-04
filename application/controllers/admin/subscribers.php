<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscribers extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in')) redirect('admin/login');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->helper('security');
		$this->load->helper('csv');
		$this->load->model('admin/M_subscribers');
		$this->load->model('admin/M_website');
		$this->load->model('admin/M_transactional_emails');
		session_start();
	}

	function index($offset = 0)
	{
		//set pagination
		$perpage = 10;
		$this->pagination($perpage);
		//set page data
		$data['subscribers'] = $this->M_subscribers->get_all($perpage, $offset);
		$data['title'] = 'Mailing List';
		$data['content'] = 'admin/subscribers/subscribers';
		$data['sitename'] = $this->M_website->getName();
		//parse temlate
		$this->parser->parse('admin/template', $data);
	}

	function add(){
		//set page data
		$data['title'] = 'Add Subscriber';
		$data['content'] = 'admin/subscribers/subscribers_add';
		$data['sitename'] = $this->M_website->getName();
		//parse temlate
		$this->parser->parse('admin/template', $data);
	}
	
	function save(){
		//$this->form_validation->set_rules('fname', 'First Name', 'required');
		//$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		/*
		$this->form_validation->set_rules('hospital', 'Hospital');
		$this->form_validation->set_rules('contact', 'Contact');
		$this->form_validation->set_rules('website', 'Website');
		$this->form_validation->set_rules('marketing_head', 'Marketing Head');
		$this->form_validation->set_rules('proper_designation', 'Proper Designation');
		$this->form_validation->set_rules('address', 'Address');
		$this->form_validation->set_rules('contact_person', 'Contact Person');
		$this->form_validation->set_rules('remarks', 'Remarks');
		*/
		if ($this->form_validation->run() == FALSE)
		{
			//set page data
			$data['title'] = 'Add Subscriber';
			$data['content'] = 'admin/subscribers/subscribers_add';
			$data['sitename'] = $this->M_website->getName();
			//parse temlate
			$this->parser->parse('admin/template', $data);
		}
		else
		{
			$_POST['subscription_key'] = do_hash($_POST['email']);
			if($this->M_subscribers->insert($_POST)){
				$_SESSION['saved'] = TRUE;
				redirect('admin/subscribers');
			}
		}
	}
	
	function view($id){
		//set page data
		$data['subscriber'] = $this->M_subscribers->get($id);
		$data['title'] = 'View Subscriber';
		$data['content'] = 'admin/subscribers/subscribers_view';
		$data['sitename'] = $this->M_website->getName();
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function edit($id){
		//set page data
		$data['subscriber'] = $this->M_subscribers->get($id);
		$data['title'] = 'Edit Subscriber';
		$data['content'] = 'admin/subscribers/subscribers_edit';
		$data['sitename'] = $this->M_website->getName();
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function update(){
		//$this->form_validation->set_rules('fname', 'First Name', 'required');
		//$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		if ($this->form_validation->run() == FALSE)
		{
			//set page data
			$data['subscriber'] = $this->M_subscribers->get($this->input->post('id_subscriber'));
			$data['title'] = 'Edit Subscriber';
			$data['content'] = 'admin/subscribers/subscribers_edit';
			$data['sitename'] = $this->M_website->getName();
			//parse template
			$this->parser->parse('admin/template', $data);
		}
		else
		{
			$_POST['subscription_key'] = do_hash($_POST['email']);
			if($this->M_subscribers->update($_POST)){
				$_SESSION['saved'] = TRUE;
				redirect('admin/subscribers');
			}
		}	
	}
	
	function delete($id){
		if($this->M_subscribers->delete($id)){
			$_SESSION['deleted'] = TRUE;	
			redirect('admin/subscribers');
		}else{
			$_SESSION['deleted'] = FALSE;
		}
	}
	
	function unsubscribe($id){
		if($this->M_subscribers->unsubscribe($id)){
			$_SESSION['saved'] = TRUE;	
			redirect('admin/subscribers');
		}else{
			$_SESSION['saved'] = FALSE;
		}
	}
	
	function subscribe($id){
		if($this->M_subscribers->subscribe($id)){
			$_SESSION['saved'] = TRUE;	
			redirect('admin/subscribers');
		}else{
			$_SESSION['saved'] = FALSE;
		}
	}
	
	function import(){
		//set page data
		$data['title'] = 'Import Subscribers';
		$data['content'] = 'admin/subscribers/subscribers_import';
		$data['sitename'] = $this->M_website->getName();
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function do_import(){
		//CSV IMPORT
		$importError = FALSE;
		$file_name = '';
		if($_FILES){
			$csvImport = $this->import_file('csvFile');
			if(isset($csvImport['error'])){
				$_SESSION['importFailed'] = $csvImport['error'];
				$importError = TRUE;
			}elseif(isset($csvImport['data'])){
				$file_name = $csvImport['data']['file_name'];
			}
		}
		
		if(!$importError){
			//TRANSFER DATA INTO DATABASE
			$import_fail = 0;
			$filePath = str_replace('system/','',BASEPATH).'tmp/'.$file_name;
			if (($handle = fopen($filePath, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					if(!$this->M_subscribers->import($data)){
						$import_fail++;
						$_SESSION['importFailed'] = $import_fail;
					}else{
						$_SESSION['importFailed'] = FALSE;
					}
				}
				fclose($handle);
			}	
			//REMOVE CSV FILE FROM tmp/ FOLDER
			if(file_exists($filePath))unlink($filePath);
			redirect('admin/subscribers');
		}else{
			//set page data
			$data['title'] = 'Import Subscribers';
			$data['content'] = 'admin/subscribers/subscribers_import';
			$data['sitename'] = $this->M_website->getName();
			//parse template
			$this->parser->parse('admin/template', $data);
		}
		
	}
	
	function import_file($field_name){
		$config['upload_path'] = str_replace('system/','',BASEPATH).'tmp/';
		$config['allowed_types'] = 'csv';
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload($field_name)){
			$upload = array('error' => $this->upload->display_errors('<p class="red">','</p>'));
			return $upload;
		}else{
			$upload = array('data' => $this->upload->data());
			return $upload;
		}
	}
	
	function action(){
		$uri_4 = $this->input->post('uri_4');
		$failCtr = 0;
		$successCtr = 0;
		if(!$this->input->post('subscribers')){
			$_SESSION['noSelected'] = TRUE;
		}else{
			switch($this->input->post('selectAction')){
				case 'subscribe':
				//SUBSCRIBE
					$_SESSION['action'] = 1;
					foreach($this->input->post('subscribers') as $row){
						if(!$this->M_subscribers->subscribe($row)){
							$failCtr++;
							$_SESSION['actionsFailed'] = $failCtr;
						}else{
							$successCtr++;
							$_SESSION['actionsSuccess'] = $successCtr;
						}
					}
					break;
				case 'unsubscribe':
				//UNSUBSCRIBE
					$_SESSION['action'] = 2;
					foreach($this->input->post('subscribers') as $row){
						if(!$this->M_subscribers->unsubscribe($row)){
							$failCtr++;
							$_SESSION['actionsFailed'] = $failCtr;
						}else{
							$successCtr++;
							$_SESSION['actionsSuccess'] = $successCtr;
						}
					}
					break;
				case 'delete':
				//DELETE
					$_SESSION['action'] = 3;
					foreach($this->input->post('subscribers') as $row){
						if(!$this->M_subscribers->delete($row)){
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
		redirect('admin/subscribers/index/'.$uri_4);
	}
	
	function email(){
		//get transactional emails
		$subscription = $this->M_transactional_emails->get('subscription');
		$unsubscription = $this->M_transactional_emails->get('unsubscription');
		//set page data
		$data['sitename'] = $this->M_website->getName();
		$data['title'] = 'Confirmation Email';
		$data['content'] = 'admin/subscribers/subscribers_email';
		if(isset($_SESSION['saved'])){
			$data['saved'] = $_SESSION['saved']; unset($_SESSION['saved']);
		}
		
		$data['subscription_msg'] = $subscription['message'];
		$data['unsubscription_msg'] = $unsubscription['message'];
		//parse template
		$this->parser->parse('admin/template', $data);
	}	
	
	function saveEmail(){
		$this->form_validation->set_rules('subscription_msg', 'Subscrition Message', 'required');
		$this->form_validation->set_rules('unsubscription_msg', 'Unsubscrition Message', 'required');
		if($this->form_validation->run() == FALSE){
			//get transactional emails
			$subscription = $this->M_transactional_emails->get('subscription');
			$unsubscription = $this->M_transactional_emails->get('unsubscription');
			//set page data
			$data['sitename'] = $this->M_website->getName();
			$data['title'] = 'Confirmation Email';
			$data['content'] = 'admin/subscribers/subscribers_email';
			
			$data['subscription_msg'] = $subscription['message'];
			$data['unsubscription_msg'] = $unsubscription['message'];
			//parse template
			$this->parser->parse('admin/template', $data);
		}else{
			
				if($this->M_transactional_emails->update('subscription', $this->input->post('subscription_msg')) && $this->M_transactional_emails->update('unsubscription', $this->input->post('unsubscription_msg'))){
					$_SESSION['saved'] = TRUE;
					redirect('admin/subscribers/email');
				}
		}
	}
	
	function export(){
		$website = $this->M_website->getName();
		//$this->db->select('id_subscriber,hospital,contact,website,email,marketing_head,	proper_designation,address,contact_person,remarks,active');
		$this->db->select('id_subscriber,fname,lname,email');
		$query = $this->db->get('subscribers');
		query_to_csv($query, TRUE, $website.'-Mailing-List.csv');
	}
	
	function pagination($perpage){
		/*PAGINATION SETTING*/
		$config['base_url'] = base_url().index_page().'admin/subscribers/index/';
		$config['total_rows'] = $this->M_subscribers->get_count(); 
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
	
}

/* End of file subscribers.php */
/* Location: ./application/controllers/admin/subscribers.php */