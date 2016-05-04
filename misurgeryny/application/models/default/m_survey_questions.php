<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_survey_questions extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->set_table_name('survey_questions');
        $this->set_primary_key('question_id');
    }

    // --------------------------------------------------------------------

    /**
     * Get questions for survey id.
     *
     * @param int $survey_id
     *
     * @return mixed
     */
    function get_survey_questions($survey_id)
    {
        $this->db->join('survey_survey_questions', 'survey_survey_questions.question_id = ' . $this->get_table_name() . '.question_id', 'LEFT');

        $this->db->where('survey_survey_questions.survey_id', $survey_id);
    
        return $this->db->get($this->get_table_name());
    }

    // --------------------------------------------------------------------

    function do_save($params)
    {
        if (isset($params['choices']) && is_array($params['choices']))
        {
            $params['choices'] = json_encode($params['choices']);
        }

        $related_surveys = $params['survey_id'];
    
        unset($params['survey_id']);

        $id = parent::do_save($params);

        $this->load->model('default/m_survey_survey_questions', 'q');

        $x = $this->q->save_question($id, $related_surveys);        

        return $id;
    }
}

/* End of file m_survey_questions.php */
/* Location: ./application/models/default/m_survey_questions.php */
