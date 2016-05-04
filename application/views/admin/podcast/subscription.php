<div class="content-container">
	<?php $this->load->view('admin/podcast/tabs'); ?>
	<div class="content-text">
		<p class="green bold"><?php if($saved): ?>Subscription text successfully saved<?php endif; ?></p>
		<form name="subscriptionForm" action="<?php echo base_url().index_page(); ?>admin/podcast/save_subscription" method="post" enctype="multipart/form-data" >
			<div>Podcast Subscribe Text</div>
			<div>
			<textarea name="subscription_text" id="subscription_text" ><?php echo set_value('subscription_text', $subscription_text); ?></textarea>
                <script type='text/javascript'>
                    var editor = CKEDITOR.replace( 'subscription_text' );
                    //CKEDITOR.config.skin = 'v2';
                    CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder' ) ;
                </script>
			</div>
			<table cellpadding="0" cellspacing="20" border="0" >
			  <tr>
				<td><input type='submit' value='Save' class="green-btn" /></td>
				<td><input type='button' class="green-btn"value='Cancel' onclick='window.location="<?php echo base_url(); ?>index.php/admin/podcast"' /></td>
			  </tr>
			</table>
		</form>
	</div><!--end of content-text-->
</div><!--end of content-container-->