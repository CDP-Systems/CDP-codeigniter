<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?php echo site_url('js/seminars.js');?>"></script>
<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
        	<h1>Online Seminars Manager</h1>
        <?php $this->load->view('admin/online_seminars/tabs', array('add' => 'active'));?>
        <div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
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
                <td>Link:</td>
                <td>
                    <input type="text" name="link" value="<?php echo (isset($link)) ? $link : '';?>"  size="70"  />
                    <?php echo form_error('link');?>
                </td>
              </tr>
              
              <tr bgcolor="#F1F1F1">
                <td>Description:</td>
                <td>
					<?php 
						$data = array(
						  'name'        => 'description',
						  'value'       => (isset($description)) ? $description : '',
						  'rows'		=> '5',
						  'cols'	    => '30'
						 );
					?>
                    <?php echo form_textarea($data); ?>
					<?php echo form_error('description');?>
                </td>
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
