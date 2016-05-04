<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title">
			<h1>Mailing List Manager</h1>
			<?php $this->load->view('admin/subscribers/tabs'); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                   
        <div class="clear"></div>
    </div>
        <div class="content-text"> 
        <div class='msg'>
            <?php if(isset($saved) && $saved): ?>
                <p>Confirmation Email  successfully saved.</p>
            <?php endif; ?>
        </div>
        
        <form action="<?php echo base_url().index_page(); ?>admin/subscribers/saveEmail" method="post" >
                <p>
                    <b style="line-height:40px">Subscription Message</b> <br />
					<?php echo form_error('subscription_msg','<div class="red">','</div>'); ?>
                    <textarea name='subscription_msg'>{subscription_msg}</textarea>
                    <script type='text/javascript'>
                        var editor = CKEDITOR.replace( 'subscription_msg' );
                        CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder/' ) ;
                    </script>
                </p>
                <br />
                <p>
                    <b style="line-height:40px">Unsubscription Message</b><br />
					<?php echo form_error('unsubscription_msg','<div class="red">','</div>'); ?>
                    <textarea name='unsubscription_msg'>{unsubscription_msg}</textarea>
                    <script type='text/javascript'>
                        var editor = CKEDITOR.replace( 'unsubscription_msg' );
                        CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder/' ) ;
                    </script>
                </p>
        
            <input type='submit' class="green-btn" value='Save' style="margin-top:20px;" />
        </form>
	</div><!--end of content-text-->
</div><!--end of content-container-->
