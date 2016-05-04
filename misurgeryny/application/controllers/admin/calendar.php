<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Calendar Manager controller for admin view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-28
 */

class Calendar extends MY_Controller {

    protected $_form_data;

    function __construct()
    {
        parent::__construct();
        $this->load->model('MCalendar');

        $this->view_data['calendar_enable_color_coding'] = $this->config->item('calendar_enable_color_coding');
        $this->view_data['calendar_enable_recurring_events'] = $this->get_setting('calendar_enable_recurring_events');

        // Restrict access if disabled.
        if (!$this->view_data['calendar_enable_recurring_events']
                && (
                    $this->get_current_action() == 'add_recurring_event'
                    || $this->get_current_action() == 'recurring_events'
                    )
                )
        {
            redirect ('admin/calendar');
        }
    }

    // --------------------------------------------------------------------

    /**
     * List all events.
     */
    function index($page = 0)
    {            
    /** 
        if ($timeid == 0)
        {
            $time = time();
        }
        else
        {
            $time = $timeid;
        }
      */  
        $events = $this->MCalendar->fetch_all();

        if ($events->num_rows() > 0)
        {        
            $pagination['total_rows'] = $events->num_rows();

            $this->paginate($pagination);

            $results = $this->MCalendar->fetch_all(10, $page);

            $this->view_data['events'] = $results->result();
        }        
        // we call _date function
        //$this->view_data = array_merge($this->view_data, $this->_date($time));

        $this->view_data['content'] = 'admin/calendar/list';

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Create a new category.
     */
    function create_category()
    {
        $this->view_data['content'] = 'admin/calendar/edit_category';
        
        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * List all categories
     */
    function categories()
    {
        $this->load->model('default/m_event_category', 'categories');

        $this->view_data['content'] = 'admin/calendar/category_list';

        $categories = $this->categories->fetch_all();

        if ($categories->num_rows() > 0)
        {
            $page = $this->uri->segment(4);

            $pagination['base_url'] = '';
            $pagination['total_rows'] = $categories->num_rows();

            $this->paginate($pagination);

            $results = $this->categories->fetch_all(10, $page);

            $this->view_data['categories'] = $results->result();
        }

        $this->parser->parse('admin/template', $this->view_data);
    }

    function dayevents ($day)
    {
        $data['dayevents']= $this->MCalendar->getDayEvents($day);
        $data['header'] = 'Day events';
        $data['main'] = 'calendar_day_events';
        $this->load->vars($data);
        $this->load->view('calendar_day_events_view');
    }

    // --------------------------------------------------------------------

    /**
     * Create a new event.
     */
    function create()
    {
        $data['title'] = "Add Events to Calendar";

        // Prepare form values for input.
        $this->_prep_form_values('calendar_edit_note');       

        if($this->input->post('add'))
        {
            if ($this->_save_event())
            {
                $this->session->set_flashdata('message','Event created!');
                redirect (current_url());
            }
        }

        $this->load->model('default/m_event_category', 'categories');

        $categories = $this->categories->fetch_all();

        $this->view_data = array_merge($this->view_data, $data);
        
        $this->view_data['content'] = 'admin/calendar/calendar_create';
        $this->view_data['categories'] = $categories->result();

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------
    
    /**
     * Update an existing event.
     * 
     * @param int $id 
     */
    function edit($id=0)
    {
        $this->load->model('default/m_event_category', 'categories');

        $event = $this->MCalendar->get($id);

        $categories = $this->categories->fetch_all();

        $this->view_data['categories'] = $categories->result();
        
        $data['title'] = "Edit Events";

        $this->_prep_form_values('calendar_edit_note', $event);

        // Add the current event id to the form data so that when we call MY_Model::do_save() it would be treated as an update. oki
        $this->_form_data['id'] = $id;

        if($this->input->post('add'))
        {
            if ($this->_save_event())
            {
                $this->session->set_flashdata('message','Event updated!');
                redirect (current_url());
            }
        }

        $data['event']= $this->MCalendar->getEventsById($id);

        $this->view_data = array_merge($this->view_data, $data);

        $this->view_data['content'] = 'admin/calendar/calendar_create';

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * List all recurring events.
     */
    function recurring_events()
    {
        $this->load->model('default/m_recurring_events', 'recurring_events');
        
        $events = $this->recurring_events->fetch_all();

        $this->view_data['title']   = 'Recurring Events';
        $this->view_data['content'] = 'admin/calendar/recurring_events_list';
        $this->view_data['events']  = $events->result();

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Edit a recurring event form.
     */
    function edit_recurring_event($id)
    {
        $this->load->model('default/m_recurring_events', 'recurring_events');
        $this->load->helper('cs_dropdown');

        $this->view_data['title'] = 'Add a recurring event';
        $this->view_data['content'] = 'admin/calendar/edit_recurring';
        $this->view_data['id'] = $id;

        $event = $this->recurring_events->get($id);
        // Prepare form values for input.
        $this->_prep_form_values('calendar_edit_recurring_event', $event);
        $this->_form_data['id'] = $id;
        
        if ($this->input->post('submit') || $this->isAjax())
        {
            $id = $this->_save('calendar_edit_recurring_event', $this->recurring_events);
            if ($id)
            {
                // Fetch the dates and save to the events table.
                $dates = $this->_get_event_dates($this->_form_data);

                $event_data['eventTitle'] = $this->_form_data['event_title'];
                $event_data['eventContent'] = $this->_form_data['details'];
                $event_data['recurring_event_id'] = $id;

                $this->load->model('MCalendar', 'event');

                foreach ($dates as $date)
                {
                    $event_data['eventDate'] = $date;
                    $this->event->do_save($event_data);
                }

                if ($this->isAjax())
                {
                    echo $id; exit();
                }

                $this->session->set_flashdata('message', 'Events updated.');

                redirect (current_url());
            }
        }

        $this->parser->parse('admin/template', $this->view_data);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Add a recurring event form.
     */
    function add_recurring_event()
    {
        $this->load->model('default/m_recurring_events', 'recurring_events');
        $this->load->helper('cs_dropdown');

        $this->view_data['title'] = 'Add a recurring event';
        $this->view_data['content'] = 'admin/calendar/edit_recurring';

        if ($this->input->post('submit') || $this->isAjax())
        {
            // Prepare form values for input.
            $this->_prep_form_values('calendar_edit_recurring_event');
            
            $id = $this->_save('calendar_edit_recurring_event', $this->recurring_events);
            if ($id)
            {
                // Fetch the dates and save to the events table.
                $dates = $this->_get_event_dates($this->_form_data);

                $event_data['eventTitle'] = $this->_form_data['event_title'];
                $event_data['eventContent'] = $this->_form_data['details'];
                $event_data['recurring_event_id'] = $id;

                $this->load->model('MCalendar', 'event');

                foreach ($dates as $date)
                {
                    $event_data['eventDate'] = $date;
                    $this->event->do_save($event_data);
                }
                
                if ($this->isAjax())
                {
                    echo $id; exit();
                }                

                $this->session->set_flashdata('message', 'Events added.');

                redirect (current_url());                
            }
        }

        $this->parser->parse('admin/template', $this->view_data);
    }

    // --------------------------------------------------------------------

	/**
	 * Get all dates covered by the recurring event.
	 *
	 * @param array $fields
	 * @return array
	 */
	private function _get_event_dates($fields)
	{        
	    switch ($fields['recurrence'])
	    {
	        case 1:
	            $recurrence = 'day';
	            break;
	        case 2:
	            $recurrence = 'week';
	            break;
	        case 3:
	            $recurrence = 'month';
	            break;
	        case 4:
	            $recurrence = 'year';
	            break;
	    }

	    $r = '+' . $fields['recurrence_rate'] . ' ' . $recurrence;

	    $start_date = strtotime($fields['start_date']);
	    $end_date = strtotime($fields['end_date']);

	    // Loop through each recurrence rate.
	    $x = 0;
        $event_dates = array();
	    while ($start_date < $end_date)
	    {
	        $pointer = $start_date;

            // Check the dates for the week at the current pointer so we can populate the array.
	        while ($pointer < strtotime('+1 week', $start_date))
	        {
	            if (in_array(date('N', $pointer), $fields['recurrence_days']))
	            {
                    // Do not add duplicate dates.
                    if (!in_array(date('Y-m-d', $pointer), $event_dates))
                    {
                        $event_dates[$x] = date('Y-m-d', $pointer);
                        $x++;
                    }                    	                
	            }
                // Add 1 day to each pointer day to reach 1 week in order to complete this loop.
	            $pointer = strtotime('+1 day', $pointer);
	        }

	        $start_date = strtotime($r, $start_date);
	    }

	    return $event_dates;
	}

    // --------------------------------------------------------------------

    /**
     * Delete an event.
     *
     * @param int $id
     */
    function delete($id = null)
    {
    	if($id != null){
	        if ($this->MCalendar->deleteEvent($id))
	        {
	            $message = 'Event/s successfully deleted.';
	        }
	        else
	        {
	            $message = 'Event/s successfully deleted.';
	        }        
	        
	        $this->session->set_flashdata('message', $message);
        
        }else{
		$this->session->set_flashdata('message', '<p class="red bold">No event(s) selected.</p>');
	}
        
       /* if ($this->isAjax())
        {
            echo $message; exit();
        }
        else
        {*/
	    redirect('admin/calendar/index');
//	}	        
    }

    // --------------------------------------------------------------------

    /**
     * Delete a recurring event.
     *
     * @param int $id
     */
    function delete_recurring_event($id=0)
    {
        $this->load->model('default/m_recurring_events', 'recurring_events');
        
        if ($this->recurring_events->delete($id))
        {
            $message = 'Event/s successfully deleted.';
        }
        else
        {
            $message = 'Could not delete the event. Please contact the administrator.';
        }

        if ($this->isAjax())
        {
            echo $message; exit();
        }
        else
        {
            $this->session->set_flashdata('message', $message);
            redirect('admin/calendar/recurring_events');
        }
    }

    // --------------------------------------------------------------------

    /**
     * Save a single event.
     *
     * @return boolean
     */
    private function _save_event()
    {
        // Validate.
        $this->load->config('validations');
        $rules = $this->config->item('calendar_edit_note');
        
        // Remove category_id rule if not needed.
        if (!$this->config->item('calendar_enable_color_coding'))
        {
            unset($rules[2]);
        }

        $this->require_validation($rules);
        if ($this->form_validation->run())
        {
            //add new event to the database
            if ($this->MCalendar->do_save($this->_form_data))
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Display calendar dates for selected time.
     *
     * @param int $time
     * @return array
     */
    private function _date($time)
    {
        $data['events'] = $this->MCalendar->getEvents($time);

        $today = date("Y/n/j", time());
        $data['today']= $today;

        $current_month = date("n", $time);
        $data['current_month'] = $current_month;

        $current_year = date("Y", $time);
        $data['current_year'] = $current_year;

        $current_month_text = date("F Y", $time);
        $data['current_month_text'] = $current_month_text;

        $total_days_of_current_month = date("t", $time);
        $data['total_days_of_current_month']= $total_days_of_current_month;

        $first_day_of_month = mktime(0,0,0,$current_month,1,$current_year);
        $data['first_day_of_month'] = $first_day_of_month;

        //geting Numeric representation of the day of the week for first day of the month. 0 (for Sunday) through 6 (for Saturday).
        $first_w_of_month = date("w", $first_day_of_month);
        $data['first_w_of_month'] = $first_w_of_month;

        //how many rows will be in the calendar to show the dates
        $total_rows = ceil(($total_days_of_current_month + $first_w_of_month)/7);
        $data['total_rows']= $total_rows;

        //trick to show empty cell in the first row if the month doesn't start from Sunday
        $day = -$first_w_of_month;
        $data['day']= $day;

        $next_month = mktime(0,0,0,$current_month+1,1,$current_year);
        $data['next_month']= $next_month;

        $next_month_text = date("F \'y", $next_month);
        $data['next_month_text']= $next_month_text;

        $previous_month = mktime(0,0,0,$current_month-1,1,$current_year);
        $data['previous_month']= $previous_month;

        $previous_month_text = date("F \'y", $previous_month);
        $data['previous_month_text']= $previous_month_text;

        $next_year = mktime(0,0,0,$current_month,1,$current_year+1);
        $data['next_year']= $next_year;

        $next_year_text = date("F \'y", $next_year);
        $data['next_year_text']= $next_year_text;

        $previous_year = mktime(0,0,0,$current_month,1,$current_year-1);
        $data['previous_year']=$previous_year;

        $previous_year_text = date("F \'y", $previous_year);
        $data['previous_year_text']= $previous_year_text;

        return $data;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Control action for bulk selections.
     */
    function action()
    {
        $data = $this->input->post('data');

        $action = $this->input->post('selectAction');

	if (trim($action) == '')
	{
		$action = 'index';
	}

        $this->$action($data);
    }         
}
/* End of file calendar.php */
/* Location: ./application/controllers/admin/calendar.php */