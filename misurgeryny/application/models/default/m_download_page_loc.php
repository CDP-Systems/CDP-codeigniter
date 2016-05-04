<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_download_page_loc extends CI_Model {

	function insert($data){
		$data = array(
			'id_page' => $data['id_page'],
			'id_download' => $data['id_download']
		);
		if($this->db->insert('download_page_loc', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function getByDownloads($id_download){
		$data = array();
		$this->db->where('id_download', $id_download);
		$q = $this->db->get('download_page_loc');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$data[] = $row;
			}
		}
		$q->free_result(); 
		return $data;
	}
	
	function deleteByDownload($id_download){ 
		$this->db->where('id_download', $id_download);
		if($this->db->delete('download_page_loc')){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function getByPage($id_page){
		$data = array();
		$this->db->where('id_page', $id_page);
		$q = $this->db->get('download_page_loc');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
}

/* End of file m_download_page_loc.php */
/* Location: ./application/models/admin/m_download_page_loc.php */