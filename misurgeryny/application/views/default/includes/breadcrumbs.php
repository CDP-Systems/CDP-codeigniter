<div>
   <ul id="breadcrumbs">
<?php
        $ci = & get_instance();
        $page = $ci->get_page();
        $ci->breadcrumbs->id_page = $page['id_page'];
        $ci->breadcrumbs->page_title = $page['page_title'];
        $ci->breadcrumbs->generate_crumbs();
?>
  </ul>
   <div class="clear"></div>
</div>
