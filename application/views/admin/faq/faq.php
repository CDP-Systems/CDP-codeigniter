<script type='text/javascript'>
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
				ans = confirm("Are you sure you want to delete this FAQ(s)?");
				break
		}
		if(ans){
			form.submit();
		}
	}
	function deleteFaq(id){
		var ans = confirm("Are you sure you want to delete this FAQ?");
		if(ans){
			window.location = "<?php echo base_url(); ?>index.php/admin/faq/delete/" + id;
		}
	}
</script>

<div class="content-container">
	<div style="background:#d1dde0;">
		<div class="title">
			<h1>FAQ Manager</h1>
			<?php $this->load->view('admin/faq/tabs'); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div> 
        <div class="clear"></div>
	</div>
	
	<div class="content-text"> 
		<div class='msg'>
		<p class="green bold">
			<?php if($saved): ?>
			FAQ successfully saved.
			<?php elseif($deleted): ?>
			FAQ successfully deleted.
			<?php elseif($no_selected): ?>
			No FAQ selected.
			<?php elseif($actions_failed): ?>
				<?php echo $actions_failed ?> FAQ successfully <?php echo $action ?>.
			<?php elseif($actions_success): ?>
				<?php echo $actions_success ?> FAQ successfully <?php echo $action ?>.
			<?php endif; ?>
		</p>
		</div><!--end of msg-->

		<div>
		<?php if(count($faq)): ?>
		<form name='faqForm' method='post' action='<?php echo base_url().index_page(); ?>admin/faq/action'>
			<input type='hidden' value='<?php echo $this->uri->segment(4); ?>' name='uri_4' />
			
			<div class="left" >
                <select id='selectAction' name="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
                    <option value=''>-Select Action-</option>
                    <option value='delete'>Delete</option>
                </select>
            </div>
			
			<div class="green-btn left" style="margin-left: 10px;">
                      <a onclick='confirmAction(document.faqForm,document.getElementById("selectAction").value)' class='hoverPointer' >Apply Action</a>
            </div>
			<div class="clear"></div>
			
			<table cellpadding="10" cellspacing="0" border="0" class="list">
				<tr class="title">
						<td>
							<div class="select-all-icon"><a id='checkAll' onclick='check_all("hiddenCheckbox",document.faqForm.checkboxes)' class='hoverPointer' alt="Select All" title="Select All" ></a></div>
							<input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
						</td>
						<td>Question</td>
						<td>Answer</td>
						<td>Category</td>
						<td width="120">Date Created</td>
						<td width="120">Date Modified</td>
						<td>Actions</td>
				</tr>
				<?php $ctr = 0; ?>
				<?php foreach($faq as $row): ?>
				<?php $ctr++; ?>
				<tr class="<?php if($ctr % 2 == 0): ?>colored<?php endif; ?>">
					<td width="40"><input type='checkbox' value='<?php echo $row['id_faq']; ?>' name='faq[];' id='checkboxes'  /></td>
					<td width="40"><?php echo $row['question']; ?></td>
                    <td width="300"><?php echo word_limiter($row['answer'],30); ?></td>
					<td width="300">
						<?php $category = $this->M_faq_category->get($row['id_faq_category']);  ?>
						<?php if(count($category))echo $category['title']; ?>
					</td>
                    <td width="200"><?php echo $row['date_add']; ?></td>
					<td width="200"><?php echo $row['date_upd']; ?></td>
					<td width="60">
						<ul class="action-btns">
							<li class="link02">
								<a title="Edit" href='<?php echo base_url().index_page(); ?>admin/faq/edit/<?php echo $row['id_faq']; ?>'></a>
							</li>
							<li class="link03">
								<a title="Delete" onclick='deleteFaq(<?php echo $row['id_faq']; ?>);'></a>
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
		</form>
		<?php else: ?>
			<div style="height:250px;"><p>No FAQ found.</p></div>
		<?php endif; ?>
		</div>
		
		
	</div><!--end of content-text-->
</div><!--end of content-container-->