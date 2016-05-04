<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_subscribers extends CI_Model {

	function insert($data){
		$data = array(
			/*
			'hospital' => $data['hospital'],
			'contact' => $data['contact'],
			'website' => $data['website'],
			*/
			'fname' => $data['fname'],
			'lname' => $data['lname'],
			'email' => $data['email'],
			/*
			'marketing_head' => $data['marketing_head'],
			'proper_designation' => $data['proper_designation'],
			'address' => $data['address'],
			'contact_person' => $data['contact_person'],
			'remarks' => $data['remarks'],
			*/
			'active' => 1,
			'subscription_key' => $data['subscription_key']
			
		);
		if($this->db->insert('subscribers', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function update($data){
		$subscriberData = array(
			/*
			'hospital' => $data['hospital'],
			'contact' => $data['contact'],
			'website' => $data['website'],
			*/
			'fname' => $data['fname'],
			'lname' => $data['lname'],
			'email' => $data['email'],
			/*
			'marketing_head' => $data['marketing_head'],
			'proper_designation' => $data['proper_designation'],
			'address' => $data['address'],
			'contact_person' => $data['contact_person'],
			'remarks' => $data['remarks'],
			*/
			'subscription_key' => $data['subscription_key']
			
		);
		$this->db->where('id_subscriber', $data['id_subscriber']);
		if($this->db->update('subscribers', $subscriberData)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function unsubscribe($id){
		$subscriberData = array(
			'active' => 0
		);
		$this->db->where('id_subscriber', $id);
		if($this->db->update('subscribers', $subscriberData)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function subscribe($id){
		$subscriberData = array(
			'active' => 1
		);
		$this->db->where('id_subscriber', $id);
		if($this->db->update('subscribers', $subscriberData)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function get_all($perpage,$offset){
		$data = array();
		$this->db->limit($perpage,$offset);
		$q = $this->db->get('subscribers');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	function get_count(){
		return $this->db->count_all('subscribers');
	}
	
	function get($id){
		$data = array();
		$this->db->limit(1);
		$this->db->where('id_subscriber', $id);
		$q = $this->db->get('subscribers');
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function delete($id){
		$this->db->where('id_subscriber', $id);
		if($this->db->delete('subscribers')){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function get_subscribers(){
		$data = array();
		$this->db->where('active', 1);
		$q = $this->db->get('subscribers');
		if($q->num_rows() > 0){
			foreach($q->result_array() as $row){
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	
	function import($data){
		$data = array(
			/*
			'hospital' => $data[0],
			'contact' => $data[1],
			'website' => $data[2],
			'email' => $data[3],
			'marketing_head' => $data[4],
			'proper_designation' => $data[5],
			'address' => $data[6],
			'contact_person' => $data[7],
			'remarks' => $data[8],
			'active' => 1
			*/
			'fname' => $data[0],
			'lname' => $data[1],
			'email' => $data[2],
			/*
			'marketing_head' => $data[4],
			'proper_designation' => $data[5],
			'address' => $data[6],
			'contact_person' => $data[7],
			'remarks' => $data[8],
			*/
			'active' => 1
		);
		if($this->db->insert('subscribers', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}



/* End of file m_subscribers.php */
/* Location: ./application/models/admin/m_subscribers.php */