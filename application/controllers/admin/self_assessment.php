<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Self_assessment extends MY_Controller {    

    // Holds values of form fields.
    protected $_form_data;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('default/m_self_assessment', 'self_assessments');

        $this->load->helper('cs_dropdown');
        
        $disabled_pages = array (
                            'questions', 
                            'add_question', 
                            'edit_question', 
                            'add_self_assessment', 
                            'edit_self_assessment', 
                            'delete_self_assessment', 
                            'delete_question'
                            );

        if(!$this->session->userdata('super_admin') && in_array($this->get_current_action(), $disabled_pages)) {
            redirect ('admin/self_assessment/index');
        }
    }

    // --------------------------------------------------------------------

    /**
     * Default action, lists all self_assessments.
     */
    function index($page = 0)
    {
        $this->view_data['content'] = 'admin/self_assessment/list';

        $self_assessments = $this->self_assessments->fetch_all();

        if ($self_assessments->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['total_rows'] = $self_assessments->num_rows();            

            $this->paginate($pagination);

            $results = $this->self_assessments->fetch_all(10, $page);

            $this->view_data['self_assessments'] = $self_assessments->result();
        }

        $this->parser->parse('admin/template', $this->view_data);
    }
    
    /**
     * Lists all self_assessment respondents.
     */
    function respondents($page = 0)
    {
    	$this->load->model('default/m_self_assessment_user_responses', 'responses');
    	
        $this->view_data['content'] = 'admin/self_assessment/list_respondents';

        $responses = $this->responses->fetch_all();

        if ($responses->num_rows() > 0)
        {
            $pagination['total_rows'] = $responses->num_rows();            

            $this->paginate($pagination);

            $results = $this->responses->fetch_all(10, $page);

            $this->view_data['responses'] = $results->result();
        }

        $this->parser->parse('admin/template', $this->view_data);
    }    

    // --------------------------------------------------------------------

    /**
     * Lists all questions.
     */
    function questions($page = 0)
    {
        $this->load->model('default/m_self_assessment_questions');

        $this->view_data['content'] = 'admin/self_assessment/list_questions';

        $questions = $this->m_self_assessment_questions->fetch_all();

        if ($questions->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['total_rows'] = $questions->num_rows();            

            $this->paginate($pagination);

            $results = $this->m_self_assessment_questions->fetch_all(10, $page);

            $this->view_data['questions'] = $questions->result();
        }

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Create a new self_assessment question.
     */
    function add_question()
    {
        $this->view_data['content'] = 'admin/self_assessment/edit_question';

        $this->_prep_form_values('validation_self_assessment_question_edit');

        if ($this->input->post('submit') || $this->isAjax())
        {
            $this->load->model('default/m_self_assessment_questions');

            $id = $this->_save('validation_self_assessment_question_edit', $this->m_self_assessment_questions);

            if ($id)
            {
                if ($this->isAjax())
                {
                    echo $id; exit();
                }

                $this->session->set_flashdata('message', 'Question added.');
        
                redirect (current_url());
            }
        }
        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Edit self_assessment question.
     */
    function edit_question($id = null)
    {
        $this->load->model('default/m_self_assessment_questions');

        if (is_null($id) || !$question = $this->m_self_assessment_questions->get($id))
        {
            show_error('Invalid or no id specified');
        }

        $this->view_data['content'] = 'admin/self_assessment/edit_question';

        $this->_prep_form_values('validation_self_assessment_question_edit', $question);

        if (isset($question->choices) && $question->choices != '')
        {
            // Reencode the data back to a php readable array format.
            $this->view_data['choices'] = json_decode($question->choices);
        }

        $this->load->model('default/m_self_assessment_self_assessment_questions', 'questions');

        // Get all self_assessments related to this question.
        $self_assessments = '';

        // Need to get questions per self_assessment to relate to our view data.
        foreach ($this->questions->get_by_question($id)->result() as $self_assessment)
        {
            $self_assessments[] = $self_assessment->self_assessment_id;
        }        

        $this->_form_data['self_assessment_id'] = set_value('self_assessment_id', $self_assessments);

        if (isset($this->_form_data['self_assessment_id']) && is_array($this->_form_data['self_assessment_id']))
        {
            $this->view_data['self_assessment_id'] = $this->_form_data['self_assessment_id'];
        }

        $this->view_data['question_id'] = $question->question_id;
        $this->_form_data['question_id'] = $question->question_id;

        if ($this->input->post('submit') || $this->isAjax())
        {        
            $id = $this->_save('validation_self_assessment_question_edit', $this->m_self_assessment_questions);
                          
            if ($id)
            {
                if ($this->isAjax())
                {
                    echo $id; exit();
                }
                $this->session->set_flashdata('message', 'Question updated.');
        
                redirect (current_url());
            }
        }
        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Create a new self_assessment.
     */
    function add_self_assessment()
    {
        $this->view_data['content'] = 'admin/self_assessment/edit_self_assessment';

        $this->_prep_form_values('validation_self_assessment_edit');              

        if ($this->input->post('submit') || $this->isAjax())
        {
            $this->load->model('default/m_self_assessment');
            
            // Either use the original value or the value from POST.
            $this->_form_data['question_id'] = set_value('question_id');

            $id = $this->_save('validation_self_assessment_edit', $this->m_self_assessment);

            if ($id)
            {
                // If the request is ajax we simply echo boolean true.
                // NOTE: Please make sure that all functions still work even without ajax. Like this one.
                if ($this->isAjax())
                {
                    echo $id; exit();
                }
                else
                {
                    $this->session->set_flashdata('message', 'Self Assessment saved.');
                
                    redirect (current_url());
                }
            }
        }

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Edit an existing self_assessment.
     */
    function edit_self_assessment($id = null)
    {
        if (is_null($id) || !$self_assessment = $this->self_assessments->get($id))
        {
            show_error('Invalid or no id specified');
        }

        $this->view_data['content'] = 'admin/self_assessment/edit_self_assessment';        

        $this->_prep_form_values('validation_self_assessment_edit', $self_assessment);              

        $this->view_data['self_assessment_id'] = $self_assessment->self_assessment_id;
        $this->_form_data['self_assessment_id'] = $self_assessment->self_assessment_id;

        $this->load->model('default/m_self_assessment_self_assessment_questions', 'questions');     

        $questions = '';
        
        // Need to get questions per self_assessment to relate to our view data.
        foreach ($this->questions->get_by_self_assessment($id)->result() as $question)
        {
            $questions[] = $question->question_id;
        }
        
        // Either use the original value or the value from POST.
        $this->_form_data['question_id'] = set_value('question_id', $questions);

        if (isset($this->_form_data['question_id']) && is_array($this->_form_data['question_id']))
        {
            $this->view_data['question_id'] = $this->_form_data['question_id'];
        }

        if ($this->input->post('submit') || $this->isAjax())
        {
            $this->load->model('default/m_self_assessment');
        
            $id = $this->_save('validation_self_assessment_edit', $this->m_self_assessment);

            if ($id)
            {
                if ($this->isAjax())
                {
                    echo $id; exit();
                }
                else
                {
                    $this->session->set_flashdata('message', 'Self Assessment saved.');               
                    
                    redirect (current_url());
                }
            }
        }

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * View user response.
     *
     */
    function user_response($id = null)
    {/** JOSE **/
        $this->load->model('default/m_self_assessment_user_responses', 'response');

        if (!is_null($id) && $response = $this->response->get($id))      
        {                         
   		$this->load->model('default/m_self_assessment_answers', 'answers');
   		$this->load->model('default/m_self_assessment_questions', 'questions');
   		
	   	$answers = $this->answers->get_by_response_id($id);                      

		foreach ($answers->result() as $answer)
		{
			$answer->question = $this->questions->get($answer->question_id);
		}
		
		$this->view_data['respondent'] = (array) $response;
		$this->view_data['responses'] = $answers->result();
        }

        $this->view_data['content'] = 'admin/self_assessment/user_response';        
        $this->parser->parse('admin/template', $this->view_data);            
    }

    // --------------------------------------------------------------------

    /**
     * View self_assessment results.
     *
     */
    function results($id = null)
    {
        $this->load->model('default/m_self_assessment', 'self_assessment');

        if (!is_null($id) && $self_assessment = $this->self_assessment->get($id))      
        {  
            $answer_data = $this->_get_answer_data($self_assessment->questions, $id); 
            
            $this->view_data['responses'] = $answer_data;
            $this->view_data['self_assessment']    = (array) $self_assessment;
        }

        $this->view_data['content'] = 'admin/self_assessment/self_assessment_results';        
        $this->parser->parse('admin/template', $this->view_data);            
    }

    // --------------------------------------------------------------------

    /**
     * Control email settings for this module.
     */
    function email_settings()
    {
        $this->load->model('default/m_settings');

        $self_assessments_email_recipient = $this->m_settings->get('self_assessments_email_recipient');
        // Email content.
        $self_assessments_patient_confirmation = $this->m_settings->get('self_assessments_email_patient');
        $self_assessments_admin_notification = $this->m_settings->get('self_assessments_email_admin');
        // Email Subject.
        $self_assessments_patient_confirmation_subject = $this->m_settings->get('self_assessments_email_patient_subject');
        $self_assessments_admin_notification_subject = $this->m_settings->get('self_assessments_email_admin_subject');
        
        $this->_form_data['self_assessments_email_recipient'] = set_value('self_assessments_email_recipient', $self_assessments_email_recipient->setting_value);

        $this->_form_data['self_assessments_email_patient'] = set_value('self_assessments_email_patient', $self_assessments_patient_confirmation->setting_value);
        $this->_form_data['self_assessments_email_patient_subject'] = set_value('self_assessments_email_patient_subject', $self_assessments_patient_confirmation_subject->setting_value);
       
        $this->_form_data['self_assessments_email_admin'] = set_value('self_assessments_email_admin', $self_assessments_admin_notification->setting_value);
        $this->_form_data['self_assessments_email_admin_subject'] = set_value('self_assessments_email_admin_subject', $self_assessments_admin_notification_subject->setting_value);

        $this->view_data = array_merge($this->view_data, $this->_form_data);

        if ($this->input->post('submit') == 'Save')
        {
            $this->load->config('validations');

            $this->require_validation($this->config->item('self_assessments_email_settings'));

            if ($this->form_validation->run())
            {
                if ($this->m_settings->save_settings($this->_form_data))
                {
                    $this->session->set_flashdata('message', 'Settings saved!');

                    redirect ('admin/self_assessment/email_settings');
                }
            }
        }

        $this->view_data['content'] = 'admin/self_assessment/email_settings';
        //parse template
        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Deletes a self_assessment
     *
     * @param mixed $id ID.
     */
    function delete_self_assessment($id)
    {
        if ($this->self_assessments->delete($id))
        {
            $message = 'Self Assessment/s successfully deleted.';
        }
        else
        {
            $message = 'Could not delete the self_assessment. Please contact the administrator.';
        }

        if ($this->isAjax())
        {
            echo $message; exit();
        }
        else
        {
            $this->session->set_flashdata('message', $message);
            redirect('admin/self_assessment/index');
        }
    }
    
    // --------------------------------------------------------------------

    /**
     * Deletes a response/s.
     *
     * @param mixed $id ID.
     */
    function delete_response($id)
    {   
        $this->load->model('default/m_self_assessment_user_responses', 'responses');    
        
        if($id != ''){
	        if ($this->responses->delete($id))
	        {
	            $message = 'Patient(s) record successfully deleted.';
	        }
	        else
	        {
	            $message = 'Could not delete the response. Please contact the administrator.';
	        }
        } else{
        	$message = '<span style="color:red;">Please select at least one record.</span>';
        }

        if ($this->isAjax())
        {
            echo $message; exit();
        }
        else
        {
            $this->session->set_flashdata('message', $message);
        }

        redirect('admin/self_assessment/respondents');
    }    

    // --------------------------------------------------------------------

    /**
     * Deletes a question/s.
     *
     * @param mixed $id ID.
     */
    function delete_question($id)
    {   
        $this->load->model('default/m_self_assessment_questions', 'questions');    
        
        if ($this->questions->delete($id))
        {
            $message = 'Question/s successfully deleted.';
        }
        else
        {
            $message = 'Could not delete the question. Please contact the administrator.';
        }

        if ($this->isAjax())
        {
            echo $message; exit();
        }
        else
        {
            $this->session->set_flashdata('message', $message);
        }

        redirect('admin/self_assessment/questions');
    }

    // --------------------------------------------------------------------

    /**
      * 
      * Returns an object which contains data about the question and specific answers.
      *
      * @param object $questions
      * @param int $self_assessment_id Self Assessment id.
      *
      * @return object
      */
    private function _get_answer_data($questions, $self_assessment_id)
    {
        $this->load->model('default/m_self_assessment_answers', 'answers');

        $results = $questions;

        foreach ($results as $question)
        {
            $question->html    = '';
            $answer_percentage = array();
            $user_answer       = array();
            $view_data         = array();    

    	    $responses = $this->answers->get_by_self_assessment($self_assessment_id, $question->question_id);

            switch ($question->type_of_question_id)
            {
                case 3:
                case 1:
                    // Get the percentage per choice.
                    foreach ($responses->result() as $response)
                    {   
                        if (array_key_exists($response->answer, $answer_percentage))
                        {
                            $user_answer[$response->answer]++;
                        }
                        else
                        {
                            $user_answer[$response->answer] = 1;
                        }

                        $answer_percentage[$response->answer] = number_format($user_answer[$response->answer] / $responses->num_rows(), 2) * 100;
                    }
                    // Sort according to key value.
                    ksort($answer_percentage);
                    
                    $view_data['range']             = $question->range;
                    $view_data['percentage']        = $answer_percentage;
                    $view_data['number_of_replies'] = $user_answer;        
        
                    break;
            }

            $file = '';

            if ($question->type_of_question_id == 3)
            {
                $file = 'range';
            }
            else if ($question->type_of_question_id == 1)
            {
                $file = 'radio';
                $view_data['choices'] = json_decode($question->choices);
            }
            else
            {
                $file = 'text';
            }

            $question->html = $this->load->view('admin/self_assessment/fields/' . $file, $view_data, TRUE);
        }

        return $results;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Control action for bulk selections.
     */
    function action()
    {
        $data = $this->input->post('data');

        $action = $this->input->post('selectAction');

	if (trim($action) == '')
	{
		$action = 'index';
	}

        $this->$action($data);
    }          
}

/* End of file self_assessments.php */
/* Location: ./application/controllers/admin/self_assessment.php */