<?php 
/*
|----------------------
| CONTENT PAGE
|----------------------
*/



if(($this->session->userdata('logged_in')) && ($content != '')){
	$this->load->view('default/page/editor');
}

?>



    <div id="editorcontents">
    <?php 
		//CONTENT
		if(isset($content))echo $content; 
	?>
	</div>
	
	<?php //DOWNLOADS ?>
	<?php $this->load->view('default/page/downloads'); ?>
    
	<?php
    //INTEGRATE CLASS
    switch($class){
		//FAQ
		case 'faq':
			$this->load->view('default/faq/categories');
			$this->load->view('default/faq/list');
            break;
		//contact us
        case 'contact_us':
            $this->load->view('default/contact_us/contact_us_form'); 
            break;
		//newsletter
        case 'newsletter':
			switch($this->uri->segment(2)){
				case 'view':
					$this->load->view('default/newsletter/newsletter_view'); 
					break;
				default:
					$this->load->view('default/newsletter/newsletter_list'); 
					break;
			}
            break;
		//search
        case 'search': 
			switch($this->uri->segment(2)){
				case 'result':
					$this->load->view('default/search/search_result');
					break;
				default:
					$this->load->view('default/search/search_form');
			}	 
            break;
		//bmi calculator
		case 'bmi_calc': 
			$segs = $this->uri->segment_array();
			switch(end($segs)){
				case 'compute': 
					if(isset($bmi))$this->load->view('default/bmi_calc/bmi_calc_result');
					else $this->load->view('default/bmi_calc/bmi_calc_form'); 
					break;
				default:
					$this->load->view('default/bmi_calc/bmi_calc_form'); 
					break;
			}
			break;
		//affordability calculator
		case 'affordability_calc':
			$segs = $this->uri->segment_array();
			switch(end($segs)){
				case 'compute': 
					if(isset($results))$this->load->view('default/affordability_calc/affordability_calc_result');
					else $this->load->view('default/affordability_calc/affordability_calc_form');
					break;
				default:
					$this->load->view('default/affordability_calc/affordability_calc_form');
					break;
			}
			break;
		//podcast
		case 'podcast':
			$this->load->view('default/podcast/podcast'); 
			break;
			
		//testimonial 
		case 'testimonial_add':
			$this->load->view('default/testimonials/edit');
			break;
		case 'testimonials': 
			$this->load->view('default/testimonials/list');
			break;
		
		//seminar 
		case 'seminars':
			$segs = $this->uri->segment_array();
			if(preg_match('/[0-9]+/', end($segs)) && in_array('register', $segs)){
				$this->load->view('default/seminars/register');
			}else{
				$this->load->view('default/seminars/list');
			}
			break;
		
		//calendar
		case 'calendar':
			$segs = $this->uri->segment_array();
			if(preg_match('/[0-9]+/', end($segs)) && in_array('view', $segs)){ 
				$this->load->view('default/calendar/view');
			}else{
				$this->load->view('default/calendar/calendar_home');
			}
			break;
			
		//news	
		case 'news':
			$this->load->view('default/news/list');
			break;
		//membership
		case 'membership':
			$segs = $this->uri->segment_array();
			if(end($segs) == 'payment')
				$this->load->view('default/membership/payment');
			else
				$this->load->view('default/membership/form');
			break;
		//ask the expert
		case 'ask_the_expert':
            $this->load->view('default/ask_the_expert/form'); 
            break;
            //online seminar
		case 'online_seminars':
            $this->load->view('default/online_seminars/register');
            break;
    }