<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_download extends CI_Model {

	function get_count(){
		return $this->db->count_all('download');
	}
	
	function get($id){
		$data = array();
		$this->db->where('id_download', $id);
		$this->db->limit(1);
		$q = $this->db->get('download');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		return $data;
	}
	
	function get_all($perpage, $offset){
		$data = array();
		$this->db->limit($perpage,$offset);
		$q = $this->db->get('download');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$row['date_posted'] = date('M d, Y; g:i A',strtotime($row['date_posted']));
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}

	function insert($data){
		$data = array(
			'title' => $data['title'],
			'file_name' => $data['file_name'],
			'file_size' => $data['file_size'],
			'date_posted' => date('Y-m-d H:i:s'),
			'desc' => $data['desc']
		);
		if($this->db->insert('download', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function update($post){            
		$data = array(
			'title' => $post['title'],
			'file_name' => $post['file_name'],
			'file_size' => $post['file_size'],
			'desc' => $post['desc']
		);
		$this->db->where('id_download', $post['id_download']);
		if($this->db->update('download', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function delete($id){ 
		$this->db->where('id_download', $id);
		if($this->db->delete('download')){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function get_downloads($id_page){
		$downloads = array();
		$pages = $this->M_download_page_loc->getByPage($id_page);
		foreach($pages as $row){
			$downloads[] = $this->M_download->get($row['id_download']);
		}
		return $downloads;
	}
	
}

/* End of file m_download.php */
/* Location: ./application/models/admin/m_download.php */