<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Self_assessment controller for user view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-05-16
 */
class Self_assessment extends MY_Controller {

    protected $_form_data;

    function __construct()
    {
        parent::__construct();

        $this->load->helper('form');

        // Load the model and assign it to "self_assessments" object.
        $this->load->model('default/m_self_assessment', 'self_assessments');
    }

    // --------------------------------------------------------------------

    /**
     * Default action. This action lists all self_assessments.
     */
    function index($page = 0)
    {
        $self_assessments = $this->self_assessments->fetch_all();

        $this->view_data['page'] = 'default/self_assessment/list';

        if ($self_assessments->num_rows() > 0)
        {
            $pagination['per_page'] = 10;
            $pagination['total_rows'] = $self_assessments->num_rows();

            $this->paginate($pagination);

            $results = $this->self_assessments->fetch_all($pagination['per_page'], $page);

            $this->view_data['self_assessments'] = $results->result();
        }
        
        $this->load->model('default/M_page');
        $url_key = $this->get_current_module(); 
	$page = $this->M_page->get($url_key);
	$this->load->model('admin/M_website');
	$website = $this->M_website->getWebsite();
	
	$this->view_data['robots'] = $website['meta_robots'];			
	$this->view_data['keywords'] = $page['keywords'];
	$this->view_data['desc'] = $page['desc'];
	
	//set global meta data if page meta data is blank
	if($page['keywords'] == ''){
		$this->view_data['keywords'] = $website['default_metakeywords'];
	}
	if($page['desc'] == ''){
		$this->view_data['desc'] = $website['default_metadesc'];
	}

        // Display the form.
        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Take a self_assessment.
     */
    function take_self_assessment($self_assessment_id = null)
    {   
        if (is_null($self_assessment_id)  || !$self_assessment = $this->self_assessments->get($self_assessment_id))
        {
            show_error('Could not find the self_assessment you specified.');
        }
	// This helper contains all functions that generate the dropdowns.
        $this->load->helper('cs_dropdown');
        $this->_prep_form_values('validation_self_assessment_take');

        $this->_prepare_self_assessment_form($self_assessment);

        if ($this->input->post('submit'))
        {
            $this->load->model('default/m_self_assessment_user_responses', 'self_assessment_response');
            
            $answerArray = $this->input->post('answer');
                //check if candidate or non-candidate
                if($answerArray['52'] == 'Yes'){
	            	$candidate = '1';
		}else if($answerArray['53']  == '40'){
			$candidate = '1';
		}else if($answerArray['53'] == '35'){
			if($answerArray['54'] != ''){
				$candidate = '1';
			}
		}else if($answerArray['55'] == 'Yes'){
			$candidate = '1';
		}else if($answerArray['56']== 'Yes'){
			$candidate = '1';
			}else{
		$candidate = '0';
		} 
               $this->_form_data['candidate'] = $candidate;          
    
            // Save the user details so we can reference it to his/her answers using the response_id.
            $answer_data['response_id'] = $this->_save('validation_self_assessment_take', $this->self_assessment_response);
			
            if ($answer_data['response_id'])
            {   
                $this->load->model('default/m_self_assessment_answers', 'self_assessment_answers');
                // Let's save the actual self_assessment answers.
                foreach ($this->input->post('answer') as $question_id => $answer)
                {
                    $answer_data['question_id'] = $question_id;
                    $answer_data['answer']      = $answer;

                    if (!$this->self_assessment_answers->do_save($answer_data))
                    {
                        die('save failed');
                    }
                }
                //save number 6 answer
                $answer_data['question_id'] = '57';
                $answer_data['answer']      = '';
	        $this->self_assessment_answers->do_save($answer_data);    
                
                // Get country.
                $this->load->model('default/m_country');
                $country              = $this->m_country->get($this->_form_data['country_id']);
                $this->_form_data['country'] = $country->name;
                
                // Get state.
                $this->load->model('default/m_states');
                $state             = $this->m_states->get($this->_form_data['state']);
                $this->_form_data['state'] = $state->state_name;
                
                /*result*/                 
                $this->load->model('default/m_self_assessment_answers', 'answers');
                $this->load->model('default/m_self_assessment_questions', 'questions');

                $answers = $this->answers->get_by_response_id($answer_data['response_id']);                      

                foreach ($answers->result() as $answer)
                {
                        $answer->question = $this->questions->get($answer->question_id);
                }

                $result['responses'] = $answers->result();
                        
                $this->_form_data['result'] = $this->parser->parse('default/self_assessment/email/result', $result);      
                /*result end */
                
                $this->_form_data['candidate'] = ($candidate == '1') ? 'Yes' : 'No';
                
    
                // Send email to admin and person.
                $this->load->helper('cs_emails');  
                // Send an email to the user.
                $x = send_email_template(
                        'self_assessments_email_patient',
                        $this->_form_data['user_email'],
                        null,
                        $this->_form_data
                    );
				
                // Send email to admin.
                send_email_template('self_assessments_email_admin', $this->get_setting('self_assessments_email_recipient')->setting_value, null, $this->_form_data);
			
		if($candidate == '1') {
			redirect ('self-assessment/candidate');
		}else{
			redirect ('self-assessment/non-candidate');
		}	
                //$this->session->set_flashdata('message', 'Your self_assessment has been submitted.');
                //redirect (current_url());
            }
        }

        $this->view_data['page']      = 'default/self_assessment/take_self_assessment';
        $this->view_data['questions'] = $self_assessment->questions;

        $this->view_data = array_merge($this->view_data, $this->_form_data);
        $this->view_data['self_assessment_id'] = $self_assessment->self_assessment_id;
        
        $this->load->model('default/M_page');
        $url_key = $this->get_current_module(); 
	$page = $this->M_page->get($url_key);
	$this->load->model('admin/M_website');
	$website = $this->M_website->getWebsite();
	
	$this->view_data['robots'] = '';			
	$this->view_data['keywords'] = $page['keywords'];
	$this->view_data['desc'] = $page['desc'];
	
	//set global meta data if page meta data is blank
	if($page['keywords'] == ''){
		$this->view_data['keywords'] = $website['default_metakeywords'];
	}
	if($page['desc'] == ''){
		$this->view_data['desc'] = $website['default_metadesc'];
	}

        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Prepare the form fields according to question type.
     *
     * @param object $self_assessment The self_assessment object.
     */
    private function _prepare_self_assessment_form(& $self_assessment)
    {
        foreach ($self_assessment->questions as $question)
        {
            $field_name = 'answer[' . $question->question_id . ']';
            $question->html = '';

            switch ($question->type_of_question_id)
            {
                case 1: // Radio buttons.
                    $choices = json_decode($question->choices);
                    
                    foreach ($choices as $key => $choice)
                    {                        
                        $question->html .= form_radio(array('name' => $field_name, 'value' => $choice, 'class' => 'required')) . $choice . '<br/>';
                    }

                    break;
                case 2:  // Text field.
                    $question->html = form_input($field_name, set_value('answer[]'), 'class="required"');
                    break; 
                case 3: // Rating.
                    $start = 1;
                    
                    while ($start <= $question->range)
                    {
                        $question->html .= form_radio(array('name' => $field_name, 'value' => $start, 'class' => 'required')) . $start;
                        $start++;
                    }
                    break;
                case 4: // Checkbox.
                    $choices = json_decode($question->choices);
                    
                    foreach ($choices as $key => $choice)
                    {                        
                        $question->html .= form_checkbox(array('name' => $field_name, 'value' => $choice, 'class' => 'required')) . $choice;
                        $question->html .= '<br/>';
                    }

                    break;        
            }
        }
    }

    // --------------------------------------------------------------------
}
/* End of file self_assessments.php */
/* Location: ./application/controllers/default/self_assessment.php */