<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title">
			<h1>
				SEO Manager
			</h1>
			<?php //$this->load->view('admin/seo/tabs'); ?>
			<?php $this->load->view('admin/seo/tabs', array('meta'=> 'active')); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
    <div class="content-text"> 
    	<div class='msg'>
            <?php if(isset($saved) && $saved):  ?>
                <p class="green bold">SEO settings saved.</p>
            <?php endif; ?>
        </div>
    	<form action='<?php echo base_url().index_page(); ?>admin/seo/save' method='post'>
        <table cellpadding="8" cellspacing="1" width="100%">
          <tr bgcolor="#F1F1F1">
            <td width="160">Global Meta Keywords:</td>
            <td>
            <?php echo form_error('default_metakeywords', '<div class="red">','</div>'); ?>
			<input style='width: 400px;' type='text' name='default_metakeywords' value='<?php if(isset($website['default_metakeywords']))echo $website['default_metakeywords']; ?>' />
            </td>               
          </tr>
          <tr bgcolor="#F1F1F1">
            <td valign="top">Global Meta Description:</td>
            <td>
            <?php echo form_error('default_metadesc', '<div class="red">','</div>'); ?>
			<textarea style='width: 400px; height: 70px' name='default_metadesc' ><?php if(isset($website['default_metadesc']))echo $website['default_metadesc']; ?></textarea>
            </td>               
          </tr>
          <tr bgcolor="#F1F1F1">
            <td>Meta Robots:</td>
            <td>
            <?php echo form_error('meta_robots', '<div class="red">','</div>'); ?>
			<input type='text' name='meta_robots' value='<?php if(isset($website['meta_robots']))echo $website['meta_robots']; ?>'  />
            </td>               
          </tr>
          <tr>
            <td colspan="2"><input type='submit' value='Save' class="green-btn" /></td>               
          </tr>
        </table>
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->
