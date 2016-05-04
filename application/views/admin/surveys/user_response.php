<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<style>
#content .border-white .content-container ul.tab { margin-top: 10px; }
#content .border-white .content-container .title { padding-bottom: 0; }
</style>

<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
            <h1>Surveys Manager</h1>            
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
            <?php $this->load->view('admin/surveys/tabs', array('respondents' => 'active'));?>
            <div class="clear"></div>
        </div>                        
        <div class="clear"></div>
    </div>
    <div class="content-text">
        <div class="green bold"><?php echo $this->session->flashdata('message');?></div>
        
        <?php if (!isset($responses)):?>
            <div class="red bold">No data found.</div>        
        <?php ;else:?>
            <div>
            <p><b>Name: <?php echo $respondent['name'];?></b></p>
            <p><b>Email: <?php echo $respondent['user_email'];?></b></p>
            <p>&nbsp;</p>
            
            <table cellpadding="8" cellspacing="1" width="100%">
              <?php 
                foreach ($responses as $response):
                ?>
              <tr bgcolor="#F1F1F1">
                <td>
                <div><strong>Question:</strong> <?php echo $response->question->question_details;?></div>
                <div><strong>Answer:</strong> <?php echo $response->answer;?></div>
                </td>
              </tr>
              <?php 
                endforeach;
                ?>
            </table>
            
            </div>            
			
        <?php endif;?>        
    </div>
</div>