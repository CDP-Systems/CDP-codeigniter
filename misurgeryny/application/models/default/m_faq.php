<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_faq extends CI_Model {

	function get_all($perpage, $offset){
		$data = array();
		$this->db->limit($perpage,$offset);
		$q = $this->db->get('faq');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$row['date_add'] = date('M d, Y g:i A',strtotime($row['date_add']));
				$row['date_upd'] = date('M d, Y g:i A',strtotime($row['date_upd']));
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	function get_by_category($id_faq_category){
		$data = array();
		$this->db->where('id_faq_category', $id_faq_category);
		$q = $this->db->get('faq');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$row['date_add'] = date('M d, Y g:i A',strtotime($row['date_add']));
				$row['date_upd'] = date('M d, Y g:i A',strtotime($row['date_upd']));
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	function get($id){
		$data = array();
		$this->db->where('id_faq', $id);
		$this->db->limit(1);
		$q = $this->db->get('faq');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		return $data;
	}
	
	function insert($data){
		$data = array(
			'id_faq_category' => $data['category'],
			'question' => $data['question'],
			'answer' => $data['answer'],
			'date_add' => date('Y-m-d H:i:s'),
			'date_upd' => date('Y-m-d H:i:s')
		);
		if($this->db->insert('faq', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function update($post){            
		$data = array(
			'id_faq_category' => $post['category'],
			'question' => $post['question'],
			'answer' => $post['answer'],
			'date_upd' => date('Y-m-d H:i:s')
		);
		$this->db->where('id_faq', $post['id_faq']);
		if($this->db->update('faq', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function get_count(){
		return $this->db->count_all('faq');
	}
	
	function delete($id){ 
		$this->db->where('id_faq', $id);
		if($this->db->delete('faq')){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}
/* End of file m_faq.php */
/* Location: ./application/models/admin/m_faq.php */