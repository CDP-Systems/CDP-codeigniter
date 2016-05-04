<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
        	<h1>Videocast Manager</h1>
            <?php $this->load->view('admin/videocast/tabs', array('edit' => 'active'));?>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div>                                    
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div id="message-div" class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <form action="" method="post" class="require-validation" enctype="multipart/form-data">
            <fieldset>
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td width="200">File:</td>
                <td>
                    <input type="file" name="video" <?php if (!isset($orig_file_name)) echo 'class="required"';?>/>
                    <input type="hidden" name="field_video" value="video"/>
                    <?php if (isset($orig_file_name)):?>
                    <div><?php echo $orig_file_name;?></div>                    
                    <?php endif;?>
                    <div>* It accepts <?php echo $upload_config['allowed_types'];?>; Max size: <?php echo $upload_config['max_size'] / 1000;?>MB</div>
                    <?php echo form_error('field_video');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">Title:</td>
                <td>
                    <input type="text" name="infoTitle" class="required" value="<?php echo (isset($infoTitle)) ? $infoTitle : ''?>"/>
                    <?php echo form_error('infoTitle');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">Description:</td>
                <td>
                    <input type="text" name="infoDesc" class="required" value="<?php echo (isset($infoDesc)) ? $infoDesc : ''?>"/>
                    <?php echo form_error('infoDesc');?>                    
                </td>
              </tr>
              <tr>
                <td colspan="2"><input type='submit' name="submit" value='Save' style="margin-top:20px;" class="green-btn" /></td>
              </tr>
            </table>
            
            </fieldset>
            <?php
                if (isset($videocast_id))
                {
                    echo form_hidden('videocast_id', $videocast_id);
                }
            ?>
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->