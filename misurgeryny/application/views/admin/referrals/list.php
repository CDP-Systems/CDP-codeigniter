<script type='text/javascript'>
    function del(id){
		var ans = confirm("Delete this?");
		if(ans){
			window.location = "<?php echo site_url('admin/referrals/delete');?>/" + id;
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
</script>

<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
        <h1>
        	Referrals Manager
        </h1>
        <?php $this->load->view('admin/referrals/tabs', array('list' => 'active'));?>
	<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <?php echo "<div class='green bold'>" . $this->session->flashdata('message') . "</div>";?>
        <br />
        <div>
                <div>
                   <div class="left" >
                        <?php echo form_open('admin/referrals/action', array('name' => 'pageForm'));?>
                        <select name="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
                            <option value=''>Select Action</option>
                            <option value='delete'>Delete</option>
                        </select>             
                    </div>
                    <div class="green-btn left" style="margin-right: 10px;">
                        <a onclick='document.pageForm.submit();' class='hoverPointer' >Apply Action</a>
                    </div>
                    <div class="green-btn left" style="margin-right: 10px;">
                        <?php echo anchor('admin/referrals/export', 'Export', array('class'=>'hoverPointer'));?>
                    </div>
                </div>
        <?php if(isset($referrals)): ?>
            <div class="clear"></div>
            <table cellpadding="10" cellspacing="0" border="0" class="list">
                <tr class="title">
                    <td width="40">
                        <div class="select-all-icon">
                            <a id='checkAll' onclick='check_all("hiddenCheckbox",document.pageForm.checkboxes)' class='hoverPointer' alt="Select All" title="Select All" ></a>
                        </div>
                        <input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
                    </td>            
                    <td>Sender</td>
                    <td>Sender's Email</td>
                    <td>Sender's Contact Details</td>
                    <td>Friend's Name</td>
                    <td>Friend's Email</td>
                    <td>Friend's Contact Details</td>
                    <td>Actions</td>
                </tr>
                 <?php $ctr = 0; ?>
                <?php foreach($referrals as $row): ?>
                    <?php $ctr++; ?>
                    <tr class="<?php if($ctr % 2 == 0): ?>colored<?php endif; ?>">      
                        <td width="40"><input type='checkbox' value='<?php echo $row->referral_id; ?>' name='referrals[];' id='checkboxes'  /></td>                  
                        <td><?php echo $row->patient_name; ?></td>
                        <td><?php echo $row->patient_email;?></td>
                        <td><?php echo $row->patient_address . "<br />" . $row->patient_phone;?></td>                           
                        <td><?php echo $row->referral_name;?></td>
                        <td><?php echo $row->referral_email;?></td>
                        <td><?php echo $row->referral_address . "<br />" . $row->referral_phone;?></td>                           
                        <td width="70">
                            <ul class="action-btns">
                            <li class="link01">
                                <?php echo anchor('admin/referrals/view/' . $row->referral_id,'<span class="hide">View</span>');?>
                            </li>
                            <li class="link03">
                                <a title="Delete"  onclick='del(<?php echo $row->referral_id; ?>);'></a>
                            </li>
                            </ul><!--end of action-btns-->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
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
