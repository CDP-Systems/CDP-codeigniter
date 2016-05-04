<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<table cellpadding="8" cellspacing="1" border="0" width="100%">
    <thead>
        <tr bgcolor="#f1f1f1">
            <th align="center">Option</th>
            <th align="center"># of Replies</th>
            <th align="center">Percentage</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($choices as $ctr => $choice):?>
            <tr bgcolor="#f1f1f1">
                <td align="center"><?php echo $choice;?></td>
                <td align="center"><?php echo (array_key_exists($ctr, $number_of_replies)) ? $number_of_replies[$ctr] : '0';?></td>
                <td align="center"><?php echo (array_key_exists($ctr, $percentage)) ? $percentage[$ctr] : '0';?> %</td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
<p>&nbsp;</p>