<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Affordability_calc extends MY_Controller{

	function __consctruct(){
		parent::__construct();
	}
	
	function index(){
		//load objects
		$this->load->model('admin/M_website');
		$this->load->model('default/M_page');
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->get_current_module(); 
		//get page data
		$page = $this->M_page->get($url_key);
		//set page data
		if(count($page)){ 
			$data['url_key'] = $url_key; 
			$data['class'] = $page['class'];
			$data['sitename'] = $website['name'];
			$data['title'] = $page['page_title'];
			$data['content'] = $page['content'];
			$data['page'] = 'default/page/inner_page';
			$data['keywords'] = $page['keywords'];
			$data['desc'] = $page['desc'];
			$data['robots'] = $website['meta_robots'];
			$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
			
			//set global meta data if page meta data is blank
			if($page['keywords'] == ''){
				$data['keywords'] = $website['default_metakeywords'];
			}
			if($page['desc'] == ''){
				$data['desc'] = $website['default_metadesc'];
			}
		}
		else{
			//Page Not Found
			redirect('Page_not_found');
		}
		//parse template
        $data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
	}
	
	function compute(){ 
		//load objects
		$this->load->library('form_validation');
		$this->load->model('admin/M_website');
		$this->load->model('default/M_page');
		//get site data
		$website = $this->M_website->getWebsite();
		//get url key
		$url_key = $this->get_current_module(); 
		//get page data
		$page = $this->M_page->get($url_key);
		//validate form
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('food_expenses', 'Food Expenses', 'required');
		$this->form_validation->set_rules('prescriptions_expenses', 'Prescriptions Expenses', 'required');
		$this->form_validation->set_rules('health_expenses', 'Out-of-Pocket Health Expenses', 'required');
		$this->form_validation->set_rules('programs_expenses', 'Weight Loss Programs Expenses', 'required');
		if($this->form_validation->run() == FALSE){
			//set page data
			if(count($page)){ 
				$data['url_key'] = $url_key; 
				$data['class'] = $page['class'];
				$data['sitename'] = $website['name'];
				$data['title'] = $page['page_title'];
				$data['content'] = $page['content'];
				$data['page'] = 'default/page/inner_page';
				$data['keywords'] = $page['keywords'];
				$data['desc'] = $page['desc'];
				$data['robots'] = $website['meta_robots'];
				$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
				
				//set global meta data if page meta data is blank
				if($page['keywords'] == ''){
					$data['keywords'] = $website['default_metakeywords'];
				}
				if($page['desc'] == ''){
					$data['desc'] = $website['default_metadesc'];
				}
			}
			else{
				//Page Not Found
				redirect('Page_not_found');
			}	
		}else{
			//load objects
			$this->load->model('admin/M_website');
			$this->load->model('default/M_page');
			//get site data
			$website = $this->M_website->getWebsite();
			//get url key
			$url_key = $this->get_current_module(); 
			//get page data
			$page = $this->M_page->get($url_key);
		
			$name = $this->input->post('name', TRUE);
			$p1 = $this->input->post('food_expenses');
			$p2 = $this->input->post('prescriptions_expenses');
			$p3 = $this->input->post('health_expenses');
			$p4 = $this->input->post('programs_expenses');
			
			/**expenses**/
			$ap1 = $p1 * 12; $ap2 = $p2 * 12;
			$ap3 = $p3 * 12; $ap4 = $p4 * 12;
			$monthly =  $p1 + $p2 +  $p3 +  $p4;
			$annual  = $ap1 + $ap2 + $ap3 + $ap4;
			
			/**savings**/
			$sp1 = .60 * $p1;
			$sp2 = .50 * $p2;
			$sp3 = .70 * $p3;
			$sp4 = $p4;
			
			$asp1 = $sp1 * 12;
			$asp2 = $sp2 * 12;
			$asp3 = $sp3 * 12;
			$asp4 = $sp4 * 12;
			
			$smt1 = $sp1  + $p2  + $sp3  + $sp4;
			$sat1 = $asp1 + $ap2 + $asp3 + $asp4;
			
			$smt2 = $sp1  + $sp2  + $sp3  + $sp4;
			$sat2 = $asp1 + $asp2 + $asp3 + $asp4;
			
			$smt3 = $sp1  + $sp2  + $sp3  + $sp4;
			$sat3 = $asp1 + $asp2 + $asp3 + $asp4;
		
			$results = array(
				'p1' => number_format($p1),
				'p2' => number_format($p2),
				'p3' => number_format($p3),
				'p4' => number_format($p4),
				'ap1' => number_format($ap1),
				'ap2' => number_format($ap2),
				'ap3' => number_format($ap3),
				'ap4' => number_format($ap4),
				'sp1' => number_format($sp1),
				'sp2' => number_format($sp2),
				'sp3' => number_format($sp3),
				'sp4' => number_format($sp4),
				'asp1' => number_format($asp1),
				'asp2' => number_format($asp2),
				'asp3' => number_format($asp3),
				'asp4' => number_format($asp4), 
				'smt1' => number_format($smt1),
				'smt2' => number_format($smt2),
				'smt3' => number_format($smt3),
				'sat1' => number_format($sat1), 
				'sat2' => number_format($sat2), 
				'sat3' => number_format($sat3)
			);
			
			//set page data
			if(count($page)){  
				$data['url_key'] = $url_key; 
				$data['class'] = $page['class'];
				$data['sitename'] = $website['name'];
				$data['title'] = $page['page_title'];
				$data['content'] = ''; //doesn't need the page content in results page
				$data['page'] = 'default/page/inner_page';
				$data['keywords'] = $page['keywords'];
				$data['desc'] = $page['desc'];
				$data['robots'] = $website['meta_robots'];
				$data['results'] = $results;
				$data['patient_name'] = $name;
				$data['monthly'] = number_format($monthly);
				$data['annual'] = number_format($annual);
                                $this->view_data['content'] = '';//doesn't need the page content in results page
                                
                                //set global meta data if page meta data is blank
				if($page['keywords'] == ''){
					$data['keywords'] = $website['default_metakeywords'];
				}
				if($page['desc'] == ''){
					$data['desc'] = $website['default_metadesc'];
				}
				
				//var_dump($results); die();
			}
			else{
				//Page Not Found
				redirect('Page_not_found');
			}	
		}
		//parse template
            $data = array_merge($data, $this->view_data);

		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
	}
	


}
/* End of file affordability_calc.php */
/* Location: ./application/controllers/default/affordability_calc.php */