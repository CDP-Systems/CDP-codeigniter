<script type="text/javascript">
	/*var $j = jQuery.noConflict();
	$j(document).ready(function(){
	 $j(this).scrollTop(1700);
	});*/
	var $j = jQuery.noConflict(); 
	$j(document).ready(function () {
		window.location = window.location + "#table";
	});
</script>

<br />



<h4 style="margin-bottom:20px" id="table">BMI Calculator Results</h4>



<p><b style="font-size:16px; margin-bottom:10px">Your BMI: <?php echo $bmi ?></b><br />



Your BMI score indicates that you are <b style="color: #000"><?php echo $weight; ?></b> and have <b style="color: #000"><?php echo $health_risk ?></b> level of health risk.</p>



<h4><b>BMI Chart</b></h2><br />



 



<style>






.chart { /*border-color: #CCC; border-style: solid solid solid none; border-width: 1px 1px 1px 0;*/ width: 100%;  font-size:  12px; background: #fff; }



.chart th { border-left: 1px solid #C3DECB; padding: 10px; background: #b3bb92; }



.chart td { border-color: #dfe5d7 -moz-use-text-color -moz-use-text-color #dfe5d7; border-style: solid none none solid; border-width: 1px 0 0 1px; padding: 10px; background: #dfe5d7; }



.chart .first { background: #b3bb92; }

.chart tr.title { background: #b3bb92; }

.border { border: 1px solid #dfe5d7; padding: 5px; }



</style>



 <div class="border">



 <table width="0"  cellspacing="0" cellpadding="0" class="chart">



      <tr class="title">



        <th><strong>BMI</strong></th>



        <th><strong>Classification</strong></th>



        <th><strong>Health Risk</strong></th>



      </tr>



      <tr>



        <td class="first">Under 18.5</td>



        <td>Underweight</td>



        <td>Minimal </td>



      </tr>



      <tr>



        <td class="first">18.5 - 24.9</td>



        <td>Normal Weight</td>



        <td>Minimal</td>



      </tr>



      <tr>



        <td class="first">25 - 29.9</td>



        <td>Overweight</td>



        <td>Increased</td>



      </tr>



      <tr>



        <td class="first">30 - 34.9</td>



        <td>Obese</td>



        <td>High</td>



      </tr>



      <tr>



        <td class="first">35 - 39.9</td>



        <td>Severely Obese</td>



        <td>Very High</td>



      </tr>



      <tr>



        <td class="first">40 and Over</td>



        <td>Morbidly Obese</td>



        <td>Extremely High </td>



      </tr>



</table>

</div>