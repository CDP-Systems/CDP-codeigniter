<script type='text/javascript'>
	function deleteContact(id){
		var ans = confirm("Delete this contact?");
		if(ans){
			window.location = "<?php echo base_url(); ?>index.php/admin/contact_us/delete/" + id;
		}
	}
	function check_all(hiddenCheckbox, checkboxes){ 
		var hiddenCB = document.getElementById(hiddenCheckbox);
		if(!hiddenCB.value || hiddenCB.value == 0){
			hiddenCB.value = 1;
		}else{
			hiddenCB.value = 0;
		}

		if(checkboxes.length){
			if(hiddenCB.value == 1){
				for(var i=0; i!=checkboxes.length; i++){
					checkboxes[i].checked = true;
				}
			}
			else{
				for(var i=0; i!=checkboxes.length; i++){
					checkboxes[i].checked = false;
				}
			}
		}
		else{
			if(hiddenCB.value == 1) checkboxes.checked = true;
			else checkboxes.checked = false;
		}
	}
	function confirmAction(form,action){
		var ans;
		switch(action){
			case 'delete':
				ans = confirm("Are you sure?");
				break
		}
		if(ans){
			form.submit();
		}
	}
</script>

<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title">
			<h1>
				Contact Us Manager
			</h1>
			<?php $this->load->view('admin/contact_us/tabs'); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
    
    <div class="content-text"> 
		<div class='msg'>
			<?php if(isset($deleted)): ?>
			<p class='green bold'>Contact successfully deleted.</p>
			<?php elseif(isset($noSelected)): ?>
			<p class='red bold'>No contact(s) selected.</p>
			<?php elseif(isset($action)): ?>
				<?php if(isset($actionsSuccess)): ?>
					<p class='green bold'>{actionsSuccess} contact(s) successfully deleted.</p>
				<?php endif; ?>
				<?php if(isset($actionsFailed)): ?>
					<p class='red bold'>{actionsFailed} contact(s) failed to delete.</p>
				<?php endif; ?>
			<?php endif; ?>
        </div>
		
        <div>
        <?php if(count($contact_us_logs)): ?>
            <form name='contactsForm' method='post' action='<?php echo base_url().index_page(); ?>admin/contact_us/action'>
            <input type='hidden' value='<?php echo $this->uri->segment(4); ?>' name='uri_4' />
            <div>
           		                 
                <div class="left" >
                    <select id='selectAction' name="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
                        <option value=''>-Select Action-</option>
                        <option value='delete'>Delete</option>
                    </select>
                </div>
                
                <div class="green-btn left" style="margin-left: 10px;">
                	<a onclick='confirmAction(document.contactsForm,document.getElementById("selectAction").value)'  class='hoverPointer' >Apply Action</a>
                </div>
                
                <div class="green-btn left" style="margin-left: 10px;">
                <a href='<?php echo base_url().index_page(); ?>admin/contact_us/export' >Export </a>
                </div>
                
            </div>
        
        	<div class="clear"></div>
            <table cellpadding="10" cellspacing="0" border="0" class="list" width='100%'>
            <tr class="title">
                <td>
                   <div class="select-all-icon">
                      <a id='checkAll' onclick='check_all("hiddenCheckbox",document.contactsForm.checkboxes)' class='hoverPointer' alt="Select All" title="Select All"></a>
                   </div>
                 <input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
                </td>
                <!--<td>ID</td>-->
                <td>Name</td>
                <!--<td>Subject</td>-->
                <td>Email</td>
                <td>Message</td>
                <td>Date Sent</td>
                <td>Actions</td>
            </tr>
            <?php $ctr = 0; ?>
            <?php foreach($contact_us_logs as $row): ?>
            	<?php $ctr++; ?>
                <tr class="<?php if($ctr % 2 == 0): ?>colored<?php endif; ?>">
                    <td><input type='checkbox' value='<?php echo $row['id_contact_us']; ?>' name='contacts[];' id='checkboxes'  /></td>
                    <!--<td><?php echo $row['id_contact_us']; ?></td>-->
                    <td><?php echo $row['name']; ?></td>
                    <!--<td><?php echo $row['subject']; ?></td>-->
                    <td><?php echo $row['email']; ?></td>
					
                    <td><?php echo word_limiter($row['message'], 20); ?></td>
                    <td><?php echo $row['date_sent']; ?></td>
                    <td>
                    	<ul class="action-btns">
                        	<li class='link01'>
                            	<a title='View' href='<?php echo base_url(); ?>index.php/admin/contact_us/view/<?php echo $row['id_contact_us']; ?>'></a>
                            </li>
                            <li class='link03'>
                            	<a title='Delete' class='hoverPointer' onclick='deleteContact(<?php echo $row['id_contact_us']; ?>);'></a>
                            </li>
                        </ul><!--end of action-btns-->
                    </td>
                </tr>
            <?php endforeach; ?>
            </table>                           
            </form>
             <ul class="pagination right">
                <?php echo $this->pagination->create_links(); ?>
            </ul>   
            <div class="clear"></div>             
        <?php else: ?>
            <div style="height:250px;"><p>No contact us logs found.</p></div>
        <?php endif; ?>
        </div>
      </div><!--end of content-text-->
</div><!--end of content-container-->