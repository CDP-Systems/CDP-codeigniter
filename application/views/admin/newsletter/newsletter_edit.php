<script type='text/javascript'>
	function removeFile(id){ 
		var ans = confirm("Remove file attachment?");
		if(ans){
			window.location = '<?php echo base_url(); ?>index.php/admin/newsletter/detach_file/' + id;
		}
	}
</script>
<div class="content-container">
    <div style="background:#d1dde0;">
    	<div class="title">
			<h1>
				Newsletter Manager 
			</h1>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div> 
        <div class="clear"></div>
    </div>
    <div class="content-text"> 
    	<ul>
            <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/newsletter'>Back</a></li>
        </ul>  
        <div class='msg'>
                <?php if(isset($_SESSION['attachFailed'])): ?>
                    <?php echo $_SESSION['attachFailed']; unset($_SESSION['attachFailed']); ?>
                <?php elseif(isset($_SESSION['detachFailed'])): ?>
                    <?php if($_SESSION['detachFailed']): ?>
                        <p class='red'>Failed to remove file.</p>
                    <?php else: ?>
                        <p class='green'>File removed.</p>
                    <?php endif; ?>
                    <?php unset($_SESSION['detachFailed']); ?>
                <?php endif; ?>
        </div>
        
        <?php if(count($newsletter)): ?>
            <form name="editNewsForm" action="<?php echo base_url().index_page(); ?>admin/newsletter/update" method="post" enctype="multipart/form-data" >
        
                <fieldset>	
                    <input type='hidden' name='id_newsletter' value='<?php echo $newsletter['id_newsletter']; ?>' />
                    <input type='hidden' name='attachment' value='<?php echo $newsletter['attachment']; ?>' />
                    <div>
                        <label>Title: </label>
						<?php echo form_error('title','<div class="red">','</div>'); ?>
                        <input type="text" name="title" class="long-text" value="<?php echo $newsletter['title']; ?>" />
                    </div>
        
                    <div>
                        <label>Body: </label>
						<?php echo form_error('body','<div class="red">','</div>'); ?>
                        <textarea name="body" style="width:400px; height:300px;" id='body'>
                            <?php echo $newsletter['body']; ?>
                        </textarea>
                        <script type='text/javascript'>
                            var editor = CKEDITOR.replace( 'body' );
                            CKFinder.setupCKEditor( editor , '<?php echo base_url(); ?>ckfinder/' ) ;
                        </script>
                    </div>
                    
                    
        
                    <div>
                        <?php if($newsletter['attachment']): ?>
                        <div>
                            File Attachment: <?php echo $newsletter['attachment']; ?>
                            <a href='<?php echo base_url(); ?>index.php/admin/newsletter/download/<?php echo $newsletter['id_newsletter']; ?>'>Download</a>
                            <a class='hoverPointer' onclick='removeFile(<?php echo $newsletter['id_newsletter']; ?>)' >Remove</a>
                        </div>
                        <label>Change file attachment</label>
                        <?php else: ?>
                        <label>Attach File</label>
                        <?php endif; ?>
                        <input type='file' name='attachment' />
                    </div>
                    
                    <div>
                        <label>&nbsp;</label>
                        <input type="submit" name="newsFormBtn" value="Save"  class="button"/>
                    </div>
        
                </fieldset>
        
            </form>   
        <?php else: ?>
            <p>Couldn't edit newsletter</p>
        <?php endif; ?>
       </div><!--end of content-text-->
</div><!--end of content-container-->