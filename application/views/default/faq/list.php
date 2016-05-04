<style>

ul#catlist {  }

ul#catlist li { list-style: none; margin-bottom: 0; padding-bottom: 0; line-height: 18px; font-weight: bold; }

ul#catlist li a { text-decoration: none; }

ul#catlist li a:hover { text-decoration: underline; }


.toggle_container { background: #eeeab6; padding: 10px; margin-top: 10px; }

.toggle_container p { font-weight:normal; }

</style>



<script type='text/javascript'>

var $j = jQuery.noConflict(); 

$j(document).ready(function(){



	//Hide (Collapse) the toggle containers on load

	$j(".toggle_container").hide(); 



	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)

	$j("p.trigger").click(function(){

		$j(this).toggleClass("active").next().slideToggle("slow");

		return false; //Prevent the browser jump to the link anchor

	});



});

</script>

<?php 

	if(isset($faqs_per_category) && is_array($faqs_per_category)):

		echo '<div class="tabwrap">';

		foreach ($faqs_per_category as $key => $faq):	

?>		

			<div id="cat<?php echo $key;?>" class="tabcontent">	

				<ul id="catlist">				

				<?php foreach($faq as $row): ?>

					<li>

						<p class="trigger" style="margin-bottom:0;  font-size: 14px;"><span style="">Q:</span> <a href="#"><?php echo $row['question']; ?></a></p>

						<div class="toggle_container"><?php echo $row['answer']; ?></div>

					</li>

					<br />

				<?php endforeach; ?>   

				</ul>

			</div>

<?php 

		endforeach;

		echo '</div>';

	else: 

?>

<h2>No FAQ found.</h2>

<?php endif; ?>  



<script type="text/javascript">

        var faq=new ddtabcontent("faqtabs")

        faq.setpersist(false)

        faq.setselectedClassTarget("selected") //"link" or "linkparent"

        faq.init()

</script>