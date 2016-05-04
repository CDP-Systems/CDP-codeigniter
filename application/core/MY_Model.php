<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *	@author		Jose Mari Consador
 *	@version	1.0.0
 *	@date		2011-03-10
 */

class MY_Model extends CI_Model
{
    // The name of the table the model represents.
    private $_table;
    // The primary key of the table.
    private $_primary;

    public function __construct()
    {
        parent::__construct();
        // Load the database library, we can either set it here or in autoload.php
        $this->load->database();
    }

    // --------------------------------------------------------------------

    // For php4 instantiation.
    function MY_Model()
    {
        self::__construct();
    }

    // --------------------------------------------------------------------

    /**
     * Get table name being used.
     *
     * @return string
     */
    public function get_table_name()
    {
        return $this->_table;
    }

    // --------------------------------------------------------------------

    /**
     * Set the table that will be used in most of the queries for the subclassed model.
     *
     * @param string $table_name
     */
    public function set_table_name($table_name)
    {
        $this->_table = $table_name;
    }

    // --------------------------------------------------------------------

    public function get_primary_key()
    {
        return $this->_primary;
    }

    // --------------------------------------------------------------------

    public function set_primary_key($primary_key)
    {
        $this->_primary = $primary_key;
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Handle saving or creating of new database entries.
    *  @param $params array Data to be stored.
    *  @return int
    */
    function do_save($params)
    {

        if (isset($params[$this->_primary]) && $this->get($params[$this->_primary]) != false)
        {
            return $this->do_update($params);
        }
        else
        {
            return $this->do_create($params);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Adds a new record.
     *
     * @param array $params
     * @return mixed
     */
    function do_create($params)
    {
        // $this->db->insert() creates a new record.
        if ($this->db->insert($this->_table, $params))
        {
            // Return the last inserted ID.
            return $this->db->insert_id();
        }
        else
        {
            return false;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Updates an existing record.
     *
     * @param array $params
     * @return int
     */
    function do_update($params)
    {
		
        //Build the query based on the primary key value.
        $this->db->where($this->_primary, $params[$this->_primary]);
        $this->db->update($this->_table, $params);
		
        return $params[$this->_primary];
    }

    // --------------------------------------------------------------------

    /**
     * Update multiple rows.
     *
     * @param <type> $ids
     * @param <type> $params
     * @return <type>
     */
    function bulk_update($ids, $params)
    {
        if (!is_array($ids))
        {
            $ids = array($ids);
        }

        $this->db->where_in($this->_primary, $ids);

        return $this->db->update($this->_table, $params);
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Fetch a table row by primary key.
    *  @param $key mixed Value of index.
    *  @return mixed
    */
    function get($key)
    {
        if (!is_array($key))
        {
            $key = array ($key);
        }
        
        $this->db->where_in($this->_table . '.' . $this->_primary, $key);

        $obj = $this->db->get($this->_table);

        if ($obj->num_rows > 0)
        {
            if ($obj->num_rows == 1)
            {// row() returns an object which holds data from a single row.                
               return $obj->row();
            }
            else
            {
                $obj = $obj->result();
                return $obj;
            }
        } 
        else
        {
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Fetch all rows.
    *  @return obj
    */
    function fetch_all($limit = null, $offset = null, $alias = FALSE)
    {
        $this->db->order_by($this->_primary . ' DESC');

        return $this->db->get($this->_table, $limit, $offset);
    }

    // --------------------------------------------------------------------

    /**
     * Search function.
     *
     * @param string $key The field name.
     * @param mixed $value Value
     * @param int $limit
     * @param int $offset
     */
    function search($key, $value, $limit = null, $offset = null)
    {

      if (!is_array($key))
        {
            $key = array ($key);
        }

        foreach ($key as $field)
        {
            $this->db->or_like($field, $value);
        }

        return self::fetch_all($limit, $offset);
        
    }

    // --------------------------------------------------------------------

    /**
     * Fulltext Search function. You MUST have an index specified and engine set to MyISAM.
     *
     * @param array $index The index name/s.
     * @param mixed $value Value
     * @param int $limit
     * @param int $offset
     * 
     * @return object
     */
    function fulltext_search($index, $key_value, $limit = null, $offset = null)
    {
        foreach ($index as $key => $value)
        {
            $this->db->or_where('MATCH (' . $value . ') AGAINST ("' . $key_value . '") > ', 0, FALSE);
        }

        return $this->db->get($this->_table, $limit, $offset);
    }

    // --------------------------------------------------------------------

    /**
                                 * Fulltext Search function. You MUST have an index specified and engine set to MyISAM.
                                 *
                                 * @param array $index The index name/s.
                                 * @param mixed $value Value
                                 * @param int $limit
                                 * @param int $offset
                                 *
                                 * @return object
                                 */
                                function fullpagetext_search($index, $key_value, $limit = null, $offset = null)
                                {
                                                $i = 0;
                                                foreach ($index as $key => $value)
                                                {
                                               
                                                                $i++;
                                                                if($i == 1){
                                                                                if(count($index) == $i){
                                                                                                $this->db->where('( MATCH (' . $value . ') AGAINST ("' . $key_value . '") > ', '0 )', FALSE);
                                                                                }else{
                                                                                                $this->db->where('( MATCH (' . $value . ') AGAINST ("' . $key_value . '") > ', '0', FALSE);
                                                                                }
                                                                }else{
                                                                                if(count($index) == $i){
                                                                                                $this->db->or_where(' MATCH (' . $value . ') AGAINST ("' . $key_value . '") > ', '0 )', FALSE);
                                                                                }else{
                                                                                                $this->db->or_where(' MATCH (' . $value . ') AGAINST ("' . $key_value . '") > ', '0', FALSE);
                                                                                }
                                                                }
                                                  
                                                }
                                               
                                                $this->db->where('status', '1 ');
 
                                                return $this->db->get($this->_table, $limit, $offset);
                                               
                                               
                                }
    // --------------------------------------------------------------------


    /**
     *
     * Delete a single of multiple records.
     * @param mixed $key Array of key values for multiple and int for single.
     * @return boolean
     */
    function delete($key)
    {
        if (!is_array($key))
        {
            $key = array($key);
        }

        $this->db->where_in($this->_table . '.' . $this->_primary, $key);
        return $this->db->delete($this->_table);
    }
}
