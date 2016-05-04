<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "testimonials" table.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-15
 */
class M_testimonial_categories extends MY_Model {

    private $_table_name = 'testimonials_category_list';
    private $_primary_key = 'cat_id';

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    function get_category_dropdown()
    {
        $cats = $this->fetch_all();

        foreach ($cats->result() as $cat)
        {
            $categories[$cat->value] = $cat->name;
        }

        return $categories;
    }
}

/* End of file m_testimonials.php */
/* Location: ./application/models/default/m_testimonial_categories.php */