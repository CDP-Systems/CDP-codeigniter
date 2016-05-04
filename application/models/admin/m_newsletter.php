<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_newsletter extends CI_Model {

	function insert($data){
		$data = array(
			'title' => $data['title'],
			'body' => $data['body'],
			'date_add' => date('Y-m-d H:i:s'),
			'date_upd' => date('Y-m-d H:i:s')
		);
		if($this->db->insert('newsletter', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function update($data){
		$newsdata = array(
			'title' => $data['title'],
			'body' => $data['body'],
			'date_upd' => date('Y-m-d H:i:s')
		);
		$this->db->where('id_newsletter', $data['id_newsletter']);
		if($this->db->update('newsletter', $newsdata)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function get_all($perpage, $offset){
		$data = array();
		$this->db->order_by('date_add', 'DESC');
		$this->db->limit($perpage,$offset);
		$q = $this->db->get('newsletter');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	function get_count(){
		return $this->db->count_all('newsletter');
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
	
	function delete($id){
		$this->db->where('id_newsletter', $id);
		if($this->db->delete('newsletter')){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function attach($id, $attachment){
		$data = array(
			'attachment' => $attachment
		);
		$this->db->where('id_newsletter', $id);
		if($this->db->update('newsletter', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function detach($id){
		$data = array('attachment' => '');
		$this->db->where('id_newsletter', $id);
		if($this->db->update('newsletter', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}



/* End of file m_newsletter.php */
/* Location: ./application/models/admin/m_newsletter.php */