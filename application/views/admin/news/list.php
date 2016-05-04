<script type='text/javascript'>
    	function del(id){
		var ans = confirm("Delete this?");
		if(ans){
			window.location = "<?php echo site_url('admin/news/delete');?>/" + id;
		}
	}
	
	function confirmAction(form,action){
	
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
        <h1>
        	News Manager
        </h1>
            <?php $this->load->view('admin/news/tabs', array('list' => 'active'));?>
           <div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>            
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <?php echo "<div class='green bold'>" . $this->session->flashdata('message') . "</div>";?>
        <div>
        <?php if(isset($news)): ?>
        <form name='pageForm' method='post' action='<?php echo site_url('admin/news/action');?>'>
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
            <table cellpadding="10" cellspacing="0" border="0" class="list" style="width: 100%">
                <tr class="title">    
                   <td width="40">
                          <div class="select-all-icon"><a id='checkAll' onclick='check_all("hiddenCheckbox",document.pageForm.checkboxes)' class='hoverPointer' alt="Select All" title="Select All" ></a></div>
                          <input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
                        </td>                
                    <td>Title</td>
                    <td>Introduction</td>
                    <td>Date</td>
                    <td>Actions</td>
                </tr>
                 <?php $ctr = 0; ?>
                <?php foreach($news as $row): ?>
                    <?php $ctr++; ?>
                    <tr class="<?php if($ctr % 2 == 0): ?>colored<?php endif; ?>">   
                        <td width="40"><input type='checkbox' value='<?php echo $row->news_id;?>' name='data[]' id='checkboxes'  /></td>                       
                        <td><?php echo $row->title; ?></td>
                        <td><?php echo $row->introduction;?></td>
                        <td><?php echo date('F j, Y', strtotime($row->date_posted));?></td>                        
                        <td width="70">
                            <ul class="action-btns">
                            <li class="link01">
                                <?php echo anchor('admin/news/view/' . $row->news_id,'<span class="hide">View</span>');?>
                            </li>
                            <li class="link02">
                                <a title="Edit" href='<?php echo site_url('admin/news/edit/' . $row->news_id);?>'></a>
                            </li>
                            <li class="link03">
                                <a title="Delete"  onclick='del(<?php echo $row->news_id; ?>);'></a>
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
