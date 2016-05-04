<?php
$pending_text = 'Pending';
$ci =& get_instance();
if ($ci->pending_testimonials > 0)
{ 
    $pending_text .=  '(' . $ci->pending_testimonials . ')';
}
?>
<ul class="tab right">
    <li><?php echo anchor('admin/testimonials/', '<span>View Testimonials</span>', array('class' => isset($list) ? $list : ''));?></li>
    <li><?php echo anchor('admin/testimonials/pending', '<span>'. $pending_text .'</span>', array('class' => isset($pending) ? $pending : ''));?></li>
    <li><?php echo anchor('admin/testimonials/add', '<span>Add New</span>', array('class' => isset($add) ? $add : ''));?></li>
    <li><?php echo anchor('admin/testimonials/email_settings', '<span>Email Settings</span>',  array('class' => isset($set_email) ? $set_email : ''));?></li>
</ul>