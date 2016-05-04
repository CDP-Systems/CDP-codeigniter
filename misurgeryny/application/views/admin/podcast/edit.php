<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title left">
        <h1>
        	Podcast Manager &gt; Edit
        </h1>
        </div>                     
        <div class="clear"></div>
    </div>
	<div class="content-text">
		<ul>
		  <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/podcast' >Back</a></li>
		</ul>
		<div class="clear"></div>
		
		<form  enctype="multipart/form-data" action="<?php echo base_url().index_page(); ?>admin/podcast/update/<?php echo $podcast['id_podcast']; ?>" method="post" >
			<input type='hidden' name='id_podcast' value='<?php echo $podcast['id_podcast']; ?>' />
            <input type='hidden' name='current_mp3' value='<?php echo $podcast['file_name']; ?>' />
			<table cellpadding="0" cellspacing="20" border="0" >
            <tr>
            	<td>Title</td>
                <td>
                <?php echo form_error('title','<div class="red">', '</div>'); ?>
				<input type='text' name='title'  value="<?php echo $podcast['title']; ?>" />
                </td>
            </tr>
			<tr>
            	<td>Author</td>
                <td>
                <?php echo form_error('author','<div class="red">', '</div>'); ?>
				<input type='text' name='author'  value="<?php echo $podcast['author']; ?>" />
                </td>
            </tr>
            <tr>
            	<td>Description</td>
                <td>
                <?php echo form_error('desc','<div class="red">', '</div>'); ?>
				<textarea type='text' name='desc' ><?php echo $podcast['desc']; ?></textarea>
                </td>
            </tr>
            <tr>
            <td>File</td>
            <td>
				<div>
				<?php if(isset($podcast['file_name']) && !empty($podcast['file_name'])): ?>
					<?php echo $podcast['file_name']; ?>
					<a href='<?php echo base_url().index_page(); ?>admin/podcast/download_mp3/<?php echo $podcast['id_podcast']; ?>'>Download</a>
				<?php endif; ?>
				</div>
            	<?php if(isset($file_error)) echo $file_error; ?>
            	<?php if(isset($podcast['file_name']) && !empty($podcast['file_name'])): ?>Upload new file<?php endif; ?>
				<input type='file' name='mp3' />
            </td>
            </tr>
			<tr>
				<td><input type='submit' value='Save' class="green-btn" /></td>
				<td> <input type='button' class="green-btn"value='Cancel' onclick='window.location="<?php echo base_url().index_page(); ?>admin/download"' /></td>
			  </tr>
			</table>
		</form>
	</div><!--end of content-text-->
</div><!--end of container-->