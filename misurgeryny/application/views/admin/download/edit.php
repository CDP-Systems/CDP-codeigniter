<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title left">
        <h1>
        	Download Manager <!-- &gt; Edit -->
        </h1>        	
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
    <div class="content-text">
    	<ul>
		  <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/download' >Back</a></li>
		</ul>
		<div class="clear"></div>
        
        <form  enctype="multipart/form-data" action="<?php echo base_url().index_page(); ?>admin/download/update/<?php echo $download['id_download']; ?>" method="post" >
        	<input type='hidden' name='id_download' value='<?php echo $download['id_download']; ?>' />
            <input type='hidden' name='current_file' value='<?php echo $download['file_name']; ?>' />
			<table cellpadding="0" cellspacing="20" border="0" >
            <tr>
            	<td>Title</td>
                <td>
                <?php echo form_error('title','<div class="red">', '</div>'); ?>
				<input type='text' name='title'  value="<?php echo $download['title']; ?>" />
                </td>
            </tr>
            <tr>
            	<td>Description</td>
                <td>
                <?php echo form_error('desc','<div class="red">', '</div>'); ?>
				<textarea type='text' name='desc' ><?php echo $download['desc']; ?></textarea>
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
								foreach($page_location as $page_location_item){
									if($row['id_page'] == $page_location_item['id_page']){ 
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
				<div>
				<?php if(isset($download['file_name']) && !empty($download['file_name'])): ?>
					<?php echo $download['file_name']; ?>
					<a href='<?php echo base_url().index_page(); ?>admin/download/download_file/<?php echo $download['id_download']; ?>'>Download</a>
				<?php endif; ?>
				</div>
            	<?php if(isset($file_error)) echo $file_error; ?>
            	<?php if(isset($download['file_name']) && !empty($download['file_name'])): ?>Upload new file<?php endif; ?>
				<input type='file' name='download_file' />
            </td>
            </tr>
			<tr>
				<td><input type='submit' value='Save' class="green-btn" /></td>
				<td> <input type='button' class="green-btn"value='Cancel' onclick='window.location="<?php echo base_url().index_page(); ?>admin/download"' /></td>
			  </tr>
			</table>
        </form>
    </div><!--content-text-->
</div><!--end of content-container-->