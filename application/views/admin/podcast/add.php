<div class="content-container">
	<?php $this->load->view('admin/podcast/tabs'); ?>
	<div class="content-text">
		<form name="addDownloadForm" action="<?php echo base_url().index_page(); ?>admin/podcast/save" method="post" enctype="multipart/form-data" >
			<table cellpadding="0" cellspacing="20" border="0" >
			<tr>
            	<td>Title</td>
                <td>
                <?php echo form_error('title','<div class="red">', '</div>'); ?>
				<input type='text' name='title'  value="<?php echo set_value('title'); ?>" />
                </td>
            </tr>
			<tr>
            	<td>Author</td>
                <td>
                <?php echo form_error('author','<div class="red">', '</div>'); ?>
				<input type='text' name='author'  value="<?php echo set_value('title'); ?>" />
                </td>
            </tr>
			<tr>
            	<td>Description</td>
                <td>
                <?php echo form_error('desc','<div class="red">', '</div>'); ?>
				<textarea type='text' name='desc' ><?php echo set_value('desc'); ?></textarea>
                </td>
            </tr>
			<tr>
            <td>File</td>
            <td>
            	<?php if(isset($file_error)) echo $file_error; ?>
            	<input type='file' name='mp3' />
            </td>
            </tr>
			<tr>
				<td><input type='submit' value='Save' class="green-btn" /></td>
				<td> <input type='button' class="green-btn"value='Cancel' onclick='window.location="<?php echo base_url().index_page(); ?>admin/podcast"' /></td>
			</tr>
			</table>
		</form>
	</div><!--end of content-text-->
</div><!--end of content-container-->