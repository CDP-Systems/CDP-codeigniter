<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surveys extends MY_Controller {    

    // Holds values of form fields.
    protected $_form_data;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('default/m_survey', 'surveys');

        $this->load->helper('cs_dropdown');
        
        $disabled_pages = array (
                            'questions', 
                            'add_question', 
                            'edit_question', 
                            'add_survey', 
                            'edit_survey', 
                            'delete_survey', 
                            'delete_question'
                            );

        if(!$this->session->userdata('super_admin') && in_array($this->get_current_action(), $disabled_pages)) {
            redirect ('admin/surveys/index');
        }
    }

    // --------------------------------------------------------------------

    /**
     * Default action, lists all surveys.
     */
    function index($page = 0)
    {
        $this->view_data['content'] = 'admin/surveys/list';

        $surveys = $this->surveys->fetch_all();

        if ($surveys->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['total_rows'] = $surveys->num_rows();            

            $this->paginate($pagination);

            $results = $this->surveys->fetch_all(10, $page);

            $this->view_data['surveys'] = $surveys->result();
        }

        $this->parser->parse('admin/template', $this->view_data);
    }
    
    /**
     * Lists all survey respondents.
     */
    function respondents($page = 0)
    {
    	$this->load->model('default/m_survey_user_responses', 'responses');
    	
        $this->view_data['content'] = 'admin/surveys/list_respondents';

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
        $this->load->model('default/m_survey_questions');

        $this->view_data['content'] = 'admin/surveys/list_questions';

        $questions = $this->m_survey_questions->fetch_all();

        if ($questions->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['total_rows'] = $questions->num_rows();            

            $this->paginate($pagination);

            $results = $this->m_survey_questions->fetch_all(10, $page);

            $this->view_data['questions'] = $questions->result();
        }

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Create a new survey question.
     */
    function add_question()
    {
        $this->view_data['content'] = 'admin/surveys/edit_question';

        $this->_prep_form_values('validation_survey_question_edit');

        if ($this->input->post('submit') || $this->isAjax())
        {
            $this->load->model('default/m_survey_questions');

            $id = $this->_save('validation_survey_question_edit', $this->m_survey_questions);

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
     * Edit survey question.
     */
    function edit_question($id = null)
    {
        $this->load->model('default/m_survey_questions');

        if (is_null($id) || !$question = $this->m_survey_questions->get($id))
        {
            show_error('Invalid or no id specified');
        }

        $this->view_data['content'] = 'admin/surveys/edit_question';

        $this->_prep_form_values('validation_survey_question_edit', $question);

        if (isset($question->choices) && $question->choices != '')
        {
            // Reencode the data back to a php readable array format.
            $this->view_data['choices'] = json_decode($question->choices);
        }

        $this->load->model('default/m_survey_survey_questions', 'questions');

        // Get all surveys related to this question.
        $surveys = '';

        // Need to get questions per survey to relate to our view data.
        foreach ($this->questions->get_by_question($id)->result() as $survey)
        {
            $surveys[] = $survey->survey_id;
        }        

        $this->_form_data['survey_id'] = set_value('survey_id', $surveys);

        if (isset($this->_form_data['survey_id']) && is_array($this->_form_data['survey_id']))
        {
            $this->view_data['survey_id'] = $this->_form_data['survey_id'];
        }

        $this->view_data['question_id'] = $question->question_id;
        $this->_form_data['question_id'] = $question->question_id;

        if ($this->input->post('submit') || $this->isAjax())
        {        
            $id = $this->_save('validation_survey_question_edit', $this->m_survey_questions);
                          
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
     * Create a new survey.
     */
    function add_survey()
    {
        $this->view_data['content'] = 'admin/surveys/edit_survey';

        $this->_prep_form_values('validation_survey_edit');              

        if ($this->input->post('submit') || $this->isAjax())
        {
            $this->load->model('default/m_survey');
            
            // Either use the original value or the value from POST.
            $this->_form_data['question_id'] = set_value('question_id');

            $id = $this->_save('validation_survey_edit', $this->m_survey);

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
                    $this->session->set_flashdata('message', 'Survey saved.');
                
                    redirect (current_url());
                }
            }
        }

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Edit an existing survey.
     */
    function edit_survey($id = null)
    {
        if (is_null($id) || !$survey = $this->surveys->get($id))
        {
            show_error('Invalid or no id specified');
        }

        $this->view_data['content'] = 'admin/surveys/edit_survey';        

        $this->_prep_form_values('validation_survey_edit', $survey);              

        $this->view_data['survey_id'] = $survey->survey_id;
        $this->_form_data['survey_id'] = $survey->survey_id;

        $this->load->model('default/m_survey_survey_questions', 'questions');     

        $questions = '';
        
        // Need to get questions per survey to relate to our view data.
        foreach ($this->questions->get_by_survey($id)->result() as $question)
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
            $this->load->model('default/m_survey');
        
            $id = $this->_save('validation_survey_edit', $this->m_survey);

            if ($id)
            {
                if ($this->isAjax())
                {
                    echo $id; exit();
                }
                else
                {
                    $this->session->set_flashdata('message', 'Survey saved.');               
                    
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
        $this->load->model('default/m_survey_user_responses', 'response');

        if (!is_null($id) && $response = $this->response->get($id))      
        {                         
   		$this->load->model('default/m_survey_answers', 'answers');
   		$this->load->model('default/m_survey_questions', 'questions');
   		
	   	$answers = $this->answers->get_by_response_id($id);                      

		foreach ($answers->result() as $answer)
		{
			$answer->question = $this->questions->get($answer->question_id);
		}
		
		$this->view_data['respondent'] = (array) $response;
		$this->view_data['responses'] = $answers->result();
        }

        $this->view_data['content'] = 'admin/surveys/user_response';        
        $this->parser->parse('admin/template', $this->view_data);            
    }

    // --------------------------------------------------------------------

    /**
     * View survey results.
     *
     */
    function results($id = null)
    {
        $this->load->model('default/m_survey', 'survey');

        if (!is_null($id) && $survey = $this->survey->get($id))      
        {  
            $answer_data = $this->_get_answer_data($survey->questions, $id); 
            
            $this->view_data['responses'] = $answer_data;
            $this->view_data['survey']    = (array) $survey;
        }

        $this->view_data['content'] = 'admin/surveys/survey_results';        
        $this->parser->parse('admin/template', $this->view_data);            
    }

    // --------------------------------------------------------------------

    /**
     * Control email settings for this module.
     */
    function email_settings()
    {
        $this->load->model('default/m_settings');

        $surveys_email_recipient = $this->m_settings->get('surveys_email_recipient');
        // Email content.
        $surveys_patient_confirmation = $this->m_settings->get('surveys_email_patient');
        $surveys_admin_notification = $this->m_settings->get('surveys_email_admin');
        // Email Subject.
        $surveys_patient_confirmation_subject = $this->m_settings->get('surveys_email_patient_subject');
        $surveys_admin_notification_subject = $this->m_settings->get('surveys_email_admin_subject');
        
        $this->_form_data['surveys_email_recipient'] = set_value('surveys_email_recipient', $surveys_email_recipient->setting_value);

        $this->_form_data['surveys_email_patient'] = set_value('surveys_email_patient', $surveys_patient_confirmation->setting_value);
        $this->_form_data['surveys_email_patient_subject'] = set_value('surveys_email_patient_subject', $surveys_patient_confirmation_subject->setting_value);
       
        $this->_form_data['surveys_email_admin'] = set_value('surveys_email_admin', $surveys_admin_notification->setting_value);
        $this->_form_data['surveys_email_admin_subject'] = set_value('surveys_email_admin_subject', $surveys_admin_notification_subject->setting_value);

        $this->view_data = array_merge($this->view_data, $this->_form_data);

        if ($this->input->post('submit') == 'Save')
        {
            $this->load->config('validations');

            $this->require_validation($this->config->item('surveys_email_settings'));

            if ($this->form_validation->run())
            {
                if ($this->m_settings->save_settings($this->_form_data))
                {
                    $this->session->set_flashdata('message', 'Settings saved!');

                    redirect ('admin/surveys/email_settings');
                }
            }
        }

        $this->view_data['content'] = 'admin/surveys/email_settings';
        //parse template
        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Deletes a survey
     *
     * @param mixed $id ID.
     */
    function delete_survey($id)
    {
    	if($id != ''){
	        if ($this->surveys->delete($id))
	        {
	            $message = 'Survey/s successfully deleted.';
	        }
	        else
	        {
	            $message = 'Could not delete the survey. Please contact the administrator.';
	        }
	}else{
        	$message = '<span style="color:red;">No Survey(s) selected.</span>';
        }
        if ($this->isAjax())
        {
            echo $message; exit();
        }
        else
        {
            $this->session->set_flashdata('message', $message);
            redirect('admin/surveys/index');
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
        $this->load->model('default/m_survey_user_responses', 'responses');    
        
        if ($this->responses->delete($id))
        {
            $message = 'Response/s successfully deleted.';
        }
        else
        {
            $message = 'Could not delete the response. Please contact the administrator.';
        }

        if ($this->isAjax())
        {
            echo $message; exit();
        }
        else
        {
            $this->session->set_flashdata('message', $message);
        }

        redirect('admin/surveys/respondents');
    }    

    // --------------------------------------------------------------------

    /**
     * Deletes a question/s.
     *
     * @param mixed $id ID.
     */
    function delete_question($id)
    {   
        $this->load->model('default/m_survey_questions', 'questions');    
        
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

        redirect('admin/surveys/questions');
    }

    // --------------------------------------------------------------------

    /**
      * 
      * Returns an object which contains data about the question and specific answers.
      *
      * @param object $questions
      * @param int $survey_id Survey id.
      *
      * @return object
      */
    private function _get_answer_data($questions, $survey_id)
    {
        $this->load->model('default/m_survey_answers', 'answers');

        $results = $questions;

        foreach ($results as $question)
        {
            $question->html    = '';
            $answer_percentage = array();
            $user_answer       = array();
            $view_data         = array();    

    	    $responses = $this->answers->get_by_survey($survey_id, $question->question_id);

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

            $question->html = $this->load->view('admin/surveys/fields/' . $file, $view_data, TRUE);
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

/* End of file surveys.php */
/* Location: ./application/controllers/admin/surveys.php */