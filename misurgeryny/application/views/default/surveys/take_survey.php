<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$ci =& get_instance();
?>
<style>
form.require-validation { border: 1px solid #CEDBC7; padding: 4px; background: white; }
form.require-validation table tr.shade td { background: #f3f6f1; }
form.require-validation table tr {}
form.require-validation table td { padding: 8px; }
form.require-validation table td ol { line-height: 18px; }
form.require-validation table td ol li { list-style: inside decimal; padding: 8px; }
form.require-validation table td ol li input { margin-top: 10px; }
form.require-validation table label.error { margin-left: 10px; font-weight: normal; font-style: italic; font-size: 11px; }
form.require-validation table input[type="radio"] { margin-left: 40px; }
</style>

<p>Using the legend below, please circle the number following each question that corresponds with your answer. For example, if your answer to the first question is <strong>&quot;excellent&quot;</strong>, you will circle the number <strong>&quot;1&quot;</strong>. If you do not have sufficient knowledge to answer a question, please circle <strong>&quot;6&quot;</strong>, don&rsquo;t know.</p>

<p><b>LEGEND:</b><br /><b>1</b>&nbsp;= Excellent<br /><b>2</b> = Above Average<br /><b>3</b> = Average<br /><b>4</b> = Below Average<br /><b>5</b> = Poor<br /><b>6</b> = Don&rsquo;t Know</p>

<p><em>All questions require answer.</em></p>

<div class="green bold"><?php echo $this->session->flashdata('message');?></div>
<form name="form-survey" class="require-validation" method="POST">
<table cellpadding="0" cellspacing="1" border="0" width="100%">
  <tr class="shade">
    <td width="30%">Your name: (optional)</td>
    <td width="70%"><input type="text" name="name" value="<?php echo (isset($name)) ? $name : '';?>" /><?php echo form_error('name');?></td>
  </tr>
  <tr>
    <td>Email: (required)</td>
    <td><input type="text" name="user_email" class="required email" value="<?php echo (isset($user_email)) ? $user_email : '';?>" /><?php echo form_error('user_email');?></td>
  </tr>
  <tr>
    <td colspan="2" style="padding: 0;">    
    <ol>
    <?php foreach ($questions as $question):?>
        <li>
            <?php echo $question->question_details;?>
            <?php echo '<br />' . $question->html;?>
        </li>
    <?php endforeach;?>
    </ol>
    </td>
  </tr>
  <tr>
    <td colspan="2">
    <input type="hidden" name="survey_id" value="<?php echo $survey_id;?>" />
    <input type="submit" name="submit" value="Submit" />
    <input type="Reset" name="reset" value="Clear" />
    <input type="button" name="cancel" value="Cancel" onClick="location.href='http://mdnetdemo.com/new/'" />
    </td>
  </tr>
</table>    
</form>
<p>&nbsp;</p>

<!-- nth Child Expression -->
<script>
$("ol li:nth-child(odd)").css( "backgroundColor", "#f3f6f1" );
</script>
<!-- nth Child Expression -->