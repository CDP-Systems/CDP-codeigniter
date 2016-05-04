<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_modules extends CI_Model {

	function getAllModules(){
		$data = array();
		$this->db->order_by('order', 'ASC');
		$q = $this->db->get('modules');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	function getActivatedModules(){
		$data = array();
		$this->db->where('activated', 1);
		$this->db->order_by('name', 'ASC');
		$q = $this->db->get('modules');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}

}


/* End of file m_modules.php */
/* Location: ./application/models/admin/m_modules.php */
