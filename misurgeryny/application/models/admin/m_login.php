<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_login extends CI_Model {

	function login($username, $password){
		$data = array();
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->limit(1);
		$q = $this->db->get('admin');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}	
	
}

/* End of file m_login.php */
/* Location: ./application/models/m_login.php */