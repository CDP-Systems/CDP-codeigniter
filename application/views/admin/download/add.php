<div class="content-container">

	<div style="background:#d1dde0;">
        <div class="title">
			<h1>
				Download Manager  
			</h1>
			<?php $this->load->view('admin/download/tabs'); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>  
		<div class="clear"></div>  
	</div>
    
    <div class="content-text">
    	<form name="addDownloadForm" action="<?php echo base_url().index_page(); ?>admin/download/save" method="post" enctype="multipart/form-data" >
        	<table cellpadding="0" cellspacing="20" border="0" >
            <tr>
            	<td>Title</td>
                <td>
                <?php echo form_error('title','<div class="red">', '</div>'); ?>
				<input type='text' name='title'  value="<?php echo set_value('title'); ?>" />
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
            	<td>Page Location</td>
                <td>
				<?php echo form_error('page_location','<div class="red">', '</div>'); ?>
				<?php if(count($pages)): ?>
					<select name='page_location[]' multiple size='10'>
						<?php foreach($pages as $row): ?>
                        	<?php
								$selected = '';
								foreach($page_location as $id_page){
									if($row['id_page'] == $id_page){ 
										$selected = "selected='selected'";
									}
								}
							?>
							<option value='<?php echo $row['id_page']; ?>' <?php echo $selected; ?> >
								<?php echo $row['page_title']; ?>
							</option>
						<?php endforeach; ?>
					</select>
				<?php else: ?>
					No page found.<a href='<?php echo base_url().index_page(); ?>admin/page/add'>Add page</a>
				<?php endif; ?>
                </td>
            </tr>
            <tr>
            <td>File</td>
            <td>
            	<?php if(isset($file_error)) echo $file_error; ?>
            	<input type='file' name='download_file' />
            </td>
            </tr>
			<tr>
				<td><input type='submit' value='Save' class="green-btn" /></td>
				<td> <input type='button' class="green-btn"value='Cancel' onclick='window.location="<?php echo base_url().index_page(); ?>admin/download"' /></td>
			  </tr>
			</table>
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->