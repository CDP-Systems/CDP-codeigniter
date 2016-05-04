<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script type='text/javascript'>
    	function deleteAttendee(id){
		var ans = confirm("Are you sure?");
		if(ans){
			window.location = "<?php echo site_url('admin/online_seminars/delete_attendee');?>/" + id;
		}
	}
</script>

<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
        <h1>
        	Online Seminars Manager
        </h1>
            <?php $this->load->view('admin/online_seminars/tabs', array('logs' => 'active'));?>
            <div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="content-text">
		<ul>
		  <li class="back-arrow">
			<a href='<?php echo base_url().index_page(); ?>admin/online_seminars/logs' >Back</a>
		  </li>
		</ul><br />
		<div class="clear"></div>
		
    <b style="text-transform: uppercase;">Seminar Attendee</b>
    <table cellpadding="10" cellspacing="0" border="0" class="list" width="50%">

      <tr class="">
        <td align="right"><b>Title</b></td>
        <td><?php echo $attendee['title'];?></td>
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
        <td align="right"><b>Insurance</b></td>
        <td><?php echo $attendee['insurance'];?></td>
      </tr>
      <tr>
        <td align="right"><b>How did you hear about us?</b></td>
        <td><?php echo ucwords(str_replace("_"," ",$attendee['how_heard']));?></td>
      </tr>
      <tr class="colored">
        <td align="right"><b>Date sent</b></td>
        <td><?php echo $attendee['attendee_date_posted'];?></td>
      </tr>
    </table>
    </div>
</div>