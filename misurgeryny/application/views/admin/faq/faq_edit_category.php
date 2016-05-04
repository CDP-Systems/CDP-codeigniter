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
		<div class="clear"></div>

		<form action="<?php echo base_url().index_page(); ?>admin/faq/category_update/<?php echo $category['id_faq_category']; ?>" method="post" >
			<input type='hidden' name='id_faq_category' value='<?php echo $category['id_faq_category']; ?>' />

            <p>&nbsp;</p>
			<table cellpadding="0" cellspacing="8" border="0">
              <tr>
                <td width="100">Title</td>
                <td>
					<?php echo form_error('title','<div class="red">','</div>'); ?>
					<input type='text' name='title' value='<?php echo $category['title']; ?>' style="width: 600px;" />
				</td>
              </tr>
              <tr>
                <td valign="top">Description</td>
                <td><textarea name='desc' style="width: 600px;" rows="5"><?php echo $category['desc']; ?></textarea></td>
              </tr>
			  <tr>
				<td></td>
				<td>
                <input type='submit' value='Save' class="green-btn" style="float: left; margin-right: 10px;" />
                <input type='button' class="green-btn"value='Cancel' style="float: left;" onclick='window.location="<?php echo base_url().index_page(); ?>admin/faq/category"' />
                </td>
			  </tr>
			</table>
		</form>
	</div><!--end of content-text--> 
</div><!--end of content-container-->