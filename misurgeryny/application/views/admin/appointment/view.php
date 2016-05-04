<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
            <h1>Appointment Manager</h1>
            <?php $this->load->view('admin/appointment/tabs', array('list' => 'active'));?>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
        </div>                        
        <div class="clear"></div>
    </div>

    <div class="content-text">
    <ul class="options">
      <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/appointment'>Back</a></li>
    </ul>
    
        <div class="clear"></div>
        <table cellpadding="10" cellspacing="0" border="0" class="list" width="50%">
            <tr>
                <td>Patient Name</td>
                <td><?php echo $name;?></td>
            </tr>
            <tr>
                <td>Patient Email</td>
                <td><?php echo $email;?></td>
            </tr>
            <tr>
                <td>Patient Address</td>
                <td><?php echo $address;?></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><?php echo $phone;?></td>
            </tr>            
            <tr>
                <td>Other Request</td>
                <td><?php echo $other;?></td>
            </tr> 
            <!--<tr>
                <td>Best time to contact this person</td>
                <td><?php echo $other;?></td>
            </tr>   -->        
            <tr>
                <td>Date Filed</td>
                <td><?php echo date('F j, Y', strtotime($date_selected));?></td>
            </tr>
        </table>
    </div>
</div>
