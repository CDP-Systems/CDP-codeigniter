<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_self_assessment_user_responses extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->set_table_name('self_assessment_user_responses');
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
    	$sql = "DELETE FROM ci_self_assessment_answers WHERE response_id = '" . $id . "'";
    	$this->db->query($sql);
    	
    	return parent::delete($id);    	    	
    }
    
    function get($id){
		$data = array();
                $this->db->join('country', 'country.country_id = ' . $this->get_table_name() . '.country_id', 'left');
                $this->db->join('states', 'states.state_id = ' . $this->get_table_name() . '.state', 'left');
		$this->db->where($this->get_primary_key(), $id);
		$this->db->limit(1);
		$q = $this->db->get($this->get_table_name());
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		return $data;
	}
}

/* End of file m_self_assessment_user_responses.php */
/* Location: ./application/models/default/m_self_assessment_user_responses.php */