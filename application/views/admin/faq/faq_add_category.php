<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title left">
			<h1>
				FAQ Manager 
			</h1>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
	<div class="content-text">
		<ul class="options">
		  <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/faq/category'>Back</a></li>
		</ul>
		<div class="clear">&nbsp;</div>
		<form name="addFaqCatForm" action="<?php echo base_url().index_page(); ?>admin/faq/category_save" method="post" >
        <table cellpadding="8" cellspacing="1" width="100%">
          <tr bgcolor="#F1F1F1">
            <td width="120"><label>Title:</label></td>
            <td>
				<?php echo form_error('title','<div class="red">','</div>'); ?>
				<input type='text' name='title' value='<?php echo set_value('title'); ?>' style='width: 400px;' />
			</td>
          </tr>
          <tr bgcolor="#F1F1F1">
            <td width="120"><label>Description:</label></td>
            <td><textarea name='desc' style='width: 400px;'><?php echo set_value('desc'); ?></textarea></td>
          </tr>
        </table>
        
        <table cellpadding="0" cellspacing="20" border="0" >
          <tr>
            <td><input type='submit' value='Save' class="green-btn" /></td>
            <td> <input type='button' class="green-btn"value='Cancel' onclick='window.location="<?php echo base_url().index_page(); ?>admin/faq/category"' /></td>
          </tr>
        </table>
        </form>
	</div><!--end of content-text--> 
</div><!--end of content-container-->