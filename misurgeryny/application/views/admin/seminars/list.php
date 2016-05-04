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
				ans = confirm("Are you sure you want to delete this Seminar(s)?");
				break
		}
		if(ans){
			form.submit();
		}
	}



    function deleteSeminar(id){
		var ans = confirm("Are you sure you want to delete this Seminar?");
		if(ans){
			window.location = "<?php echo site_url('admin/seminars/delete_seminar');?>/" + id;
		}
	}
	
   $(document).ready(function(){
		
		//by default old seminars are hidden
		$('table tr.old').hide();
		
		$('#seminar_toggle').change(function(){	
			var val = $(this).val();
			if(val == 'hide'){
				$('table tr.old').fadeOut();
			}else{
				$('table tr.old').fadeIn();
			}
			
		});
	
	});
</script>

<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
            <h1>Seminars Manager</h1>
            <?php $this->load->view('admin/seminars/tabs', array('list' => 'active'));?>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div>                        
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div class='green bold'><?php echo $this->session->flashdata('message');?></div>
        <div>
        <?php if(isset($seminars) && count($seminars)): ?>
		<form name='seminarsForm' method='post' action='<?php echo base_url().index_page(); ?>admin/seminars/action/seminars'>
				<input type='hidden' value='<?php echo $this->uri->segment(4); ?>' name='uri_4' />
				<!--Toolbar-->
				 <div class="left" >
                    
					<select id='selectAction' name="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
                        <option value=''>-Select Action-</option>
                        <option value='delete'>Delete</option>
                    </select>
					
                </div>
                <div class='right'>
			<select name='seminar_toggle' id='seminar_toggle'>
				<option value='hide'> Hide old seminar </option>
				<option value='show'> Show old seminar </option>
			</select>
		</div>
                
                <div class="green-btn left" style="margin-left: 10px;">
                	<a onclick='confirmAction(document.seminarsForm,document.getElementById("selectAction").value)'  class='hoverPointer' >Apply Action</a>
                </div>
				
				<div class="clear"></div>
				<table cellpadding="10" cellspacing="0" border="0" class="list" width='100%'>
					<tr class="title">     
						<td>
							   <div class="select-all-icon">
								  <a id='checkAll' onclick='check_all("hiddenCheckbox",document.seminarsForm.checkboxes)' class='hoverPointer' alt="Select All" title="Select All"></a>
							   </div>
							 <input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
							</td>
						<td>Seminar Date</td>
						<td>Time</td>
						<td>Title</td>
						<td>Location</td>
						<td>Actions</td>
					</tr>
					  <?php $ctr = 0; ?>
					<?php foreach($seminars as $row): ?>
						<?php $ctr++; ?>
						
						<?php 
						//mark the seminar row if it is an old seminar
						$old = '';
						if(strtotime($row->seminar_date) < time()){
							$old = 'old';
						}
						?>
						
						<tr class="<?php if($ctr % 2 == 0): ?>colored<?php endif; ?> <?php echo $old; ?>"> 
			                <td><input type='checkbox' value='<?php echo $row->seminar_id; ?>' name='seminars[];' id='checkboxes'  /></td>

							<td><?php echo $row->seminar_date; ?></td>
							<td><?php echo $row->time . ' - ' . $row->end_time;?></td>
							<td><?php echo $row->title; ?></td>
							<td><?php echo $row->location;?></td>
							<td width="70">
								<ul class="action-btns">
								<!--<li class="link01">
									<?php echo anchor('admin/seminars/view','<span class="hide">View</span>');?>
								</li>-->
								<li class="link02">
									<a title="Edit" href='<?php echo site_url('admin/seminars/edit/' . $row->seminar_id);?>'></a>
								</li>
								<li class="link03">
									<a title="Delete"  onclick='deleteSeminar(<?php echo $row->seminar_id; ?>);'></a>
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
