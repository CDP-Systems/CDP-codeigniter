<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_contact_us extends CI_Model {

	function insert($post){
		$data = array(
			'specialty' => '',
			'name' => $post['name'],
			'time_to_contact' => $post['time_to_contact'],
			'email' => $post['email'],
			'date_sent' => date('Y-m-d H:i:s'),
			'message' => $post['message'],
			'number' => $post['number']
		);
		if($this->db->insert('contact_us', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	

}

/* End of file m_contact_us.php */
/* Location: ./application/models/default/m_contact_us.php */