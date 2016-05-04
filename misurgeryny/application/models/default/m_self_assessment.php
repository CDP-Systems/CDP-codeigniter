<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_self_assessment extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->set_table_name('self_assessment');
        $this->set_primary_key('self_assessment_id');
    }

    function get($id)
    {
        $self_assessment = parent::get($id);

        if ($self_assessment)
        {
            $this->load->model('default/m_self_assessment_questions');
            $self_assessment->questions = (array) $this->m_self_assessment_questions->get_self_assessment_questions($id)->result();

            return $self_assessment;
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
            $this->load->model('default/m_self_assessment_self_assessment_questions', 'sq');

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

/* End of file m_self_assessment.php */
/* Location: ./application/models/default/m_self_assessment.php */
