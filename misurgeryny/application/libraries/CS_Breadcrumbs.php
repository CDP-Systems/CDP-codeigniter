<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Handle creation of breadcrumbs for CS framework.
 *
 * @author Jose Consador
 * @version 0.1
 */
class CS_Breadcrumbs
{
    private $_ci;
    private $_params;    
    private $_links;

    /**
     * Constructor.
     * 
     * @param array Page data.
     */
    public function __construct($params)
    {
        $this->_ci =& get_instance();     
        $this->_params = $params;
    }

    public function generate_crumbs()
    {
        // Display first link ("HOME").
        echo anchor('', 'Home');

        if ($this->_has_parent($this->_params['id_page']))
        {              
            // Reverse the parent array so we start from the first parent.
            $p = array_reverse($this->_parents);

            echo ' > ';

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
                    echo anchor ($url, $parent->page_title);                                                
                    echo ' > ';
                }
                else
                {
                    echo $parent->page_title;
                }
            }
        }
        else
        {
             echo ' > ' . $this->_params['page_title'];
        }
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
        
        if ($obj->parent_id > 0)
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
