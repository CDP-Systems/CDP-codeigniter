<style>
#content .border-white .content-container ul.tab { margin-top: 10px; }
#content .border-white .content-container .title { padding-bottom: 0; }
</style>

<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
            <h1>Self Assessment Manager</h1>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
            <?php $this->load->view('admin/self_assessment/tabs', array('questions' => 'active'));?>            
            <div class="clear"></div>
        </div>            
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div class="green bold"><?php echo $this->session->flashdata('message');?></div>
        <div>
            <form name='pageForm' method='post' action='<?php echo site_url('admin/self_assessment/action');?>'>
                <div>
                   <div class="left" style="margin-right: 10px;">
                        <select id='selectAction' name="selectAction" style="font-size: 11px; color:#77787a; height: 22px; padding-top: 3px;" >
                            <option value=''>Select Action</option>
                            <option value='delete_question'>Delete</option>
                        </select>
                    </div>
                    <div class="green-btn left">
                        <a class='hoverPointer' onclick='confirmAction(document.pageForm,document.getElementById("selectAction").value)' >Apply Action</a>
                    </div>
                </div>
        <?php if(isset($questions)): ?>
            <div class="clear"></div>
            <table cellpadding="10" cellspacing="0" border="0" class="list" width="100%">
                <thead>
                <tr class="title">     
                    <td width="40">
                      <div class="select-all-icon">
                        <a id='checkAll' onclick='check_all("hiddenCheckbox",document.pageForm.checkboxes)' class='hoverPointer' alt="Select All" title="Select All" ></a>
                      </div>
                      <input type='hidden' name='hiddenCheckbox' id='hiddenCheckbox'  />
                    </td>               
                    <td>Question</td>
                    <td>Type</td>
                    <td>Actions</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach($questions as $row): ?>
                    <tr>               
                        <td width="40"><input type='checkbox' value='<?php echo $row->question_id; ?>' name='data[]' id='checkboxes'  /></td>         
                        <td><?php echo html_entity_decode($row->question_details);?></td>
                        <td><?php echo $row->type_of_question_id;?></td>
                        <td width="70">
                            <ul class="action-btns">
                            <!--<li class="link01">
                                <?php echo anchor('admin/seminars/view','<span class="hide">View</span>');?>
                            </li>-->
                            <li class="link02">
                                <a title="Edit" href='<?php echo site_url('admin/self_assessment/edit_question/' . $row->question_id);?>'></a>
                            </li>
                            <li class="link03">
                                <a title="Delete" class="delete" href="<?php echo site_url('admin/self_assessment/delete_question/' . $row->question_id);?>"></a>
                            </li>
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
            <p>No questions found.</p>
            <?php endif; ?>
        </div>
   </div><!--end of content-text-->
</div><!--end of content-container-->