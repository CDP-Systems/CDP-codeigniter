<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_us extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logged_in')) redirect('admin/login');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->helper('text');
		$this->load->helper('csv');
		$this->load->model('admin/M_administrator');
		$this->load->model('admin/M_website');
		$this->load->model('admin/M_contact_us');
		$this->load->model('admin/M_transactional_emails');
		session_start();
	}
	
	function index($offset = 0){
		//set pagination
		$perpage = 10;
		$this->pagination($perpage);
		//set page data
		$data['contact_us_logs'] = $this->M_contact_us->get_all($perpage, $offset);
		$data['title'] = 'Contact Us';
		$data['content'] = 'admin/contact_us/contact_us';
		$data['sitename'] = $this->M_website->getName();
		//actions settled
		if(isset($_SESSION['deleted'])){
			$data['deleted'] = $_SESSION['deleted']; unset($_SESSION['deleted']);
		}elseif(isset($_SESSION['noSelected'])){
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
	
	function settings(){
		$this->load->model('default/m_settings');
		//get transactional email
		$email_recipient= $this->m_settings->get('contact_us_email_recipient');
		$email_confirmation = $this->m_settings->get('contact_us_email_confirmation');
		$email_confirmation_subj = $this->m_settings->get('contact_us_email_confirmation_subject');
		$email_admin_notification = $this->m_settings->get('contact_us_admin_notificaion');
		$email_admin_notification_subj = $this->m_settings->get('contact_us_admin_notificaion_subject');
		
		//set page data
		$data['title'] = 'Contact Us Settings';
		$data['content'] = 'admin/contact_us/contact_us_settings';
		$data['sitename'] = $this->M_website->getName();
		$data['contact_us_email_recipient'] =  $email_recipient->setting_value;
		$data['contact_us_email_confirmation'] = $email_confirmation->setting_value;
		$data['contact_us_email_confirmation_subject'] = $email_confirmation_subj->setting_value;
		$data['contact_us_admin_notificaion'] = $email_admin_notification->setting_value;
		$data['contact_us_admin_notificaion_subject'] = $email_admin_notification_subj->setting_value;
		if(isset($_SESSION['saved'])){
			$data['saved'] = $_SESSION['saved']; unset($_SESSION['saved']);
		}
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function settings_save(){
		$this->load->model('default/m_settings');
		//get transactional email
		$email_recipient= $this->m_settings->get('contact_us_email_recipient');
		$email_confirmation = $this->m_settings->get('contact_us_email_confirmation');
		$email_admin_notification = $this->m_settings->get('contact_us_admin_notificaion');
		
		//set page data
		$data['title'] = 'Contact Us Settings';
		$data['content'] = 'admin/contact_us/contact_us_settings';
		$data['sitename'] = $this->M_website->getName();
		$data['contact_us_email_recipient'] = $this->input->post('contact_us_email_recipient');
		$data['contact_us_email_confirmation'] = $this->input->post('contact_us_email_confirmation');
		$data['contact_us_email_confirmation_subject'] = $this->input->post('contact_us_email_confirmation_subject');
		$data['contact_us_admin_notificaion'] = $this->input->post('contact_us_admin_notificaion');
		$data['contact_us_admin_notificaion_subject'] = $this->input->post('contact_us_admin_notificaion_subject');
		
		//validate form
		$this->form_validation->set_rules('contact_us_email_recipient','Email Recipient', 'required|valid_emails');
		$this->form_validation->set_rules('contact_us_email_confirmation', 'Contact Us message [Confirmation]', 'required');
		$this->form_validation->set_rules('contact_us_email_confirmation_subject', 'Subject' ,'required');
		$this->form_validation->set_rules('contact_us_admin_notificaion', 'Contact Us message [Admin Noification]', 'required');
		$this->form_validation->set_rules('contact_us_admin_notificaion_subject', 'Subject' ,'required');
		if($this->form_validation->run()){
			$_SESSION['saved'] = TRUE;
			if ($this->m_settings->save_settings($data)){

				$this->session->set_flashdata('message', 'Settings Saved.');
				redirect('admin/contact_us/settings');
			}
		}
		//parse template
		$this->parser->parse('admin/template', $data);
	}

	function view($id){
		//set page data
		$data['title'] = 'View Contact Us Sender';
		$data['content'] = 'admin/contact_us/contact_us_view';
		$data['sitename'] = $this->M_website->getName();
		$data['contact'] = $this->M_contact_us->get($id);
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function delete($id){
		if($this->M_contact_us->delete($id)){
			$_SESSION['deleted'] = TRUE;	
			redirect('admin/contact_us');
		}
	}
	
	function action(){
		$uri_4 = $this->input->post('uri_4');
		$failCtr = 0;
		$successCtr = 0;
		if(!$this->input->post('contacts')){
			$_SESSION['noSelected'] = TRUE;
		}else{
			switch($this->input->post('selectAction')){
				case 'delete':
					//DELETE
					$_SESSION['action'] = 1;
					foreach($this->input->post('contacts') as $row){
						if(!$this->M_contact_us->delete($row)){
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
		redirect('admin/contact_us/index/'.$uri_4);
	}
	
	function export(){
		$website = $this->M_website->getName();
		$query = $this->db->get('contact_us');
		query_to_csv($query, TRUE, $website.'-Contacts.csv');
	}
	
	function pagination($perpage){
		/*PAGINATION SETTING*/
		$config['base_url'] = base_url().index_page().'admin/contact_us/index/';
		$config['total_rows'] = $this->M_contact_us->get_count(); 
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
/* End of file contact_us.php */
/* Location: ./application/controllers/admin/contact_us.php */