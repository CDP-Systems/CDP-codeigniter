<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_subscribers extends CI_Model {

	function insert($data){
		$data = array(
			'email' => $data['email'],
			'active' => 1,
			'subscription_key' => $data['subscription_key']
		);
		if($this->db->insert('subscribers', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function save($data){
		$data = array(
                        'fname' => $data['fname'],
                        'lname' => $data['lname'],
			'email' => $data['email'],
			'active' => 1,
			'subscription_key' => $data['subscription_key']
		);
		if($this->db->insert('subscribers', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function getBySubscriptionKey($subscription_key){
		$data = array();
		$q = $this->db->get_where('subscribers', array('subscription_key' => $subscription_key), 1);
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function getByEmail($email){
		$data = array();
		$q = $this->db->get_where('subscribers', array('email' => $email), 1);
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function get($id){
		$data = array();
		$q = $this->db->get_where('subscribers', array('id_subscriber' => $id), 1);
		if($q->num_rows() > 0){
			$data = $q->row_array();
		}
		$q->free_result();
		return $data;
	}
	
	function unsubscribe($subscription_key){
		$subscriberData = array(
			'active' => 0
		);
		$this->db->where('subscription_key', $subscription_key);
		if($this->db->update('subscribers', $subscriberData)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function subscribe($subscription_key){
		$subscriberData = array(
			'active' => 1
		);
		$this->db->where('subscription_key', $subscription_key);
		if($this->db->update('subscribers', $subscriberData)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}

/* End of file m_subscribers.php */
/* Location: ./application/models/default/m_subscribers.php */