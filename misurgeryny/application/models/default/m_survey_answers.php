<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_survey_answers extends MY_Model {

        function __construct()
        {
            parent::__construct();

            $this->set_table_name('survey_answers');
            $this->set_primary_key('survey_answer_id');
        }

        // --------------------------------------------------------------------

        /**
          * Get all answers by survey id.
          *
          * @param int $survey_id The survey id.
          * @param int $question_id OPTIONAL
          *
          * @return mixed FALSE on error.
          */
        function get_by_survey($survey_id, $question_id = NULL)
        {
            $id = mysql_real_escape_string($survey_id);

            $where = '';

            if (!is_null($question_id) && $question_id > 0)
            {
                $where = ' AND question_id = ' . mysql_real_escape_string($question_id);
            }

            $this->db->select('* FROM (`ci_survey_answers`) WHERE response_id IN (SELECT response_id FROM ci_survey_user_responses WHERE survey_id = ' . $id .')'. $where);

            return $this->db->get();
        }
        
        // --------------------------------------------------------------------

        /**
          * Get all answers of a respondent.
          *
          * @param int $response_id The response id.
          *
          * @return mixed FALSE on error.
          */        
        function get_by_response_id($response_id)
        {
        	$this->db->where('response_id', $response_id);
        	
        	return parent::fetch_all();
        }
}

/* End of file m_survey.php */
/* Location: ./application/models/default/m_survey.php */