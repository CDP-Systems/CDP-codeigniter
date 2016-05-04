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
    <div class="content-text"> 
        <div>
            <?php //echo validation_errors(); ?>
        </div>
    
    <form action="<?php echo base_url().index_page(); ?>admin/subscribers/save" method="post">
    <table cellpadding="8" cellspacing="1" width="100%">
      <tr bgcolor="#F1F1F1">
        <td width="120">First Name:</td>
        <td><?php echo form_error('fname','<div class="red">','</div>'); ?><input type='text' name='fname' value="<?php echo set_value('fname'); ?>" style="width: 240px;" /></td>
      </tr>
      <tr bgcolor="#F1F1F1">
        <td>Last Name:</td>
        <td><?php echo form_error('lname','<div class="red">','</div>'); ?><input type='text' name='lname' value="<?php echo set_value('lname'); ?>" style="width: 240px;" /></td>
      </tr>
      <tr bgcolor="#F1F1F1">
        <td>Email Address:</td>
        <td><?php echo form_error('email','<div class="red">','</div>'); ?><input type='text' name='email' value="<?php echo set_value('email'); ?>" style="width: 240px;" /></td>
      </tr>
    </table>
    
    <table cellspacing="20">
      <tr>
        <td><input type='submit' class="green-btn" value='Save' /></td>
      </tr>
    </table>
   	</div><!--end of content-text-->
</div><!--end of content-container-->