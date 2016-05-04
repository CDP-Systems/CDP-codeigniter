<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_transactional_emails extends CI_Model {

	function get($name){
		$data = array();
		$q = $this->db->get_where('ci_transactional_emails', array('name' => $name), 1);
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function update($name, $msg){
		$data = array(
			'message' => $msg
		);
		$this->db->where('name', $name);
		if($this->db->update('transactional_emails', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}
/* End of file m_transactional_emails.php */
/* Location: ./application/models/admin/m_transactional_emails.php */