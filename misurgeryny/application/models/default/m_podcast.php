<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_podcast extends CI_Model {

	function get_count(){
		return $this->db->count_all('podcast');
	}
	
	function get($id){
		$data = array();
		$this->db->where('id_podcast', $id);
		$this->db->limit(1);
		$q = $this->db->get('podcast');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		return $data;
	}
	
	function get_all($perpage, $offset){
		$data = array();
		$this->db->limit($perpage,$offset);
		$q = $this->db->get('podcast');
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
	
	function insert($post){
		$data = array(
			'title' => $post['title'],
			'author' => $post['author'],
			'file_name' => $post['file_name'],
			'file_type' => $post['file_type'],
			'date_add' => date('Y-m-d H:i:s'),
			'date_upd' => date('Y-m-d H:i:s'),
			'desc' => $post['desc']
		);
		if($this->db->insert('podcast', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function update($post){            
		$data = array(
			'title' => $post['title'],
			'author' => $post['author'],
			'file_name' => $post['file_name'],
			'file_type' => $post['file_type'],
			'date_upd' => date('Y-m-d H:i:s'),
			'desc' => $post['desc']
		);
		$this->db->where('id_podcast', $post['id_podcast']);
		if($this->db->update('podcast', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function delete($id){ 
		$this->db->where('id_podcast', $id);
		if($this->db->delete('podcast')){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function get_all_for_podcast(){
		$data = array();
		$this->db->order_by('date_add', 'DESC');
		$q = $this->db->get('podcast');
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
	
}

/* End of file m_podcast.php */
/* Location: ./application/models/admin/m_podcast.php */