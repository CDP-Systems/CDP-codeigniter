<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_faq_category extends CI_Model {

	function get_all($perpage, $offset){
		$data = array();
		$this->db->limit($perpage,$offset);
		$q = $this->db->get('faq_category');
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
		$this->db->where('id_faq_category', $id);
		$this->db->limit(1);
		$q = $this->db->get('faq_category');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function get_count(){
		return $this->db->count_all('faq_category');
	}
	
	function get_categories(){
		$data = array();
		$this->db->order_by('id_faq_category', 'ASC');
		$q = $this->db->get('faq_category');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	function get_min(){
		$data = array();
		$this->db->limit(1);
		$this->db->select_min('id_faq_category');
		$q = $this->db->get('faq_category');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function insert($data){
		$data = array(
			'title' => $data['title'],
			'desc' => $data['desc'],
			'date_add' => date('Y-m-d H:i:s'),
			'date_upd' => date('Y-m-d H:i:s')
		);
		if($this->db->insert('faq_category', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function update($post){
		$data = array(
			'title' => $post['title'],
			'desc' => $post['desc'],
			'date_upd' => date('Y-m-d H:i:s')
		);
		$this->db->where('id_faq_category', $post['id_faq_category']);
		if($this->db->update('faq_category', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function delete($id){ 
		$this->db->where('id_faq_category', $id);
		if($this->db->delete('faq_category')){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	

}
/* End of file m_faq_category.php */
/* Location: ./application/models/admin/m_faq_category.php */