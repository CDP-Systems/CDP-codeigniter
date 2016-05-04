<script type="text/javascript">
	function deleteNewsletter(id) {
		var ans = confirm('Delete this newsletter?');
		if(ans){
			window.location = '<?php echo base_url(); ?>index.php/admin/newsletter/delete/' + id;
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
				Newsletter Manager
			</h1>
			<?php $this->load->view('admin/newsletter/tabs'); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
    
    <div class="content-text">   
        <div class='msg'>
        <?php if(isset($_SESSION['saved'])):  ?>
            <?php if($_SESSION['saved']): ?>
                <p  class="green bold">Newsletter successfully saved.<p>
            <?php else: ?>	
                <p class="red bold">Newsletter not saved.</p>
            <?php endif; ?>
            <?php unset($_SESSION['saved']); ?>
        <?php elseif(isset($_SESSION['deleted'])):  unset($_SESSION['deleted']);?>
                <p class="green bold">Newsletter successfully deleted.</p>
        <?php elseif(isset($_SESSION['sendingFailed'])): ?>
            <?php if($_SESSION['sendingFailed']): ?>
                <p class="red bold"><?php echo $_SESSION['sendingFailed']; ?> message failed.</p>
            <?php else: ?>
                <p class="green bold">Message sent.</p>
            <?php endif; ?>
            <?php unset($_SESSION['sendingFailed']); ?>
        <?php elseif(isset($_SESSION['noSubscribers'])): unset($_SESSION['noSubscribers']); ?>
                <p class="red bold">No subscriber found.</p>
        <?php elseif(isset($noSelected)): ?>
            	<p class="red bold">No newsletter(s) selected.</p>
        <?php elseif(isset($action)): ?>
        		<?php if(isset($actionsSuccess)): ?>
                    <p  class="green bold">{actionsSuccess} newsletter(s) successfully deleted.</p>
                <?php endif; ?>
                <?php if(isset($actionsFailed)): ?>
                    <p class="red bold">{actionsFailed} newsletter(s) failed to delete.</p>
                <?php endif; ?>  
        <?php endif; ?>
        </div>
        
        <div>
        <?php if(count($newsletters)): ?>     
        <form name='newsletterForm' method='post' action='<?php echo base_url().index_page(); ?>admin/newsletter/action'>  
        		<input type='hidden' value='<?php echo $this->uri->segment(4); ?>' name='uri_4' /> 
        		<div>
                	                    
                    <div class="left" >
                        <select id='selectAction' name="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
                            <option value=''>-Select Action-</option>
                            <option value='delete'>Delete</option>
                        </select>
                    </div>
                    
                    <div class="green-btn left" style="margin-left: 10px;">
                        <a onclick='confirmAction(document.newsletterForm,document.getElementById("selectAction").value)'  class='hoverPointer' >Apply Action</a>
                    </div>
                </div>
           		<div class="clear"></div>    
            <table cellpadding="10" cellspacing="0" border="0" class="list" style="width: 100%">
                <tr class="title">
                	 <td>
                        <div class="select-all-icon">
                          <a class='hoverPointer left' id='checkAll' onclick='check_all("hiddenCheckbox",document.newsletterForm.checkboxes)' alt="Select All" title="Select All" ></a>                         
                        </div>
                       <input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
                     </td>
                    <!--<td>ID</td>-->
                    <td>Title</td>
                    <td>Date Added</td>
                    <td>Date Updated</td>
                    <td width="90">Actions</td>
                </tr>
                 <?php $ctr = 0; ?>
                <?php foreach($newsletters as $row): ?>
                	<?php $ctr++; ?>
                    <tr class="<?php if($ctr % 2 == 0): ?>colored<?php endif; ?>">
                    	<td><input type='checkbox' value='<?php echo $row['id_newsletter']; ?>' name='newsletters[];' id='checkboxes'  /></td>
                        <!--<td><?php echo $row['id_newsletter']; ?></td>-->
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo date('M d, Y g:i:s A',strtotime($row['date_add'])); ?></td>
                        <td><?php echo date('M d, Y g:i:s A',strtotime($row['date_upd'])); ?></td>
                        <td>
                        	<ul class="action-btns">
                            	<li class="link01">
                                <a title='View' href='<?php echo base_url().index_page(); ?>admin/newsletter/view/<?php echo $row['id_newsletter']; ?>'></a>
                                </li>
                                <li class="link02">
                                <a title='Edit' href='<?php echo base_url().index_page(); ?>admin/newsletter/edit/<?php echo $row['id_newsletter']; ?>'></a>
                                </li>
                                
                                <li class="link06">
                                <a title='Send' href='<?php echo base_url().index_page(); ?>admin/newsletter/send/<?php echo $row['id_newsletter']; ?>'></a>
                                </li>
                                
                                <li class="link03">
                                <a title='Delete' class='hoverPointer' onclick='deleteNewsletter(<?php echo $row['id_newsletter']; ?>);'></a>
                                </li>
                            </ul><!--end of action-btns-->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <ul class="pagination right">
            <?php echo $this->pagination->create_links(); ?>
            </ul>
            </form>
               <div class="clear"></div>
            
        <?php else: ?>
            <div style="height:250px;"><p>No newsletter found.</p></div>
        <?php endif; ?>
        </div>
    </div><!--end of content-text-->
</div><!--end of content-container-->