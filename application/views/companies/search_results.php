<div class="row page-results-list">
	<nav class="navbar navbar-default companies-list-header" role="navigation">
	  <div class="container-fluid">
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	      <?php if($current_campaign_name && $current_campaign_owner_id && $current_campaign_id ): ?>
	      	<li><p class="navbar-text"><?php if($current_campaign_is_shared == False): ?><span class="label label-danger">Private</span><?php else: ?> <span class="label label-success">Shared</span> <?php endif;?>  <?php echo $current_campaign_name ?> <small>| <?php echo $companies_count; ?></small></p></li>
	      <?php else: ?> 
	      	<li><p class="navbar-text">Companies | <strong><?php echo $companies_count; ?></strong></p></li>
	      <?php endif; ?>
	        
	      </ul>
	      
	      <ul class="nav navbar-nav navbar-right">
	      <?php if(($companies_count > 0)): ?>
	      	<?php if($current_campaign_name && $current_campaign_owner_id && $current_campaign_id ): ?>
				<?php if($current_campaign_editable): ?>
				<li class="dropdown">
				<a href="#" class="dropdown-toggle " data-toggle="dropdown">edit <span class="caret"></span></a>
				<ul class="dropdown-menu campaing_edit_options" role="menu">
				<?php echo form_open(site_url().'campaigns/edit', 'name="edit_campaign" role="form"'); echo form_hidden('campaign_id', $current_campaign_id); ?>
					<?php if($current_campaign_is_shared == False): ?>
					<li><button type="submit" class="btn btn-warning btn-sm  btn-block" name="make_public" >Make public</button></li>
					<?php else: ?>
					<li><button type="submit" class="btn btn-warning btn-success btn-sm  btn-block" name="make_private" >Make private</button></li>
					<?php endif; ?>
					<li class="divider"></li>
					<li><button type="submit" class="btn btn-danger btn-sm btn-block" name="delete" >Delete</button></li>
				<?php echo form_close(); ?>
				</ul>
				</li>
				<?php else: ?>
				<h4><?php echo $current_campaign_name;?></h4>	
				<?php endif; ?>
			
			<?php else: ?>
			<li>
			<?php echo form_open(site_url().'campaigns/create', 'name="create_campaign" class="create_campaign navbar-form navbar-left" role="form"'); ?>
			 	<div class="form-group">
					<input type="text" name="name" class="form-control" id="name" placeholder="Save search">
			    </div>
				<div class="btn-group toggle-btn-group" data-toggle="buttons">
					<label class="btn  active">
						<input type="radio" name="private" id="sharedfalse" > private
					</label>
					<label class="btn ">
						<input type="radio" name="public" id="sharedtrue">  public
					</label>
				</div>
			    <button type="submit" class="btn btn-primary">Save</button>
			  <?php echo form_close(); ?>
			</li>
			<?php endif; ?>
		<?php endif; ?>
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