<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Surveys controller for user view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-05-16
 */
class Surveys extends MY_Controller {

    protected $_form_data;

    function __construct()
    {
        parent::__construct();

        $this->load->helper('form');

        // Load the model and assign it to "surveys" object.
        $this->load->model('default/m_survey', 'surveys');
    }

    // --------------------------------------------------------------------

    /**
     * Default action. This action lists all surveys.
     */
    function index($page = 0)
    {
        $surveys = $this->surveys->fetch_all();

        $this->view_data['page'] = 'default/surveys/list';

        if ($surveys->num_rows() > 0)
        {
            $pagination['per_page'] = 10;
            $pagination['total_rows'] = $surveys->num_rows();

            $this->paginate($pagination);

            $results = $this->surveys->fetch_all($pagination['per_page'], $page);

            $this->view_data['surveys'] = $results->result();
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
     * Take a survey.
     */
    function take_survey($survey_id = null)
    {   
        if (is_null($survey_id)  || !$survey = $this->surveys->get($survey_id))
        {
            show_error('Could not find the survey you specified.');
        }

        $this->_prep_form_values('validation_survey_take');

        $this->_prepare_survey_form($survey);

        if ($this->input->post('submit'))
        {
            $this->load->model('default/m_survey_user_responses', 'survey_response');            
    
            // Save the user details so we can reference it to his/her answers using the response_id.
            $answer_data['response_id'] = $this->_save('validation_survey_take', $this->survey_response);
			
            if ($answer_data['response_id'])
            {   
                $this->load->model('default/m_survey_answers', 'survey_answers');
                // Let's save the actual survey answers.
                foreach ($this->input->post('answer') as $question_id => $answer)
                {
                    $answer_data['question_id'] = $question_id;
                    $answer_data['answer']      = $answer;

                    if (!$this->survey_answers->do_save($answer_data))
                    {
                        die('save failed');
                    }
                }
    
                // Send email to admin and person.
                $this->load->helper('cs_emails');  
                // Send an email to the user.
                $x = send_email_template(
                        'surveys_email_patient',
                        $this->_form_data['user_email'],
                        null,
                        $this->_form_data
                    );
				
                // Send email to admin.
                send_email_template('surveys_email_admin', $this->get_setting('surveys_email_recipient')->setting_value, null, $this->_form_data);
				
                $this->session->set_flashdata('message', 'Your survey has been submitted.');
                redirect (current_url());
            }
        }

        $this->view_data['page']      = 'default/surveys/take_survey';
        $this->view_data['questions'] = $survey->questions;

        $this->view_data = array_merge($this->view_data, $this->_form_data);
        $this->view_data['survey_id'] = $survey->survey_id;
        
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
     * @param object $survey The survey object.
     */
    private function _prepare_survey_form(& $survey)
    {
        foreach ($survey->questions as $question)
        {
            $field_name = 'answer[' . $question->question_id . ']';
            $question->html = '';

            switch ($question->type_of_question_id)
            {
                case 1: // Radio buttons.
                    $choices = json_decode($question->choices);
                    
                    foreach ($choices as $key => $choice)
                    {                        
                        $question->html .= form_radio(array('name' => $field_name, 'value' => $key, 'class' => 'required')) . $choice;
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
            }
        }
    }

    // --------------------------------------------------------------------
}
/* End of file surveys.php */
/* Location: ./application/controllers/default/surveys.php */