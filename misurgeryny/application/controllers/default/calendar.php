<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Calendar controller for user view only.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-28
 */

class Calendar extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('MCalendar');
		$this->load->model('default/M_page');
    }

    // --------------------------------------------------------------------

    /**
     * Default action displays the calendar.
     */
    function index($timeid = 0)
    {               
        if($timeid==0)
        {
            $time = time();
        }
        else
        {
            $time = $timeid;
        }

        $this->load->model('default/m_event_category', 'categories');
        $categories = $this->categories->fetch_all();

        $this->view_data['categories'] = $categories->result();

        // we call _date function
        $this->view_data = array_merge($this->view_data, $this->_date($time));

        $this->view_data['page'] = 'default/page/inner_page';
		
        $this->view_data['calendar_enable_color_coding'] = $this->config->item('calendar_enable_color_coding');
			
			//some page data
			$url_key = $this->get_current_module();
			
			$page = $this->M_page->get($url_key);
			$this->load->model('admin/M_website');
			$website = $this->M_website->getWebsite();
			
			$data['class'] = $page['class'];
			$data['content'] = $page['content'];
			$data['downloads'] = $this->M_download->get_downloads($page['id_page']);
			$data['robots'] = '';
			$data['keywords'] = $page['keywords'];
			$data['desc'] = $page['desc'];
			
			//set global meta data if page meta data is blank
			if($page['keywords'] == ''){
				$data['keywords'] = $website['default_metakeywords'];
			}
			if($page['desc'] == ''){
				$data['desc'] = $website['default_metadesc'];
			}
			
			$this->view_data = array_merge($this->view_data, $data);	
			
        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Show events for the selected day.
     *
     * @param string $day
     */
    function dayevents ($day)
    { 
        $this->view_data['dayevents']= $this->MCalendar->getDayEvents($day);
        $this->view_data['header'] = 'Day events';
        $this->view_data['main'] = 'calendar_day_events';

        $this->view_data['page'] = 'default/calendar/calendar_day_events_view';        

        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Show a single event.
     *
     * @param int $id
     */
    function view ($id)
    {
        $event = $this->MCalendar->get($id);
        // Check if event exists.
        if ($event)
        {
            $this->view_data['event_title']   = $event->eventTitle;
            $this->view_data['event_content'] = $event->eventContent;
            $this->view_data['event_date']    = $event->eventDate;
        }
        else
        {
            $this->view_data['empty'] = TRUE;
        }

        $this->view_data['page'] = 'default/page/inner_page';

			//some page data
			$url_key = $this->get_current_module();
			
			$page = $this->M_page->get($url_key);
			$this->load->model('admin/M_website');
			$website = $this->M_website->getWebsite();
			
			$data['class'] = $page['class'];
			$data['robots'] = '';
			$data['keywords'] = $page['keywords'];
			$data['desc'] = $page['desc'];
			
			//set global meta data if page meta data is blank
			if($page['keywords'] == ''){
				$data['keywords'] = $website['default_metakeywords'];
			}
			if($page['desc'] == ''){
				$data['desc'] = $website['default_metadesc'];
			}
		
			$this->view_data = array_merge($this->view_data, $data);        

        $this->parser->parse('default/templates/' . $this->get_setting('inner_template'), $this->view_data);
    }
	
    // --------------------------------------------------------------------

    /**
     * Get calendar dates for selected time period.
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
}
/* End of file calendar.php */
/* Location: ./application/controllers/default/calendar.php */
