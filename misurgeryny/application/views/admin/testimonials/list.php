<script type='text/javascript'>
    	function deleteTestimonial(id){
		var ans = confirm("Are you sure you want to delete this testimonial?");
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
	
	function confirmAction(form,action){
	
		if(action != ''){
			var ans;
			switch(action){
				case 'delete':
					ans = confirm("Are you sure you want to delete this testimonial(s)?");
					break
				default:
					ans = confirm("Are you sure?");
					break
			}
			if(ans){
				form.submit();
			}
		}
	}
</script>

<style>
a.action-btn-2 img { margin-top: 10px; }
a.action-btn-2:hover img { opacity: 0.5; filter: alpha(opacity=50); }
</style>

<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title">
            <h1>Testimonials Manager</h1>
            <?php $this->load->view('admin/testimonials/tabs', array('list' => 'active'));?>
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
                        <select name="selectAction" id="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
                            <option value=''>Select Action</option>
                            <option value='delete'>Delete</option>
                            <option value='publish'>Publish</option>
                            <option value='unpublish'>Unpublish</option>
                        </select>
                    </div>
                    <div class="green-btn left">
                        <a onclick='confirmAction(document.pageForm,document.getElementById("selectAction").value)' class='hoverPointer' >Apply Action</a>
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
                    <!--<td width="40">ID</td>-->
                    <td width="100">Sender</td>
                    <td width="300">Message</td>
                    <td>Before Photo</td>
                    <td>After Photo</td>
                    <td width="120">Date Posted</td>
                    <td>Publish</td>
                    <td width="60">Actions</th>
                </tr>
                 <?php $ctr = 0; ?>
                <?php foreach($testimonials as $row): ?>
                    <?php $ctr++; ?>
                    <tr class="<?php if($ctr % 2 == 0): ?>colored<?php endif; ?>">
                        <td width="40"><input type='checkbox' value='<?php echo $row->testi_id; ?>' name='testimonials[];' id='checkboxes'  /></td>
                        <!--<td width="40"><?php echo $row->testi_id; ?></td>-->
                        <td width="100"><?php echo $row->first_name . ' ' . $row->last_name;?></td>
                        <td width="300"><?php echo $row->body; ?></td>
                        <td><?php if (isset($row->before_picture)):?><img width="74" height="96" src="<?php echo base_url() . 'uploads/testimonials/' . $row->before_picture;?>" /><?php endif;?></td>
                        <td><?php if (isset($row->after_picture)):?><img width="74" height="96" src="<?php echo base_url() . 'uploads/testimonials/' . $row->after_picture;?>" /><?php endif;?></td>
                        <!--<td>{class}</td>-->                       
                        <td width="120"><?php echo $row->date_posted; ?></td>
                        <td>
                            <?php if ($row->publish):?>
                                <a href="<?php echo site_url('admin/testimonials/unpublish/' . $row->testi_id);?>" class="action-btn-2">                                
                                    <img alt="Unpublish" src="<?php echo base_url();?>images/admin/icon-unpublish.png" title="Unpublish this testimonial"/>
                                </a>
                            <?php ; else:?>
                                <a href="<?php echo site_url('admin/testimonials/publish/' . $row->testi_id);?>" class="action-btn-2">
                                    <img alt="Publish" src="<?php echo base_url();?>images/admin/icon-publish.png" title="Publish this testimonial"/>
                                </a>
                            <?php endif;?>
                        </td>
                        <td width="60">
                            <ul class="action-btns">
                            <!--<li class="link01"><a href="#"><span class="hide">View</span></a></li>-->
                            <li class="link02">
                            <a title="Edit" href='<?php echo site_url('admin/testimonials/edit/' . $row->testi_id);?>'></a>
                            </li>
                            <li class="link03">
                            <a title="Delete"  onclick='deleteTestimonial(<?php echo $row->testi_id; ?>);'></a>
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
            <p>No records found.</p>
            <?php endif; ?>
            </div>
   </div><!--end of content-text-->
</div><!--end of content-container-->
