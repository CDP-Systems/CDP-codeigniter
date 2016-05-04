<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?php echo $js_dir. '/seminars.js';?>"></script>
<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
        	<h1>News Manager</h1>
        <?php $this->load->view('admin/news/tabs', array('add' => 'active'));?>
        <div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <?php echo "<div class='green bold'>" . $this->session->flashdata('message') . "</div>";?>
        <form action="" method="post">
            <fieldset>
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td width="120"><label>Title:</label></td>
                <td>
                <input type="text" name="title" value="<?php echo (isset($title) && $title != 'Seminars') ? $title : '';?>" style="width: 300px;" />
                <?php echo form_error('title');?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="120" valign="top"><label>Introduction:<?php echo form_error('introduction');?></label></td>
                <td><textarea name="introduction" style="width: 300px;"><?php echo (isset($introduction)) ? $introduction : '';?></textarea></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="120" valign="top"><label>Body:<?php echo form_error('body');?></label></td>
                <td>
                <textarea name="body"><?php echo (isset($body)) ? $body : '';?></textarea>
                <script type='text/javascript'>
					var editor = CKEDITOR.replace( 'body' );
					CKFinder.setupCKEditor( body, '<?php echo base_url(); ?>ckfinder/' ) ;
				</script>
                </td>
              </tr>
            </table>
            </fieldset>
            <input type='submit' name="submit" value='Save' class='green-btn' style="margin-top:20px;" />
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->
