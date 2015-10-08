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
						$user_icon = explode(",", ($current_campaign_owner->image)); echo "<div style='margin-bottom:5px;'><div class='label' style='text-align: center;font-weight: 300; font-size:12px;background-color:".$user_icon[1]."; color:".$user_icon[2].";'>Owned by ".$current_campaign_owner->username."</div></div>"
						; endforeach ?>		
						<?php endif;?>
						</strong>
						<?php echo $current_campaign_name; ?>
					<?php if(!empty($current_campaign_stats->description)): ?>

						<p style="font-size:14px"><?php echo $current_campaign_stats->description; ?></p>
												<?php endif;?>

						<div><a class="btn btn-info btn-xs" href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_id; ?>">Refresh</a></div>

						</div>	
<div class="row" style="margin-bottom: 20px;">
<div class="col-sm-12 mobile-hide">
</div>
<div class="col-sm-2 mobile-hide">
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->campaign_id; ?>">
<div class="circle-responsive black-circle <?php echo empty($this->session->userdata('pipeline'))? 'active':'';?>"><div class="circle-content mega">
<div class="large-number"><?php echo number_format($current_campaign_stats->campaign_total); ?></div> <div class="small-text"><?php if ($companies_count<> "1") {echo "Companies in $results_type";} else { echo "Company in $results_type";}?></div>
</div>
</div>
</a>
<div class="small-text" style="font-weight:300; font-size:9px; max-width:80%; margin-left:auto; margin-right:auto;"><?php if ($current_campaign_stats->campaign_unsuitable > "0") {echo "Includes ".$current_campaign_stats->campaign_unsuitable." marked as unsuitable";} else {}?></div>
</div>
<div class="col-sm-2 mobile-hide">
<div class="circle-responsive cyan-circle ">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->contacted; ?>%</div>
<div class="small-text">Contacted</div>


</div>
</div>
<div class="small-text" style="font-weight:300; font-size:9px; max-width:80%; margin-left:auto; margin-right:auto;"><?php if ($current_campaign_stats->campaign_unsuitable > "0") {echo "Companies marked as Unsuitable are not included in this figure";} else {}?></div>
</div>
<div class="col-sm-2 mobile-hide">
<?php if ($current_campaign_stats->campaign_prospects>0): ?>
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->campaign_id; ?>&pipeline=prospect">
<?php else: endif; ?>
<div class="circle-responsive prospect-circle <?php if ($this->session->userdata('pipeline')=='prospect'): echo 'Prospect active';else: endif; ?>
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
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->campaign_id; ?>&pipeline=intent">
<?php else: endif; ?>
<div class="circle-responsive intent-circle <?php if ($this->session->userdata('pipeline')=='intent'): echo 'Intent active';else: endif; ?>">
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
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->campaign_id; ?>&pipeline=proposal">
<?php else: endif; ?>
<div class="circle-responsive proposal-circle <?php if ($this->session->userdata('pipeline')=='proposal'): echo 'active';else: endif; ?>">
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
<a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $current_campaign_stats->campaign_id; ?>&pipeline=customer">
<?php else: endif; ?>
<div class="circle-responsive customer-circle <?php if ($this->session->userdata('pipeline')=='customer'): echo 'active';else: endif; ?>">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_customers; ?></div>
<div class="small-text"><?php if ($current_campaign_stats->campaign_customers <> "1") {echo "Customers";} else { echo "Customer";}?></div></div>
</div>
<?php if ($current_campaign_stats->campaign_customers>0): ?>
</a><?php else: endif; ?>
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
