<ul class="tab right">
    <li><?php echo anchor('admin/self_assessment/', '<span>Self Assessment</span>', array('class' => isset($list) ? $list : ''));?></li>
    <li><?php echo anchor('admin/self_assessment/respondents', '<span>Patient Logs</span>', array('class' => isset($respondents) ? $respondents : ''));?></li>
	<?php if($this->session->userdata('super_admin')): ?>
    <li><?php echo anchor('admin/self_assessment/add_self_assessment', '<span>Add</span>', array('class' => isset($add_self_assessment) ? $add_self_assessment : ''));?></li>
    <li><?php echo anchor('admin/self_assessment/questions', '<span>Questions</span>', array('class' => isset($questions) ? $questions : ''));?></li>
    <li><?php echo anchor('admin/self_assessment/add_question', '<span>Add Questions</span>',  array('class' => isset($add_question) ? $add_question : ''));?></li>
    <?php endif;?>
    <li><?php echo anchor('admin/self_assessment/email_settings', '<span>Email Settings</span>',  array('class' => isset($set_email) ? $set_email : ''));?></li>
</ul>