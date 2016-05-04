<ul class="tab right">
    <li><?php echo anchor('admin/online_seminars/', '<span>Online Seminar</span>', array('class' => isset($add) ? $add : ''));?></li>
    <?php if(1==0): ?>
		<li><?php echo anchor('admin/online_seminars/add', '<span>Add Online Seminar</span>', array('class' => isset($add) ? $add : ''));?></li>
	<?php endif; ?>
    <li><?php echo anchor('admin/online_seminars/logs', '<span>Seminar Logs</span>', array('class' => isset($logs) ? $logs : ''));?></li>
    <li><?php echo anchor('admin/online_seminars/email_settings', '<span>Email Settings</span>',  array('class' => isset($set_email) ? $set_email : ''));?></li>
</ul>
