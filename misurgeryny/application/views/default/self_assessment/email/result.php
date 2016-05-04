<style>
ol { line-height: 18px; }
ol li { list-style: inside decimal; padding: 8px; }
ol li input { margin-top: 10px; }
ul.no-list-style li, ol.no-list-style li { list-style-type: none !important; margin-bottom: 5px !important;  margin-left: 20px !important; }
</style>
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

