<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title">
			<h1>
				FAQ Manager 
			</h1>
			<?php $this->load->view('admin/faq/tabs'); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
    <div class="content-text">
		
		<form name="addFaqForm" action="<?php echo base_url().index_page(); ?>admin/faq/save" method="post" >			
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td width="120">
                <label>Category:</label></td>
                <td>
				<?php echo form_error('category','<div class="red">', '</div>'); ?>
                <?php if(count($categories)): ?>
					<select name='category' style="width: 200px;">
						<option value=''>-Select-</option>
						<?php foreach($categories as $row): ?>
							<?php if(set_value('category') == $row['id_faq_category']) $selected = "selected='selected'";else $selected = ''; ?>
							<option value='<?php echo $row['id_faq_category']; ?>' <?php echo $selected; ?> >
								<?php echo $row['title']; ?>
							</option>
						<?php endforeach; ?>
					</select>
				<?php else: ?>
					No category found.<a href='<?php echo base_url().index_page(); ?>admin/faq/add_category'>Add category</a>
				<?php endif; ?>
                </td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td width="120">
                <label>Question:</label></td>
                <td>
					<?php echo form_error('question','<div class="red">', '</div>'); ?>
					<input type='text' name='question' style="width: 200px;" value="<?php echo set_value('question'); ?>" />
				</td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">
                
                <label>Answer:</label></td>
                <td>
				<?php echo form_error('answer','<div class="red">', '</div>'); ?>
                <textarea name="answer" style="width:400px; height:300px;" id='answer' ><?php echo set_value('answer'); ?></textarea>
				<script type='text/javascript'>
					var editor = CKEDITOR.replace( 'answer' );
					CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder/' ) ;
                </script>
                </td>
              </tr>
            </table>
            
			<table cellpadding="0" cellspacing="20" border="0" >
			  <tr>
				<td><input type='submit' value='Save' class="green-btn" /></td>
				<td> <input type='button' class="green-btn"value='Cancel' onclick='window.location="<?php echo base_url().index_page(); ?>admin/faq"' /></td>
			  </tr>
			</table>
		</form>
	</div><!--end of content-text-->
</div><!--end of content-container-->