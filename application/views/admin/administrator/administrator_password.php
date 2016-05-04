<div class="content-container" style="height: 320px">
	<div style="background:#d1dde0;">
        <div class="title left">
        <h1>
        	Settings [Change Password]
        </h1>
        </div>                     
           <ul class="tab right">
           	   <li><a href="<?php echo base_url().index_page(); ?>admin/administrator"><span>Settings</span></a></li>
               <?php if($this->session->userdata('super_admin')): ?>                   	   
               <li><a href="<?php echo base_url().index_page(); ?>admin/administrator/modules"><span>Modules</span></a></li>           	   
               <?php endif;?>
               <li><a href="<?php echo base_url().index_page(); ?>admin/administrator/password" class="active"><span>Change Password</span></a></li>
           </ul>
        <div class="clear"></div>
    </div>
    <div class="content-text"> 
        <div><?php echo validation_errors(); ?></div> 
        <div>
            <form action='<?php echo base_url().index_page(); ?>admin/administrator/change_password' method='post'>
                <input type='hidden' value='<?php echo $admin['id_admin']; ?>' name='id_admin' />
                <table cellpadding="0" cellspacing="20" border="0">
                <tr>
                    <td>Old Password</td>
                    <td><input type='password' name='old_password'  /></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td><input type='password' name='new_password' /></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='confirm_password' /></td>
                </tr>
                <tr>
                    <td><input type='submit' value='Save' class="green-btn" /></td>
                </tr>
                </table>
            </form>
        </div>
    </div><!--end of content-text-->
</div><!--end of content-container-->