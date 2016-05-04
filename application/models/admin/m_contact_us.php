<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_contact_us extends CI_Model {

	function get_count(){
		return $this->db->count_all('contact_us');
	}
	
	function get($id){
		$data = array();
		$this->db->limit(1);
		$this->db->where('id_contact_us', $id);
		$q = $this->db->get('contact_us');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function get_all($perpage, $offset){
		$data = array();
		$this->db->order_by('date_sent', 'DESC');
		$this->db->limit($perpage,$offset);
		$q = $this->db->get('contact_us');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$row['date_sent'] = date('M d, Y', strtotime($row['date_sent']));
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	function delete($id){
		$this->db->where('id_contact_us', $id);
		if($this->db->delete('contact_us')){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}
/* End of file m_contact_us.php */
/* Location: ./application/models/admin/m_contact_us.php */