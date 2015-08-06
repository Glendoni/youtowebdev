<div class="col-md-12">
<div class="page-results-list">

	<ul class="pager">
		<?php if($previous_page_number): ?>
	  	<li class="previous">
	  		<a href="?page_num=<?php echo $previous_page_number; ?>">&larr; Previous</a>
	  	</li>
	    <?php endif; ?>

        <span class="count_of_results">
			<?php echo $companies_count; ?> <?php if ($companies_count<> "1") {echo "Companies";} else { echo "Company";}?>
			<?php if($previous_page_number or $next_page_number): ?><span style="font-size:15px; font-weight:700;"> Page <?php echo $current_page_number; ?> of <?php echo $page_total ?> </span><?php endif; ?>
		</span>
			    

	    <?php if($next_page_number): ?>
	  	<li class="next">
	  		<a href="?page_num=<?php echo $next_page_number; ?>">Next &rarr;</a>
	  	</li>
		<?php endif; ?>
	</ul>

	


	
	<?php 
	// Display companies
	$this->load->view('companies/list.php');
	?>
	
	<ul class="pager">
		<?php if($previous_page_number): ?>
	  	<li class="previous"><a href="?page_num=<?php echo $previous_page_number; ?>">&larr; Previous</a></li>
	    <?php endif; ?>

	    <?php if($next_page_number): ?>
	  	<li class="next"><a href="?page_num=<?php echo $next_page_number; ?>">Next &rarr;</a></li>
		<?php endif; ?>
	</ul>
</div>
</div>