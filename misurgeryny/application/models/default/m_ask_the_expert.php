<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ask_the_expert extends CI_Model {

	function get_count(){
		return $this->db->count_all('ask_the_expert');
	}
	
	function get($id){
		$data = array();
		$this->db->limit(1);
		$this->db->where('id_ask_the_expert', $id);
		$q = $this->db->get('ask_the_expert');
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
		$q = $this->db->get('ask_the_expert');
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
		$this->db->where('id_ask_the_expert', $id);
		if($this->db->delete('ask_the_expert')){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function insert($post){
		$data = array(
			'name' => $post['name'],
			'email' => $post['email'],
			'subject' => $post['subject'],
			'date_sent' => date('Y-m-d H:i:s'),
			'question' => $post['question']
		);
		if($this->db->insert('ask_the_expert', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}
/* End of file m_ask_the_expert.php */
/* Location: ./application/models/admin/m_ask_the_expert.php */