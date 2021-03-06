<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_online_seminars extends MY_Model {

    private $_table_name = 'online_seminars';
    private $_primary_key = 'seminar_id';
    //
    private $_extra_where;

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    function fetch_all_admin($limit = null, $offset = null)
    {   
        $this->db->order_by($this->_primary_key . ' DESC');
        return parent::fetch_all($limit, $offset);
    }

    // --------------------------------------------------------------------
    
   

    /**
     * Returns an assoc array for dropdown fields.
     *
     * @return array.
     */
    function get_dates_dropdown()
    {
        $seminars = $this->fetch_all();

        $dropdown = array();

        // Loop through the results and form an associative array to use in form_select.
        foreach ($seminars->result() as $seminar)
        {
            $dropdown[$seminar->seminar_id] = date('F j, Y,', strtotime($seminar->seminar_date)) . ' ' . $seminar->time . ' - ' . $seminar->end_time;
        }

        return $dropdown;
    }

    function do_save($params)
    {
        $params['date_posted'] = date('Y-m-d');
        return parent::do_save($params);
    }

    /**
     * Override do_update so we can catch the checkbox for is_full.
     */
    function do_update($params)
    {
        
        return parent::do_update($params);
    }
}

/* End of file m_seminars.php */
/* Location: ./application/models/default/m_seminars.php */
