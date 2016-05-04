<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
            <h1>Appointment Manager</h1>
            <?php $this->load->view('admin/appointment/tabs', array('list' => 'active'));?>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
         </div>
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <?php echo "<div class='green bold'>" . $this->session->flashdata('message') . "</div>";?>
        <div>
        <?php if(isset($appointments)): ?>
         <form name='pageForm' method='post' action='<?php echo site_url('admin/appointment/action');?>'>
        	<div>                    
	            	<div class="left" style="margin-right: 10px;">
	            	<select id="selectAction" name="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
	            		<option value=''>-Select Action-</option>
	            		<option value='delete'>Delete</option>
	            	</select>
	            	</div>            
	            	<div class="green-btn left">
	                        <a class='hoverPointer' onclick='confirmAction(document.pageForm,document.getElementById("selectAction").value)' >Apply Action</a>
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
                        <td>Patient Name</td>
                        <td>Email</td>
                        <td>Address</td>
                        <td>Phone</td>
                        <td>Date</td>
                        <td>Other Request</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($appointments as $row): ?>
                    <tr>
                    	<td width="40"><input type='checkbox' value='<?php echo $row->appointment_id;?>' name='data[]' id='checkboxes'  /></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->email;?></td>
                        <td><?php echo $row->address;?></td>                        
                        <td><?php echo $row->phone;?></td>
                        <td><?php echo date('F j, Y', strtotime($row->date_selected));?></td>                        
                        <td><?php echo $row->other;?></td>                                                                        
                        <td width="70">
                            <ul class="action-btns">
                            <li class="link01">
                                <?php echo anchor('admin/appointment/view/' . $row->appointment_id,'<span class="hide">View</span>');?>
                            </li>
                            <li class="link03">
                                <a href="<?php echo site_url('admin/appointment/delete') . '/' . $row->appointment_id;?>" title="Delete" class="delete"></a>
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