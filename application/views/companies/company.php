<div class="row page-results-list">
	<h1 class="page-header"><?php echo $company->name; ?></h1>
	<div class="panel <?php if(isset($company->company_assigned_to)): ?> panel-primary <?php else: ?> panel-default <?php endif; ?> ">
		<?php if(isset($company->company_assigned_to)): ?>
		<div class="panel-heading text-center" >
            Assigned to <?php echo $company->company_assigned_to; ?> 
        </div>
		<?php endif; ?>
		<div class="panel-body">
			<div class="col-md-12">
				<h3 class="name">
					
						<?php echo $company->name; ?>
					
				</h3>
				<small><?php echo $company->address; ?> </small>
			</div>
			
			<div class="col-md-12">
				<hr>
			</div>
			
			<!-- TURNOVER -->
			<div class="col-md-3 centre"><small>Turnover</small>
				<h3 class="details">
					<strong>£ <?php echo number_format($company->turnover); ?></strong>
					<br>
					<small><?php $methods = unserialize (TURNOVER_METHODS); echo $methods[$company->turnover_method]?></small>
				</h3>
				<small>Founded</small>
				<h5 class="details"><strong><?php echo $company->eff_from ?></strong></h5>
			</div>

			<!-- EMPLOYEES -->
			<div class="col-md-3 centre"><small>Employees</small>
				<h3 class="details"><?php  echo  ($company->emp_count)? '<strong><span class="label label-info">'.$company->emp_count.'</span></strong>' : '<span class="label label-warning">Unknown</span>' ?> </h3>
				<small>LinkedIn Connections</small>
				<h3 class="details"><strong><span class="label label-info"><?php echo $company->company_connections ?></span> </strong></h3>

			</div>

			<!-- SECTORS -->
			<div class="col-md-3 centre">
				<small>Sectors</small> 
				<?php $company_sectors = explode(",",$company->company_sectors);
				foreach ($company_sectors as $sector) {
					echo '<h5>'.$sector.'</h5>';
				}?>
			</div>

			<!-- LINKS AND BTN -->
			<div class="col-md-3">
				<?php if ($company->ddlink): ?>
				<a class="btn btn-outline btn-info btn-sm btn-block" href="<?php echo $company->ddlink ?>" target="_blank">View on Duedil</a>
				<?php endif; ?>
				<?php if ($company->linkedin_id): ?>
				<a class="btn btn-outline btn-info btn-sm btn-block" href="https://www.linkedin.com/company/<?php echo $company->linkedin_id ?>"  target="_blank">View on LinkedIn</a>
				<?php endif; ?>
				<?php if ($company->url): ?>
				<a class="btn btn-outline btn-info btn-sm btn-block" href="<?php echo $company->url ?>" target="_blank">Visit Website</a>
				<?php endif; ?>
				<?php if(isset($company->company_assigned_to) and !empty($company->company_assigned_to)): ?>
					<?php echo $company->company_assigned_to_id; echo $current_user['id']; if($company->company_assigned_to_id == $current_user['id']) : ?>			
						<?php  $hidden = array('company_id' => $company->id , 'user_id' => $current_user['id'], 'page_number' => $current_page_number );
						echo form_open('companies/unassign',array('style' => 'margin-top: 5px;', 'name' => 'assignto', 'class'=>'assign-to-form'),$hidden); ?>
						<button type="submit" class="btn btn-sm btn-primary btn-block ladda-button" data-style="expand-right" data-size="1">
						    <span class="ladda-label"> Unassign </span>
						</button>
						<?php echo form_close(); ?>
					<?php else: ?>
						<a class="btn btn-sm btn-primary btn-block" disabled="disabled"><?php  echo 'Assigned to '.$company->company_assigned_to; ?></a>
					<?php endif; ?>

				<?php else: ?>
				<?php 
				$hidden = array('company_id' => $company->id , 'user_id' => $current_user['id'], 'page_number' => $current_page_number );
				echo form_open('companies/assignto',array('style' => 'margin-top: 5px;', 'name' => 'assignto', 'class'=>'assign-to-form'),$hidden); ?>
				<button type="submit" assignto="<?php echo $current_user['name']; ?>" class="btn btn-sm btn-primary btn-block ladda-button" data-style="expand-right" data-size="1">
			        <span class="ladda-label"> Assign </span>
			    </button>
				<?php echo form_close(); ?>
				<?php endif; ?>
			</div>
					
			<!-- MORTGAGES -->
			
			<div class="col-md-12">
			<?php if(!empty($company->mortgages)): ?>
				<table class="table table-hover" style="margin-top:10px;">
				<thead>
					<tr>
						<th class="col-md-7">Provider</th>
						<th class="col-md-3">Status</th>
						<th class="col-md-2">Start Date</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($company->mortgages as $mortgage):?>
					<tr <?php echo $mortgage['stage']==MORTGAGES_SATISFIED? 'class="danger"' : 'class="success"' ?> >
						<td class="col-md-7" ><?php echo $mortgage['name']; ?></td>
						<td class="col-md-3"><?php echo $mortgage['stage']; ?></td>
						<td class="col-md-2"><?php echo $mortgage['eff_from']; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
				<?php else: ?>
				<div class="alert alert-info" style="margin-top:10px;">
	                No mortgage data registered.
	            </div>
			<?php endif; ?>
			</div>
		</div>
	</div>
</div>