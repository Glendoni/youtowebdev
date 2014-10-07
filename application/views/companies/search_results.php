<div class="row page-results-list">
	<nav class="navbar navbar-default companies-list-header" role="navigation">
	  <div class="container-fluid">
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="col-md-4">
	      <ul class="nav navbar-nav">
	      	<li><p class="navbar-text"><strong><?php echo $companies_count; ?></strong> Companies </p></li>        
	      </ul>
	      
	      </div>

<div class="col-md-8" style="text-align:right;">

	      	<?php if(($companies_count > 0)): ?>
			<?php if($current_campaign_name && $current_campaign_owner_id && $current_campaign_id ): ?>

		<div class="navbar-text saved-search-text">
		<span style="font-weight:300; font-size:16px;">Search:</span>
		<?php echo $current_campaign_name; ?>
		</div>
        
		<?php if($current_campaign_is_shared == False): ?>
		<div class="navbar-text saved-search-text">
		<span style="font-weight:300; font-size:10px;"><i class="fa fa-user"></i> Private Search</span>
</div>	
		<?php else: ?> 
		<div class="navbar-text saved-search-text">
		<span style="font-weight:300; font-size:10px;"><i class="fa fa-users"></i> Public Search</span>
</div>	
					<?php endif;?>  
					<?php if($current_campaign_editable): ?>
					<?php endif; ?>
				  <?php if($current_campaign_editable): ?>
                  <?php echo form_open(site_url().'campaigns/edit', 'name="edit_campaign" role="form"'); echo form_hidden('campaign_id', $current_campaign_id); ?>
                  <?php if($current_campaign_is_shared == False): ?>
						<button type="submit" class="btn btn-warning btn-sm btn-search-edit" name="make_public" ><i class="fa fa-users"></i> Make Public</button>
						<?php else: ?>
						<button type="submit" class="btn btn-warning btn-success btn-sm btn-search-edit" name="make_private" ><i class="fa fa-user"></i> Make Private</button>
						<?php endif; ?>
                        
						<button type="submit" class="btn btn-danger btn-sm btn-search-edit" name="delete" ><i class="fa fa-trash-o fa-lg"></i> </button>
					<?php echo form_close(); ?>
				  <?php endif; ?>
				</div>
					
			<?php else: ?>


			<?php echo form_open(site_url().'campaigns/create', 'name="create_campaign" class="create_campaign navbar-form navbar-left" role="form"'); ?>
			 	<div class="form-group">
					<input type="text" name="name" class="form-control" id="name" placeholder="Enter search name...">
			    </div>
				<div class="btn-group toggle-btn-group" data-toggle="buttons">
					<label class="btn  active">
						<input type="radio" name="private" id="sharedfalse" ><i class="fa fa-user"></i> Private
					</label>
					<label class="btn ">
						<input type="radio" name="public" id="sharedtrue"><i class="fa fa-user"></i> Public
					</label>
				</div>
			    <button type="submit" class="btn btn-primary">Save Search</button>
			  <?php echo form_close(); ?>
			<?php endif; ?>
		<?php endif; ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<ul class="pager">
		<?php if($previous_page_number): ?>
	  	<li class="previous"><a href="?page_num=<?php echo $previous_page_number; ?>">&larr; Previous</a></li>
	    <?php endif; ?>
        <span class="count_of_results">
Page <?php echo $current_page_number; ?> of <?php echo $page_total ?>
</span>
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