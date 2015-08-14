<div class="row">
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

						<div style="font-weight:300; font-size:22px; margin-bottom: 20px; margin-top: -20px;">
						<strong>
						<?php if($current_campaign_is_shared == False): ?>
						Private
						<?php else: ?> 						
						Team
						<?php endif;?> <?php echo $results_type ?>:
						</strong>
						<?php echo $current_campaign_name; ?>
						</div>	
					<div class="row" style="margin-bottom: 20px;">
					<div class="col-md-2">
<div class="circle-responsive black-circle">
  <div class="circle-content mega">
<div class="large-number"><?php echo number_format($companies_count); ?></div> <div class="small-text"><?php if ($companies_count<> "1") {echo "Companies in List";} else { echo "Company in List";}?></div></div>
  </div>
</div>

<?php foreach($current_campaign_stats as $current_campaign_stats)
        {?>
<div class="col-md-2">
<div class="circle-responsive gray-circle">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_prospects; ?></div>
<div class="small-text"><?php if ($current_campaign_stats->campaign_prospects <> "1") {echo "Prospects";} else { echo "Prospect";}?></div></div>
</div>
</div>
<div class="col-md-2">
<div class="circle-responsive gray-circle">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_intent; ?></div>
<div class="small-text">Intent</div></div>
</div>
</div>
<div class="col-md-2">
<div class="circle-responsive gray-circle">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_proposals; ?></div>
<div class="small-text"><?php if ($current_campaign_stats->campaign_proposals <> "1") {echo "Proposals";} else { echo "Proposal";}?></div></div>
</div>
</div>
<div class="col-md-2">
<div class="circle-responsive green3-circle">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_customers; ?></div>
<div class="small-text"><?php if ($current_campaign_stats->campaign_customers <> "1") {echo "Customers";} else { echo "Customer";}?></div></div>
</div>
</div>
<div class="col-md-2">
<div class="circle-responsive red-circle">
<div class="circle-content mega">
<div class="large-number"><?php echo $current_campaign_stats->campaign_lost; ?></div>
<div class="small-text">Lost</div></div>
</div>
</div>


<?php
}
?>				
</div><!--END ROW-->
					
			</div>	
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
</div>