<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seo extends MY_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logged_in')) redirect('admin/login');
		$this->load->library('form_validation');
		$this->load->model('admin/M_website');
	}
	
	function index(){
		//set page data
		$data['title'] = 'SEO';
		$data['content'] = 'admin/seo/form';
		$data['sitename'] = $this->M_website->getName();
		$data['website'] = $this->M_website->getWebsite();
		$data['saved'] = $this->session->flashdata('saved');
		//parse template
		$this->parser->parse('admin/template', $data);
	}

	function save(){
		$this->form_validation->set_rules('default_metakeywords', 'Global Meta Keywords', 'required');
		$this->form_validation->set_rules('default_metadesc', 'Global Meta Description', 'required');
		$this->form_validation->set_rules('meta_robots', 'Meta Robots', 'required');
		if ($this->form_validation->run()){ 
			if($this->M_website->updateSeo($_POST)){             
				$this->session->set_flashdata('saved', TRUE);
				//redirect page
				redirect('admin/seo');
			}
		}else{
			//set page data
			$data['title'] = 'SEO';
			$data['content'] = 'admin/seo/form';
			$data['sitename'] = $this->M_website->getName();
			$data['website'] = $this->M_website->getWebsite();
			$data['saved'] = $this->session->flashdata('saved');
			//parse template
			$this->parser->parse('admin/template', $data);
		}
	}
	
	function advanced()
	{
		$this->load->helper('cs_functions');
		
		$data['sitename'] = $this->M_website->getName();
		$data['website'] = $this->M_website->getWebsite();
		$data['title'] = 'Advanced Site Statistics';
		$data['content'] = 'admin/seo/advanced';		
				
		$data['url'] = '';
		if ($this->get_setting('seo_enable_advanced')->setting_value == 1)
		{
			$data['hash'] = base64_encode(date('Ymd') . 'MahalNaAraw');
			$data['url']  = base_url() . 'webstat/index.php?hash=' . $data['hash'];
		}
		
		$this->parser->parse('admin/template', $data);
	}
}

/* End of file faq.php */
/* Location: ./application/controllers/admin/seo.php */