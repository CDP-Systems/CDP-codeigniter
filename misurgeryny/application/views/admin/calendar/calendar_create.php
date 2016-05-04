<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
            <h1>Calendar Manager</h1>
            <?php $this->load->view('admin/calendar/tabs', array('add' => 'active'));?>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div>                        
        <div class="clear"></div>
    </div>
    <div class="content-text">
            <h1><?php echo $title; ?></h1>
            <?php
            if ($this->session->flashdata('message')){
                    echo "<div class='status_box green bold'>".$this->session->flashdata('message')."</div>";
            }

            ?>
            <p>&nbsp;</p>
            <form action="" method="POST" class="require-validation">
            <table cellpadding="8" cellspacing="1" width="100%">
              <tr bgcolor="#F1F1F1">
                <td width="120">Date:</td>
                <td><input id="date" name="eventDate" size="15" class="required" value="<?php echo isset($eventDate) ? $eventDate : '';?>" /><?php echo form_error('eventDate');?></td>
              </tr>
              <tr bgcolor="#F1F1F1">
                <td>Event Title:</td>
                <td><input id="eventTitle" name="eventTitle" class="required" value="<?php echo isset($eventTitle) ? $eventTitle : '';?>" style="width: 400px;" /><?php echo form_error('eventTitle');?></td>
              </tr>
              <?php if ($calendar_enable_color_coding):?>
              <tr bgcolor="#F1F1F1">
                <td>Category:</td>
                <td>
                <select name="category_id">
                    <option value="">--Choose a category--</option>
                    <?php                                            
                    foreach ($categories as $category):
                        if (isset($category_id) && $category->category_id == $category_id)
                        {
                            $checked = ' selected=selected';
                        }
                        else
                        {
                            $checked = '';
                        }
                        ?>
                    <option value="<?php echo $category->category_id;?>" <?php echo $checked;?>>
                        <?php echo $category->category_name;?>
                    </option>
                    <?php endforeach;?>
                </select>
                <?php echo form_error('category_id');?>
                </td>
              </tr>
              <?php endif;?>
              <tr bgcolor="#F1F1F1">
                <td>Event Details:</td>
                <td><textarea rows="5" name="eventContent" id="eventContent" class="required" style="width: 400px;"><?php echo isset($eventContent) ? $eventContent : '';?></textarea>
                    <?php echo form_error('eventContent');?>
					<script type='text/javascript'>
							CKEDITOR.replace( 'eventContent' );
							CKEDITOR.config.toolbar = [    
									['Source'],
                                    ['TextColor','BGColor'],
                                    ['Format','Font'],
                                    ['Bold', 'Italic', 'Underline']
                                ];
                            CKEDITOR.config.resize_enabled = false;
                            CKEDITOR.config.width = 500;
							CKEDITOR.config.height = 100;
					</script>
				</td>
              </tr>
              <tr>
                <td><input type="hidden" name="user_id" id="user_id" value="<?php // echo $user_id;?>" /></td>
                <td><input type="hidden" name="user" id="nick" value="<?php // echo $user;?>" /></td>
              </tr>
              <tr>
                <td colspan="2"><input type="submit" value="Add Event" name="add" class="green-btn" /></td>
              </tr>
            </table>

                    <?php form_close() ;?>

                    <?php
            //check if there is any alert message set
            if(isset($alert) && !empty($alert))
            {
                    //message alert
                    echo $alert;
            }
            ?>
    </div>
</div>
