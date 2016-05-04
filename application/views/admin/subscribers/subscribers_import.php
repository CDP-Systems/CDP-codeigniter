<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title">
			<h1>
				Mailing List Manager 
			</h1>
			<?php $this->load->view('admin/subscribers/tabs'); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
	<div class="content-text" style="height:250px;"> 
        <div class='msg'>
            <?php if(isset($_SESSION['importFailed'])): ?>
                <?php echo $_SESSION['importFailed']; unset($_SESSION['importFailed']); ?>
            <?php endif; ?>
        </div>
        <form action="<?php echo base_url().index_page(); ?>admin/subscribers/do_import" method="post" enctype="multipart/form-data" >
        <table cellpadding="8" cellspacing="1" width="100%">
          <tr bgcolor="#F1F1F1">
            <td width="120">Import a CSV file:</td>
            <td><input type='file' name='csvFile' /></td>
          </tr>
          <tr>
            <td colspan="2"><input type='submit' value='Import' class="green-btn" /></td>
          </tr>
        </table>      
        
        </form>
    </div><!--end of content-text-->
</div><!--end of content-container-->