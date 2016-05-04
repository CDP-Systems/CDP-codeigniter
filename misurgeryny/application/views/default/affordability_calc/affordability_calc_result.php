<style>

table.affordability-result1 { margin: 10px 0 20px 0; border: 1px solid #ccc; border-left: 0; width: 400px; font-size: 12px; line-height: 18px; background: #fff; }

table.affordability-result1 th {  border: 1px solid #ccc; padding: 10px; border-top:0; border-bottom:0;  border-right:0; }

table.affordability-result1 td {  border: 1px solid #ccc; padding: 10px; border-right:0; border-bottom:0; }

table.affordability-result1 tr.title { background: #4f622b; color: #fff; font-weight: bold; font-size: 14px; text-align:center; }

table.affordability-result1 .colored { background: #ecf7fc; }



table.affordability-result2 { margin: 10px 0 20px 0; border: 1px solid #ccc; border-left: 0; width: 400px; font-size: 12px; line-height: 18px;  }

table.affordability-result2 tr {  border: 1px solid #ccc; }

table.affordability-result2 th {  border: 1px solid #ccc; padding: 10px; border-top:0; border-bottom:0;  border-right:0; }

table.affordability-result2 td {  border: 1px solid #ccc; padding: 10px; border-right:0; border-bottom:0; }

table.affordability-result2 tr.title { background: #c5e3ef; font-weight: bold; font-size: 14px; text-align:center; }

table.affordability-result2 .colored { background: #ecf7fc; }

table.affordability-result2 td.total { background: #fbd1d1; }



/* Y */

table.affordability-result1 tr.title,

table.affordability-result2 tr.title { background: /*#CFF #ECF7FC*/; background: #b3bb92; }

table.affordability-result1 .colored,

table.affordability-result2 .colored { background: #dfe5d7; }

</style>

<!--<h1>Affordability Calculator</h1>-->

<h2>Results</h2><br />



<fieldset>

<legend><b style="color: #000"><?php echo $patient_name; ?></b>, your current expenses are:</legend>

<table cellpadding="0" cellspacing="0" border="0" class="affordability-result1" >

  <tr class="title">

    <td style="border-top:0">Item</td>

    <th>Monthly</th>

    <th>Annual</th>

  </tr>

  <tr>

    <td class="colored">Food</td>

    <td>$<?php echo $results['p1']; ?></td>

    <td>$<?php echo $results['ap1']; ?></td>

  </tr>

  <tr>

    <td class="colored">Prescription co-pays</td>

    <td>$<?php echo $results['p2']; ?></td>

    <td>$<?php echo $results['ap2']; ?></td>

  </tr>

  <tr>

    <td class="colored">Out-of-pocket health</td>

    <td>$<?php echo $results['p3']; ?></td>

    <td>$<?php echo $results['ap3']; ?></td>

  </tr>

  <tr>

    <td class="colored">Weight-loss programs</td>

    <td>$<?php echo $results['p4']; ?></td>

    <td>$<?php echo $results['ap4']; ?></td>

  </tr>

  <tr style="background: #67b174; color: #fff">

  <!--tr style="background: #fbd1d1;"-->

    <td>TOTAL EXPENSES</td>

    <td>$<?php echo $monthly; ?></td>

    <td>$<?php echo $annual; ?></td>

  </tr>

</table>

</fieldset>

<br />

<fieldset>

<legend><p style=" margin-bottom:0; padding-bottom:0"><b style="color: #000;"><?php echo $patient_name; ?></b>, your savings will be:</p></legend>

<p><b>M</b> - Monthly, <b>A</b> - Annually</p>

<table cellpadding="0" cellspacing="0" border="0" class="affordability-result1" style="width:100%">

  <tr class="title">

    <th style="border-bottom:0">Item</th>

    <th colspan="2">Year 1</th>

    <th colspan="2">Year 2</th>

    <th colspan="2">Year 3</th>

    <th style="border-bottom:0">Remarks</th>

  </tr>

  <tr class="title">

    <td style="border-top:0;">&nbsp;</td>

    <th style="font-weight: normal">M</th>

    <th style="font-weight: normal">A</th>

    <th style="font-weight: normal">M</th>

    <th style="font-weight: normal">A</th>

    <th style="font-weight: normal">M</th>

    <th style="font-weight: normal">A</th>

    <td style="border-top:0;">&nbsp;</td>

  </tr>

  <tr>

    <td class="colored">Food</td>

    <td>$<?php echo $results['sp1']; ?></td>

    <td>$<?php echo $results['asp1']; ?></td>

    <td>$<?php echo $results['sp1']; ?></td>

    <td>$<?php echo $results['asp1']; ?></td>

    <td>$<?php echo $results['sp1']; ?></td>

    <td>$<?php echo $results['asp1']; ?></td>

    <td><strong>Food:</strong><br />

      Down 60% every year starting year 1</td>

  </tr>

  <tr>

    <td class="colored">Prescription co-pays</td>

    <td>$<?php echo $results['p2']; ?></td>

    <td>$<?php echo $results['ap2']; ?></td>

    <td>$<?php echo $results['sp2']; ?></td>

    <td>$<?php echo $results['asp2']; ?></td>

    <td>$<?php echo $results['sp2']; ?></td>

    <td>$<?php echo $results['asp2']; ?></td>

    <td><strong>Co-pays:</strong><br />

      Down 50% starting year 2</td>

  </tr>

  <tr>

    <td class="colored">Out-of-pocket health expenses</td>

    <td>$<?php echo $results['sp3']; ?></td>

    <td>$<?php echo $results['asp3']; ?></td>

    <td>$<?php echo $results['sp3']; ?></td>

    <td>$<?php echo $results['asp3']; ?></td>

    <td>$<?php echo $results['sp3']; ?></td>

    <td>$<?php echo $results['asp3']; ?></td>

    <td><strong>Out-of-pocket health expenses:</strong><br />

      Down 70% every year starting year 1</td>

  </tr>

  <tr>

    <td class="colored">Weight-loss programs</td>

    <td>$<?php echo $results['sp4']; ?></td>

    <td>$<?php echo $results['asp4']; ?></td>

    <td>$<?php echo $results['sp4']; ?></td>

    <td>$<?php echo $results['asp4']; ?></td>

    <td>$<?php echo $results['sp4']; ?></td>

    <td>$<?php echo $results['asp4']; ?></td>

    <td><strong>Weight-loss programs:</strong><br />

      Completely removed starting year 1</td>

  </tr>

  <tr style="background: #67b174; color: #fff">

  <!--tr style="background: #fbd1d1;"-->

    <td>TOTAL SAVINGS</td>

    <td><strong>$<?php echo $results['smt1']; ?></strong></td>

    <td><strong>$<?php echo $results['sat1']; ?></strong></td>

    <td><strong>$<?php echo $results['smt2']; ?></strong></td>

    <td><strong>$<?php echo $results['sat2']; ?></strong></td>

    <td><strong>$<?php echo $results['smt3']; ?></strong></td>

    <td><strong>$<?php echo $results['sat3']; ?></strong></td>

    <td>&nbsp;</td>

  </tr>

  <tr style="background: #4f622b; color: #fff">

    <!--td colspan="8" align="center" style="background: #eee;"-->

    <td colspan="8" align="center"><strong style="font-size: 14px;">These savings are equal to a LAP-BAND procedure financed monthly at 8% interest for 3 years.</strong></td>  

  </tr>

</table>

</fieldset>