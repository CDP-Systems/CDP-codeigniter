<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package		CS
 * @author		CS
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 */

 if (!function_exists('template_dropdown'))
{
    /**
     * Return an associative array containing months of the year.
     *
     * @return array.
     */
    function template_dropdown()
    {
		$data = array();
		 $ci =& get_instance();
		 $ci->load->helper('file');
         $templates =  get_filenames(APPPATH . 'views/default/templates');
		 foreach($templates as $_template){
			
			$data[$_template] = $_template;
			
		 }
		 return $data;
    }
}
 
if (!function_exists('month_dropdown'))
{
    /**
     * Return an associative array containing months of the year.
     *
     * @return array.
     */
    function month_dropdown()
    {
        return array (
                '' => '-Month-',
                1 => 'January',
                2 => 'February',
                3 => 'March',
                4 => 'April',
                5 => 'May',
                6 => 'June',
                7 => 'July',
                8 => 'August',
                9 => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December'
            );
    }
}

// --------------------------------------------------------------------

if (!function_exists('day_dropdown'))
{
    /**
     * Return an associative array containing days of the week.
     *
     * @return array.
     */
    function day_dropdown()
    {
        return array(
                    1 => 'Monday',
                    2 => 'Tuesday',
                    3 => 'Wednesday',
                    4 => 'Thursday',
                    5 => 'Friday',
                    6 => 'Saturday',
                    7 => 'Sunday'
                    );
    }
}

// --------------------------------------------------------------------

if (!function_exists('date_dropdown'))
{
    /**
     * Return an associative array containing dates of the month.
     */
    function date_dropdown()
    {
        $dates[''] = '-Date-';
        for ($i = 1; $i <= 31; $i++)
        {
            $dates[$i] = $i;
        }

        return $dates;
    }
}

// --------------------------------------------------------------------

if (!function_exists('year_dropdown'))
{
    function year_dropdown($start = 1930, $end = null)
    {
        $years[''] = '-Year-';
        if ($end == null)
        {
            $end = date('Y');
        }

        while ($start < $end)
        {
            $years[$start] = $start;
            $start++;
        }

        return $years;
    }
}

// --------------------------------------------------------------------

if (!function_exists('state_dropdown'))
{
    function state_dropdown()
    {
        $ci =& get_instance();

        $ci->load->model('default/m_states');

        $states = $ci->m_states->fetch_all();

        $a_states[''] = '--select a state--';

        foreach ($states->result() as $state)
        {
            $a_states[$state->state_id] = $state->state_name;
        }

        return $a_states;
    }
}

// --------------------------------------------------------------------

if (!function_exists('country_dropdown'))
{
    function country_dropdown()
    {
        $ci =& get_instance();

        $ci->load->model('default/m_country');

        $countries = $ci->m_country->fetch_all();

        $a_country[''] = '--select a country--';

        foreach ($countries->result() as $country)
        {
            $a_country[$country->country_id] = $country->name;
        }

        return $a_country;
    }
}

// --------------------------------------------------------------------

if (!function_exists('gender_dropdown'))
{
    function gender_dropdown()
    {
        $gender[''] = '--select a gender--';
        $gender['Male'] = 'Male';
        $gender['Female'] = 'Female';

        return $gender;
    }
}

// --------------------------------------------------------------------

if (!function_exists('seminar_category_dropdown'))
{
    function seminar_category_dropdown()
    {
        
        return array (
	        '' => '-Select-',
	        'bariatric_surgery' => 'Bariatric Surgery',
	        'diabetes_surgery' => 'Diabetes Surgery',
	        'rose_procedure' => 'Rose Procedure',
	    );
    }
}

// --------------------------------------------------------------------

if (!function_exists('how_heard_dropdown'))
{
    /**
     * Return an associative array containing how you've heard about us.
     *
     * @return array.
     */
    function how_heard_dropdown()
    {
   
        return array (
                '' => '-Select-',
                'doctor' => 'Doctor',
                'friend_or_family' => 'Friend/Family',
               
                'online_search' => 'Online Search',
                'other' => 'Other'
            );
    }
}


// --------------------------------------------------------------------

if (!function_exists('number_dropdown'))
{
    /**
     * Return an array of numbers from $start to $limit.
     *
     * @param int $limit
     * @return array
     */
    function number_dropdown($start = 0, $limit)
    {
        while ($start <= $limit)
        {
            $numbers[$start] = $start;
            $start++;
        }

        return $numbers;
    }    
}

// --------------------------------------------------------------------

if (!function_exists('time_dropdown'))
{
    /**
     * Returns an array of times of the day.
     *
     * @return array
     */
    function time_dropdown()
    {
        $times = array();
        $time = strtotime("00:00:00");
        $times[""] = "--select--";
        for($i = 1;$i < 48;$i++) {
                $time = strtotime("+ 30 minutes",$time);
                $key = date("g:i A",$time);//date("H:i:s",$time);
                $times[$key] = $key;//date("g:i a",$time);
        }

        return $times;
    }
}

