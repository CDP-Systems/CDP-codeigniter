<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logged_in')) redirect('admin/login');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->helper('text');
		$this->load->model('default/M_faq');
		$this->load->model('default/M_faq_category');
		$this->load->model('admin/M_website');
		$this->load->model('admin/M_administrator');
		session_start();
	}
	
	function index($offset = 0){
		//set pagination
		$pagination_config = array(
			'perpage' => 10,
			'base_url' => base_url().index_page().'admin/faq/index/',
			'count' => $this->M_faq->get_count()
		);
		$this->pagination($pagination_config);
		//set page data
		$data['faq'] = $this->M_faq->get_all($pagination_config['perpage'], $offset);
		$data['title'] = 'FAQ';
		$data['content'] = 'admin/faq/faq';
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
		$data['title'] = 'Add FAQ';
		$data['content'] = 'admin/faq/faq_add';
		$data['sitename'] = $this->M_website->getName();
		$data['categories'] = $this->M_faq_category->get_categories();
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function edit($id){
		//set page data
		$data['title'] = 'Edit FAQ';
		$data['content'] = 'admin/faq/faq_edit';
		$data['sitename'] = $this->M_website->getName();
		$data['categories'] = $this->M_faq_category->get_categories();
		$data['faq'] = $this->M_faq->get($id);
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function update($id){
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('question', 'Question', 'required');
		$this->form_validation->set_rules('answer', 'Answer', 'required');
		if ($this->form_validation->run() == FALSE){
			//set page data
			$data['title'] = 'Edit FAQ';
			$data['content'] = 'admin/faq/faq_edit';
			$data['sitename'] = $this->M_website->getName();
			$data['categories'] = $this->M_faq_category->get_categories();
			$data['faq'] = $this->M_faq->get($id);
			//parse template
			$this->parser->parse('admin/template', $data);
		}else{
			if($this->M_faq->update($_POST)){
				$this->session->set_flashdata('saved', TRUE);
				redirect('admin/faq');
			}
		}
	}
	
	function save(){
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('question', 'Question', 'required');
		$this->form_validation->set_rules('answer', 'Answer', 'required');
		if ($this->form_validation->run() == FALSE){
			//set page data
			$data['title'] = 'Add FAQ';
			$data['content'] = 'admin/faq/faq_add';
			$data['sitename'] = $this->M_website->getName();
			$data['categories'] = $this->M_faq_category->get_categories();
			//parse template
			$this->parser->parse('admin/template', $data);
		}else{
			if($this->M_faq->insert($_POST)){
				$this->session->set_flashdata('saved', TRUE);
				redirect('admin/faq');
			}
		}
	}
	
	function action(){
		$uri_4 = $this->input->post('uri_4');
		$failCtr = 0;
		$successCtr = 0;
		if(!$this->input->post('faq')){
			$this->session->set_flashdata('noSelected', TRUE);
		}else{
			switch($this->input->post('selectAction')){
				case 'delete':
					//DELETE
					$this->session->set_flashdata('action', 'deleted'); 
					foreach($this->input->post('faq') as $row){ 
					
						if(!$this->M_faq->delete($row)){ 
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
		redirect('admin/faq/index/'.$uri_4);
	}
	
	function delete($id){
		if($this->M_faq->delete($id)){
			$this->session->set_flashdata('deleted', TRUE);	
			redirect('admin/faq');
		}
	}
	
	function add_category(){
		//set page data
		$data['title'] = 'Add FAQ Category';
		$data['content'] = 'admin/faq/faq_add_category';
		$data['sitename'] = $this->M_website->getName();
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function edit_category($id){
		//set page data
		$data['category'] = $this->M_faq_category->get($id);
		$data['title'] = 'Edit FAQ Category';
		$data['content'] = 'admin/faq/faq_edit_category';
		$data['sitename'] = $this->M_website->getName();
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function category($offset = 0){
		//set pagination
		$pagination_config = array(
			'perpage' => 10,
			'base_url' => base_url().index_page().'admin/faq/category/',
			'count' => $this->M_faq_category->get_count()
		);
		$this->pagination($pagination_config);
		//set page data
		$data['categories'] = $this->M_faq_category->get_all($pagination_config['perpage'], $offset);
		$data['title'] = 'FAQ Category';
		$data['content'] = 'admin/faq/faq_category';
		$data['sitename'] = $this->M_website->getName();
		
		//for actions message
		$data['action'] = $this->session->flashdata('action');
		$data['saved'] = $this->session->flashdata('saved');
		$data['deleted'] = $this->session->flashdata('deleted');
		$data['no_selected'] = $this->session->flashdata('noSelected');
		$data['actions_failed'] = $this->session->flashdata('actionsFailed'); 
		$data['actions_success'] = $this->session->flashdata('actionsSuccess'); 
		
		//parse template
		$this->parser->parse('admin/template', $data);
	}
	
	function category_save(){ 
		$this->form_validation->set_rules('title', 'Title', 'required');
		if ($this->form_validation->run() == FALSE){
			//set page data
			$data['title'] = 'Add FAQ Category';
			$data['content'] = 'admin/faq/faq_add_category';
			$data['sitename'] = $this->M_website->getName();
			//parse template
			$this->parser->parse('admin/template', $data);
		}else{
			if($this->M_faq_category->insert($_POST)){
				$this->session->set_flashdata('saved', TRUE);
				redirect('admin/faq/category');
			}
		}
	}
	
	function category_update($id){
		$this->form_validation->set_rules('title', 'Title', 'required');
		if ($this->form_validation->run() == FALSE){
			//set page data
			$data['category'] = $this->M_faq_category->get($id);
			$data['title'] = 'Edit FAQ Category';
			$data['content'] = 'admin/faq/faq_edit_category';
			$data['sitename'] = $this->M_website->getName();
			//parse template
			$this->parser->parse('admin/template', $data);
		}else{
			if($this->M_faq_category->update($_POST)){
				$this->session->set_flashdata('saved', TRUE);
				redirect('admin/faq/category');
			}
		}
	}
	
	function category_delete($id){
		if($this->M_faq_category->delete($id)){
			$this->session->set_flashdata('deleted', TRUE);	
			redirect('admin/faq/category');
		}
	}
	
	function category_action(){ 
		$uri_4 = $this->input->post('uri_4');
		$failCtr = 0;
		$successCtr = 0;
		if(!$this->input->post('categories')){
			$this->session->set_flashdata('noSelected', TRUE);
		}else{
			switch($this->input->post('selectAction')){
				case 'delete':
					//DELETE
					$this->session->set_flashdata('action', 'deleted'); 
					foreach($this->input->post('categories') as $row){ 
					
						if(!$this->M_faq_category->delete($row)){ 
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
		redirect('admin/faq/category/'.$uri_4);
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
/* End of file faq.php */
/* Location: ./application/controllers/admin/faq.php */