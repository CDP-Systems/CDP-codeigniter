<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_states extends MY_Model {

        function __construct()
        {
            parent::__construct();

            $this->set_table_name('states');
            $this->set_primary_key('state_id');
	     $this->db->order_by('state_name', 'asc');
        }
}

/* End of file m_states.php */
/* Location: ./application/models/default/m_states.php */