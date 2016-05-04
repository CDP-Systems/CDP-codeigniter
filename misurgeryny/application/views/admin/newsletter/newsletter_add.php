<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title">
			<h1>
				Newsletter Manager
			</h1>
			<?php $this->load->view('admin/newsletter/tabs'); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
    <div class="content-text"> 
        <div class='msg'>
            <?php if(isset($_SESSION['attachFailed'])): ?>
                <?php echo $_SESSION['attachFailed']; unset($_SESSION['attachFailed']); ?>
            <?php endif; ?>
        </div>
        <form name="addNewsForm" action="<?php echo base_url().index_page(); ?>admin/newsletter/save" method="post" enctype="multipart/form-data" >
    
            <fieldset>	
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td width="120">Title:</td>
                <td>
					<?php echo form_error('title','<div class="red">','</div>'); ?>
					<input type="text" name="title" class="long-text" value="<?php echo set_value('title'); ?>" style="width: 320px;" />
				</td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td valign="top">Body:</td>
                <td>
				<?php echo form_error('body','<div class="red">','</div>'); ?>
                <textarea name="body" style="width:400px; height:300px; margin-top: 20px;" id='body'>
                        <?php echo set_value('body'); ?>
                </textarea>
                <script type='text/javascript'>
                    var editor = CKEDITOR.replace( 'body' );
                    CKFinder.setupCKEditor( editor , '<?php echo base_url(); ?>ckfinder/' ) ;
                </script>
                </td>
              </tr>
            </table>
            <p>&nbsp;</p>
            
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td width="120">Attach File:</td>
                <td><input type='file' name='attachment' /></td>
              </tr>
              <tr>
                <td colspan="2"><input type="submit" name="newsFormBtn" class="green-btn button" value="Save" /></td>
              </tr>
            </table>                
            </fieldset>
    
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->