<div class="row">
	<?php foreach ( $companies_chunk as $company): ?>
<div class="panel panel-default">
	<div class="panel-body row">
		<?php if(isset($company->company_assignto)): ?>
		<div class="col-md-12">
			<div class="col-md-2 row">
				<div class="benefits-circle-text">
					<div class="benefits-circle-inner">
						<p>Assigned to</p>
						<h2><?php $names = explode( " ", $company->company_assignto ); echo $names[0][0].$names[1][0]; ?></h2>
					</div>
				</div>
			</div>
			<div class="col-md-10">
				<h3 class="name">
					<a href="/company/<?php echo $company->id;?>">
						<?php echo $company->name; ?>
					</a>
				</h3>
				<small><?php echo $company->address; ?> </small>
			</div>
		</div>
		<?php else: ?>
		<div class="col-md-12">
			<h3 class="name">
				<a href="/company/<?php echo $company->id;?>">
					<?php echo $company->name; ?>
				</a>
			</h3>
			<small><?php echo $company->address; ?> </small>
		</div>
		<?php endif; ?>
		<div class="col-md-3 centre"><small>Turnover</small>
			<h3 class="details"><strong>£ <?php echo number_format($company->turnover); ?></strong><br>
				<small><?php $methods = unserialize (TURNOVER_METHODS); echo $methods[$company->turnover_method]?></small></h3>
				<small>Founded</small>
				<h5 class="details"><strong><?php echo $company->eff_from ?></strong></h5>
			</div>
			<div class="col-md-3 centre"><small>Employees</small>
				<h3 class="details"><?php  echo  ($company->emp_coun)? '<strong><span class="label label-info">'.$company->emp_count.'</span></strong>' : '<span class="label label-warning">Unknown</span>' ?> </h3>
				<small>LinkedIn Connections</small>
				<h3 class="details"><strong><span class="label label-info"><?php echo $company->company_connections ?></span> </strong></h3>

			</div>
			<div class="col-md-3 centre">
				<small>Sectors</small> 
				
				<?php $company_sectors = explode(",",$company->company_sectors);
				foreach ($company_sectors as $sector) {
					echo '<h5>'.$sector.'</h5>';
				}?>
				
			</div>
			<div class="col-md-3">
				<a class="btn btn-danger btn-sm btn-block" href="<?php echo $company->ddlink ?>" target="_blank">View on Duedil</a>
				<?php if ($company->linkedin_id): ?>
				<a href="https://www.linkedin.com/company/<?php echo $company->linkedin_id ?>" class="btn linkedinbtn btn-sm base btn-block" target="_blank">View on LinkedIn</a>
				<?php endif; ?>
				<?php if ($company->url): ?>
				<a href="<?php echo $company->url ?>" class="btn btn-default btn-sm btn-block" target="_blank">Visit Website</a>
				<?php endif; ?>
				<!-- <a class="btn btn-sm btn-primary btn-block" disabled="disabled">Assigned to RL(pending)</a>
				<a href="includes/base-add.php?id=03688086" class="btn btn-success btn-sm base btn-block" target="_blank">Add to Base</a>
				<a href="includes/update-request.php?id=03688086&amp;user=11" class="btn btn-warning btn-sm update btn-block" target="_blank">Request Update</a>
				<input type="hidden" name="assign_user_id" value="11">
				<input type="hidden" name="assign_business_id" value=""> -->
			</div>
			<div class="col-md-12"><table class="table table-hover" style="margin-top:10px;">
				<thead>
					<tr>
						<th class="col-md-7">Provider</th>
						<th class="col-md-3">Status</th>
						<th class="col-md-2">Start Date</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($company->mortgages as $mortgage):?>
					<tr>
						<td class="col-md-7" ><?php echo $mortgage['name']; ?></td>
						<td class="col-md-3"><?php echo $mortgage['stage']; ?></td>
						<td class="col-md-2"><?php echo $mortgage['eff_from']; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>