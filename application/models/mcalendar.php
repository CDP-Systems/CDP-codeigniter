<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MCalendar extends MY_Model {

    private $_table_name = 'eventcal';
    private $_primary_key = 'id';

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    function getEvents($time){

            $today = date("Y/n/j", time());
            $current_month = date("n", $time);
            $current_year = date("Y", $time);
            $current_month_text = date("F Y", $time);
            $total_days_of_current_month = date("t", $time);

            $events = array();

            $query = $this->db->query("
            SELECT DATE_FORMAT(eventDate,'%d') AS day,
            eventContent,eventTitle,id,user,user_id, category_color
            FROM ci_eventcal AS ev
                LEFT JOIN ci_calendar_category AS cc ON ev.category_id = cc.category_id
            WHERE eventDate BETWEEN  '$current_year/$current_month/01'
                                            AND '$current_year/$current_month/$total_days_of_current_month'");

            foreach ($query->result() as $row_event)
            {
                    $events[intval($row_event->day)][] = $row_event;
            }
            $query->free_result();
            return $events;
    }


    function getDayEvents($day){

            $query = $this->db->get_where('eventcal',array('eventDate'=>$day));
            foreach ($query->result_array() as $row_event)
            {
                    $events[] = $row_event;
            }
            $query->free_result();
            return $events;

    }


    function getMyEvents($time, $user_id=0){

            $today = date("Y/n/j", time());
            $current_month = date("n", $time);
            $current_year = date("Y", $time);
            $current_month_text = date("F Y", $time);
            $total_days_of_current_month = date("t", $time);

            $events = array();

            $query = $this->db->query("
            SELECT DATE_FORMAT(eventDate,'%d') AS day,
            eventContent,
            eventTitle,id,user,user_id
            FROM eventcal
            WHERE  eventDate BETWEEN  '$current_year/$current_month/01'
                                            AND '$current_year/$current_month/$total_days_of_current_month'
            AND user_id = '$user_id' ");
            foreach ($query->result() as $row_event)
            {
                    $events[intval($row_event->day)][] = $row_event;
            }
            $query->free_result();
            return $events;
    }

    function getEventsById($id){

    $this->db->where('id', $id);
    $query = $this->db->get('eventcal');
    foreach ($query->result_array() as $event)
            {
                    $data[] = $event;
            }
    $query->free_result();
     return $data;
    }


    function addEvents()
    {
        unset($_POST['add']);
        return parent::do_save($_POST);
    }

    function updateEvent(){

            $data = array(
           'eventDate' => db_clean($_POST['date']),
           'eventTitle' => db_clean($_POST['eventTitle']),
           'eventContent' => db_clean($_POST['eventContent'])
        );
            $this->db->where('id', id_clean($_POST['id']));
            $this->db->update('eventcal', $data);
    }


    function deleteEvent($id){
            return parent::delete($id);
    }

// end of Model/MCalendar.php	
}
