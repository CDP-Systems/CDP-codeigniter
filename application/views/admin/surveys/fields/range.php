<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<table cellpadding="8" cellspacing="1" border="0" width="100%">
    <thead>
        <tr bgcolor="#f1f1f1">
            <th align="center">Rating</th>
            <th align="center"># of Replies</th>
            <th align="center">Percentage</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $ctr = 1;
        while ($ctr <= $range) 
        {
        ?>
            <tr bgcolor="#f1f1f1">
                <td align="center"><?php echo $ctr;?></td>
                <td align="center"><?php echo (array_key_exists($ctr, $number_of_replies)) ? $number_of_replies[$ctr] : '0';?></td>
                <td align="center"><?php echo (array_key_exists($ctr, $percentage)) ? $percentage[$ctr] : '0';?> %</td>
            </tr>
        <?php 
        $ctr++;
        }
        ?>
    </tbody>
</table>
<p>&nbsp;</p>