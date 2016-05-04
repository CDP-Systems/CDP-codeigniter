<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_survey_user_responses extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->set_table_name('survey_user_responses');
        $this->set_primary_key('response_id');
    }

    // --------------------------------------------------------------------

    function do_create($params)
    {
        $params['date_taken'] = date('Y-m-d h:i:s');

        return parent::do_create($params);
    }    
    
    // --------------------------------------------------------------------
    
    function delete($id)
    {
    	$sql = "DELETE FROM ci_survey_answers WHERE response_id = '" . $id . "'";
    	$this->db->query($sql);
    	
    	return parent::delete($id);    	    	
    }
}

/* End of file m_survey_user_responses.php */
/* Location: ./application/models/default/m_survey_user_responses.php */