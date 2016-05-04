<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "news" table.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-28
 */
class M_news extends MY_Model {

    private $_table_name = 'news';
    private $_primary_key = 'news_id';

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    /**
     * Return the latest news posted.
     * 
     * @param int $limit How many records to retrieve.
     * @return obj
     */
    function fetch_latest_news($limit = 3)
    {
        $this->db->limit($limit);
        $this->db->order_by('date_posted DESC');

        return parent::fetch_all();
    }

    /**
     * Override so we can set date_posted.
     */
    function do_create($params)
    {
        $params['date_posted'] = date('Y-m-d');
        
        return parent::do_create($params);
    }

    /**
     * Fetch record by title.
     *
     * @param string $title News title.
     *     
     * @return mixed FALSE if no match found.
     */
    function get_by_title($title)
    {
        $this->db->where('title', $title);
        
        $news = $this->db->get($this->_table_name);

        if ($news->num_rows() > 0)
        {
            return $news->row();
        }
        else
        {
            return FALSE;
        }
    }
	
	function get_by_id($news_id){
	
		$this->db->where('news_id', $news_id);
        
        $news = $this->db->get($this->_table_name);

        if ($news->num_rows() > 0)
        {
            return $news->row();
        }
        else
        {
            return FALSE;
        }
	}
	
	
}

/* End of file m_event_category.php */
/* Location: ./application/models/default/m_event_category.php */
