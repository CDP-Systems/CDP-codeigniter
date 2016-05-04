<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?php echo site_url('js/self_assessments.js');?>"></script>

<style>
#content .border-white .content-container ul.tab { margin-top: 10px; }
</style>

<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
        	<h1>Self Assessment Manager</h1>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
            <div class="clear"></div>
            <?php $this->load->view('admin/self_assessment/tabs', array('add_self_assessment' => 'active'));?>            
        </div>                        
        <div class="clear"></div>
    </div>
    <div class="content-text">
    <ul class="options">
            <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/self_assessment'>Back</a></li>
        </ul>
        <br/>
        <div id="message-div" class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <form action="" method="post" class="require-validation" name="edit-self_assessment-form">
            <fieldset>
            <table cellpadding="8" cellspacing="1" width="80%">
              <tr bgcolor="#F1F1F1">
                <td width="200">Title:</td>
                <td>
                    <input type="text" name="self_assessment_name" class="required" value="<?php echo (isset($self_assessment_name) && $self_assessment_name != 'Seminars') ? $self_assessment_name : '';?>" size="70" />
                    <?php echo form_error('self_assessment_name');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td>Description:</td>
                <td>
                    <input type="text" name="self_assessment_description" class="required" value="<?php echo (isset($self_assessment_description)) ? $self_assessment_description : '';?>" size="70"/>
                    <?php echo form_error('self_assessment_description');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">Questions:</td>
                <td>
                    <?php echo form_dropdown('question_id[]', questions2_dropdown(), (isset($question_id)) ? $question_id : '', 'multiple ');?>                    
                </td>  
              </tr>
              <tr>
                <td colspan="2"><input type='submit' name="submit" value='Save' style="margin-top:20px;" class="green-btn" /></td>
              </tr>
            </table>
            
            </fieldset>
            <?php
                if (isset($self_assessment_id))
                {
                    echo form_hidden('self_assessment_id', $self_assessment_id);
                }
            ?>
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->
