<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_self_assessment_answers extends MY_Model {

        function __construct()
        {
            parent::__construct();

            $this->set_table_name('self_assessment_answers');
            $this->set_primary_key('self_assessment_answer_id');
        }

        // --------------------------------------------------------------------

        /**
          * Get all answers by self_assessment id.
          *
          * @param int $self_assessment_id The self_assessment id.
          * @param int $question_id OPTIONAL
          *
          * @return mixed FALSE on error.
          */
        function get_by_self_assessment($self_assessment_id, $question_id = NULL)
        {
            $id = mysql_real_escape_string($self_assessment_id);

            $where = '';

            if (!is_null($question_id) && $question_id > 0)
            {
                $where = ' AND question_id = ' . mysql_real_escape_string($question_id);
            }

            $this->db->select('* FROM (`ci_self_assessment_answers`) WHERE response_id IN (SELECT response_id FROM ci_self_assessment_user_responses WHERE self_assessment_id = ' . $id .')'. $where);

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
        	
        	$this->db->order_by('question_id' . ' ASC');

                return $this->db->get($this->get_table_name(), null, null);
        }
}

/* End of file m_self_assessment.php */
/* Location: ./application/models/default/m_self_assessment.php */