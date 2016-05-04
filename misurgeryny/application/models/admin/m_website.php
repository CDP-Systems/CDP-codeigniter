<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_website extends CI_Model {

	function getWebsite(){
		$data = array();
		$this->db->limit(1);
		$q = $this->db->get('website');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function getName(){
		$data['name'] = '';
		$this->db->select('name');
		$this->db->limit(1);
		$q = $this->db->get('website');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data['name'];
	}
	
	function updateWebsite($post){
		$webdata = array(
			'name' => $post['sitename'],
			'site_logo' => $post['site_logo']
		);
		if($this->db->update('website', $webdata)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function updateSeo($post){
		$webdata = array(
			'default_metakeywords' => $post['default_metakeywords'],
			'default_metadesc' => $post['default_metadesc'],
			'meta_robots' => $post['meta_robots']
		);
		if($this->db->update('website', $webdata)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function removeLogo($id){
		$webdata = array('site_logo' => '');
		$this->db->where('id_website', $id);
		if($this->db->update('website', $webdata)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}


/* End of file m_website.php */
/* Location: ./application/models/admin/m_website.php */