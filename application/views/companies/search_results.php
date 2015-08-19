<div class="page-results-list">
		<ul class="pager">
		<div class="col-xs-2">
		<?php if($previous_page_number): ?>
	  	<li class="previous">
	  		<a href="?page_num=<?php echo $previous_page_number; ?>">&larr; Previous</a>
	  	</li>
	    <?php endif; ?>
		</div>
		<div class="col-xs-8 ">
        <span class="count_of_results">
				<?php if($current_campaign_name && $current_campaign_owner_id && $current_campaign_id ): ?>
				<?php else: ?>
				<?php echo number_format($companies_count); ?> <?php if ($companies_count<> "1") {echo "Companies";} else { echo "Company";}?>
				<?php endif; ?>
				<?php if($previous_page_number or $next_page_number): ?><span style="font-size:15px; font-weight:700;"> Page <?php echo $current_page_number; ?> of <?php echo $page_total ?> </span><?php endif; ?>
		</span>
		</div>    
	<div class="col-xs-2">
	    <?php if($next_page_number): ?>
	  	<li class="next">
	  		<a href="?page_num=<?php echo $next_page_number; ?>">Next &rarr;</a>
	  	</li>
		<?php endif; ?>
		</div>
	</ul>

	  <div class="container-fluid">
	    <!-- Collect the nav links, forms, and other content for toggling -->
		<div style="text-align:center;">
	      	<?php if(($companies_count > 0)): ?>
				<?php if($current_campaign_name && $current_campaign_owner_id && $current_campaign_id ): ?>
					<?php foreach($current_campaign_stats as $current_campaign_stats)
        {?>
						<div style="font-weight:300; font-size:22px; margin-bottom: 20px; margin-top: -20px;">
						<strong>
						<?php if($current_campaign_is_shared == False): ?>
						<?php else: ?>
						 <?php foreach($current_campaign_owners as $current_campaign_owner):
echo "<div style='font-size:12px;'>Owned by ".$current_campaign_owner->username."</div>"; endforeach ?>					
						<?php endif;?> <?php echo $results_type ?>:
						</strong>
						<?php echo $current_campaign_name; ?>
						<p style="font-size:14px"><?php echo $current_campaign_stats->description; ?></p>

						</div>	
					<div class="row" style="margin-bottom: 20px;">

<div class="col-sm-12 mobile-hide">
</div>
<div class="col-sm-2 mobile-hide">
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->id; ?>">
<div class="circle-responsive black-circle <?php echo empty($this->session->userdata('pipeline'))? 'active':'';?>"><div class="circle-content mega">
<div class="large-number"><?php echo number_format($current_campaign_stats->campaign_total); ?></div> <div class="small-text"><?php if ($companies_count<> "1") {echo "Companies in List";} else { echo "Company in List";}?></div></div>
</div>
</a>
</div>

<div class="col-sm-2 mobile-hide">
<?php if ($current_campaign_stats->campaign_prospects>0): ?>
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->id; ?>&pipeline=prospect">
<?php else: endif; ?>
<div class="circle-responsive gray-circle <?php if ($this->session->userdata('pipeline')=='prospect'): echo 'active';else: endif; ?>
">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_prospects; ?></div>
<div class="small-text"><?php if ($current_campaign_stats->campaign_prospects <> "1") {echo "Prospects";} else { echo "Prospect";}?></div></div>
</div>
<?php if ($current_campaign_stats->campaign_prospects>0): ?>
</a><?php else: endif; ?>
</div>
<div class="col-sm-2 mobile-hide">
<?php if ($current_campaign_stats->campaign_intent>0): ?>
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->id; ?>&pipeline=intent">
<?php else: endif; ?>
<div class="circle-responsive gray-circle <?php if ($this->session->userdata('pipeline')=='intent'): echo 'active';else: endif; ?>">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_intent; ?></div>
<div class="small-text">Intent</div></div>
</div>
<?php if ($current_campaign_stats->campaign_intent>0): ?>
</a>
<?php else: endif; ?>
</div>
<div class="col-sm-2 mobile-hide">
<?php if ($current_campaign_stats->campaign_proposals>0): ?>
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->id; ?>&pipeline=proposal">
<?php else: endif; ?>
<div class="circle-responsive blue-circle <?php if ($this->session->userdata('pipeline')=='proposal'): echo 'active';else: endif; ?>">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_proposals; ?></div>
<div class="small-text"><?php if ($current_campaign_stats->campaign_proposals <> "1") {echo "Proposals";} else { echo "Proposal";}?></div></div>
</div>
<?php if ($current_campaign_stats->campaign_proposals>0): ?>
</a>
<?php else: endif; ?>
</div>
<div class="col-sm-2 mobile-hide">
<?php if ($current_campaign_stats->campaign_customers>0): ?>
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->id; ?>&pipeline=customer">
<?php else: endif; ?>
<div class="circle-responsive green3-circle <?php if ($this->session->userdata('pipeline')=='customer'): echo 'active';else: endif; ?>">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_customers; ?></div>
<div class="small-text"><?php if ($current_campaign_stats->campaign_customers <> "1") {echo "Customers";} else { echo "Customer";}?></div></div>
</div>
<?php if ($current_campaign_stats->campaign_customers>0): ?>
</a><?php else: endif; ?>
</div>
<div class="col-sm-2 mobile-hide">
<?php if ($current_campaign_stats->campaign_lost>0): ?>
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->id; ?>&pipeline=lost">
<?php else: endif; ?>

<div class="circle-responsive red-circle">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_lost; ?></div>
<div class="small-text">Lost</div></div>
</div>
<?php if ($current_campaign_stats->campaign_lost>0): ?>
</a>
<?php else: endif; ?>
</div>


<?php
}
?>
		
</div><!--END ROW-->
					
<?php else: ?>
<?php endif; ?>					
<?php endif; ?>
</div><!-- /.row -->


	
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
