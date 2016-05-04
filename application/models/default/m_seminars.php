<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "seminars" table.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-25
 */
class M_seminars extends MY_Model {

    private $_table_name = 'seminars';
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
     * Fetch all available seminars.
     *
     * @param int $limit
     * @param int $offset
     */
    function fetch_all($limit = null, $offset = null)
    {
        $ci =& get_instance();        

        $sql = "SELECT s1.*, COUNT(seminar_attendee_id) + SUM(number_of_guests) AS total_attendees FROM ci_seminars AS s1 
                LEFT JOIN ci_seminar_attendees AS s2 ON s2.seminar_id = s1.seminar_id 
                WHERE 1=1 ";

        
        // Modify the query based on the configuration.
        if ($ci->config->item('seminars_show_inactive') == FALSE)
        {
            $sql .= "AND s1.status = 'active' ";
        }

        if ($ci->config->item('seminars_show_ended') == FALSE)
        {
            $sql .= "AND s1.seminar_date >= '" . date('Y-m-d') . "'";
        }

        $sql .= " GROUP BY s1.seminar_id "; 

        if ($ci->config->item('seminars_show_full') == FALSE)
        {            
            $sql .= "HAVING total_attendees <= s1.max_num_attendees ";
        }

        $sql .= "ORDER BY s1.seminar_date ASC";

        if (!is_null($offset))
        {
            $sql .= " LIMIT " . $offset;
        }

        if (!is_null($limit))
        {
            $sql .= ", " . $limit;
        }

        return $this->db->query($sql);
    }

    /**
     * Returns an assoc array for dropdown fields.
     *
     * @return array.
     */
    function get_dates_dropdown($condition = null)
    {
        $seminars = $this->fetch_all(null, null, $condition);

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
        if (set_value('is_full') == '' || set_value('is_full') == FALSE)
        {
            $params['is_full'] = FALSE;
        }
        
        return parent::do_update($params);
    }
}

/* End of file m_seminars.php */
/* Location: ./application/models/default/m_seminars.php */
