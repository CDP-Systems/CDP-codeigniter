<ul class="tab right">
    <li><?php echo anchor('admin/surveys/', '<span>Surveys</span>', array('class' => isset($list) ? $list : ''));?></li>
    <li><?php echo anchor('admin/surveys/respondents', '<span>Survey Respondents</span>', array('class' => isset($respondents) ? $respondents : ''));?></li>
	<?php if($this->session->userdata('super_admin')): ?>
    <li><?php echo anchor('admin/surveys/add_survey', '<span>Add Survey</span>', array('class' => isset($add_survey) ? $add_survey : ''));?></li>
    <li><?php echo anchor('admin/surveys/questions', '<span>Questions</span>', array('class' => isset($questions) ? $questions : ''));?></li>
    <li><?php echo anchor('admin/surveys/add_question', '<span>Add Questions</span>',  array('class' => isset($add_question) ? $add_question : ''));?></li>
    <?php endif;?>
    <li><?php echo anchor('admin/surveys/email_settings', '<span>Email Settings</span>',  array('class' => isset($set_email) ? $set_email : ''));?></li>
</ul>