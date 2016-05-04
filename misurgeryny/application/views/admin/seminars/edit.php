<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?php echo site_url('js/seminars.js');?>"></script>
<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
        	<h1>Seminar Manager</h1>
            <?php $this->load->view('admin/seminars/tabs', array('add' => 'active'));?>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div>                            
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <form action="" method="post">
            <fieldset>
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td width="200">Title:</td>
                <td>
                    <input type="text" name="title" value="<?php echo (isset($title) && $title != 'Seminars') ? $title : '';?>" size="70" />
                    <?php echo form_error('title');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td>Date of Seminar:</td>
                <td>
                    <input type="text" name="seminar_date" value="<?php echo (isset($seminar_date)) ? $seminar_date : '';?>" />
                    <?php echo form_error('seminar_date');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td>Time of Seminar:</td>
                <td>
                <span style="margin-right: 10px;">Start</span><?php echo form_dropdown('time', time_dropdown(), (isset($time)) ? $time : '');?>
                <span style="margin: 0 10px 0 20px;">End</span><?php echo form_dropdown('end_time', time_dropdown(),(isset($end_time)) ? $end_time : '');?>
                <?php echo form_error('time') != '' ? "<br/>". form_error('time') : '' ;?>
                <?php echo form_error('end_time') != '' ? "<br/>". form_error('end_time') : '' ;?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td>Location:</td>
                <td>
                    <input type="text" name="location" value="<?php echo (isset($location)) ? $location : '';?>" size="70" />
                    <?php echo form_error('location');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td>Maximum number of attendees:</td>
                <td><input type="text" name="max_num_attendees" size="10" value="<?php echo (isset($max_num_attendees)) ? $max_num_attendees : '0';?>" /><?php echo form_error('max_num_attendees');?></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td>Seminar is FULL:</td>
                <td><input type="checkbox" name="is_full" size="10" value="1" <?php echo (isset($is_full) && $is_full == true) ? 'checked=checked' : '';?> /><?php echo form_error('is_full');?></td>
              </tr>
              <tr>
                <td colspan="2"><input type='submit' name="submit" value='Save' style="margin-top:20px;" class="green-btn" /></td>
              </tr>
            </table>
            
            </fieldset>
            <?php
                if (isset($seminar_id))
                {
                    echo form_hidden('seminar_id', $seminar_id);
                }
            ?>
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->
