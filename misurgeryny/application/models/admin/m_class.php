<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_class extends CI_Model {

	function get_all(){
		$data = array();
		$this->db->order_by('name', 'ASC');
		$q = $this->db->get('class');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}

}

/* End of file m_class.php */
/* Location: ./application/models/admin/m_class.php */