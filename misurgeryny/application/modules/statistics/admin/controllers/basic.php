<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Statistics categories controller for admin.
 *
 * @package Statistics
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-06-21
 */
class Basic extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        
        $this->load->helper('form');
                
        // Add this module's directories to the loader so it is aware of the new directories to look in.               
        $this->load->add_package_path(MODPATH . 'statistics');
        $this->load->model('m_statistics', 'statistics');
    }       
    
    // --------------------------------------------------------------------    
    
    /**
     * 
     */
    function index()
    {
        //build array of times.
        $times = array();
        $time = strtotime("00:00:00");
        $times["00:00:00"]['time'] = date("g:i a",$time);
        
        for($i = 1;$i < 24;$i++) {
	        $time = strtotime("+ 1 hour",$time);
	        $key = date("H:i:s",$time);
	        $times[$key]['time'] = date("g:i a",$time);
	        $times[$key]['hits'] = $this->statistics->get_total_hits($key);
	        $times[$key]['unique'] = $this->statistics->get_unique_visitors($key);	        
        }
        
        $times["00:00:00"]['hits'] = $this->statistics->get_total_hits("00:00:00");
        $times["00:00:00"]['unique'] = $this->statistics->get_unique_visitors("00:00:00");       

        $this->view_data['times'] = $times;

        $this->view_data['total_hits']   = $this->statistics->get_total_hits();
        $this->view_data['total_unique'] = $this->statistics->get_unique_visitors();
        $this->view_data['today_hits']   = $this->statistics->get_total_hits('today');
        $this->view_data['today_unique']   = $this->statistics->get_unique_visitors('today');        
    
        $this->view_data['last_monday_hits'] = $this->statistics->get_total_hits('last monday');
        $this->view_data['last_monday_unique'] = $this->statistics->get_unique_visitors('last monday');
    
        $this->view_data['last_tuesday_hits'] = $this->statistics->get_total_hits('last tuesday');
        $this->view_data['last_tuesday_unique'] = $this->statistics->get_unique_visitors('last tuesday');    
    
        $this->view_data['last_wednesday_hits'] = $this->statistics->get_total_hits('last wednesday');
        $this->view_data['last_wednesday_unique'] = $this->statistics->get_unique_visitors('last wednesday');        
        
        $this->view_data['last_thursday_hits'] = $this->statistics->get_total_hits('last thursday');
        $this->view_data['last_thursday_unique'] = $this->statistics->get_unique_visitors('last thursday');        
        
        $this->view_data['last_friday_hits'] = $this->statistics->get_total_hits('last friday');
        $this->view_data['last_friday_unique'] = $this->statistics->get_unique_visitors('last friday');                    
        
        $this->view_data['last_saturday_hits'] = $this->statistics->get_total_hits('last saturday');
        $this->view_data['last_saturday_unique'] = $this->statistics->get_unique_visitors('last saturday');        

        $this->view_data['last_sunday_hits'] = $this->statistics->get_total_hits('last sunday');
        $this->view_data['last_sunday_unique'] = $this->statistics->get_unique_visitors('last sunday');

        $this->view_data['this_week_hits'] = $this->statistics->get_total_hits('week');
        $this->view_data['this_week_unique'] = $this->statistics->get_unique_visitors('week');        

        $this->view_data['last_week_hits'] = $this->statistics->get_total_hits('last week');
        $this->view_data['last_week_unique'] = $this->statistics->get_unique_visitors('last week');  

        $this->view_data['two_week_hits'] = $this->statistics->get_total_hits('2 weeks ago');
        $this->view_data['two_week_unique'] = $this->statistics->get_unique_visitors('2 weeks ago');    

        $this->view_data['three_week_hits'] = $this->statistics->get_total_hits('3 weeks ago');
        $this->view_data['three_week_unique'] = $this->statistics->get_unique_visitors('3 weeks ago');   

        $this->view_data['four_week_hits'] = $this->statistics->get_total_hits('4 weeks ago');
        $this->view_data['four_week_unique'] = $this->statistics->get_unique_visitors('4 weeks ago'); 

        $this->view_data['this_month_hits'] = $this->statistics->get_total_hits('this month');
        $this->view_data['this_month_unique'] = $this->statistics->get_unique_visitors('this month');

        $month_array = array ( 
                1 => 'January',
                2 => 'February',
                3 => 'March',
                4 => 'April',
                5 => 'May',
                6 => 'June',
                7 => 'July',
                8 => 'August',
                9 => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December'
            );

        $curr_month = date('Y-m');

        $this->view_data['month_array'] = $month_array;

        foreach ($month_array as $month)
        {
            $month = strtolower($month);
            $this->view_data[$month . '_hits'] = $this->statistics->get_total_hits($month);
            $this->view_data[$month . '_unique'] = $this->statistics->get_unique_visitors($month);

            $year = date('Y');
            
            if (strtotime(date('Y-m', strtotime(ucwords($month)))) > strtotime($curr_month))
            {
                $year = date('Y', strtotime('- 1 year'));
            }            
            $this->view_data[$month . '_year'] = $year;            
        }

        $this->view_data['top_pages'] = (array) $this->statistics->get_top_pages(15)->result();
        $this->view_data['content'] = 'basic';
        
        $this->parser->parse('admin/template', $this->view_data);
    }           
}
