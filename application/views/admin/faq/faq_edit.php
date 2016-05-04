<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title">
			<h1>
				FAQ Manager 
			</h1>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
    <div class="content-text">
		<ul class="options">
		  <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/faq'>Back</a></li>
		</ul>
		<div class="clear"></div>
		
		<form action="<?php echo base_url().index_page(); ?>admin/faq/update/<?php echo $faq['id_faq']; ?>" method="post" >
			<input type='hidden' name='id_faq' value='<?php echo $faq['id_faq']; ?>' />
			<p>
				<?php echo form_error('category','<div class="red">', '</div>'); ?>
				Category
				<?php if(count($categories)): ?>
					<select name='category'>
						<option value=''>-Select-</option>
						<?php foreach($categories as $row): ?>
							<?php if($faq['id_faq_category'] == $row['id_faq_category']) $selected = "selected='selected'";else $selected = ''; ?>
							<option value='<?php echo $row['id_faq_category']; ?>' <?php echo $selected; ?> >
								<?php echo $row['title']; ?>
							</option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>
			</p>
			<p>
				<?php echo form_error('question','<div class="red">', '</div>'); ?>
				Question <input type='text' name='question'  value="<?php echo $faq['question']; ?>" />
			</p>
			<p>
				<?php echo form_error('answer','<div class="red">', '</div>'); ?>
				Answer <br />
				<textarea name="answer" style="width:400px; height:300px;" id='answer' ><?php echo $faq['answer']; ?></textarea>
				 <script type='text/javascript'>
                        var editor = CKEDITOR.replace( 'answer' );
                        CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder/' ) ;
                 </script>
			</p>
			<table cellpadding="0" cellspacing="20" border="0" >
			  <tr>
				<td><input type='submit' value='Save' class="green-btn" /></td>
				<td> <input type='button' class="green-btn"value='Cancel' onclick='window.location="<?php echo base_url().index_page(); ?>admin/faq"' /></td>
			  </tr>
			</table>
		</form>
	</div><!--end of content-text-->
</div><!--end of content-container-->