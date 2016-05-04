<ul class="tab right">
    <li><?php echo anchor('admin/news/', '<span>List of News</span>', array('class' => isset($list) ? $list : ''));?></li>
    <li><?php echo anchor('admin/news/add', '<span>Add News</span>', array('class' => isset($add) ? $add : ''));?></li>
</ul>