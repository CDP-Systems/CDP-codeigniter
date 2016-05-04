<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_newsletter extends CI_Model {

	function get_newsletter($count){
		$data = array();
		$this->db->limit($count);
		$q = $this->db->get('newsletter');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function get($id){
		$data = array();
		$this->db->limit(1);
		$this->db->where('id_newsletter', $id);
		$q = $this->db->get('newsletter');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function get_all(){
		$data = array();
		$q = $this->db->get('newsletter');
		if($q->num_rows() > 0){
			$data = $q->result_array();
		}
		$q->free_result();
		return $data;
	}
	
}

/* End of file m_page.php */
/* Location: ./application/models/default/m_page.php */