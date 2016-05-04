<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "appointment" table.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-05-23
 */
class M_appointment extends MY_Model {

    private $_table_name = 'appointment';
    private $_primary_key = 'appointment_id';
    //
    private $_extra_where;

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }
    

    // --------------------------------------------------------------------

    /**
     * Override to remove unwanted fields.
     * 
     * @param array $params
     *
     * @return mixed FALSE on error.
     */
    function do_save($params)
    {
		
        if (isset($params['date_selected']))
        {
            $params['date_selected'] = date('Y-m-d', strtotime($params['date_selected']));
        }
        else
        {
            $params['date_selected'] = $params['year'] . '-' . $params['month'] . '-' . $params['date'];
        }
        
        unset($params['year']);
        unset($params['month']);
        unset($params['date']);                
        
		if(!is_array($params['phone'])){
		
			show_error("Invalid data type of phone given.");
		}else{
        
			$params['phone'] = implode('-', $params['phone']);
        }
        return parent::do_save($params);
    } 
    
    function persist($post)
    {
    	$data = array(
		'name' => $post['name'],
		'phone' => $post['phone'],
		'email' => $post['email'],
		'other' => $post['other'],
		'comments' => $post['comments']
	);
	if($this->db->insert($this->get_table_name(), $data)){
		return TRUE;
	}else{
		return FALSE;
	}
    }
}

/* End of file m_appointment.php */
/* Location: ./application/models/default/m_appointment.php */
