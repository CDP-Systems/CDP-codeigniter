<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_online_seminar_attendees extends MY_Model {

    private $_table_name = 'online_seminar_attendees';
    private $_primary_key = 'seminar_attendee_id';

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    // --------------------------------------------------------------------
    
    /**
     * Override parent::do_create() because we need to perform some modifications to the data.
     *
     * @param array $params  Associative array of data to be inserted.
     * @return int           The last inserted id.
     */
    function do_create($params)
    {  
        // Convert to inches.
        $params['height'] = ($params['feet'] * 12) + $params['inches'];
        // Compute for bmi.
        $params['bmi'] = number_format( ($params['weight'] / pow($params['height'], 2) ) * 703 , 2);

        $params['date_of_birth'] = $params['year'] . '-' . $params['month'] . '-' . $params['date'];
        $params['date_posted'] = date('Y-m-d h:i:s');

        unset($params['feet']);
        unset($params['inches']);
        unset($params['month']);
        unset($params['year']);
        unset($params['date']);

        return parent::do_create($params);
    }

    // --------------------------------------------------------------------

    /**
     * Get all attendees along with the seminar they attended.
     *
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    function get_all_attendee_seminar($limit = null, $offset = null)
    {
        $this->db->select(
                '*, '.$this->_table_name.'.date_posted AS attendee_date_posted, CONCAT(address1, " ", address2, " ,", city, " ,", states.state_name, " ,", zip , " ,", country.name) AS attendee_address',
                FALSE
                );
        $this->db->join('online_seminars', $this->_table_name.'.seminar_id = ' . $this->_table_name . '.seminar_id', 'left');
        $this->db->join('country', 'country.country_id = ' . $this->_table_name . '.country_id', 'left');
        $this->db->join('states', 'states.state_id = ' . $this->_table_name . '.state', 'left');
        $this->db->order_by($this->_table_name.'.date_posted DESC');

        return $this->db->get($this->_table_name, $limit, $offset);
    }

    // --------------------------------------------------------------------

    /**
     * Get single attendee along with the seminar attended.
     *
     * @param int $id
     * @return mixed
     */
    function get_attendee_seminar($id)
    {
        $this->db->where($this->_primary_key, $id);

        return $this->get_all_attendee_seminar();
    }

    // --------------------------------------------------------------------

    /**
     * Get number of attendees for a seminar.
     *
     * @param int $seminar_id
     * @return int
     */
    function get_attendee_count($seminar_id)
    {
        $this->db->select('COUNT(seminar_attendee_id) + SUM(number_of_guests) AS total_attendees', FALSE);
                            
        $this->db->where('seminar_id', $seminar_id);

        $attendees = $this->db->get($this->_table_name)->row();

        return $attendees->total_attendees;
    }
}

/* End of file m_seminars.php */
/* Location: ./application/models/default/m_seminars.php */
