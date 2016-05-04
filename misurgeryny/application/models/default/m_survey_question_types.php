<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_survey_question_types extends MY_Model {

        function __construct()
        {
            parent::__construct();

            $this->set_table_name('survey_question_types');
            $this->set_primary_key('type_of_question_id');
        }
}

/* End of file m_survey_questions_types.php */
/* Location: ./application/models/default/m_survey_questions_types.php */
