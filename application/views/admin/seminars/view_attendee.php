<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type='text/javascript'>
    	function deleteAttendee(id){
		var ans = confirm("Are you sure?");
		if(ans){
			window.location = "<?php echo site_url('admin/seminars/delete_attendee');?>/" + id;
		}
	}
</script>

<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title left">
        <h1>
        	Seminars Manager
        </h1>
        </div>
            <?php $this->load->view('admin/seminars/tabs', array('logs' => 'active'));?>
        <div class="clear"></div>
    </div>
    
    <div class="content-text">
    <ul class="options">
            <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/seminars/logs'>Back</a></li>
        </ul>
        
        <div class="clear"></div>
    <b style="text-transform: uppercase;">Seminar Attendee</b>
    <table cellpadding="10" cellspacing="0" border="0" class="list" width="50%">
      <!--tr class="title">
        <td colspan="2">Seminar Attendee</td>
      </tr-->
      <tr class="colored">
        <td  align="right" width="140"><b>Seminar Date</b></td>
        <td><?php echo $attendee['seminar_date'];?></td>
      </tr>
      <tr>
        <td align="right"><b>Seminar Time</b></td>
        <td><?php echo $attendee['time'] . ' - ' . $attendee['end_time'];?></td>
      </tr>
      <tr class="colored">
        <td align="right"><b>Title</b></td>
        <td><?php echo $attendee['title'];?></td>
      </tr>
      <tr>
        <td align="right"><b>Location</b></td>
        <td><?php echo $attendee['location'];?></td>
      </tr>
      <tr class="colored">
        <td align="right"><b>Birth Date</b></td>
        <td><?php echo $attendee['date_of_birth'];?></td>
      </tr>
      <tr>
        <td align="right"><b>BMI</b></td>
        <td><?php echo $attendee['bmi'];?></td>
      </tr>
      <tr class="colored">
        <td align="right"><b>Name</b></td>
        <td><?php echo ucfirst(strtolower($attendee['first_name'])) . ' ' . ucfirst(strtolower($attendee['last_name']));?></td>
      </tr>
      <tr>
        <td align="right"><b>Address</b></td>
        <td><?php echo $attendee['address1'] . ' ' . $attendee['address2'];?></td>
      </tr>
      <tr class="colored">
        <td align="right"><b>City</b></td>
        <td><?php echo $attendee['city'];?></td>
      </tr>
      <tr>
        <td align="right"><b>State</b></td>
        <td><?php echo $attendee['state_name'];?></td>
      </tr>
      <tr class="colored">
        <td align="right"><b>Zip</b></td>
        <td><?php echo $attendee['zip'];?></td>
      </tr>
      <tr>
        <td align="right"><b>Country</b></td>
        <td><?php echo $attendee['name'];?></td>
      </tr>
      <tr class="colored">
        <td align="right"><b>Contact Phone</b></td>
        <td><?php echo $attendee['phone1'];?></td>
      </tr>
      <tr>
        <td align="right"><b>Email</b></td>
        <td><?php echo $attendee['email'];?></td>
      </tr>
      
      <tr class="colored">
        <td align="right"><b>Number of guests</b></td>
        <td><?php echo $attendee['number_of_guests'];?></td>
      </tr>
      <tr>
        <td align="right"><b>Date sent</b></td>
        <td><?php echo $attendee['attendee_date_posted'];?></td>
      </tr>
    </table>
    </div>
</div>