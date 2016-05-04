<?php 
	$ci =& get_instance();
?>
<?php if($search_results): ?>

<h2><i>Found <?php echo $total_rows; ?> result(s) for &#34<?php echo $search_key; ?>&#34 </i></h2>

<p><?php echo $this->pagination->create_links(); ?></p>

<br />

<ul style="margin-left:0">
	<?php foreach($search_results as $row): ?>
    <li style="list-style:none">
    	<div>
            <h3>
					<?php 
                    $ci->breadcrumbs->clear();                    
                    $ci->breadcrumbs->id_page = $row->id_page;

                    echo anchor($ci->breadcrumbs->get_link(), $row->page_title);
					
                    ?>
            </h3>
            <p>
            <?php echo word_limiter(strip_tags($row->content), 90); ?>
            </p>
        </div>
        <hr />
    </li>	
    <?php endforeach; ?>
</ul>
<p><?php echo $this->pagination->create_links(); ?></p>
<?php elseif($search_results != 0): ?>
<p><strong><i>No search result for &#34<?php echo $search_key; ?>&#34 </i></strong></p>
<?php endif; ?>

<p>
<h4 style="color: #000; padding-bottom: 10px;">New Search:</h4>
<style>
#search-bordered input[type="text"] { border: 1px solid #CCC; height: 20px; }
</style>
<div id="search-bordered">
<?php $this->load->view('default/search/search_form'); ?>
</div>
</p>