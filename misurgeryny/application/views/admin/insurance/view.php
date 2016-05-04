<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
            <h1>Insurance Manager</h1>
            <?php $this->load->view('admin/insurance/tabs', array('list' => 'active'));?>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div>                        
        <div class="clear"></div>
    </div>

    <div class="content-text">
    <ul class="options">
      <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/insurance'>Back</a></li>
    </ul>
    
        <div class="clear"></div>
        <table cellpadding="10" cellspacing="0" border="0" class="list" width="50%">
            <tr>
                <td>Patient Name</td>
                <td><?php echo $patient_name;?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo $email;?></td>
            </tr>
            <tr>
                <td>Date of birth</td>
                <td><?php echo date('F j, Y', strtotime($date_of_birth));?></td>
            </tr>                        
            <tr>
                <td>Home Phone</td>
                <td><?php echo $home_phone;?></td>
            </tr>
            <tr>
                <td>Work Phone</td>
                <td><?php echo $work_phone;?></td>
            </tr>            
            <tr>
                <td>Cell Phone</td>
                <td><?php echo $cell_phone;?></td>
            </tr>            
            <tr>
                <td>Height</td>
                <td><?php echo $feet;?>&rsquo;<?php echo $inches;?>&rdquo;</td>
            </tr>            
            <tr>
                <td>Weight</td>
                <td><?php echo $weight;?> lbs</td>
            </tr>
            <?php if($have_insurance == 'Yes'):?>
            <tr>
                <td>Insurance</td>
                <td><?php echo $insurance;?></td>
            </tr>
            <tr>
                <td>Subscriber Name</td>
                <td><?php echo $subscriber_name;?></td>
            </tr>            
            <tr>
                <td>Subscriber ID</td>
                <td><?php echo $subscriber_id;?></td>
            </tr>            
	    <?php endif;?>        
            <tr>
                <td>Member Services Number</td>
                <td><?php echo $cell_phone;?></td>
            </tr>
            <tr>
                <td>Group Number</td>
                <td><?php echo $group_number;?></td>
            </tr>	            	    
            <tr>
                <td>Subscriber date of birth</td>
                <td><?php echo date('F j, Y', strtotime($subscriber_date_of_birth));?></td>
            </tr>                
            <tr>
                <td>Date Submitted</td>
                <td><?php echo date('F j, Y', strtotime($date_submitted));?></td>
            </tr>
        </table>
    </div>
</div>