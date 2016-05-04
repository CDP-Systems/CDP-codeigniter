<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_self_assessment_questions extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->set_table_name('self_assessment_questions');
        $this->set_primary_key('question_id');
    }

    // --------------------------------------------------------------------

    /**
     * Get questions for self_assessment id.
     *
     * @param int $self_assessment_id
     *
     * @return mixed
     */
    function get_self_assessment_questions($self_assessment_id)
    {
        $this->db->join('self_assessment_self_assessment_questions', 'self_assessment_self_assessment_questions.question_id = ' . $this->get_table_name() . '.question_id', 'LEFT');

        $this->db->where('self_assessment_self_assessment_questions.self_assessment_id', $self_assessment_id);
        $this->db->order_by('self_assessment_self_assessment_questions.question_id', 'ASC');
    
        return $this->db->get($this->get_table_name());
    }

    // --------------------------------------------------------------------

    function do_save($params)
    {
        if (isset($params['choices']) && is_array($params['choices']))
        {
            $params['choices'] = json_encode($params['choices']);
        }

        $related_self_assessments = $params['self_assessment_id'];
    
        unset($params['self_assessment_id']);

        $id = parent::do_save($params);

        $this->load->model('default/m_self_assessment_self_assessment_questions', 'q');

        $x = $this->q->save_question($id, $related_self_assessments);        

        return $id;
    }
    
    // --------------------------------------------------------------------
    
    function fetch_all($limit = null, $offset = null, $alias = FALSE)
    {
        $this->db->order_by($this->get_primary_key() . ' ASC');

        return $this->db->get($this->get_table_name(), $limit, $offset);
    }
    
    
}

/* End of file m_self_assessment_questions.php */
/* Location: ./application/models/default/m_self_assessment_questions.php */
