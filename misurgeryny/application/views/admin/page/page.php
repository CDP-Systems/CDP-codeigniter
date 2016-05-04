<?php 
    $ci =& get_instance();
    $ci->load->library('CS_Url_Tree', null, 'breadcrumbs');
?>
<script type='text/javascript'>

	function deletePage(id){
		var ans = confirm("Delete this page?");
		if(ans){
			window.location = "<?php echo base_url(); ?>index.php/admin/page/delete/" + id;
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
	
	function confirmPageAction(form,action){
	
		if(action != ''){
			var ans;
			switch(action){
				case '1':
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
				Page Manager
				</h1>
				<?php $this->load->view('admin/page/tabs'); ?>
			   <div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div><!--end of title-->                
        <div class="clear"></div>
    </div>

	<div class="content-text"> 
        <div class='msg'>
            <?php if(isset($_SESSION['saved'])): unset($_SESSION['saved']); ?>
                <p class="green bold">Page successfully saved.<p>
        <?php elseif(isset($_SESSION['deleted'])):  unset($_SESSION['deleted']);?>
                <p class="green bold">Page successfully deleted.</p>
        <?php elseif(isset($_SESSION['actionsFailed']) && isset($_SESSION['action'])): ?>
                <?php 
                    switch($_SESSION['action']){
                        case 1: $action = 'show'; break;
                        case 2: $action = 'hide'; break;
                        case 3: $action = 'delete'; break;
                    }
                ?>
                <p class='red bold'><?php echo $_SESSION['actionsFailed'] ?> Page(s) failed to <?php echo $action; ?>.</p>
                <?php unset($_SESSION['actionsFailed']); ?>
                <?php unset($_SESSION['action']); ?>
        <?php elseif(isset($_SESSION['actionsSuccess']) && isset($_SESSION['action']) ): ?>
                <?php 
                    switch($_SESSION['action']){
                        case 1: $action = 'show'; break;
                        case 2: $action = 'hide'; break;
                        case 3: $action = 'deleted'; break;
                    }
                ?>
                <p class='green bold'><?php echo $_SESSION['actionsSuccess'] ?> Page(s) successfully <?php echo $action; ?></p>
                <?php unset($_SESSION['actionsSuccess']); ?>
                <?php unset($_SESSION['action']); ?>
        <?php elseif(isset($_SESSION['noSelected'])): unset($_SESSION['noSelected']); ?>
            <p class='red bold'>Please select page(s).</p>
        <?php endif; ?>
        </div>  
        <div>
        <?php if(count($pages)): ?>
            <div class="green-btn right" style="margin-right: 10px;">
                   <?php echo form_open('admin/page/post_to_uri');?>
                        Search: <input type="text" name="search" value = "" />
                        <input type="submit" value="Go" name="submit" />(search for title, class) 
                    <?php echo form_close();?>
            </div>
            <form name='pageForm' method='post' action='<?php echo base_url().index_page(); ?>admin/page/action'>
                <input type='hidden' value='<?php echo $this->uri->segment(4); ?>' name='uri_4' />
                <div>
                            
                    <div class="left" style="margin-right: 10px;">
                        <select name="selectAction" id="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
                            <option value=''>-Select Action-</option>
                           
                            <option value='1'>Delete</option>
                        </select>
                    </div>
                    

                    <div class="green-btn left">
	                        <a class='hoverPointer' onclick='confirmPageAction(document.pageForm,document.getElementById("selectAction").value)' >Apply Action</a>
	                </div>

                     <div class="green-btn left" style="padding-left: 5px;">  
                    <a href="<?php echo base_url().index_page(); ?>admin/page/view_all" ><span>View All</span></a>
                    </div>



                    
                </div>
           	<div class="clear"></div>
                <table cellpadding="10" cellspacing="0" border="0" class="list sortable" id="myTable">
                <thead>
                <tr class="title">
                    <td width="40">
                      <div class="select-all-icon">
<a id='checkAll' onclick='check_all("hiddenCheckbox",document.pageForm.checkboxes)' class='hoverPointer' alt="Select All" title="Select All" ></a></div>
                      <input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
                    </td>
                    <th width="300">Title</th>
                    <th width="80">Class</th>
                    <th width="80">Status</th>
                    <th width="120">Date Created</th>
                    <th width="120">Date Modified</th>
                    <td width="90">Actions</td>
                </tr>
                </thead>
                <?php $ctr = 0; ?>
                <?php foreach($pages as $row): ?>
                    <?php
                     	$ctr++;
                    	$ci->breadcrumbs->id_page = $row['id_page'];
                        ?>
                     
                    <tr class="<?php if($ctr % 2 == 0): ?>colored<?php endif; ?> ">
                        <td width="40"><input type='checkbox' value='<?php echo $row['id_page']; ?>' name='pages[];' id='checkboxes'  /></td>
                       
                        <td width="300">
                       		<div><?php echo $row['page_title']; ?></div>
                                <div>
                                <?php 
                                    if ($row['class'] == 'link')
                                    {
                                        echo $row['url_key'];   
                                    }
                                    else
                                    {
                                        echo $ci->breadcrumbs->get_link(); 
                                    }
                                    $ci->breadcrumbs->clear();
                                 ?>
                                </div>
                        </td>
                        <td><?php echo $row['class']; ?></td>
                        <td width="80"><?php echo $row['status'] = ($row['status']==='1')?'Enabled':'Disabled'; ?></td>
                        <td width="120"><?php echo $row['date_add']; ?></td>
                        <td width="120"><?php echo $row['date_upd']; ?></td>
                        <td width="66">

                        <?php if($this->session->userdata('super_admin')) { ?>
                            <ul class="action-btns">
                            <!--<li class="link01"><a href="<?php echo base_url() . index_page(); ?>admin/page/view/<?php echo $row['id_page']; ?>"><span class="hide">View</span></a></li>-->
                            <li class="link02">
                            <a title="Edit" href='<?php echo base_url().index_page(); ?>admin/page/edit/<?php echo $row['id_page']; ?>'></a>
                            </li>
                            <li class="link03">
                            <a title="Delete" onclick='deletePage(<?php echo $row['id_page']; ?>);'></a>
                            </li>

                            <li class="link04">
                                        <a title='Show' href='<?php echo base_url().index_page(); ?>admin/page/show/<?php echo $row['id_page']; ?>'><span class="hide">Show</span></a>
                            </li>

                            <li class="link05">
                                  <a title='Hide' href='<?php echo base_url().index_page(); ?>admin/page/hide/<?php echo $row['id_page']; ?>'><span class="hide">Hide</span></a>
                            </li>

                            </ul><!--end of action-btns-->

                       <?php } else {?> 

                            <ul class="action-btns">
                            <!--<li class="link01"><a href="<?php echo base_url() . index_page(); ?>admin/page/view/<?php echo $row['id_page']; ?>"><span class="hide">View</span></a></li>-->
                            <li class="link02">
                            <a title="Edit" href='<?php echo base_url().index_page(); ?>admin/page/edit/<?php echo $row['id_page']; ?>'></a>
                            </li>
                            
                            </ul><!--end of action-btns-->
                    
                      <?php }?>
                                   

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
            <p>No page found.</p>
            <?php endif; ?>
            </div>
   </div><!--end of content-text-->
</div><!--end of content-container-->
