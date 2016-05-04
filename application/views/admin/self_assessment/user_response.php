<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<style>
#content .border-white .content-container ul.tab { margin-top: 10px; }
#content .border-white .content-container .title { padding-bottom: 0; }
ol { line-height: 18px; }
ol li { list-style: inside decimal; padding: 8px; }
ol li input { margin-top: 10px; }
ul.no-list-style li, ol.no-list-style li { list-style-type: none !important; margin-bottom: 5px !important;  margin-left: 20px !important; }
</style>

<div class="content-container">
    <div style="background:#d1dde0;">
        <div class="title">
            <h1>Self Assessment Manager</h1>            
            <div style="margin-top: 10px"><?php echo set_breadcrumb(); ?></div>
            <?php $this->load->view('admin/self_assessment/tabs', array('respondents' => 'active'));?>
            <div class="clear"></div>
        </div>                        
        <div class="clear"></div>
    </div>
    <div class="content-text">
    <ul class="options">
	<li class="back-arrow"><a href='<?php echo base_url().index_page(); ?>admin/self_assessment/respondents'>Back</a></li>
</ul>
<br/>
        <div class="green bold"><?php echo $this->session->flashdata('message');?></div>
        
        <?php if (!isset($responses)):?>
            <div class="red bold">No data found.</div>        
        <?php ;else:?>
            <div>
            <p><b>Name: <?php echo $respondent['firstname']. ' '. $respondent['lastname'];?></b></p>
            <p><b>Address: <?php echo $respondent['address'];?></b></p>
            <p><b>City: <?php echo $respondent['city'];?></b></p>
            <p><b>State: <?php echo $respondent['state_name'];?></b></p>
            <p><b>Zipcode: <?php echo $respondent['zip'];?></b></p>
            <p><b>Country: <?php echo $respondent['name'];?></b></p>
            <p><b>Email: <?php echo $respondent['user_email'];?></b></p>
            <p><b>Phone: <?php echo $respondent['phone'];?></b></p>
            <p><b>Candidate: <?php echo ($respondent['candidate'] == 1) ? 'Yes' : 'No';?></b></p>
            <p>&nbsp;</p>
            
            <ol>
    <?php foreach ($responses as $response): ;?>
   
   	<?php if($response->question->question_id == '58' ||$response->question->question_id == '59' || $response->question->question_id == '60'){ ?>
   	    	
   	    <?php if($response->question->question_id == '58'){ ?>
   	    	<ol class="no-list-style"> <li>a.
   	    <?php }else if($response->question->question_id == '59'){ ?>
   	    	<li>b.
   	    <?php }else if($response->question->question_id == '60'){ ?>
   	    	<li>c.
   	    <?php } ?>
             <?php echo html_entity_decode($response->question->question_details);?>
            <strong>Answer:</strong> <?php echo $response->answer;?>
            <?php if($response->question->question_id == '60'){ ?>
   	    	</ol>
   	    <?php } ?>
       	<?php }else if($response->question->question_id == '57'){?>
       		<li style="background-color: none;">
	            <strong>Question:</strong> <?php echo html_entity_decode($response->question->question_details);?>
	        </li>
        <?php }else{ ?>
	        <li style="background-color: none;">
	            <strong>Question:</strong> <?php echo html_entity_decode($response->question->question_details);?>
	            <strong>Answer:</strong> <?php echo $response->answer;?>
	        </li>
        <?php } ?>
    <?php endforeach;?>
    </ol>
            
            </div>            
			
        <?php endif;?>        
    </div>
</div>