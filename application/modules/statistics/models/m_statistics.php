<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "statistics" table.
 *
 * @package Statistics
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-06-21
 */
class M_statistics extends MY_Model {

    private $_table_name = 'statistics';
    private $_primary_key = 'statistics_id';

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }
    
    // --------------------------------------------------------------------    
    
    /**
     * Get total page views.
     *
     * @param string $modifier
     *
     * @return int
     */
    public function get_total_hits($modifier = null)
    {                
        if (!is_null($modifier))
        {
            $this->_get_where($modifier);
        }
        
        $hits = parent::fetch_all();

        return $hits->num_rows();
    }
    
    // --------------------------------------------------------------------    
    
    public function get_unique_visitors($modifier = null)
    {
        $this->db->group_by('ip_address');
        
        if (!is_null($modifier))
        {
            $this->_get_where($modifier);
        }        
        
        $visitors = parent::fetch_all();

        return $visitors->num_rows();       
    }   

    // --------------------------------------------------------------------   
    
    public function get_top_pages($limit = 10)
    {
        $this->db->select('page, COUNT(ip_address) AS count');
        $this->db->limit($limit);
        $this->db->group_by('page');
        $this->db->order_by('count', 'DESC');
        
        return $this->db->get($this->_table_name);
    }

    // --------------------------------------------------------------------    
    
    private function _get_where($modifier)
    {
        $m = explode(' ', $modifier);        

        if ($m[0] == 'last')
        {        
            if (strtolower($m[1]) == strtolower(date('l')))
            {
                $modifier = 'today';
            }
            
            if ($m[1] == strtolower(date('l', strtotime('yesterday'))))
            {
                $modifier = 'yesterday';
            }
        }
        
        if ($modifier == 'this month')
        {
            $modifier = strtolower(date('F'));
        }

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

        if (in_array(ucwords($modifier), $month_array))
        {
            $curr_month = date('Y-m');
            $month = date('Y-m', strtotime($modifier));
            
            $year = date('Y');
            
            if (strtotime($month) > strtotime($curr_month))
            {
                $year = date('Y', strtotime('-1 year'));
            }
        }            

        switch ($modifier)
        {
            case 'yesterday':
                $this->db->where('date_time >', date('Y-m-d H:i:s', strtotime('yesterday')));
                $this->db->where('date_time <', date('Y-m-d H:i:s', strtotime('today')));                
                break;          
            case 'today':
                $this->db->where('date_time >', date('Y-m-d H:i:s', strtotime('today')));
                break;                
            case 'week':
                $this->db->where('date_time >', date('Y-m-d H:i:s', strtotime('-1 week')));
                break;      
            case 'last week':
                $this->db->where('date_time >', date('Y-m-d H:i:s', strtotime('-2 weeks')));
                $this->db->where('date_time <', date('Y-m-d H:i:s', strtotime('-1 week')));                                
                break;                            
            case '2 weeks ago':
                $this->db->where('date_time >', date('Y-m-d H:i:s', strtotime('-3 weeks')));
                $this->db->where('date_time <', date('Y-m-d H:i:s', strtotime('-2 weeks')));                
                break;             
            case '3 weeks ago':
                $this->db->where('date_time >', date('Y-m-d H:i:s', strtotime('-4 weeks')));
                $this->db->where('date_time <', date('Y-m-d H:i:s', strtotime('-3 weeks')));                
                break;
            case '4 weeks ago':
                $this->db->where('date_time >', date('Y-m-d H:i:s', strtotime('-5 weeks')));
                $this->db->where('date_time <', date('Y-m-d H:i:s', strtotime('-4 weeks')));                
                break;                                         
            case 'month':
                $this->db->where('date_time >', date('Y-m-d H:i:s', strtotime('-1 month')));
                break;
            case 'last monday':
                $this->db->where('date_time <', date('Y-m-d 00:00:00', strtotime('last tuesday')));
                $this->db->where('date_time >', date('Y-m-d 00:00:00', strtotime('last monday')));
                break;
            case 'last tuesday':
                $this->db->where('date_time <', date('Y-m-d 00:00:00', strtotime('last wednesday')));
                $this->db->where('date_time >', date('Y-m-d 00:00:00', strtotime('last tuesday')));
                break;
            case 'last wednesday':
                $this->db->where('date_time <', date('Y-m-d 00:00:00', strtotime('last thursday')));
                $this->db->where('date_time >', date('Y-m-d 00:00:00', strtotime('last wednesday')));
                break;
            case 'last thursday':
                $this->db->where('date_time <', date('Y-m-d 00:00:00', strtotime('last friday')));
                $this->db->where('date_time >', date('Y-m-d 00:00:00', strtotime('last thursday')));
                break;
            case 'last friday':
                $this->db->where('date_time <', date('Y-m-d 00:00:00', strtotime('last saturday')));
                $this->db->where('date_time >', date('Y-m-d 00:00:00', strtotime('last friday')));
                break;
            case 'last saturday':
                $this->db->where('date_time <', date('Y-m-d 00:00:00', strtotime('last sunday')));
                $this->db->where('date_time >', date('Y-m-d 00:00:00', strtotime('last saturday')));
                break;
            case 'last sunday':
                $this->db->where('date_time <', date('Y-m-d 00:00:00', strtotime('monday this week')));
                $this->db->where('date_time >', date('Y-m-d 00:00:00', strtotime('last sunday')));
                break;
            case 'january':
                $this->db->where('date_time >', $year . '-01-01 00:00:00');
                $this->db->where('date_time <', $year . '-02-01 00:00:00');           
                break;
            case 'february':
                $this->db->where('date_time >', $year . '-02-01 00:00:00');
                $this->db->where('date_time <', $year . '-03-01 00:00:00');           
                break; 
            case 'march':
                $this->db->where('date_time >', $year . '-03-01 00:00:00');
                $this->db->where('date_time <', $year . '-04-01 00:00:00');            
                break; 
            case 'april':
                $this->db->where('date_time >', $year . '-04-01 00:00:00');
                $this->db->where('date_time <', $year . '-05-01 00:00:00');         
                break; 
            case 'may':
                $this->db->where('date_time >', $year . '-05-01 00:00:00');
                $this->db->where('date_time <', $year . '-06-01 00:00:00');            
                break; 
            case 'june':
                $this->db->where('date_time >', $year . '-06-01 00:00:00');
                $this->db->where('date_time <', $year . '-07-01 00:00:00'); 
                break;
            case 'july':
                $this->db->where('date_time >', $year . '-07-01 00:00:00');
                $this->db->where('date_time <', $year . '-08-01 00:00:00');            
                break; 
            case 'august':
                $this->db->where('date_time >', $year . '-08-01 00:00:00');
                $this->db->where('date_time <', $year . '-09-01 00:00:00'); 
                break; 
            case 'september':
                $this->db->where('date_time >', $year . '-09-01 00:00:00');
                $this->db->where('date_time <', $year . '-10-01 00:00:00');        
                break; 
            case 'october':
                $this->db->where('date_time >', $year . '-10-01 00:00:00');
                $this->db->where('date_time <', $year . '-11-01 00:00:00');        
                break; 
            case 'november':
                $this->db->where('date_time >', $year . '-11-01 00:00:00');
                $this->db->where('date_time <', $year . '-12-01 00:00:00'); 
                break; 
            case 'december':
                $this->db->where('date_time >', $year . '-12-01 00:00:00');

                if ($year == '2010')
                {
                    $year = ' 2011';
                }

                $this->db->where('date_time <', $year . '-01-01 00:00:00'); 
                break;
            default:
                // Time of day.
                $offset = '-1 hour';
                
                $this->db->where('date_time <', date('Y-m-d H:i:s', strtotime($modifier)));
                $this->db->where('date_time >', date('Y-m-d H:i:s', strtotime($offset, strtotime($modifier))));
                break;                
        }
    }
    
    // --------------------------------------------------------------------    
}

/* End of file m_statistics.php */
/* Location: ./application/modules/statistics/models/m_statistics.php */
