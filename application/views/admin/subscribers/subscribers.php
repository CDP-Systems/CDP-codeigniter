<script type="text/javascript">
	function deleteSubscriber(id) {
		var ans = confirm('Delete this subscriber?');
		if(ans){
			window.location = '<?php echo base_url(); ?>index.php/admin/subscribers/delete/' + id;
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
			default:
				ans = true;
				break;
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
				Mailing List Manager
			</h1>
			<?php $this->load->view('admin/subscribers/tabs'); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>                     
        <div class="clear"></div>
    </div>
        <div class="content-text"> 
        <div class='msg'>
        <?php if(isset($_SESSION['saved'])): unset($_SESSION['saved']); ?>
                <p class="green bold">Subscriber successfully saved.<p>
        <?php elseif(isset($_SESSION['deleted'])):  unset($_SESSION['deleted']);?>
                <p class="green bold">Subscriber successfully deleted.</p>
        <?php elseif(isset($_SESSION['importFailed'])): ?>
                <?php if($_SESSION['importFailed']): ?>
                    <p><?php echo $_SESSION['importFailed']; ?> row(s) failed.</p>
                <?php else: ?>
                    <p class="green bold">Import success.</p>
                <?php endif; ?>
                <?php unset($_SESSION['importFailed']); ?>
        <?php elseif(isset($_SESSION['actionsFailed']) && isset($_SESSION['action'])): ?>
                <?php 
                    switch($_SESSION['action']){
                        case 1: $action = 'subscribe'; break;
                        case 2: $action = 'unsubscribe'; break;
                        case 3: $action = 'delete'; break;
                    }
                ?>
                <p class='red bold'><?php echo $_SESSION['actionsFailed'] ?> subscriber(s) failed to <?php echo $action; ?>.</p>
                <?php unset($_SESSION['actionsFailed']); ?>
                <?php unset($_SESSION['action']); ?>
        <?php elseif(isset($_SESSION['actionsSuccess']) && isset($_SESSION['action']) ): ?>
                <?php 
                    switch($_SESSION['action']){
                        case 1: $action = 'subscribed'; break;
                        case 2: $action = 'unsubscribed'; break;
                        case 3: $action = 'deleted'; break;
                    }
                ?>
                <p class='green bold'><?php echo $_SESSION['actionsSuccess'] ?> subscriber(s) successfully <?php echo $action; ?></p>
                <?php unset($_SESSION['actionsSuccess']); ?>
                <?php unset($_SESSION['action']); ?>
        <?php elseif(isset($_SESSION['noSelected'])): unset($_SESSION['noSelected']); ?>
            <p class='red bold'>Please select subscriber(s).</p>
        <?php endif; ?>
        </div>
        <div>
        <?php if(count($subscribers)): ?>
        <form name='subscriberForm' method='post' action='<?php echo base_url().index_page(); ?>admin/subscribers/action'>
            <input type='hidden' value='<?php echo $this->uri->segment(4); ?>' name='uri_4' />
            <div>                                    
                    <div class="left">
                    <select id='selectAction' name="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
                        <option value=''>-Select Action-</option>
                        <option value='subscribe'>Subscribe</option>
                        <option value='unsubscribe'>Unubscribe</option>
                        <option value='delete'>Delete</option>
                    </select>
                	</div>
                    
                    <div class="green-btn left" style="margin-left: 10px;">
                	<a onclick='confirmAction(document.subscriberForm,document.getElementById("selectAction").value)'  class='hoverPointer' >Apply Action</a>
                	</div>
                    
                    <div class="green-btn left" style="margin-left: 10px;">
                	 <a href='<?php echo base_url().index_page(); ?>admin/subscribers/export' >Export </a>
                	</div>
                    
                    <br class="clear" />
                    
            </div>
            <div class="clear"></div>
                <table cellpadding="10" cellspacing="0" border="0" class="list" width="100%">
                    <tr class="title">
                        <td width="40">
                            <div class="select-all-icon">
                               <a id='checkAll' onclick='check_all("hiddenCheckbox",document.subscriberForm.checkboxes)' class='hoverPointer' alt="Select All" title="Select All" ></a>            
                            </div>
                        <input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
                        </td>
                        <!-- td>Name</td-->
                        <td>Email</td>
                        <td width="100">Status</td>
                        <td width="100">Actions</td>
                    </tr>
                    
                    <?php $ctr = 0; ?>
                    <?php foreach($subscribers as $row): ?>
                    	<?php $ctr++; ?>
                        <tr class="<?php if($ctr % 2 == 0): ?>colored<?php endif; ?>">
                            <td width="40"><input type='checkbox' value='<?php echo $row['id_subscriber']; ?>' name='subscribers[];' id='checkboxes'  /></td>
                            <!-- td><?php echo $row['fname'] . " ". $row['lname']; ?></td-->
                            <td><?php echo $row['email']; ?></td>
                            <td width="100"><?php if($row['active'] == 1){ echo 'Active'; }else{ echo 'Inactive'; }; ?></td>
                            <td width="100">
                            	<ul class="action-btns">
                                    <li class="link02">
                                    <a title='Edit' href='<?php echo base_url().index_page(); ?>admin/subscribers/edit/<?php echo $row['id_subscriber']; ?>'><span class="hide">Edit</span></a>
                                    </li>
                                    <li class="link04">
                                    <?php if($row['active'] == 1): ?>
                                        <a title='Unsubscribe' href='<?php echo base_url().index_page(); ?>admin/subscribers/unsubscribe/<?php echo $row['id_subscriber']; ?>'><span class="hide">Unsubscribe</span></a>
                                    <?php else: ?>
                                        <a title='Subscribe' href='<?php echo base_url().index_page(); ?>admin/subscribers/subscribe/<?php echo $row['id_subscriber']; ?>'><span class="hide">Subscribe</span></a>
                                    <?php endif; ?>
                                    </li>
                                    <li class="link03">
                                    <a title='Delete' class='hoverPointer' onclick='deleteSubscriber(<?php echo $row['id_subscriber']; ?>);'><span class="hide">Delete</span></a>
                                    </li>
                                </ul>
                                
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
            <p>No subscriber found.</p>
        <?php endif; ?>
        </div>
        
     </div><!--end of content-text-->     
</div><!--end of content-container-->
