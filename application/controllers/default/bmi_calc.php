<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bmi_calc extends MY_Controller{

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
		$this->form_validation->set_rules('feet', 'Height', 'required');
		$this->form_validation->set_rules('pounds', 'Weight', 'required');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
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
			$feet = $this->input->post('feet', TRUE);
			$inches = $this->input->post('inches', TRUE);
			$pounds = $this->input->post('pounds', TRUE);
			$gender = $this->input->post('gender');
			//get BMI
			$BMI = $this->process($feet, $inches, $pounds);
			if ($BMI <= 18.5){
				$weight= "underweight";
				$health_risk= "minimal";
			}

			if ($BMI > 18.5 && $BMI <= 24.9){
				$weight= "of normal weight";
				$health_risk= "a minimal";
			}

			if ($BMI >= 25 && $BMI <= 29.9){
				$weight= "overweight";	
				$health_risk= "an increased";					
			}

			if ($BMI >= 30 && $BMI <= 34.9){
				$weight= "obese";
				$health_risk= "a high";
			}
			
			if ($BMI >= 35 && $BMI <= 39.9){
				$weight= "severely obese";
				$health_risk= "a very high";
			}
		
			if ($BMI >= 40){
				$weight= "morbidly obese";
				$health_risk= "an extremely high";
			}
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
				$data['bmi'] = $BMI;
				$data['weight'] = $weight;
				$data['health_risk'] = $health_risk;
				
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
		}
		//parse template
        $data = array_merge($data, $this->view_data);
		$this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $data);
	}
	
	function process($feet, $inches, $pounds){  
	   $v = $feet;
	   $u = $inches;
	   $w = $pounds;
	   
		// Format values for the BMI calculation
		if (!$this->chkw($u)){
			$ii = 0;
			$u= 0;
		}else{
			$it = $u * 1;	
			$ii = (float)$it;	
		}

		$fi = (float)$v;
		$fi = $fi * 12;   
		$i = $fi + $ii;

		//Perform the calculation
		$iVal = 0;
		$iVal = $this->cal_bmi($w, $i);
		
		return $iVal;
	}
	
	function chkw($w){
		if (is_nan(intval($w))){
		    return false;
		}else if ($w < 0){
		    return false;
		}
		else{
			return true;
		}
	}
	
	function cal_bmi($lbs, $ins){   
	   $h2 = $ins * $ins;
	   $bmi = $lbs / $h2; 
	   $bmi = $bmi * 703;
	   $f_bmi = floor($bmi); 
	   $diff  = $bmi - $f_bmi;
	   $diff = $diff * 10;
	   $diff = round($diff);
	   
	   
	   if ($diff == 10){
	      // Need to bump up the whole thing instead
	      $f_bmi += 1;
	      $diff = 0;
	   }
	   $bmi = $f_bmi . "." . $diff;
	   return $bmi;
	}
	
	
}


/* End of file bmi_calc.php */
/* Location: ./application/controllers/default/bmi_calc.php */
