<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title">
			<h1>
				Mailing List Manager 
			</h1>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
    <div class="content-text"> 
    <ul>
		<li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/subscribers'>Back</a></li>
    </ul>
	<div>
		<?php //echo validation_errors(); ?>
	</div>
	<?php if(count($subscriber)): ?>
        <form  action="<?php echo base_url().index_page(); ?>admin/subscribers/update" method="post">
            <input type='hidden' name='id_subscriber' value='<?php echo $subscriber['id_subscriber']; ?>' />
            <table>
            <!--
            <tr><td>Hospital</td><td><input type='text' name='hospital' value="<?php echo $subscriber['hospital']; ?>" /></td></tr>
            <tr><td>Contact No.</td><td><input type='text' name='contact'  value="<?php echo $subscriber['contact']; ?>" /></td></tr>
            <tr><td>Website</td><td><input type='text' name='website'  value="<?php echo $subscriber['website']; ?>" /></td></tr>
            -->
            
            <tr><td>First Name</td><td><?php echo form_error('fname','<div class="red">','</div>'); ?><input type='text' name='fname'  value="<?php echo $subscriber['fname']; ?>" /></td></tr>
            <tr><td>Last Name</td><td><?php echo form_error('lname','<div class="red">','</div>'); ?><input type='text' name='lname'  value="<?php echo $subscriber['lname']; ?>" /></td></tr>
            <tr><td>Email</td><td><?php echo form_error('email','<div class="red">','</div>'); ?><input type='text' name='email'  value="<?php echo $subscriber['email']; ?>" /></td></tr>
            
            <!--
            <tr><td>Marketing Head</td><td><input type='text' name='marketing_head'  value="<?php echo $subscriber['marketing_head']; ?>" /></td></tr>
            <tr><td>Proper Designation</td><td><input type='text' name='proper_designation'  value="<?php echo $subscriber['proper_designation']; ?>" /></td></tr>
            <tr><td>Address</td><td><input type='text' name='address'  value="<?php echo $subscriber['address']; ?>" /></td></tr>
            <tr><td>Contact Person</td><td><input type='text' name='contact_person'  value="<?php echo $subscriber['contact_person']; ?>" /></td></tr>
            <tr><td>Remarks</td><td><textarea name='remarks' ><?php echo $subscriber['remarks']; ?></textarea></td></tr>
            -->
            <tr>
                <td>
                    <input type='submit' value='Save' class="green-btn" />
                </td>
            </tr>
            </table>
        </form>
    
    <?php else: ?>
        <p>Couldn't edit subscriber.</p>
    <?php endif; ?>
	</div><!--end of content-text-->
</div><!--end of content-container-->