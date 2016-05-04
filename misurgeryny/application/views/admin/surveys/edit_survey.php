<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?php echo site_url('js/surveys.js');?>"></script>

<style>
#content .border-white .content-container ul.tab { margin-top: 10px; }
</style>

<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
        	<h1>Surveys Manager</h1>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
            <div class="clear"></div>
            <?php $this->load->view('admin/surveys/tabs', array('add_survey' => 'active'));?>            
        </div>                        
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div id="message-div" class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <form action="" method="post" class="require-validation" name="edit-survey-form">
            <fieldset>
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td width="200">Title:</td>
                <td>
                    <input type="text" name="survey_name" class="required" value="<?php echo (isset($survey_name) && $survey_name != 'Seminars') ? $survey_name : '';?>" size="70" />
                    <?php echo form_error('survey_name');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td>Description:</td>
                <td>
                    <input type="text" name="survey_description" class="required" value="<?php echo (isset($survey_description)) ? $survey_description : '';?>" size="70"/>
                    <?php echo form_error('survey_description');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">Questions:</td>
                <td>
                    <?php echo form_dropdown('question_id[]', questions_dropdown(), (isset($question_id)) ? $question_id : '', 'multiple ');?>                    
                </td>  
              </tr>
              <tr>
                <td colspan="2"><input type='submit' name="submit" value='Save' style="margin-top:20px;" class="green-btn" /></td>
              </tr>
            </table>
            
            </fieldset>
            <?php
                if (isset($survey_id))
                {
                    echo form_hidden('survey_id', $survey_id);
                }
            ?>
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->
