<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_survey_survey_questions extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->set_table_name('survey_survey_questions');
        $this->set_primary_key('survey_id');
    }

    // --------------------------------------------------------------------

    /**
     * Fetch questions related to specified survey id.
     *
     * @param int $id Survey id.
     *
     * @return mixed FALSE on error.
     */
    function get_by_survey($id)
    {
        $this->db->where('survey_id', $id);
        $this->db->join('survey_questions', $this->get_table_name() . '.question_id = survey_questions.question_id');

        return $this->db->get($this->get_table_name());
    }

    // --------------------------------------------------------------------

    /**
     * Fetch all surveys related to a question id.
     *
     * @param int $id question id.
     *
     * @return mixed FALSE on error.
     */
    function get_by_question($id)
    {
        $this->db->where($this->get_table_name() . '.question_id', $id);
        $this->db->join('survey_questions', $this->get_table_name() . '.question_id = survey_questions.question_id');

        return $this->db->get($this->get_table_name());
    }

    // --------------------------------------------------------------------

    /**
     * Saves a question to the table after saving a survey.
     *
     * @param array $question_ids
     * @param int $survey_id
     *
     * @return mixed FALSE on error.
     */    
    function do_save($question_ids, $survey_id)
    {
        // First delete all records.
        $this->delete($survey_id);

        // Create an array for insert_batch.
        foreach ($question_ids as $id)
        {
            $a[] = array ('question_id' => $id, 'survey_id' => $survey_id);
        }

        return $this->db->insert_batch($this->get_table_name(), $a);
    }

    // --------------------------------------------------------------------

    /**
     * Saves a question to the table.
     *
     * @param int $question_id
     * @param array $survey_id
     *
     * @return mixed FALSE on error.
     */    
    function save_question($question_id, $survey_id)
    {
        // Set the primary to question_id so it deletes according to question_id.
        $this->set_primary_key('question_id');
        // First delete all records.
        $this->delete($question_id);
        // Set back the original key, just in case.
        $this->set_primary_key('survey_id');

        if (isset($survey_id))
        {
            if (!is_array($survey_id))
            {
                if ($survey_id > 0)
                {
                    $survey_id = (array) $survey_id;
                }
                else
                {
                    return TRUE;
                }
            }

            // Create an array for insert_batch.
            foreach ($survey_id as $id)
            {
                $a[] = array ('question_id' => $question_id, 'survey_id' => $id);
            }

            return $this->db->insert_batch($this->get_table_name(), $a);
        }

        return TRUE;
    }
}

/* End of file m_survey_questions.php */
/* Location: ./application/models/default/m_survey_questions.php */
