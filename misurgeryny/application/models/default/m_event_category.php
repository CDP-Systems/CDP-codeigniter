<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "event_category" table.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-28
 */
class M_event_category extends MY_Model {

    private $_table_name = 'calendar_category';
    private $_primary_key = 'category_id';

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    function fetch_all($limit = null, $offset = null)
    {
        $this->db->where('status', '1');

        return parent::fetch_all($limit, $offset);
    }
}

/* End of file m_event_category.php */
/* Location: ./application/models/default/m_event_category.php */