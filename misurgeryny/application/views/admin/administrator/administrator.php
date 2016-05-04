<script type='text/javascript'>
	function removeLogo(){
		var ans = confirm("Are you sure?");
		if(ans){
			window.location = '<?php echo base_url().index_page(); ?>admin/administrator/remove_logo';
		}
	}
</script>
<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title left">
        <h1>
        	Settings
        </h1>
        </div>                     
           <ul class="tab right">
           	   <li><a href="<?php echo base_url().index_page(); ?>admin/administrator" class="active"><span>Settings</span></a></li>
               <?php if($this->session->userdata('super_admin')): ?>        
               <li><a href="<?php echo base_url().index_page(); ?>admin/administrator/modules"><span>Modules</span></a></li>           	   
               <?php endif;?>
               <li><a href="<?php echo base_url().index_page(); ?>admin/administrator/password"><span>Change Password</span></a></li>
               <!--<li><a href="">Help</a></li>-->
           </ul>
        <div class="clear"></div>
    </div>
	<div class="content-text"> 
        <div>
            <?php //echo validation_errors(); ?>
        </div>
        <div>
            <?php if(isset($saved) && $saved):  ?>
                <p class="green bold">Admin settings saved.</p>
            <?php endif; ?>
        </div>
        <form enctype="multipart/form-data" action='<?php echo base_url().index_page(); ?>admin/administrator/save' method='post'>
        <input type='hidden' value='<?php echo $admin['id_admin']; ?>' name='id_admin' />
        <input type='hidden' value='<?php echo $website['site_logo']; ?>' name='site_logo' />
        <table cellpadding="8" cellspacing="1" width="100%">
          <tr bgcolor="#F1F1F1">
            <td width="200"><label>Site Name:</label></td>
            <td>
            <?php echo form_error('sitename', '<div class="red">','</div>'); ?>
					<input style='width: 400px;'  type='text' name='sitename' value='<?php if(isset($website['name']))echo $website['name']; ?>' />
            </td>
          </tr>
          <tr bgcolor="#F1F1F1">
            <td><label>Site Logo:</label></td>
            <td>
            <?php if($website['site_logo']): ?>
            <div><img title='Logo' src='<?php echo base_url(); ?>uploads/admin/<?php echo $website['site_logo']; ?>' /></div>
            <p>&nbsp;</p>
            <input onclick='removeLogo();' type='button' value='Remove the current logo' />
            
            <?php endif; ?>
            <div style='margin: 5px 0'>
		    <?php if(isset($logo_error)) echo $logo_error; ?>
	            <?php if($website['site_logo']): ?>Change Logo<?php endif; ?>
	            <input type='file' name='site_logo' /><br />
	            <div>Maximum file size: 2mb</div>
	            <div>Maximum dimensions: 350 x 90</div>
            </div>
            <!--?php if($website['site_logo']): ?><a class='hoverPointer' onclick='removeLogo();'>Remove</a--><!--?php endif; ?-->
            </td>
          </tr>
          <tr bgcolor="#F1F1F1">
            <td><label>Administrator&#39;s Name:</label></td>
            <td>
            <?php echo form_error('admin_name', '<div class="red">','</div>'); ?>
					<input style='width: 400px;'  type='text' name='admin_name' value='<?php if(isset($admin['name'])) echo $admin['name']; ?>' />
            </td>
          </tr>
          <tr bgcolor="#F1F1F1">
            <td><label>Administrator&#39;s Email:</label></td>
            <td>
            <?php echo form_error('admin_email', '<div class="red">','</div>'); ?>
					<input style='width: 400px;'  type='text' name='admin_email' value='<?php if(isset($admin['email'])) echo $admin['email']; ?>' />
            </td>
          </tr>
          <tr bgcolor="#F1F1F1">
            <td><label>Outgoing Email Sender Address:</label></td>
            <td>
            <?php echo form_error('admin_outgoing_email', '<div class="red">','</div>'); ?>
	<input style='width: 400px;'  type='text' name='admin_outgoing_email' value='<?php if(isset($admin_outgoing_email)) echo $admin_outgoing_email; ?>' />
            </td>
          </tr>
		  <?php if($this->session->userdata('super_admin')): ?> 
          <tr bgcolor="#F1F1F1">
            <td><label>Email Footer:</label></td>
            <td>
            <?php echo form_error('global_email_footer', '<div class="red">','</div>'); ?>
					<textarea style='width: 400px; height: 70px' id='global_email_footer' name='global_email_footer'><?php if (isset($email_footer)) echo $email_footer;?></textarea>
					<script type='text/javascript'>
							CKEDITOR.replace( 'global_email_footer' );
							CKEDITOR.config.toolbar = [    
									['Source'],
                                    ['TextColor','BGColor'],
                                    ['Format','Font'],
                                    ['Bold', 'Italic', 'Underline']
                                ];
                            CKEDITOR.config.resize_enabled = false;
                            CKEDITOR.config.width = 500;
							CKEDITOR.config.height = 100;
					</script>
			</td>
          </tr>
		  <?php endif; ?>
        </table>
        <p>&nbsp;</p>
		
		<?php if($this->session->userdata('super_admin')): ?> 
			<h2>Template</h2>
			<table cellpadding="8" cellspacing="1" width="100%">
			  <tr bgcolor="#F1F1F1">
				<td><label>Home Template:</label></td>
				<td><?php echo form_dropdown('home_template', template_dropdown(), $home_template); ?></td>
			  </tr >
			  <tr bgcolor="#F1F1F1">
				<td><label>Inner Template:</label></td>
				<td><?php echo form_dropdown('inner_template', template_dropdown(), $inner_template); ?></td>
			  </tr>
		  </table>	
		<?php endif; ?>
		
		<br />
		<?php if($this->session->userdata('super_admin')): ?>        
        <fieldset>
            <legend>Seminars</legend>
            <div>
                <label>Show Full</label>
                <?php echo form_dropdown('seminars_show_full', yes_no_dropdown(), ($seminars_show_full != '') ? $seminars_show_full : 0);?>
            </div>       
            <div>
                <label>Show Ended</label>
                <?php echo form_dropdown('seminars_show_ended', yes_no_dropdown(), ($seminars_show_ended != '') ? $seminars_show_ended : 0);?>
            </div>       
            <div>
                <label>Enable Captcha</label>
                <?php echo form_dropdown('seminars_enable_captcha', yes_no_dropdown(), ($seminars_enable_captcha != '') ? $seminars_enable_captcha : 0);?>
            </div>       
        </fieldset>

        <fieldset>
            <legend>Contact Us</legend>
            <div>
                <label>Enable Captcha</label>
                <?php echo form_dropdown('contact_us_enable_captcha', yes_no_dropdown(), ($contact_us_enable_captcha != '') ? $contact_us_enable_captcha : 0);?>
            </div>       
        </fieldset>
        
        <fieldset>
            <legend>Calendar</legend>
            <div>
                <label>Enable Recurring Events</label>
                <?php echo form_dropdown('calendar_enable_recurring_events', yes_no_dropdown(), ($calendar_enable_recurring_events != '') ? $calendar_enable_recurring_events : 0);?>
            </div>       
        </fieldset>   
        
        <fieldset>
            <legend>Appointments</legend>
            <div>
                <label>Enable Captcha</label>
                <?php echo form_dropdown('appointment_enable_captcha', yes_no_dropdown(), ($appointment_enable_captcha != '') ? $appointment_enable_captcha : 0);?>
            </div>       
        </fieldset> 
        
        <fieldset>
            <legend>Page Manager</legend>
            <div>
                <label>Enable Scratchpad</label>
                <?php echo form_dropdown('page_enable_scratchpad', yes_no_dropdown(), ($page_enable_scratchpad != '') ? $page_enable_scratchpad : 0);?>
            </div>       
        </fieldset>  
		<fieldset>
            <legend>Online Seminar</legend>      
            <div>
                <label>Enable Captcha</label>
                <?php echo form_dropdown('online_seminars_enable_captcha', yes_no_dropdown(), ($online_seminars_enable_captcha != '') ? $online_seminars_enable_captcha : 0);?>
            </div>       
        </fieldset>
         <fieldset>
            <legend>Testimonials</legend>
            <div>
                <label>Enable Captcha</label>
                <?php echo form_dropdown('testimonials_enable_captcha', yes_no_dropdown(), ($testimonials_enable_captcha != '') ? $testimonials_enable_captcha : 0);?>
            </div>       
        </fieldset> 		
        <?php endif;?>

        <table>            
            <tr>
                <td>
                <input type='submit' value='Save' class="green-btn" />
                </td>
            </tr>
        </table>
        </form>
     </div><!--end of content-text-->
</div><!--end of content-container-->