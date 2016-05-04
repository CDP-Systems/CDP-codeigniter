<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_survey extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->set_table_name('survey');
        $this->set_primary_key('survey_id');
    }

    function get($id)
    {
        $survey = parent::get($id);

        if ($survey)
        {
            $this->load->model('default/m_survey_questions');
            $survey->questions = (array) $this->m_survey_questions->get_survey_questions($id)->result();

            return $survey;
        }

        return FALSE;
    }

    function do_save($params)
    {
        if (isset($params['question_id']))
        {
            $questions = $params['question_id'];
            unset($params['question_id']);
        }        

        $id = parent::do_save($params);

        if ($id && isset($questions))
        {
            $this->load->model('default/m_survey_survey_questions', 'sq');

            if (!$this->sq->do_save($questions, $id))
            {
                return FALSE;
            }
        }
    
        return $id;
    }

    /**
     * Override to set date_created.
     */
    function do_create($params)
    {
        $params['date_created'] = date('Y-m-d h:i:s');

        return parent::do_create($params);
    }
}

/* End of file m_survey.php */
/* Location: ./application/models/default/m_survey.php */
