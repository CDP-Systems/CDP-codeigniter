<script>
function deleteEvent(id){
	var ans = confirm("Are you sure?");
	if(ans){
		window.location = '<?php echo base_url().index_page(); ?>admin/calendar/delete/' + id;
	}
}

function confirmCalAction(form,action){

	if(action != ''){
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
}
</script>
<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
            <h1>Calendar Manager</h1>
            <?php $this->load->view('admin/calendar/tabs', array('list' => 'active'));?>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div>                        
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div id="message-div" class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <div>
        <?php if(isset($events)): ?>
        <form name='pageForm' method='post' action='<?php echo site_url('admin/calendar/action');?>'>
        	<div>                    
	            	<div class="left" style="margin-right: 10px;">
	            	<select id="selectAction" name="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
	            		<option value=''>-Select Action-</option>
	            		<option value='delete'>Delete</option>
	            	</select>
	            	</div>            
	            	<div class="green-btn left">
	                        <a class='hoverPointer' onclick='confirmCalAction(document.pageForm,document.getElementById("selectAction").value)' >Apply Action</a>
	                </div> 	            	
            </div>
            
            <div class="clear"></div>
            <table cellpadding="10" cellspacing="0" border="0" class="list" width="100%">
                <thead>
                    <tr class="title">
                    	<td width="40">
                          <div class="select-all-icon"><a id='checkAll' onclick='check_all("hiddenCheckbox",document.pageForm.checkboxes)' class='hoverPointer' alt="Select All" title="Select All" ></a></div>
                          <input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
                        </td>                
                        <td>Title</td>
                        <td>Details</td>
                        <td>Event Date</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($events as $row): ?>
                    <tr>   
                    	<td width="40"><input type='checkbox' value='<?php echo $row->id;?>' name='data[]' id='checkboxes'  /></td>                     
                        <td><?php echo $row->eventTitle; ?></td>
                        <td><?php echo html_entity_decode($row->eventContent);?></td>
                        <td><?php echo $row->eventDate;?></td>                        
                        <td width="70">
                            <ul class="action-btns">
                            <li class="link02">
                                <a title="Edit" href='<?php echo site_url('admin/calendar/edit/' . $row->id);?>'></a>
                            </li>
                            <li class="link03">
                                <a onclick='deleteEvent(<?php echo $row->id; ?>);' href='javascript:void(0)'  title="Delete" >&nbsp;</a>
                            </li>
                            </ul><!--end of action-btns-->
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </form>
            <ul class="pagination right">
                <?php echo $this->pagination->create_links(); ?>
            </ul>
            <div class="clear"></div>
            <?php else: ?>
            <p>No records found.</p>
            <?php endif; ?>
        </div>
   </div><!--end of content-text-->
</div><!--end of content-container-->