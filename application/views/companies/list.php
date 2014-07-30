<div class="row">
	<?php foreach ( $companies_chunk as $company): print_r($company);?>
	<div class="panel panel-default">
		<div class="panel-body row">
			<div class="col-md-12">
				<div class="col-md-2 row">
				<div class="benefits-circle-text">
					<div class="benefits-circle-inner">
						<p>Assigned to</p>
						<h2>RL</h2>
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
		<div class="col-md-3 centre"><small>Turnover</small>
			<h3 class="details"><strong>£ <?php echo number_format($company->turnover); ?></strong><br>
				<small>Type(pending)</small></h3>
				<small>Founded</small>
				<h5 class="details"><strong><?php echo $company->eff_from ?></strong></h5>
			</div>
			<div class="col-md-3 centre"><small>Employees</small>
				<h3 class="details"><strong><span class="label label-info"><?php echo $company->emp_count ?></span> </strong></h3>
				<small>LinkedIn Connections</small>
				<h3 class="details"><strong><span class="label label-info">(pending)</span> </strong></h3>

			</div>
			<div class="col-md-3 centre"><small>Sectors</small> <h5>IT</h5>
			</div>
			<div class="col-md-3">
				<a class="btn btn-danger btn-sm btn-block" href="https://www.duedil.com/company/03688086" target="_blank">View on Duedil</a><a href="https://www.linkedin.com/company/97535" class="btn linkedinbtn btn-sm base btn-block" target="_blank">View on LinkedIn</a>
				<a href="http://www.acumin.co.uk" class="btn btn-default btn-sm btn-block" target="_blank">Visit Website</a><a class="btn btn-sm btn-primary btn-block" disabled="disabled">Assigned to RL</a><a href="includes/base-add.php?id=03688086" class="btn btn-success btn-sm base btn-block" target="_blank">Add to Base</a><a href="includes/update-request.php?id=03688086&amp;user=11" class="btn btn-warning btn-sm update btn-block" target="_blank">Request Update</a>
				<input type="hidden" name="assign_user_id" value="11">
				<input type="hidden" name="assign_business_id" value="">
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

					<tr class="">
						<td class="col-md-7">BARCLAYS BANK PLC</td>
						<td class="col-md-3">Outstanding</td>
						<td class="col-md-2">29/09/2005</td>
					</tr></tbody>
				</table>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>