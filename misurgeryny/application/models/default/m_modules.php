<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_modules extends MY_Model {

    function __construct()
    {
        parent::__construct();

        $this->set_table_name('modules');
        $this->set_primary_key('id_module');
    }
	
	// --------------------------------------------------------------------
	
	/**
	 *
	 * Determine whether the controller is activated.
	 *
	 * @param string
	 *
	 * @return boolean
	 */
	function is_enabled($identifier)
	{
		$this->db->where('url_key', $identifier);
		$this->db->limit(1);
		$result = $this->db->get($this->get_table_name());
		$row = $result->row();
		
		if ($result->num_rows() == 0 || $row->activated == 1)
		{
		    return TRUE;
		}
		
		return FALSE;
	}
    
}

/* End of file m_videocast.php */
/* Location: ./application/models/default/m_modules.php */