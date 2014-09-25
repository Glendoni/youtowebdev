<div class="row page-results-list">
	<nav class="navbar navbar-default companies-list-header" role="navigation">
	  <div class="container-fluid">
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="">
	      <ul class="nav navbar-nav">
	      	<li><p class="navbar-text"><strong><?php echo $companies_count; ?></strong> Companies </p></li>        
	      </ul>
	      
	      
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	
	
	<p>Page <?php echo $current_page_number; ?> of <?php echo $page_total ?></p>
	<ul class="pager">
		<?php if($previous_page_number): ?>
	  	<li class="previous"><a href="?page_num=<?php echo $previous_page_number; ?>">&larr; Previous</a></li>
	    <?php endif; ?>

	    <?php if($next_page_number): ?>
	  	<li class="next"><a href="?page_num=<?php echo $next_page_number; ?>">Next &rarr;</a></li>
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