<script type="text/javascript">
$(document).ready(function () {
    $('.list tr:even').addClass('colored');
});
</script>
<div class="content-container">
    <div style="background:#d1dde0;">
            <div class="title">
        <h1>
        	Referrals Manager
        </h1>
        <?php $this->load->view('admin/referrals/tabs', array('list' => 'active'));?>
	<div style='margin-top: 10px'><?php echo set_breadcrumb(); ?></div>
        </div>
            <div class="clear"></div>
    </div>

    <div class="content-text">
        <div class="left" >
            <div class="green-btn left" style="margin-right: 10px;">
                <?php echo anchor('admin/referrals/', 'Back', array('class'=>'hoverPointer'));?>
            </div>
        </div>
        <div class="clear"></div>
        <table cellpadding="10" cellspacing="0" border="0" class="list" width="50%">
            <tr>
                <td>Patient Name</td>
                <td><?php echo $patient_name;?></td>
            </tr>
            <tr>
                <td>Patient Email</td>
                <td><?php echo $patient_email;?></td>
            </tr>
            <tr>
                <td>Patient Address</td>
                <td><?php echo $patient_address;?></td>
            </tr>
            <tr>
                <td>Referral Name</td>
                <td><?php echo $referral_name;?></td>
            </tr>
            <tr>
                <td>Referral Email</td>
                <td><?php echo $referral_email;?></td>
            </tr>
            <tr>
                <td>Referral Relationship</td>
                <td><?php echo $referral_relationship;?></td>
            </tr>
            <tr>
                <td>Date Filed</td>
                <td><?php echo date('F j, Y', strtotime($date_filed));?></td>
            </tr>
        </table>
    </div>
</div>
