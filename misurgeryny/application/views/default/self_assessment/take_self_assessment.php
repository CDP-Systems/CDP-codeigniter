 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$ci =& get_instance();
if (isset($page_content))
{
    echo $page_content;
}
?>
<style>
table { border: 1px solid #CEDBC7; padding: 4px; background: white; }
table tr.shade td { background: #f3f6f1; }
table tr {}
table td { padding: 8px; }
table td ol { line-height: 18px; }
table td ol li { list-style: inside decimal; padding: 8px; }
table td ol li input { margin-top: 10px; }
table label.error { margin-left: 10px; font-weight: normal; font-style: italic; font-size: 11px; }
table input[type="radio"] { margin-left: 40px; }
ul.no-list-style li, ol.no-list-style li { list-style-type: none !important; margin-bottom: 5px !important; }
</style>

<!--
<p>Using the legend below, please circle the number following each question that corresponds with your answer. For example, if your answer to the first question is <strong>&quot;excellent&quot;</strong>, you will circle the number <strong>&quot;1&quot;</strong>. If you do not have sufficient knowledge to answer a question, please circle <strong>&quot;6&quot;</strong>, don&rsquo;t know.</p>

<p><b>LEGEND:</b><br /><b>1</b>&nbsp;= Excellent<br /><b>2</b> = Above Average<br /><b>3</b> = Average<br /><b>4</b> = Below Average<br /><b>5</b> = Poor<br /><b>6</b> = Don&rsquo;t Know</p>

<p><em>All questions require answer.</em></p> -->
<p class="red">*All items are required.</p>

<div class="green bold"><?php echo $this->session->flashdata('message');?></div>
<form name="form-self_assessment" class="require-validation" method="POST">
<ol>
    <?php foreach ($questions as $question): ;?>
   
   	<?php if($question->question_id == '58' ||$question->question_id == '59' || $question->question_id == '60'){ ?>
   	    	
   	    <?php if($question->question_id == '58'){ ?>
   	    	<ol class="no-list-style"> <li>a.
   	    <?php }else if($question->question_id == '59'){ ?>
   	    	<li>b.
   	    <?php }else if($question->question_id == '60'){ ?>
   	    	<li>c.
   	    <?php } ?>
            <?php echo html_entity_decode($question->question_details);?>
            <?php echo '<br />' . $question->html;?>
            <?php if($question->question_id == '60'){ ?>
   	    	</ol>
   	    <?php } ?>
       
        <?php }else{ ?>
	        <li style="background-color: none;">
	            <?php echo html_entity_decode($question->question_details);?>
	            <?php echo '<br />' . $question->html;?>
	        </li>
        <?php } ?>
    <?php endforeach;?>
    </ol>
    <p class="red">*All items are required.</p>
                    
                    <p><strong>Personal Information</strong></p>
<table cellpadding="0" cellspacing="1" border="0" width="100%">
  <tr class="shade">
    <td width="30%">First Name:</td>
    <td width="70%"><input type="text" name="firstname" class="required" value="<?php echo (isset($firstname)) ? $firstname: '';?>" /><?php echo form_error('firstname');?></td>
  </tr>
   <tr>
    <td width="30%">Last Name:</td>
    <td width="70%"><input type="text" name="lastname" class="required" value="<?php echo (isset($lastname)) ? $lastname: '';?>" /><?php echo form_error('lastname');?></td>
  </tr>
   <tr class="shade">
    <td width="30%">Address:</td>
    <td width="70%"><input type="text" name="address" class="required" value="<?php echo (isset($address)) ? $address: '';?>" style="width: 237px;" /><?php echo form_error('address');?></td>
  </tr>
  </tr>
   <tr>
    <td width="30%">City:</td>
    <td width="70%"><input type="text" name="city" class="required" value="<?php echo (isset($city)) ? $city: '';?>"/><?php echo form_error('city');?></td>
  </tr>
  </tr>
   <tr class="shade">
    <td width="30%">State:</td>
     <td><?php echo form_dropdown('state', state_dropdown(), set_value('state'), 'class="required"');?><?php echo form_error('state');?></td>
      </tr>
  </tr>
   <tr>
    <td width="30%">Zipcode:</td>
    <td width="70%"><input type="text" name="zip" class="required" value="<?php echo (isset($zip)) ? $zip: '';?>"/><?php echo form_error('zip');?></td>
  </tr>
  </tr>
   <tr class="shade">
    <td width="30%">Country:</td>
     <td><?php echo form_dropdown('country_id', country_dropdown(), 1, 'class="required"');?><?php echo form_error('country');?></td>
      </tr>
  <tr>
    <td>Email:</td>
    <td><input type="text" name="user_email" class="required email" value="<?php echo (isset($user_email)) ? $user_email : '';?>" /><?php echo form_error('user_email');?></td>
  </tr>
  </tr>
   <tr class="shade">
    <td width="30%">Phone:</td>
    <td width="70%"><input type="text" name="phone" class="required" value="<?php echo (isset($phone)) ? $phone: '';?>"/><?php echo form_error('phone');?></td>
  </tr>
  <tr>
    <td colspan="2">
    <input type="hidden" name="self_assessment_id" value="<?php echo $self_assessment_id;?>" />
    <input type="submit" name="submit" value="Submit" />
    <input type="Reset" name="reset" value="Clear" />
    <input type="button" name="cancel" value="Cancel" onClick="location.href='<?php echo base_url();?>self-assessment'" />
    </td>
  </tr>
</table>    
</form>
<p>&nbsp;</p>

<!-- nth Child Expression -->
<script>
//$("ol li:nth-child(odd)").css( "backgroundColor", "#f3f6f1" );
</script>
<!-- nth Child Expression -->