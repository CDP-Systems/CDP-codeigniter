<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_administrator extends CI_Model {

	function getSuperAdmin(){
		$data = array();
		$this->db->limit(1);
		$this->db->where('super_admin', 1);
		$q = $this->db->get('admin');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function getAdminEmail(){
		$data = array();
		$this->db->limit(1);
                $this->db->where('username', 'admin');
		$this->db->where('super_admin', 0);
		$q = $this->db->get('admin');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data['email'];
	}
	
	function getAdmin($id){
		$data = array();
		$this->db->limit(1);
		$this->db->where('id_admin', $id);
		$q = $this->db->get('admin');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function updateSuperAdmin($post){
		$admindata = array(
			'email' => $post['admin_email'],
			'name' => $post['admin_name']
		);
		$this->db->where('super_admin', 1);
		$this->db->where('id_admin', $post['id_admin']);
		if($this->db->update('admin', $admindata)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function updateAdmin($post, $id){
		$admindata = array(
			'email' => $post['admin_email'],
			'name' => $post['admin_name']
		);
		$this->db->where('id_admin', $id);
		if($this->db->update('admin', $admindata)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function changePassword($id, $password){
		$this->db->where('id_admin', $id);
		if($this->db->update('admin', array('password' => $password))){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function getPassword($id){
		$data['password'] = '';
		$this->db->select('password');
		$this->db->where('id_admin', $id);
		$this->db->limit(1);
		$q = $this->db->get('admin');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data['password'];
	}
	
	function getAdminByEmail($email){
		$data = array();
		$q = $this->db->get_where('admin', array('email' => $email));
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function resetPassword($id, $new_password){
		$data = array('password' => $new_password);
		$this->db->where('id_admin', $id);
		if($this->db->update('admin', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function confirmAdmin($id, $reset_key){
		$data = array();
		$this->db->where('id_admin', $id);
		$this->db->where('reset_key', $reset_key);
		$this->db->limit(1);
		$q = $this->db->get('admin');
		if($q->row_array() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function setResetKey($id, $key){
		$this->db->where('id_admin', $id);
		if($this->db->update('admin', array('reset_key' => $key))){
			return TRUE;
		}else{
			return FALSE;
		}
	}	
	
	function saveResetPass($id, $reset_pass){
		$this->db->where('id_admin', $id);
		if($this->db->update('admin', array('reset_pass' => $reset_pass))){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}

/* End of file m_administrator.php */
/* Location: ./application/models/admin/m_administrator.php */