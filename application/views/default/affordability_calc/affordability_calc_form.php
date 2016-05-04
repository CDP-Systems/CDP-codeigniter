<style type="text/css">

legend.affordability-title { font-weight: bold; font-size: 14px; padding: 0 0 10px 10px; }

table.affordability-chart { margin: 0 0 20px; /*border: 1px solid #ccc;*/ background: #b3bb92; line-height: 18px;  font-size: 12px; }

</style>

<div style='clear: both'></div>



<form action="<?php echo str_replace('/compute', '', current_url()); ?>/compute" method='post' style="margin-bottom: 20px;">



<?php echo form_error('name','<p class="red" style="margin-bottom:5px; padding-bottom:0; font-size: 11px; font-style: italic;">','</p>'); ?>

<?php echo form_error('food_expenses','<p class="red" style="margin-bottom:5px; padding-bottom:0; font-size: 11px; font-style: italic;">','</p>'); ?>

<?php echo form_error('prescriptions_expenses','<p class="red" style="margin-bottom:5px; font-size: 11px; font-style: italic; padding-bottom:0">','</p>'); ?>

<?php echo form_error('health_expenses','<p class="red" style="margin-bottom:5px; font-size: 11px; font-style: italic; padding-bottom:0">','</p>'); ?>

<?php echo form_error('programs_expenses','<p class="red" style="margin-bottom:5px; font-size: 11px; font-style: italic; padding-bottom:0">','</p>'); ?>



<br />



<div style="border: 1px solid #b3bb92; padding: 4px; background: #dfe5d7; padding: 10px;">

<table cellpadding="4" cellspacing="1" border="0" style="margin-bottom: 20px;" class="affordability-chart">

    <tr>

      <td align="left">Please tell us your name:&nbsp;</td>

      <td>

		

		<input type='text' name='name' value='<?php echo set_value("name"); ?>' />

	  </td>

    </tr>

</table>



<fieldset>

<legend class="affordability-title">Food </legend>



<table cellpadding="10" cellspacing="1" border="0" class="affordability-chart">

    <tr>

      <td>Based on research, a seriously overweight person spends $6,100 annually on groceries and dining out. Approximately, how much do you spend per month on groceries and dining out?<br /><br /></td>

    </tr>

    <tr>

      <td>

	  

	  <em>I am spending about 

		<select name='food_expenses' >

			<?php $food_expenses = set_value("food_expenses"); ?>

			<option value='' >-Select-</option>

			<option value='500' <?php if($food_expenses == '500') echo 'selected="selected"' ?> >$500</option>

			<option value='550' <?php if($food_expenses == '550') echo 'selected="selected"' ?> >$550</option>

			<option value='600' <?php if($food_expenses == '600') echo 'selected="selected"' ?>>$600</option>

			<option value='650' <?php if($food_expenses == '650') echo 'selected="selected"' ?>>$650</option>

			<option value='700' <?php if($food_expenses == '700') echo 'selected="selected"' ?>>$700</option>

		</select>

		per month on groceries and dining out.</em></td>

      <td>&nbsp;</td>    

    </tr>

</table>

</fieldset>



<fieldset>

	<legend class="affordability-title">Prescriptions</legend>



<table cellpadding="10" cellspacing="1" border="0" class="affordability-chart">

    <tr>

      <td>Based on research, a seriously overweight person spends $700 annually on prescription co-pays. Approximately, how much do you spend per month on prescription co-pays?<br /><br /></td>

    </tr>

    <tr>

      <td>

		

		<em>I am spending about 

		<select name='prescriptions_expenses' >

			<?php $prescriptions_expenses = set_value("prescriptions_expenses"); ?>

			<option value='' >-Select-</option>

			<option value='0' <?php if($prescriptions_expenses == '0') echo 'selected="selected"' ?>>$0</option>

			<option value='20' <?php if($prescriptions_expenses == '20') echo 'selected="selected"' ?>>$20</option>

			<option value='40' <?php if($prescriptions_expenses == '40') echo 'selected="selected"' ?>>$40</option>

			<option value='60' <?php if($prescriptions_expenses == '60') echo 'selected="selected"' ?>>$60</option>

			<option value='70' <?php if($prescriptions_expenses == '70') echo 'selected="selected"' ?>>$70</option>

			<option value='80' <?php if($prescriptions_expenses == '80') echo 'selected="selected"' ?>>$80</option>

			<option value='90' <?php if($prescriptions_expenses == '90') echo 'selected="selected"' ?>>$90</option>

			<option value='100' <?php if($prescriptions_expenses == '100') echo 'selected="selected"' ?>>$100</option>

		</select>

		per month on prescription co-pays.</em></td>

    </tr>

</table>

</fieldset>



<fieldset>

	<legend class="affordability-title">Out-of-Pocket Health Expenses</legend>

    

<table cellpadding="10" cellspacing="1" border="0" class="affordability-chart">

    <tr>

      <td>Based on research, a seriously overweight person spends $2,500 on out-of-pocket healthcare expenses each year.</td>

    </tr>

    <tr>

      <td><b>Out-of-pocket healthcare expenses include:</b><br />

      	<ul>

		  <li>Over the counter drugs/remedies such as glucosamine, snore relief remedies, ibuprofen, etc.</li>

		  <li>Co-pays for doctor office visits</li>

		  <li>Co-pays for lab work</li>

		  <li>Co-pays for specialists</li>

		  <li>Co-pays for physical therapist/allied health professionals</li>

	    </ul>

      </td>

    </tr>

    <tr>

      <td>

		

	    <em>I am spending about 

		<select name='health_expenses' >

			<?php $health_expenses = set_value("health_expenses"); ?>

			<option value='' >-Select-</option>

			<option value='200' <?php if($health_expenses == '100') echo 'selected="selected"' ?>>$200</option>

			<option value='250' <?php if($health_expenses == '250') echo 'selected="selected"' ?>>$250</option>

			<option value='300' <?php if($health_expenses == '300') echo 'selected="selected"' ?>>$300</option>

			<option value='350' <?php if($health_expenses == '350') echo 'selected="selected"' ?>>$350</option>

			<option value='400' <?php if($health_expenses == '400') echo 'selected="selected"' ?>>$400</option>

		</select>

		per month on out-of-pocket healthcare expenses.</em></td>

    </tr>

</table>

</fieldset>



<fieldset>

	<legend class="affordability-title">Weight Loss Programs</legend>



<table cellpadding="10" cellspacing="1" border="0" class="affordability-chart">

    <tr>

      <td>Based on research, a seriously overweight person spends $700 annually on non-surgical weight loss programs.</td>

    </tr>

    <tr>

      <td><b>Examples of non-surgical weight loss programs include:</b><br />

          <ul>

            <li>Jenny Craig</li>

            <li>Lindora</li>

            <li>Weight Watchers</li>

            <li>Nutri-systems</li>

            <li>Curves</li>

         </ul>

      </td>

    </tr>

    <tr>

      <td>

		

	   <em>I am spending about 

		<select name='programs_expenses' >

			<?php $programs_expenses = set_value("programs_expenses"); ?>

			<option value='' >-Select-</option>

			<option value='60' <?php if($programs_expenses == '60') echo 'selected="selected"' ?>>$60</option>

			<option value='70' <?php if($programs_expenses == '70') echo 'selected="selected"' ?>>$70</option>

			<option value='80' <?php if($programs_expenses == '80') echo 'selected="selected"' ?>>$80</option>

			<option value='90' <?php if($programs_expenses == '90') echo 'selected="selected"' ?>>$90</option>

			<option value='100' <?php if($programs_expenses == '100') echo 'selected="selected"' ?>>$100</option>

		</select>

		per month on non-surgical weight loss programs.</em></td>

      <td>&nbsp;</td>

    </tr>

</table>    

</fieldset>



<div><input type='submit' value='Compute' class="green-btn-small"></div>

</div>

</form>

<div style="clear:both"></div>

