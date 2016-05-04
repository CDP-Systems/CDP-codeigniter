<ul class="tab right">
    <li><?php echo anchor('admin/seminars/', '<span>Seminar List</span>', array('class' => isset($list) ? $list : ''));?></li>
    <li><?php echo anchor('admin/seminars/add', '<span>Add a Seminar</span>', array('class' => isset($add) ? $add : ''));?></li>
    <li><?php echo anchor('admin/seminars/logs', '<span>Seminar Logs</span>', array('class' => isset($logs) ? $logs : ''));?></li>
    <li><?php echo anchor('admin/seminars/email_settings', '<span>Email Settings</span>',  array('class' => isset($set_email) ? $set_email : ''));?></li>
</ul>
