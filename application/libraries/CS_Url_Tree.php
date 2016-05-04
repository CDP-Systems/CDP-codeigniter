<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Handle creation of breadcrumbs for CS framework.
 *
 * @author Jose Consador
 * @version 0.1
 */
class CS_Url_Tree
{
    private $_ci;
    private $_params;    
    private $_links;
    private $_parents;
    private $_children;

    /**
     * Constructor.
     * 
     * @param array Page data.
     */
    public function __construct($params = null)
    {
        $this->_ci =& get_instance();   

        if (!isset($this->_ci->m_page) || !method_exists ($this->_ci->m_page ,'get_by_id'))
        {
            $this->_ci->load->model('default/m_page');
        }
    }

    public function __set($param, $value)
    {
        $this->_params[$param] = $value;
    }
    
    /**
     * Display breadcrumbs.
     */
    public function generate_crumbs()
    {
        // Display first link ("HOME").
        echo '<li>' . anchor('', 'Home') . ' /  </li>';

        if ($this->_has_parent($this->_params['id_page']))
        {              
            // Reverse the parent array so we start from the first parent.
            $p = array_reverse($this->_parents);

            // Display parent links.
            foreach($p as $key => $parent)
            {                
                $x   = 0;
                $url = '';
                   
                while ($x <= $key)
                {   
                    $url .= $p[$x]->url_key . '/';
                    $x++;
                } 
                
                if ($key < count($p) - 1)
                {   
                    // Links.
                    echo '<li>' . anchor ($url, $parent->page_title) . ' / </li>';                                                
                }
                else
                {
                    if ($this->_ci->get_current_module() == 'search')
                    {
                    	echo '<li>' . anchor ($url, $parent->page_title) . ' / </li>'; 
                    }
                    else
                    {
                    	echo '<li>' . $parent->page_title . '  </li>';
                    }
                }
            }
        }
        else
        {
             echo '<li>' . $this->_params['page_title'] . '</li>';
        }
        
        if ($this->_ci->get_current_module() == 'search')
        {
        	echo '<li>' . $this->_ci->view_data['search_key'] . '</li>';
        }
    }

    public function get_child_pages()
    {
        $p = $this->_ci->m_page->get($this->_params['url_key']);

        if ($p && $this->_has_children($p['id_page']))
        {
            return $this->_children->result();
        }
        else
        {
            return FALSE;
        }
    }

    /**
     *
     * Clears all members.
     *
     */
    public function clear()
    {
        $this->_params = array();
        $this->_links = array();
        $this->_parents = array();
        $this->_children = array();
    }
    
    /**
     * Returns the link for a single page.
     */
    public function get_link()
    {
    	$page = $this->_ci->m_page->get_by_id($this->_params['id_page']);
    
    	if ($page->class == 'link')
    	{
    		return $page->url_key;
    	}
    
        if ($this->_has_parent($this->_params['id_page']))
        {
            // Check if there is another parent aside from the home page.
            if (count($this->_parents) > 1)
            {
                $parents = array_reverse($this->_parents);
                $url = '';
                $parentArray = array();
                foreach ($parents as $row)
                {
                    array_push($parentArray, $row->url_key);
                } 
                $parentList = array_unique($parentArray);   
                foreach ($parentList as $parent)
                {
                    $url .= $parent . '/';
                }  
                      
                return ($url);
            }
            else
            {            	
                return ($this->_parents[0]->url_key);
            }
        }
    }

    private function _get_children($page_id)
    {
        $this->_ci->m_page->db->where('parent_id', $page_id);
        $this->_ci->m_page->db->order_by('order_by', 'ASC');
        
        $this->_children = $this->_ci->m_page->db->get($this->_ci->m_page->get_table_name());

        return ($this->_children->num_rows > 0);
    }

    private function _has_children($page_id)
    {
        return $this->_get_children($page_id);
    }

    /**
     *
     * Get parent of page.
     *
     * @param int $page_id
     *
     * @return 
     */
    private function _get_parent($page_id)
    {
        $obj = $this->_ci->m_page->get_by_id($page_id);

        if ($obj)
        {
            $this->_parents[] = $obj;

            $this->_has_parent($obj->parent_id);
            return TRUE;
        }

        return FALSE;
    }

    /**
     *
     * Check if page has a parent.
     *
     * @param int $page_id
     *
     * @return bool
     */
    private function _has_parent($page_id)
    {
        return $this->_get_parent($page_id);
    }

    
}