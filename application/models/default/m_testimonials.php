<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "testimonials" table.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-15
 */
class M_testimonials extends MY_Model {

    private $_table_name = 'testimonials';
    private $_primary_key = 'testi_id';

    public function  __construct() {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    /**
     * Fetch all testimonials that have been approved by admin.
     *
     * @return obj
     */
    public function fetch_all_approved($limit = null, $offset = null)
    {
        $this->db->where('status', 'approved');        
        $this->db->order_by('date_posted DESC');

        return parent::fetch_all($limit, $offset);
    }

    /**
     * Fetch all testimonials that have been approved by admin and set to be published.
     *
     * @return obj
     */
    public function fetch_all_published($limit = null, $offset = null, $category_id = null)
    {
        $ci =& get_instance();

        if ($ci->get_setting('testimonials_enable_category') == '1')
        {
            $this->db->join('testimonials_category_list', 'name = category');
            $this->db->where('cat_id', $category_id);
        }

        $this->db->where('status', 'approved');
        $this->db->where('publish', TRUE);

        $this->db->order_by('date_posted DESC');

        return parent::fetch_all($limit, $offset);
    }

    public function fetch_all_pending($limit = null, $offset = null)
    {
        $this->db->where('status', 'pending');
        $this->db->order_by('date_posted DESC');

        return parent::fetch_all($limit, $offset);
    }

    public function approve_testimonials($ids)
    {
        return $this->bulk_update($ids, array('status' => 2));
    }

    public function publish_testimonials($ids)
    {        
        return $this->bulk_update($ids, array('publish' => TRUE));
    }

    public function unpublish_testimonials($ids)
    {
        return $this->bulk_update($ids, array('publish' => FALSE));
    }
}

/* End of file m_testimonials.php */
/* Location: ./application/models/default/m_testimonials.php */