// --------------------------------------------------------------------

if (!function_exists('question_type_dropdown'))
{
    /**
     * Returns an array of survey question types.
     *
     * @return array
     */
    function question_type_dropdown()
    {
        $ci =& get_instance();
        
        $ci->load->model('default/m_survey_question_types');

        $question_types = $ci->m_survey_question_types->fetch_all();

        $a_question_types[''] = '--select type--';

        foreach ($question_types->result() as $question_type)
        {
            $a_question_types[$question_type->type_of_question_id] = $question_type->question_description;
        }

        return $a_question_types;
    }
}

// --------------------------------------------------------------------

if (!function_exists('survey_dropdown'))
{
    /**
     * Returns an array of surveys.
     *
     * @return array
     */
    function survey_dropdown()
    {
        $ci =& get_instance();
        
        $ci->load->model('default/m_survey');

        $surveys = $ci->m_survey->fetch_all();

        $a_surveys[''] = '----';

        foreach ($surveys->result() as $survey)
        {
            $a_surveys[$survey->survey_id] = $survey->survey_description;
        }

        return $a_surveys;
    }
}

// --------------------------------------------------------------------

if (!function_exists('questions_dropdown'))
{
    /**
     * Returns an array of available questions.
     *
     * @return array
     */
    function questions_dropdown()
    {
        $ci =& get_instance();
        
        $ci->load->model('default/m_survey_questions', 'survey_questions');

        $questions = $ci->survey_questions->fetch_all();

        $a[''] = '--select question--';

        foreach ($questions->result() as $question)
        {
            $a[$question->question_id] = $question->question_details;
        }

        return $a;
    }
}

// --------------------------------------------------------------------

if (!function_exists('yes_no_dropdown'))
{
    /**
     * Returns an array of yes and no.
     *
     * @return array
     */
    function yes_no_dropdown()
    {
        return array (1 => 'Yes', 0 => 'No');
    }
}

// --------------------------------------------------------------------

if (!function_exists('page_url_dropdown'))
{
    /**
     * Returns an array of all pages and their URL as the key.
     *
     * @return array
     */
    function page_url_dropdown()
    {
    	$ci =& get_instance();
    	
    	$ci->load->model('default/m_page', 'pages');
    	$ci->load->library('CS_Url_Tree', null, 'tree');
    	
    	$pages = $ci->pages->fetch_all();
    	
    	$a_pages = array();
    		
    	if ($pages->num_rows() > 0)
	{
		foreach ($pages->result() as $page)
    		{	
    			$ci->tree->id_page = $page->id_page;
    			$a_pages[$ci->tree->get_link()] = $page->url_key;
    			$ci->tree->clear();
    		}
    	}
    	
    	return $a_pages;
    }
}

// --------------------------------------------------------------------

if (!function_exists('target'))
{
    /**
     * Returns an array of "target" for anchors.
     *
     * @return array
     */
    function target_dropdown()
    {
	return array ('' => 'Current window', '_blank' => 'New Window');
    }
}

// --------------------------------------------------------------------

if (!function_exists('question2_type_dropdown'))
{
    /**
     * Returns an array of self_assessment question types.
     *
     * @return array
     */
    function question2_type_dropdown()
    {
        $ci =& get_instance();
        
        $ci->load->model('default/m_self_assessment_question_types');

        $question_types = $ci->m_self_assessment_question_types->fetch_all();

        $a_question_types[''] = '--select type--';

        foreach ($question_types->result() as $question_type)
        {
            $a_question_types[$question_type->type_of_question_id] = $question_type->question_description;
        }

        return $a_question_types;
    }
}

// --------------------------------------------------------------------

if (!function_exists('self_assessment_dropdown'))
{
    /**
     * Returns an array of self_assessments.
     *
     * @return array
     */
    function self_assessment_dropdown()
    {
        $ci =& get_instance();
        
        $ci->load->model('default/m_self_assessment');

        $self_assessments = $ci->m_self_assessment->fetch_all();

        $a_self_assessments[''] = '----';

        foreach ($self_assessments->result() as $self_assessment)
        {
            $a_self_assessments[$self_assessment->self_assessment_id] = $self_assessment->self_assessment_description;
        }

        return $a_self_assessments;
    }
}

// --------------------------------------------------------------------

if (!function_exists('questions2_dropdown'))
{
    /**
     * Returns an array of available questions.
     *
     * @return array
     */
    function questions2_dropdown()
    {
        $ci =& get_instance();
        
        $ci->load->model('default/m_self_assessment_questions', 'self_assessment_questions');

        $questions = $ci->self_assessment_questions->fetch_all();

        $a[''] = '--select question--';

        foreach ($questions->result() as $question)
        {
            $a[$question->question_id] = $question->question_details;
        }

        return $a;
    }
}

/* End of file cs_dropdown_helper.php */
/* Location: ./application/application/helpers/cs_dropdown_helper.php */