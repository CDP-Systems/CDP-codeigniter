<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<style>
#content .border-white .content-container ul.tab { margin-top: 10px; }
#content .border-white .content-container .title { padding-bottom: 0; }
</style>

<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
            <h1>Self Assessment Manager</h1>
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
			<?php $this->load->view('admin/self_assessment/tabs', array('list' => 'active'));?>
            <div class="clear"></div>
        </div>                        
        <div class="clear"></div>
    </div>
    <div class="content-text">
    	<ul class="options">
          <li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/self_assessment'>Back</a></li>
        </ul>
        <div class="clear">&nbsp;</div>
        
        <div class="green bold"><?php echo $this->session->flashdata('message');?></div>
        
        <?php if (!isset($responses)):?>
            <div class="red bold">No data found.</div>        
        <?php ;else:?>
            <div>
            <p><b>Title: <?php echo $self_assessment['self_assessment_name'];?></b></p>
            <p>&nbsp;</p>
            <ol>
                <?php 
                foreach ($responses as $response):
                	if ($response->type_of_question_id != 2):
                ?>
                    <li>
                        <div style="background: #F1F1F1; border: solid white; border-width: 0 1px; padding: 8px;"><?php echo html_entity_decode($response->question_details);?></div>
                        <div><?php echo $response->html;?></div>
                    </li>
                <?php 
                	endif;
                endforeach;
                ?>
            </ol>
            
            </div>            
			
        <?php endif;?>        
    </div>
</div>