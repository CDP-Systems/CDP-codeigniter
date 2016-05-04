<style>

ul#faqtabs { margin-bottom: 10px; margin-left:0 !important; }

ul#faqtabs li a { text-decoration: none; font-size: 18px; color: #336350; list-style: none !important; font-weight: bold; color: #FCFCF9; }

ul#faqtabs li a:hover { text-decoration: underline; }

</style>



<?php if(isset($categories) && is_array($categories)): $x = 1;?>

<div id='faq'>

	<ul id="faqtabs" class="tabs">

		<?php foreach ($categories as $category):?>	

			<?php if ($x == 1) { $class = 'class="selected"'; $x++;} else { $class = '';}?>	

			<li style="list-style:none;"></li>

		<?php endforeach;?>

	</ul>

</div>

<?php endif; ?>