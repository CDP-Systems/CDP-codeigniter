
<style>

.border { border: 1px solid #dfe5d7; padding: 4px; }

.subtext { font-size: 11px; }

.red { color: red; font-weight: bold; }

.form { font-size: 12px; width: 100%; background: #b3bb92; }

.form td { padding: 8px 0 8px 8px; }

.form td select { width: 205px; }

.form td.title { width: 120px; }

.form td.captcha-section label.error { margin-left: -165px; }

label.error { font-weight: normal; font-style: italic; color: red; font-size: 11px; padding-left: 10px; }



h3.subtitle { margin-bottom: 10px; }

h4 a{ margin-bottom: 10px; text-decoration: none; cursor: pointer; }

</style>



<div style='clear: both;'></div>

<br /> 

<h4 style="margin-bottom: 0; padding-bottom: 10px;"><a name="bmi">BMI Calculator</a></h4>

<p style="margin-bottom: 0; padding-bottom: 0; font-size: 11px; font-style: italic;"><?php echo validation_errors('<p class="red" style="margin-bottom: 0; padding-bottom: 5px; font-size: 11px; font-style: italic;">','</p>'); ?></p>



<div class="border">

<form action="<?php echo str_replace('/compute', '', current_url()); ?>/compute" method="POST">

<table cellpadding="0" cellspacing="1" border="0" class="form">

  <tr class="shade">

    <td width="80">Height:</td>

    <td>

    <input type='text' class="require_numeric" name='feet' style="width: 40px;" value='<?php echo set_value("feet"); ?>' maxlength="2"/>

    <span style="margin: 0 20px 0 10px;">feet</span>

    <input type='text' class="require_numeric" style="width: 40px;" name='inches' value='<?php echo set_value("inches"); ?>' maxlength="2"/>

    <span style="margin: 0 20px 0 10px;">inches</span>

    </td>

  </tr>

  <tr>

    <td>Weight:</td>

    <td>

    <input type='text' class="require_numeric" style="width: 40px;" name='pounds' value='<?php echo set_value("pounds"); ?>' maxlength="3"/>

    <span style="margin: 0 20px 0 10px;">pounds</span>

    </td>

  </tr>

  <tr class="shade">

    <td>Gender:</td>

    <td>

    <?php $gender_val = set_value('gender'); ?>

	<?php if(!($gender_val) || $gender_val == 'male'): ?>

        <input type='radio' name='gender' checked value='male' /> Male &nbsp; 

        <input type='radio' name='gender' value='female' /> Female

    <?php elseif($gender_val == 'female'): ?>

        <input type='radio' name='gender' value='male' /> Male &nbsp; 

        <input type='radio' name='gender' checked  value='female' /> Female

    <?php endif; ?>

    </td>

  </tr>

  <tr>

    <td></td>

    <td><input type='submit' value='Compute BMI' class="green-btn-small" /></td>

  </tr>

</table>

</form>

</div>

<p>&nbsp;</p>



<script src="http://code.jquery.com/jquery-latest.js"></script>

<script>$("table.form tr:nth-child(odd)").css( "backgroundColor", "#dfe5d7" );</script>