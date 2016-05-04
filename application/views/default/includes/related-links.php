<?php 
    // This function sorts the array of related pages by the "order" set on the database.
    function sort_order($a, $b)
    {
        if ($a->order_by == $b->order_by)
        {
            return 0;
        }    
        
        return ($a->order_by > $b->order_by) ? +1 : -1;
    }
?>

<div id="related-list">
            <ul>
<?php
    $ci =& get_instance();
    $ci->load->library('CS_Url_Tree', null, 'tree');
    // Automated related page generation.
    if (isset($related_pages) && is_array($related_pages)):
        
        usort($related_pages, 'sort_order');    
        
        foreach ($related_pages as $r_page):
            $ci->tree->id_page = $r_page->id_page;
?>
    <li><?php echo anchor($ci->tree->get_link(), $r_page->page_title);?></li>
<?php 
            $ci->tree->clear();
        endforeach;
    endif;
?>
</ul>
</div>