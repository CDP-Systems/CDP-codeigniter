<script type='text/javascript'>
	function deleteContact(id){ 
		var ans = confirm("Delete this log?");
		if(ans){
			window.location = "<?php echo base_url(); ?>index.php/admin/ask-the-expert/delete/" + id;
		}
	}
</script>
<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title left">
			<h1>
				Ask The Expert Manager [View]
			</h1>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
    
    <div class="content-text">                    
    	<ul class="options">
            <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/ask-the-expert'>Back</a></li>
            <li class="options-delete-icon"><a class='hoverPointer' onclick='deleteContact(<?php echo $contact['id_ask_the_expert']; ?>)'>Delete</a></li>
        </ul>
        
        <div class="clear"></div>
    
		<?php if(count($contact)): ?>
        <table cellpadding="0" cellspacing="0" border="0" class="contact">
		 <tr>
            <td><b>Name:</b></b></td>
            <td><?php echo $contact['name']; ?></td>
        </tr>
        <tr>
            <td><b>Email:</b></td>
            <td><?php echo $contact['email']; ?></td>
        </tr>
		<tr>
            <td><b>Subject:</b></td>
            <td><?php echo $contact['subject']; ?></td>
        </tr>
		<tr valign="top">
            <td><b>Question:</b></td>
            <td><?php echo $contact['question']; ?></td>
        </tr>
        <tr>
            <td><b>Date</b></td>
            <td><?php echo date('M d, Y g:i:s A',strtotime($contact['date_sent'])); ?></td>
        </tr>
        </table>
        <?php else: ?>
        <p>log not found.</p>
        <?php endif; ?>
    </div><!--end of content-text-->
</div><!--end of content-container-->