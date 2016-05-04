<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Podcast extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logged_in')) redirect('admin/login');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->helper('download');
		$this->load->model('admin/M_website');
		$this->load->model('default/M_podcast');
	}

	function index($offset = 0){
		//set pagination
		$pagination_config = array(
			'perpage' => 10,
			'base_url' => base_url().index_page().'admin/podcast/index/',
			'count' => $this->M_podcast->get_count()
		);
		$this->pagination($pagination_config);
		//set page data
		$data['podcasts'] = $this->M_podcast->get_all($pagination_config['perpage'], $offset);
		$data['title'] = 'Podcast';
		$data['content'] = 'admin/podcast/list';
		$data['sitename'] = $this->M_website->getName();
	
		//for actions messages
		$data['action'] = $this->session->flashdata('action');
		$data['saved'] = $this->session->flashdata('saved');
		$data['deleted'] = $this->session->flashdata('deleted');
		$data['no_selected'] = $this->session->flashdata('noSelected');
		$data['actions_failed'] = $this->session->flashdata('actionsFailed'); 
		$data['actions_success'] = $this->session->flashdata('actionsSuccess');
		
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function add(){
		//set page data
		$data['title'] = 'Upload MP3';
		$data['content'] = 'admin/podcast/add';
		$data['sitename'] = $this->M_website->getName();
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function edit($id){
		//set page data
		$data['podcast'] = $this->M_podcast->get($id);
		$data['title'] = 'Upload MP3';
		$data['content'] = 'admin/podcast/edit';
		$data['sitename'] = $this->M_website->getName();
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function save(){ 
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('author', 'Author', 'required');
		$this->form_validation->set_rules('desc', 'Description');
		if ($this->form_validation->run() == FALSE){
			//set page data
			$page = array('content' => 'admin/podcast/add', 'title' => 'Upload MP3');
			//parse template
			$this->parser->parse('admin/template', $this->set_page_data($page));
		}else{
			//FILE UPLOAD
			$uploaded_file = $this->upload_file();
			if(isset($uploaded_file['error'])){
				//set page data
				$page = array('content' => 'admin/podcast/add', 'title' => 'Upload MP3', 'file_error' => $uploaded_file['error']);
				//parse template
				$this->parser->parse('admin/template', $this->set_page_data($page));
			}else{
				if(isset($uploaded_file['data'])){
					$_POST['file_name'] = $uploaded_file['data']['file_name'];
					$_POST['file_type'] = $uploaded_file['data']['file_type'];
				}
				if($this->M_podcast->insert($_POST)){
					$this->session->set_flashdata('saved', TRUE);
					redirect('admin/podcast');
				}
			}
				
		}
	}
	
	function update($id){
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('author', 'Author', 'required');
		$this->form_validation->set_rules('desc', 'Description');
		if ($this->form_validation->run() == FALSE){
			//set page data
			$page = array(
				'podcast' => $this->M_podcast->get($id),
				'content' => 'admin/podcast/edit', 
				'title' => 'Edit Podcast'
			);
			//parse template
			$this->parser->parse('admin/template', $this->set_page_data($page));
		}else{
			//FILE UPLOAD
			$uploadError = FALSE; 
			if($_FILES['mp3']['name'] != ''){ 
				$uploaded_file = $this->upload_file();
				if(isset($uploaded_file['error'])){
					$uploadError = TRUE;
				}
			}
			
			if($uploadError){
				//set page data
				$page = array(
					'podcast' => $this->M_podcast->get($id),
					'content' => 'admin/podcast/edit', 
					'title' => 'Edit Podcast', 
					'file_error' => $uploaded_file['error']
				);
				//parse template
				$this->parser->parse('admin/template', $this->set_page_data($page));
			}else{
				if(isset($uploaded_file['data'])){ 
					//delete current mp3
					$this->delete_mp3($this->input->post('current_mp3'));
					$_POST['file_name'] = $uploaded_file['data']['file_name'];
					$_POST['file_type'] = $uploaded_file['data']['file_type'];
				}else{
					//use current mp3
					$podcast_data = $this->M_podcast->get($id);
					$_POST['file_name'] = $podcast_data['file_name'];
					$_POST['file_type'] = $podcast_data['file_type'];
				}
				if($this->M_podcast->update($_POST)){
					$this->session->set_flashdata('saved', TRUE);
					redirect('admin/podcast');
				}
			}
		}
	}
	
	function upload_file(){
		$config['upload_path'] = str_replace('system/','',BASEPATH).'uploads/podcasts/';
		$config['allowed_types'] = 'mp3';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('mp3')){
			$file = array('error' => $this->upload->display_errors('<div class="red">','</div>'));
		}
		else{
			$file = array('data' => $this->upload->data());
		}
		return $file;
	}
	
	function set_page_data($page = NULL){
		$data['title'] = $page['title'];
		$data['content'] = $page['content'];
		$data['sitename'] = $this->M_website->getName();
		$data['file_error'] = (isset($page['file_error']))?$page['file_error']:'';
		$data['podcast'] = (isset($page['podcast']))?$page['podcast']:'';
		return $data;
	}
	
	function action(){
		$uri_4 = $this->input->post('uri_4');
		$failCtr = 0;
		$successCtr = 0;
		if(!$this->input->post('podcasts')){
			$this->session->set_flashdata('noSelected', TRUE);
		}else{
			switch($this->input->post('selectAction')){
				case 'delete':
					//DELETE
					$this->session->set_flashdata('action', 'deleted'); 
					foreach($this->input->post('podcasts') as $id_podcast){ 
						//delete mp3s from uploads directory
						$podcast = $this->M_podcast->get($id_podcast);
						if(count($podcast))$this->delete_mp3($podcast['file_name']);
						
						//delete podcasts 
						if(!$this->M_podcast->delete($id_podcast)){ 
							$failCtr++;
							$this->session->set_flashdata('actionsFailed', $failCtr);
						}else{
							$successCtr++;
							$this->session->set_flashdata('actionsSuccess', $successCtr);
						}	
					}
					break;
			}
		}
		redirect('admin/podcast/index/'.$uri_4);
	}
	
	function delete($id){
		//delete mp3s from uploads directory
		$podcast = $this->M_podcast->get($id);
		if(count($podcast))$this->delete_mp3($podcast['file_name']);
		//delete podcast
		if($this->M_podcast->delete($id)){
			$this->session->set_flashdata('deleted', TRUE);	
			redirect('admin/podcast');
		}
	}
	
	function delete_mp3($file){
		$filePath = str_replace('system/','',BASEPATH).'uploads/podcasts/'.$file;
		if(file_exists($filePath)){
			if(is_file($filePath))unlink($filePath);
			return TRUE;
		}
		return FALSE;
	}
	
	function download_mp3($id){ 
		$podcast = $this->M_podcast->get($id); 
		if(count($podcast)){
			$filePath = str_replace('system/','',BASEPATH).'uploads/podcasts/'.$podcast['file_name'];
			$name = $podcast['file_name'];
			force_download($name, file_get_contents($filePath));
			return TRUE;
		}
		return FALSE;
	}
	
	function subscription(){
		$this->load->model('default/m_settings');
		//set page data
		$data['title'] = 'Subscription Text';
		$data['content'] = 'admin/podcast/subscription';
		$data['sitename'] = $this->M_website->getName();
		$data['subscription_text'] = $this->m_settings->get('podcast_subscription_text')->setting_value;
		$data['saved'] = $this->session->flashdata('saved');
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function save_subscription(){
		$this->load->model('default/m_settings');
		$data['podcast_subscription_text'] = $this->input->post('subscription_text');
		$this->m_settings->save_settings($data);
		$this->session->set_flashdata('saved', TRUE);
		redirect('admin/podcast/subscription');
	}
	
	function pagination($pagination_config){
		/*PAGINATION SETTING*/
		$config['base_url'] = $pagination_config['base_url'];
		$config['total_rows'] = $pagination_config['count']; 
		$config['per_page'] = $pagination_config['perpage']; 
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

/* End of file podcast.php */
/* Location: ./application/controllers/admin/podcast.php */