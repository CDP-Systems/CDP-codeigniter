<ul class="tab right">
    <li><?php echo anchor('admin/calendar/', '<span>Calendar Events</span>', array('class' => isset($list) ? $list : ''));?></li>   
    <li><?php echo anchor('admin/calendar/create', '<span>Add an Event</span>', array('class' => isset($add) ? $add : ''));?></li>    
    <?php if ($calendar_enable_color_coding):?>
    <li><?php echo anchor('admin/calendar/categories', '<span>Categories</span>', array('class' => isset($categories) ? $categories : ''));?></li>
    <li><?php echo anchor('admin/calendar/create_category', '<span>Add Category</span>',  array('class' => isset($category_add) ? $category_add : ''));?></li>
    <?php endif;?>
</ul>