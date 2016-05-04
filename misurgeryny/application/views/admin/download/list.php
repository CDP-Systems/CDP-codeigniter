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
				ans = confirm("Are you sure you want to delete this file(s)?");
				break
		}
		if(ans){
			form.submit();
		}
	}
	function deleteDownload(id){
		var ans = confirm("Are you sure you want to delete this file?");
		if(ans){
			window.location = "<?php echo base_url(); ?>index.php/admin/download/delete/" + id;
		}
	}
</script>
<div class="content-container">
	<div style="background:#d1dde0;">
        <div class="title">
			<h1>
				Download Manager  
			</h1>
			<?php $this->load->view('admin/download/tabs'); ?>
			<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>  
		<div class="clear"></div>  
	</div>
    <div class="content-text"> 
    	<div class='msg'>
        	<?php if($saved): ?>
			<p class='green bold'>Download successfully saved.</p>
			<?php elseif($deleted): ?>
			<p class='green bold'>Download successfully deleted.</p>
			<?php elseif($no_selected): ?>
			<p class='red bold'>No download selected.</p>
			<?php elseif($actions_failed): ?>
				<p class='red bold'><?php echo $actions_failed ?> download(s) successfully <?php echo $action ?>.</p>
			<?php elseif($actions_success): ?>
				<p class='green bold'><?php echo $actions_success ?> download(s) successfully <?php echo $action ?>.</p>
			<?php endif; ?>
        </div><!--end of msg-->
        
        <div>
        <?php if(count($downloads)): ?>
        	<form name='downloadForm' method='post' action='<?php echo base_url().index_page(); ?>admin/download/action'>
            	<input type='hidden' value='<?php echo $this->uri->segment(4); ?>' name='uri_4' />
                <div class="left" >
                <select id='selectAction' name="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
                    <option value=''>-Select Action-</option>
                    <option value='delete'>Delete</option>
                </select>
            	</div>
                
                <div class="green-btn left" style="margin-left: 10px;">
                      <a onclick='confirmAction(document.downloadForm,document.getElementById("selectAction").value)' class='hoverPointer' >Apply Action</a>
            	</div>
                <div class="clear"></div>
                
                <table cellpadding="10" cellspacing="0" border="0" class="list">
				<tr class="title">
						<td>
							<div class="select-all-icon"><a id='checkAll' onclick='check_all("hiddenCheckbox",document.downloadForm.checkboxes)' class='hoverPointer' alt="Select All" title="Select All" ></a></div>
							<input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
						</td>
						<td>Title</td>
						<td>Page Location</td>
						<td>Filename</td>
						<td width="120">Filesize (kilobytes)</td>
						<td width="120">Date Posted</td>
						<td>Actions</td>
				</tr>
                <?php $ctr = 0; ?>
				<?php foreach($downloads as $row): ?>
                	<?php $ctr++; ?>
                <tr class="<?php if($ctr % 2 == 0): ?>colored<?php endif; ?>">
					<td width="40"><input type='checkbox' value='<?php echo $row['id_download']; ?>' name='downloads[];' id='checkboxes'  /></td>
					<td width="40"><?php echo $row['title']; ?></td>
                    <td width="300">
                    <?php 
						$page_locations = $this->M_download_page_loc->getByDownloads($row['id_download']);
					?>
                    <ul>
                    <?php foreach($page_locations as $page_loc): ?>
                    	<?php $page = $this->M_page->get($page_loc['id_page']); ?>
				<li>
					<?php if(count($page))echo $page['page_title']; ?>
				</li>
			<?php endforeach; ?>
                    </ul>
                    </td>
					<td width="300"><?php echo $row['file_name']; ?></td>
                    <td width="200"><?php echo $row['file_size']; ?></td>
                   
					<td width="200"><?php echo str_replace(";", ";&nbsp;&nbsp;", $row['date_posted']); ?></td>
					<td width="60">
						<ul class="action-btns">
							<li class="link02">
								<a title="Edit" href='<?php echo base_url().index_page(); ?>admin/download/edit/<?php echo $row['id_download']; ?>'></a>
							</li>
							<li class="link03">
								<a title="Delete" class='hoverPointer' onclick='deleteDownload(<?php echo $row['id_download']; ?>);'></a>
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
        	<div style="height:250px;"><p>No download found.</p></div>
        <?php endif; ?>
        </div>
    </div><!--end of content-text-->
</div><!--end of content-container-->