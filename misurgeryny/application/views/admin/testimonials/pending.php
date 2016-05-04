<script type='text/javascript'>
    	function deleteTestimonial(id){
		var ans = confirm("Delete this testimonial?");
		if(ans){
			window.location = "<?php echo site_url('admin/testimonials/delete');?>/" + id;
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
            <h1>Testimonials Manager<!--[Pending]--></h1>
            <?php $this->load->view('admin/testimonials/tabs', array('pending' => 'active'));?>
		    <div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>            
        </div>		    
        <div class="clear"></div>
    </div>

	<div class="content-text">
        <div class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <div>
        <?php if(isset($testimonials)): ?>
            <form name='pageForm' method='post' action='<?php echo site_url('admin/testimonials/action');?>'>
                <input type='hidden' value='<?php echo $this->uri->segment(4); ?>' name='uri_4' />
                <div>
                    <div class="left" style="margin-right: 10px;">
                        <select name="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
                            <option value=''>Select Action</option>
                            <option value='delete'>Delete</option>
                            <option value='approve'>Approve</option>
                        </select>
                    </div>
                    <div class="green-btn left">
                        <a onclick='document.pageForm.submit();' class='hoverPointer' >Apply Action</a>
                    </div>
                </div>
           		<div class="clear"></div>
                <table cellpadding="10" cellspacing="0" border="0" class="list">
                <tr class="title">
                    <td width="40">
                     <div class="select-all-icon">
                    <a id='checkAll' onclick='check_all("hiddenCheckbox",document.pageForm.checkboxes)' class='hoverPointer' alt="Select All" title="Select All" ></a>
                    </div>                    
                    <input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
                    </td>
                    <td width="40">ID</td>
                    <td width="100">Sender</td>
                    <td width="300">Message</td>
                    <td>Before Photo</td>
                    <td>After Photo</td>
                    <td width="120">Date Posted</td>
                    <td width="60">Actions</th>
                </tr>
                 <?php $ctr = 0; ?>
                <?php foreach($testimonials as $row): ?>
                    <?php $ctr++; ?>
                    <tr class="<?php if($ctr % 2 == 0): ?>colored<?php endif; ?>">
                        <td width="40"><input type='checkbox' value='<?php echo $row->testi_id; ?>' name='testimonials[];' id='checkboxes'  /></td>
                        <td width="40"><?php echo $row->testi_id; ?></td>
                        <td width="100"><?php echo $row->first_name . ' ' . $row->last_name;?></td>
                        <td width="300"><?php echo $row->body; ?></td>
                        <td><?php if (isset($row->before_picture)):?><img width="74" height="96" src="<?php echo base_url() . 'uploads/testimonials/' . $row->before_picture;?>" /><?php endif;?></td>
                        <td><?php if (isset($row->after_picture)):?><img width="74" height="96" src="<?php echo base_url() . 'uploads/testimonials/' . $row->after_picture;?>" /><?php endif;?></td>
                        <!--<td>{class}</td>-->                       
                        <td width="120"><?php echo $row->date_posted; ?></td>
                        <td width="60">
                        <ul class="action-btns">
                          <li class="link05"><a title='Approve' class='hoverPointer' href='<?php echo site_url('admin/testimonials/approve/' . $row->testi_id);?>'></a></li>
                          <li class="link03"><a title='Delete' class='hoverPointer' onclick='deleteTestimonial(<?php echo $row->testi_id; ?>);'></a></li>                  
                        </ul>
                                
                            <!--a title="Approve" href='<?php echo site_url('admin/testimonials/approve/' . $row->testi_id);?>'>
                                <img src="<?php echo site_url('../images/admin/icon_approve.gif');?>" alt="Approve testimonial" title="Approve testimonial" />
                            </a-->
                            <!--a title="Delete"  onclick='deleteTestimonial(<?php echo $row->testi_id; ?>);'>
                                <img src="<?php echo site_url('../images/admin/icon_delete.gif');?>" alt="Delete testimonial" title="Delete testimonial" />
                            </a-->
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
            <p>No pending testimonials found.</p>
            <?php endif; ?>
            </div>
   </div><!--end of content-text-->
</div><!--end of content-container-->
