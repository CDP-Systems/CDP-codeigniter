<script type='text/javascript'>
	function deleteContact(id){ 
		var ans = confirm("Delete this contact?");
		if(ans){
			window.location = "<?php echo base_url(); ?>index.php/admin/contact_us/delete/" + id;
		}
	}
</script>
<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title left">
			<h1>
				Contact Us Manager
			</h1>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
    
    <div class="content-text">                    
    	<ul class="options">
            <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/contact_us'>Back</a></li>
            <li class="options-delete-icon"><a class='hoverPointer' onclick='deleteContact(<?php echo $contact['id_contact_us']; ?>)'>Delete</a></li>
        </ul>
        
        <div class="clear"></div>
    
		<?php if(count($contact)): ?>
        <table cellpadding="0" cellspacing="0" border="0" class="contact" width="100%">
		  <tr>
            <td width="260"><b>Name:</b></td>
            <td><?php echo $contact['name']; ?></td>
          </tr>
          <tr>
            <td><b>Phone Number:</b></td>
            <td><?php echo $contact['number']; ?></td>
          </tr>
          <tr>
            <td><b>Email:</b></td>
            <td><?php echo $contact['email']; ?></td>
          </tr>
          <tr>
            <td><b>Best time to contact this person:</b></td>
            <td><?php echo $contact['time_to_contact']; ?></td>
          </tr>
          <tr>
            <td><b>Date</b></td>
            <td><?php echo date('M d, Y g:i:s A',strtotime($contact['date_sent'])); ?></td>
          </tr>
          <tr valign="top">
            <td><b>Message:</b></td>
            <td><?php echo $contact['message']; ?></td>
          </tr>
        </table>
        <?php else: ?>
        <p>Contact not found.</p>
        <?php endif; ?>
    </div><!--end of content-text-->
</div><!--end of content-container-->