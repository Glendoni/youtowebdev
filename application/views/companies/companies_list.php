
<?php foreach ( $companies as $company): ?>
<div class="modal fade" id="editModal<?php echo $company->id; ?>" tabindex="-1" role="dialog" aria-labelledby="Edit <?php echo $company->name; ?>" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        	<?php $hidden = array('company_id' => $company->id , 'user_id' => $current_user['id'], 'page_number' => $current_page_number,'edit_company'=>'1' );
				 echo form_open(site_url().'companies/edit', 'name="edit_company" class="edit_company" role="form"',$hidden); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Edit <?php echo $company->name; ?></h4>
            </div>
            <div class="modal-body">
				<!-- <div class="">
                    <div class=" form-group ">
                        <label for="turnover" class="control-label">Turnover</label>                            
                        <input type="text" name="turnover" value="<?php echo $company->turnover; ?>" id="turnover" maxlength="50" class="form-control">
                    </div>
                </div> -->
                <div class="">
                    <div class=" form-group ">
                        <label for="linkedin_id" class="control-label">Linkedin ID</label>                            
                        <input type="text" name="linkedin_id" value="<?php echo $company->linkedin_id; ?>" id="linkedin_id" maxlength="50" class="form-control">
                    </div>
                </div>
                <div class="">
                    <div class=" form-group ">
                        <label for="url" class="control-label">Website</label>                            
                        <input type="text" name="url" value="<?php echo $company->url; ?>" id="url" maxlength="50" class="form-control">
                    </div>
                </div>
                <hr>
                <div class="">
	                <label for="url" class="control-label">Recruitment Type</label>
	                <div class="tag-holder">  
						<span class="button-checkbox" id="contract">
					        <button type="button" class="btn btn-default" data-color="primary" id="contract"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Contract</button>
							<input type="checkbox" name="contract" value="1" id="contract" class="hidden" <?php echo $tcompany->contract? 'checked': '' ; ?> >
							
						</span>
						<span class="button-checkbox" id="contract">
							<button type="button" class="btn btn-default" data-color="primary" id="permanent"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Permanent</button>
							<input type="checkbox" name="perm" value="1" id="permanent" class="hidden" <?php echo $tcompany->perm? 'checked': '' ; ?> >
						</span>
					</div>
				</div>
				<hr>
				<div>
					<label for="url" class="control-label">Sectors</label>
					<div class="tag-holder">

					<?php 
					$array_sectors = explode(',', $company->company_sectors_ids);	
					foreach ($sectors_array as $key => $value): ?>
						<span class="button-checkbox">
					        <button type="button" class="btn " data-color="primary" >&nbsp;<?php echo $value; ?></button>
					        <input type="checkbox" name="sectors[]" value="<?php echo $key; ?>" class="hidden" <?php echo in_array($key,$array_sectors)? 'checked': '' ; ?>  />
					    </span>
					<?php endforeach ?>
					</div>
				</div>
			</div>
            <div class="modal-footer">
            	<button type="submit" class="btn btn-sm btn-primary btn-block ladda-button submit_btn" edit-btn="editbtn<?php echo $company->id; ?>" data-style="expand-right" data-size="1">
		        	<span class="ladda-label"> Save changes </span>
		    	</button>                
                <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
            </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="panel <?php if(isset($company->company_assigned_to)): ?> panel-primary <?php else: ?> panel-default <?php endif; ?> ">
	<?php if(isset($company->company_assigned_to)): ?>
	<div class="panel-heading text-center" >
        Assigned to <?php echo $company->company_assigned_to; ?> 
    </div>
	<?php endif; ?>
	<div class="panel-body">
		<div class="col-md-12">
			<div class="btn-group pull-right assign-to-wrapper">
				<?php if(isset($company->company_assigned_to) and !empty($company->company_assigned_to)): ?>
					<?php if($company->company_assigned_to_id == $current_user['id']) : ?>			
						<?php  $hidden = array('company_id' => $company->id , 'user_id' => $current_user['id'], 'page_number' => $current_page_number );
						echo form_open('companies/unassign',array('name' => 'assignto', 'class'=>'assign-to-form'),$hidden); ?>
						<button type="submit" class="btn  btn-primary  ladda-button" data-style="expand-right" data-size="1">
						    <span class="ladda-label"> Unassign from me </span>
						</button>
						<?php echo form_close(); ?>
					<?php else: ?>
						<button class="btn btn-sm btn-primary btn-block" disabled="disabled"><?php  echo 'Assigned to '.$company->company_assigned_to; ?></button>
					<?php endif; ?>
				<?php else: ?>
				<?php 
				$hidden = array('company_id' => $company->id , 'user_id' => $current_user['id'], 'page_number' => $current_page_number );
				echo form_open(site_url().'companies/assignto',array('name' => 'assignto', 'class'=>'assign-to-form'),$hidden); ?>
				<button type="submit" assignto="<?php echo $current_user['name']; ?>" class="btn  btn-primary  ladda-button" data-style="expand-right" data-size="1">
			        <span class="ladda-label"> Assign to me </span>
			    </button>
				<?php echo form_close(); ?>
				<?php endif; ?>
				<button class="btn btn-warning ladda-button edit-btn" data-toggle="modal" id="editbtn<?php echo $company->id; ?>" data-style="expand-right" data-size="1" data-target="#editModal<?php echo $company->id; ?>">
                    <span class="ladda-label"> Edit </span>
                </button>
                
			</div>
			<h3 class="name">
				<a href="<?php echo site_url();?>companies/company?id=<?php echo $company->id;?>">
					<?php echo $company->name; ?>
				</a>
				<?php if ($company->url): ?>
				<a class="btn btn-link" href="<?php echo $company->url ?>" target="_blank"><?php echo $company->url ?></a>
				<?php endif; ?>
			</h3>
			<small><?php echo $company->address; ?> </small>
		</div>
		
		<div class="col-md-12">
			<hr>
		</div>
		
		<!-- TURNOVER -->
		<div class="col-md-3 centre">
		<small>Turnover</small>
			<h3 class="details">
				<strong>£ <?php echo number_format($company->turnover); ?></strong>
				<br>
				<small><?php $methods = unserialize (TURNOVER_METHODS); echo $methods[$company->turnover_method]?></small>
			</h3>
			<h5>Founded</h5>
			<h5 class="details"><strong><?php echo $company->eff_from ?></strong></h5>
		</div>

		<!-- EMPLOYEES -->
		<div class="col-md-3 centre"><small>Employees</small>
			<h3 class="details"><?php  echo  ($company->emp_count)? '<strong><span class="label label-info">'.$company->emp_count.'</span></strong>' : '<span class="label label-warning">Unknown</span>' ?> </h3>
			<!-- <small>LinkedIn Connections</small>
			<h3 class="details"><strong><span class="label label-info"><?php echo $company->company_connections ?></span> </strong></h3> -->

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
			<a class="btn btn-outline btn-info btn-sm btn-block" href="<?php echo $company->ddlink ?>" target="_blank">Duedil</a>
			<?php endif; ?>
			<?php if ($company->linkedin_id): ?>
			<a class="btn btn-outline btn-info btn-sm btn-block" href="https://www.linkedin.com/company/<?php echo $company->linkedin_id ?>"  target="_blank">LinkedIn</a>
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
<?php endforeach; ?>