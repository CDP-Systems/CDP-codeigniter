<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?php echo site_url('js/surveys.js');?>"></script>

<style>
#content .border-white .content-container ul.tab { margin-top: 10px; }
#content .border-white .content-container .title { padding-bottom: 0; }
</style>

<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
        	<h1>Surveys Manager</h1>            
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
            <?php $this->load->view('admin/surveys/tabs', array('add_question' => 'active'));?>
            <div class="clear"></div>
        </div>                                    
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div id="message-div" class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <form action="" method="post" class="require-validation" name="edit-question-form">
            <fieldset>
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td width="200">Survey:</td>
                <td>
                    <?php echo form_dropdown('survey_id[]', survey_dropdown(), (isset($survey_id)) ? $survey_id : '', 'multiple');?>
                    <?php echo form_error('survey_id[]');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">Question:</td>
                <td>
                    <textarea name="question_details" rows="5" cols="40" class="required"><?php echo (isset($question_details)) ? $question_details : '';?></textarea>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">Type:</td>
                <td>
                    <?php echo form_dropdown('type_of_question_id', question_type_dropdown(), (isset($type_of_question_id)) ? $type_of_question_id : '', 'class="type-dropdown required number min(0)"');?>
                    <div class="type-block">                        
                        <?php if (isset($choices) && is_array($choices)):?>
                        <ol style="list-style-type: decimal;" id="radio-choices">
                            <?php foreach ($choices as $choice):?>
                            <li><input type="text" name="choices[]" class="required" value="<?php echo $choice;?>"/><a href="" class="remove-choice">Remove</a></li>
                            <?php endforeach;?>
                        </ol>
                        <a href="" class="add-choice">Add another choice</a>
                        <?php ; elseif (isset($range) && $range > 0):?>
                        Range : <input type="text" size="2" maxlength="2" class="range required number" name="range" value="<?php echo $range;?>"/>
                        <?php ;endif;?>
                    </div>
                </td>
              </tr>
              <tr>
                <td colspan="2"><input type='submit' name="submit" value='Save' style="margin-top:20px;" class="green-btn" /></td>
              </tr>
            </table>
            
            </fieldset>
            <?php
                if (isset($question_id))
                {
                    echo form_hidden('question_id', $question_id);
                }
            ?>
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->
