<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
            <h1>Surveys Manager</h1>
            <?php $this->load->view('admin/surveys/tabs', array('list' => 'active'));?>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div>                        
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div id="message-div" class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <div>
        <?php if(isset($surveys)): ?>
        <form name='pageForm' method='post' action='<?php echo site_url('admin/surveys/action');?>'>
            <div>                    
            	<div class="left" style="margin-right: 10px;">
	            	<select name="selectAction" id="selectAction"  style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
	            		<option value=''>-Select Action-</option>
	            		<option value='delete_survey'>Delete</option>
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
                        <td>Title</td>
                        <td>Description</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($surveys as $row): ?>
                    <tr>  
                    	<td width="40"><input type='checkbox' value='<?php echo $row->survey_id;?>' name='data[]' id='checkboxes'  /></td>                      
                        <td><?php echo $row->survey_name; ?></td>
                        <td><?php echo $row->survey_description;?></td>
                        <td width="70">
                            <ul class="action-btns">
                            <!--<li class="link01">
                                <?php echo anchor('admin/seminars/view','<span class="hide">View</span>');?>
                            </li>-->
                            <li class="link01">
                                <a title="View results" href="<?php echo site_url('admin/surveys/results/' . $row->survey_id);?>"></a>
                            </li>
                            <?php if($this->session->userdata('super_admin')): ?>
                            <li class="link02">
                                <a title="Edit" href='<?php echo site_url('admin/surveys/edit_survey/' . $row->survey_id);?>'></a>
                            </li>
                            <li class="link03">
                                <a href="<?php echo site_url('admin/surveys/delete_survey/' . $row->survey_id);?>" title="Delete" class="delete"></a>
                            </li>
                            <?php endif;?>                            
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
            <p>No surveys found.</p>
            <?php endif; ?>
        </div>
   </div><!--end of content-text-->
</div><!--end of content-container-->