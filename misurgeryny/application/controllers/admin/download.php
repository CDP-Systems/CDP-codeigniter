<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logged_in')) redirect('admin/login');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->helper('download');
		$this->load->model('admin/M_website');
		$this->load->model('admin/M_page');
		$this->load->model('default/M_download');
		$this->load->model('default/M_download_page_loc');
	}
	
	function index($offset = 0){ 
		//set pagination
		$pagination_config = array(
			'perpage' => 10,
			'base_url' => base_url().index_page().'admin/download/index/',
			'count' => $this->M_download->get_count()
		);
		$this->pagination($pagination_config);
		//set page data
		$data['downloads'] = $this->M_download->get_all($pagination_config['perpage'], $offset);
		$data['title'] = 'Download';
		$data['content'] = 'admin/download/list';
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
		$data['title'] = 'Add Download';
		$data['content'] = 'admin/download/add';
		$data['sitename'] = $this->M_website->getName();
		$data['pages'] = $this->M_page->get_all();
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function edit($id){
		//set page data
		$data['download'] = $this->M_download->get($id);
		$data['title'] = 'Edit Download';
		$data['content'] = 'admin/download/edit';
		$data['sitename'] = $this->M_website->getName();
		$data['pages'] = $this->M_page->get_all();
		$data['page_location'] = $this->M_download_page_loc->getByDownloads($id);
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function update($id){
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('desc', 'Description');
		$this->form_validation->set_rules('page_location', 'Page Location', 'required');
		if ($this->form_validation->run() == FALSE){
			//set page data
			$page = array(
				'page_locations' => $this->M_download_page_loc->getByDownloads($id),
				'download' => $this->M_download->get($id), 
				'content' => 'admin/download/edit', 
				'title' => 'Edit Download',
				'page_location' => $this->input->post('page_location')
			);
			//parse template
			$this->parser->parse('admin/template', $this->set_page_data($page));
		}else{
			//FILE UPLOAD
			$uploadError = FALSE; 
			if($_FILES['download_file']['name'] != ''){ 
				$uploaded_file = $this->upload_file();
				if(isset($uploaded_file['error'])){
					$uploadError = TRUE;
				}
			}
			
			if($uploadError){
				//set page data
				$page = array(
					'page_locations' => $this->M_download_page_loc->getByDownloads($id),
					'download' => $this->M_download->get($id),
					'content' => 'admin/download/edit', 
					'title' => 'Add Download', 
					'file_error' => $uploaded_file['error'], 
					'page_location' => $this->input->post('page_location')
				);
				//parse template
				$this->parser->parse('admin/template', $this->set_page_data($page));
			}else{
				if(isset($uploaded_file['data'])){ 
					//delete current download
					$this->delete_file($this->input->post('current_file'));
					$_POST['file_name'] = $uploaded_file['data']['file_name'];
					$_POST['file_size'] = $uploaded_file['data']['file_size'];
				}else{
					//use current download
					$download_data = $this->M_download->get($id);
					$_POST['file_name'] = $download_data['file_name'];
					$_POST['file_size'] = $download_data['file_size'];
				}
				if($this->M_download->update($_POST)){
					$id_download = $this->input->post('id_download');
					//delete previous page locations
					$this->M_download_page_loc->deleteByDownload($id_download);
					//insert new page locations
					foreach($this->input->post('page_location') as $id_page){
						$page_loc_data = array(
							'id_page' => $id_page,
							'id_download' => $id_download
						);
						$this->M_download_page_loc->insert($page_loc_data);
					}
					$this->session->set_flashdata('saved', TRUE);
					redirect('admin/download');
				}
			}
		}
	}
	
	function save(){ 
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('desc', 'Description');
		$this->form_validation->set_rules('page_location', 'Page Location', 'required');
		if ($this->form_validation->run() == FALSE){
			//set page data
			$page = array('content' => 'admin/download/add', 'title' => 'Add Download','page_locations' => $this->input->post('page_location'));
			//parse template
			$this->parser->parse('admin/template', $this->set_page_data($page));
		}else{
			//FILE UPLOAD
			$uploaded_file = $this->upload_file();
			if(isset($uploaded_file['error'])){
				//set page data
				$page = array('content' => 'admin/download/add', 'title' => 'Add Download', 'file_error' => $uploaded_file['error'], 'page_locations' => $this->input->post('page_location'));
				//parse template
				$this->parser->parse('admin/template', $this->set_page_data($page));
			}else{
				if(isset($uploaded_file['data'])){
					$_POST['file_name'] = $uploaded_file['data']['file_name'];
					$_POST['file_size'] = $uploaded_file['data']['file_size'];
				}
				if($this->M_download->insert($_POST)){
					$id_download = $this->db->insert_id();
					//insert page locations
					foreach($this->input->post('page_location') as $id_page){
						$page_loc_data = array(
							'id_page' => $id_page,
							'id_download' => $id_download
						);
						$this->M_download_page_loc->insert($page_loc_data);
					}
					$this->session->set_flashdata('saved', TRUE);
					redirect('admin/download');
				}
			}
				
		}
	}
	
	function set_page_data($page = NULL){
		$data['title'] = $page['title'];
		$data['content'] = $page['content'];
		$data['sitename'] = $this->M_website->getName();
		$data['pages'] = $this->M_page->get_all();
		$data['file_error'] = (isset($page['file_error']))?$page['file_error']:'';
		$data['page_location'] = (isset($page['page_locations']))?$page['page_locations']:'';
		$data['download'] = (isset($page['download']))?$page['download']:'';
		return $data;
	}
	
	function upload_file(){
		$config['upload_path'] = str_replace('system/','',BASEPATH).'uploads/downloads/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls|xlsx|ppt|pptx|txt|zip|rar';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('download_file')){
			$file = array('error' => $this->upload->display_errors('<div class="red">','</div>'));
		}
		else{
			$file = array('data' => $this->upload->data());
		}
		return $file;
	}
	
	function action(){
		$uri_4 = $this->input->post('uri_4');
		$failCtr = 0;
		$successCtr = 0;
		if(!$this->input->post('downloads')){
			$this->session->set_flashdata('noSelected', TRUE);
		}else{
			switch($this->input->post('selectAction')){
				case 'delete':
					//DELETE
					$this->session->set_flashdata('action', 'deleted'); 
					foreach($this->input->post('downloads') as $id_download){ 
						//delete downloads page location
						$this->M_download_page_loc->deleteByDownload($id_download);
						
						//delete files from uploads directory
						$download = $this->M_download->get($id_download);
						if(count($download))$this->delete_file($download['file_name']);
						
						//delete downloads 
						if(!$this->M_download->delete($id_download)){ 
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
		redirect('admin/download/index/'.$uri_4);
	}
	
	function delete($id){
		//delete downloads page location
		$this->M_download_page_loc->deleteByDownload($id);
						
		//delete files from uploads directory
		$download = $this->M_download->get($id);
		if(count($download))$this->delete_file($download['file_name']);
		
		//delete download
		if($this->M_download->delete($id)){
			$this->session->set_flashdata('deleted', TRUE);	
			redirect('admin/download');
		}
	}
	
	function delete_file($file){
		$filePath = str_replace('system/','',BASEPATH).'uploads/downloads/'.$file;
		if(file_exists($filePath)){
			if(is_file($filePath))unlink($filePath);
			return TRUE;
		}
		return FALSE;
	}
	
	function download_file($id){ 
		$download = $this->M_download->get($id); 
		if(count($download)){
			$filePath = str_replace('system/','',BASEPATH).'uploads/downloads/'.$download['file_name'];
			$name = $download['file_name'];
			force_download($name, file_get_contents($filePath));
			return TRUE;
		}
		return FALSE;
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

/* End of file download.php */
/* Location: ./application/controllers/admin/download.php */