<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title">
			<h1>
				Ask The Expert Manager 
			</h1>
			<?php $this->load->view('admin/ask_the_expert/tabs'); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
    <div class="content-text"> 
		<div class='msg'>
			<?php echo '<p class="green bold">'.$this->session->flashdata('message'). '</p>'; ?>
		</div>
		
        <form action="<?php echo base_url().index_page(); ?>admin/ask-the-expert/settings_save" method="post">
        <table cellpadding="8" cellspacing="1" width="100%">
			<tr bgcolor="#F1F1F1">
				<td>
					<?php echo form_error('ask_the_expert_email_recipient', '<div class="red">','</div>'); ?>
					<b>Email Recipient</b>
					<input type='text' name='ask_the_expert_email_recipient' value='<?php echo $ask_the_expert_email_recipient; ?>' />
				</td>
			</tr>
		</table>
		<br />
		<fieldset>
		 <table cellpadding="8" cellspacing="1" width="100%">
			<tr bgcolor="#F1F1F1">
				<td>
					<legend style="margin-bottom: 20px;"><b>Ask The Expert Message [Confirmation]</b></legend>
					<?php echo form_error('ask_the_expert_email_confirmation_subject','<div class="red">','</div>'); ?>
					<strong>Subject </strong><input style="width: 300px" type='text' name='ask_the_expert_email_confirmation_subject' value='{ask_the_expert_email_confirmation_subject}' />
					<?php echo form_error('ask_the_expert_email_confirmation','<div class="red">','</div>'); ?>
					<textarea name="ask_the_expert_email_confirmation" id="message" >{ask_the_expert_email_confirmation}</textarea>
						<script type='text/javascript'>
							var editor = CKEDITOR.replace( 'message' );
							CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder' ) ;
						</script>
				</td>
			</tr>
		 </table>
        </fieldset>
        <br /><br />
        <fieldset>
		<table cellpadding="8" cellspacing="1" width="100%">
			<tr bgcolor="#F1F1F1">
				<td>
					<legend style="margin-bottom: 20px;"><b>Ask The Expert [Admin Notification]</b></legend>
					<?php echo form_error('ask_the_expert_admin_notificaion_subject','<div class="red">','</div>'); ?>
					<strong>Subject </strong> <input style="width: 300px" type='text' name='ask_the_expert_admin_notificaion_subject' value='{ask_the_expert_admin_notificaion_subject}' />
					<?php echo form_error('ask_the_expert_admin_notificaion','<div class="red">','</div>'); ?>
				   <textarea name="ask_the_expert_admin_notificaion" id="message_to_admin" ><?php echo $ask_the_expert_admin_notificaion; ?></textarea>
						<script type='text/javascript'>
							var editor = CKEDITOR.replace( 'message_to_admin' );
							CKFinder.setupCKEditor( editor, '<?php echo base_url(); ?>ckfinder' ) ;
						</script>
				</td>
			</tr>
		</table>
        </fieldset>
        <input type='submit' value='Save' class="green-btn" style="margin-top: 20px;" />
        </form>
	</div><!--end of content-text-->
</div><!--end of content-container-->
