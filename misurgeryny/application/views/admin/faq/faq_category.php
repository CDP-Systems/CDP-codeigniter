<script type='text/javascript'>
	function deleteCat(id){
		var ans = confirm("Delete this category?");
		if(ans){
			window.location = "<?php echo base_url(); ?>index.php/admin/faq/category_delete/" + id;
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
				FAQ Manager 
			</h1>
			<?php $this->load->view('admin/faq/tabs'); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
		</div> 
		<div class="clear"></div>
	</div>
	<div class="content-text">
		
		<div class='msg'>
			<?php if($saved): ?>
			<p class='green bold'>Category successfully saved.</p>
			<?php elseif($deleted): ?>
			<p class='green bold'>Category successfully deleted.</p>
			<?php elseif($no_selected): ?>
			<p class='red bold'>No category selected.</p>
			<?php elseif($actions_failed): ?>
				<p class='red bold'><?php echo $actions_failed ?> <?php if($actions_failed == 1): ?>category<?php else: ?>categories<?php endif; ?> successfully <?php echo $action ?>.</p>
			<?php elseif($actions_success): ?>
				<p class='green bold'><?php echo $actions_success ?> <?php if($actions_success == 1): ?>category<?php else: ?>categories<?php endif; ?> successfully <?php echo $action ?>.</p>
			<?php endif; ?>
		</div><!--end of msg-->
		
		
		<div>
		<?php if(count($categories)): ?>
			<form name='catForm' method='post' action='<?php echo base_url().index_page(); ?>admin/faq/category_action'>
				<input type='hidden' value='<?php echo $this->uri->segment(4); ?>' name='uri_4' />
				
				<div class="left" >
                    <select id='selectAction' name="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
                        <option value=''>-Select Action-</option>
                        <option value='delete'>Delete</option>
                    </select>
                </div>
				
				<div class="green-btn left" style="margin-left: 10px;">
                      <a onclick='confirmAction(document.catForm,document.getElementById("selectAction").value)' class='hoverPointer' >Apply Action</a>
                </div>
                
                <div class="green-btn-large left" style="margin-left: 10px;"><a href='<?php echo base_url().index_page(); ?>admin/faq/add_category' class='hoverPointer' >Add New Category</a></div>
				<div class="clear"></div>
				
				<table cellpadding="10" cellspacing="0" border="0" class="list">
				<tr class="title">
                    <td width="40">
                      <div class="select-all-icon"><a id='checkAll' onclick='check_all("hiddenCheckbox",document.catForm.checkboxes)' class='hoverPointer' alt="Select All" title="Select All" ></a></div>
                      <input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
                    </td>
                    <td width="300">Category Name</td>
                    <td width="200">Description</td>
                    <td width="120">Date Created</td>
                    <td width="120">Date Modified</td>
                    <td width="60">Actions</th>
                </tr>
				<?php $ctr = 0; ?>
				<?php foreach($categories as $row): ?>
					<?php $ctr++; ?>
					<tr>
						<td width="40"><input type='checkbox' value='<?php echo $row['id_faq_category']; ?>' name='categories[];' id='checkboxes'  /></td>
						<td width="40"><?php echo $row['title']; ?>&nbsp;</td>
                        <td width="300"><?php echo $row['desc']; ?>&nbsp;</td>
                        <td width="200"><?php echo $row['date_add']; ?>&nbsp;</td>
						<td width="200"><?php echo $row['date_upd']; ?>&nbsp;</td>
						<td width="60">
							<ul class="action-btns">
								<li class="link02">
									<a title="Edit" href='<?php echo base_url().index_page(); ?>admin/faq/edit_category/<?php echo $row['id_faq_category']; ?>'></a>
								</li>
								<li class="link03">
									<a title="Delete"  onclick='deleteCat(<?php echo $row['id_faq_category']; ?>);'></a>
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
		<p>No category found.</p>
		<?php endif; ?>
		</div>
	</div><!--end of content-text-->
	
</div><!--endof content-container-->