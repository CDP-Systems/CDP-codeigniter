<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_self_assessment_self_assessment_questions extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->set_table_name('self_assessment_self_assessment_questions');
        $this->set_primary_key('self_assessment_id');
    }

    // --------------------------------------------------------------------

    /**
     * Fetch questions related to specified self_assessment id.
     *
     * @param int $id Self Assessment id.
     *
     * @return mixed FALSE on error.
     */
    function get_by_self_assessment($id)
    {
        $this->db->where('self_assessment_id', $id);
        $this->db->join('self_assessment_questions', $this->get_table_name() . '.question_id = self_assessment_questions.question_id');

        return $this->db->get($this->get_table_name());
    }

    // --------------------------------------------------------------------

    /**
     * Fetch all self_assessments related to a question id.
     *
     * @param int $id question id.
     *
     * @return mixed FALSE on error.
     */
    function get_by_question($id)
    {
        $this->db->where($this->get_table_name() . '.question_id', $id);
        $this->db->join('self_assessment_questions', $this->get_table_name() . '.question_id = self_assessment_questions.question_id');

        return $this->db->get($this->get_table_name());
    }

    // --------------------------------------------------------------------

    /**
     * Saves a question to the table after saving a self_assessment.
     *
     * @param array $question_ids
     * @param int $self_assessment_id
     *
     * @return mixed FALSE on error.
     */    
    function do_save($question_ids, $self_assessment_id)
    {
        // First delete all records.
        $this->delete($self_assessment_id);

        // Create an array for insert_batch.
        foreach ($question_ids as $id)
        {
            $a[] = array ('question_id' => $id, 'self_assessment_id' => $self_assessment_id);
        }

        return $this->db->insert_batch($this->get_table_name(), $a);
    }

    // --------------------------------------------------------------------

    /**
     * Saves a question to the table.
     *
     * @param int $question_id
     * @param array $self_assessment_id
     *
     * @return mixed FALSE on error.
     */    
    function save_question($question_id, $self_assessment_id)
    {
        // Set the primary to question_id so it deletes according to question_id.
        $this->set_primary_key('question_id');
        // First delete all records.
        $this->delete($question_id);
        // Set back the original key, just in case.
        $this->set_primary_key('self_assessment_id');

        if (isset($self_assessment_id))
        {
            if (!is_array($self_assessment_id))
            {
                if ($self_assessment_id > 0)
                {
                    $self_assessment_id = (array) $self_assessment_id;
                }
                else
                {
                    return TRUE;
                }
            }

            // Create an array for insert_batch.
            foreach ($self_assessment_id as $id)
            {
                $a[] = array ('question_id' => $question_id, 'self_assessment_id' => $id);
            }

            return $this->db->insert_batch($this->get_table_name(), $a);
        }

        return TRUE;
    }
}

/* End of file m_self_assessment_questions.php */
/* Location: ./application/models/default/m_self_assessment_questions.php */
