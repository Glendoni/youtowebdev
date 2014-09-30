<?php  $company = $companies[0]; 
 // print_r('<pre>');print_r($company);print_r('</pre>');
?>

<div class="row page-results-list">
	<h2 class="page-header">
		
	<?php echo $company['name']; ?>

	<?php if (isset($company['url'])): ?>
	<a class="btn btn-link" href="<?php $parsed = parse_url($company['url']); if (empty($parsed['scheme'])) { $company['url'] = 'http://' . ltrim($company['url'], '/'); echo $company['url'];}else{ echo $company['url']; } ?>" target="_blank"><?php echo $company['url'] ?></a>
	<?php endif; ?>
	</h2>
	<div class="modal fade" id="editModal<?php echo $company['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="Edit <?php echo $company['name']; ?>" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        	<?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'edit_company'=>'1' );
				 echo form_open(site_url().'companies/edit', 'name="edit_company" class="edit_company" role="form"',$hidden); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Edit <?php echo isset($company['name'])?$company['name']:'';; ?></h4>
            </div>
            <div class="modal-body">
				<!-- <div class="">
                    <div class=" form-group ">
                        <label for="turnover" class="control-label">Turnover</label>                            
                        <input type="text" name="turnover" value="<?php echo $company['turnover']; ?>" id="turnover" maxlength="50" class="form-control">
                    </div>
                </div> -->
                <div class="">
                    <div class=" form-group ">
                        <label for="linkedin_id" class="control-label">Linkedin ID</label>                            
                        <input type="text" name="linkedin_id" value="<?php echo isset($company['linkedin_id'])?$company['linkedin_id']:''; ?>" id="linkedin_id" maxlength="50" class="form-control">
                    </div>
                </div>
                <div class="">
                    <div class=" form-group ">
                        <label for="url" class="control-label">Website</label>                            
                        <input type="text" name="url" value="<?php echo isset($company['url'])?$company['url']:''; ?>" id="url" maxlength="50" class="form-control">
                    </div>
                </div>
                <hr>
                <div class="">
	                <label for="url" class="control-label">Recruitment Type</label>
	                <div class="tag-holder">  
						<span class="button-checkbox" id="contract">
					        <button type="button" class="btn btn-default" data-color="primary" id="contract"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Contract</button>
							<input type="checkbox" name="contract" value="1" id="contract" class="hidden" <?php echo isset($company['contract'])? 'checked': '' ; ?> >							
						</span>
						<span class="button-checkbox" id="contract">
							<button type="button" class="btn btn-default" data-color="primary" id="permanent"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Permanent</button>
							<input type="checkbox" name="perm" value="1" id="permanent" class="hidden" <?php echo isset($company['perm'])? 'checked': '' ; ?> >
						</span>
					</div>
				</div>
				<hr>
				<div>
					<label for="url" class="control-label">Sectors</label>
					<div class="tag-holder">
					<?php 
						
					foreach ($sectors_array as $key => $value): ?>
						<span class="button-checkbox">
					        <button type="button" class="btn " data-color="primary" >&nbsp;<?php echo $value; ?></button>
					        <input type="checkbox" name="sectors[]" value="<?php echo $key; ?>" class="hidden" <?php echo isset($company['sectors']) and array_key_exists($key,$company['sectors'])? 'checked': '' ; ?>  />
					    </span>
					<?php endforeach ?>
					</div>
				</div>
				<div class="modal-loading-display text-center " id="loading-display-<?php echo $company['id']; ?>">
					<button class="btn btn-default btn-lg" ><i class="fa fa-refresh fa-spin"></i></button>
				</div>
			</div>
            <div class="modal-footer">
            	<button type="submit" class="btn btn-sm btn-primary btn-block ladda-button submit_btn" edit-btn="editbtn<?php echo $company['id']; ?>" loading-display="loading-display-<?php echo $company['id']; ?>" data-style="expand-right" data-size="1">
		        	<span class="ladda-label"> Save changes </span>
		    	</button>                
                
            </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="panel <?php if(isset($company['assigned_to_name'])): ?> panel-primary <?php else: ?> panel-default <?php endif; ?> company">
	<?php if(isset($company['assigned_to_name'])): ?>
	<div class="panel-heading text-center" >
        Assigned to <?php echo $company['assigned_to_name']; ?> 
    </div>
	<?php endif; ?>
	<div class="panel-body">
		<div class="col-md-12">
			<div class="pull-right assign-to-wrapper">
				<?php if(isset($company['assigned_to_name']) and !empty($company['assigned_to_name'])): ?>
					<?php if($company['assigned_to_id'] == $current_user['id']) : ?>			
						<?php  $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id']);
						echo form_open('companies/unassign',array('name' => 'assignto', 'class'=>'assign-to-form'),$hidden); ?>
						<button type="submit" class="btn  btn-primary  ladda-button" data-style="expand-right" data-size="1">
						    <span class="ladda-label"> Unassign from me </span>
						</button>
						<?php echo form_close(); ?>
					<?php else: ?>
						<button class="btn  btn-primary " disabled="disabled"><?php  echo 'Assigned to '.$company['assigned_to_name']; ?></button>
					<?php endif; ?>
				<?php else: ?>
				<?php 
				$hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'] );
				echo form_open(site_url().'companies/assignto',array('name' => 'assignto', 'class'=>'assign-to-form'),$hidden); ?>
				<button type="submit" assignto="<?php echo $current_user['name']; ?>" class="btn  btn-primary  ladda-button" data-style="expand-right" data-size="1">
			        <span class="ladda-label"> Assign to me </span>
			    </button>
				<?php echo form_close(); ?>
				<?php endif; ?>
				<button class="btn btn-warning ladda-button edit-btn" data-toggle="modal" id="editbtn<?php echo $company['id']; ?>" data-style="expand-right" data-size="1" data-target="#editModal<?php echo $company['id']; ?>">
                    <span class="ladda-label"> Edit </span>
                </button>
                
			</div>
			<h3 class="name">
				Address
			</h3>
			<small><?php echo $company['address']; ?> </small>
		</div>
		
		<div class="col-md-12">
			<hr>
		</div>
		
		<!-- TURNOVER -->
		<div class="col-md-3 centre">
		<strong>Turnover</strong>
			<h3 class="details">
				<strong>£<?php echo number_format (round($company['turnover'],-3));?></strong><br>
				<small><?php  echo $company['turnover_method']?></small>
			</h3>
			<h5>Founded</h5>
			<h5 class="details"><strong><?php echo $company['eff_from'] ?></strong></h5>
		</div>

		<!-- EMPLOYEES -->
		<div class="col-md-3 centre"><strong>Employees</strong>
			<h3 class="details"><?php  echo  (isset($company['emp_count']))? '<strong><span class="label label-info">'.$company['emp_count'].'</span></strong>' : '' ?> </h3>
			<!-- <small>LinkedIn Connections</small>
			<h3 class="details"><strong><span class="label label-info"></span> </strong></h3> -->

		</div>

		<!-- SECTORS -->
		<div class="col-md-3 centre">
			<strong>Sectors</strong> 
			<?php 
			if(isset($company['sectors'])){
				foreach ($company['sectors'] as $key => $name) {
					echo '<h5>'.$name.'</h5>';
				}
			}
			?>
		</div>

		<!-- LINKS AND BTN -->
		<div class="col-md-3">
			<?php if (isset($company['ddlink'])): ?>
			<a class="btn  btn-info btn-sm btn-block duedil" href="<?php echo $company['ddlink'] ?>" target="_blank">Duedil</a>
			<?php endif; ?>
			<?php if (isset($company['linkedin_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block linkedin" href="https://www.linkedin.com/company/<?php echo $company['linkedin_id'] ?>"  target="_blank">LinkedIn</a>
			<?php endif; ?>
		</div>
			
			<!-- MORTGAGES -->
			
			<div class="col-md-12">
			<?php if(!empty($company['mortgages'])): ?>
				<table class="table table-hover" style="margin-top:10px;">
				<thead>
					<tr>
						<th class="col-md-7">Provider</th>
						<th class="col-md-3">Status</th>
						<th class="col-md-2">Start Date</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($company['mortgages'] as $mortgage):?>
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

	<div class="row">
		<div class="col-md-9">
		<div class="panel panel-success ">
		  <div class="panel-heading">
		    <h3 class="panel-title">Done</h3>
		  </div>
		  <div class="panel-body">
		   <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id']);
					 echo form_open(site_url().'actions/create', 'name="create" class="form" role="form"',$hidden); ?>
			<div class="form-group ">
				<label>Type</label>
				<select name="action_type" class="form-control">
					<?php foreach($action_types_done as $action ): ?>
					  <option value="<?php echo $action->id; ?>"><?php echo $action->name; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group ">
				<label>Outcome</label>
				<textarea class="form-control" name="comment" rows="12"></textarea>
			</div>
			<div class="form-group " >
			<label> </label>
			<button type="submit" name="save" class="btn btn-success form-control">Save</button>
			</div>
			<?php echo form_close(); ?>
		  </div>
		</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-info">
			  <div class="panel-heading">
			    <h3 class="panel-title">Follow up</h3>
			  </div>
			  <div class="panel-body">
			   <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id']);
						 echo form_open(site_url().'actions/create', 'name="create" class="form" role="form"',$hidden); ?>
				<div class="">
					<div class="form-group ">
						<label>Type</label>
						<select name="action_type" class="form-control">
							<?php foreach($action_types_planned as $action ): ?>
							  <option value="<?php echo $action->id; ?>"><?php echo $action->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group " >
						<label>Planned for</label>
						<input type="text" class="form-control" id="planned_at" data-date-format="YYYY/MM/DD H:m" name="planned_at" placeholder="">
					</div>
					<div class="form-group ">
						<label>Note</label>
						<textarea class="form-control" name="comment" rows="6"></textarea>
					</div>
					<!-- <div class="form-group " >
						<label>Actioned</label>
						<input type="text" class="form-control" id="actioned_at" name="actioned_at" placeholder="">
					</div> -->

					<!-- <div class="form-group 	 window_completition" >
						<label>Window for completion </label>
						<input type="text" class="form-control " id="" name="window" placeholder="days">
					</div> -->
					<button type="submit" name="save" class="btn btn-primary form-control">Schedule</button>
				</div>
				<?php echo form_close(); ?>
			  </div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h3 class="panel-title">Actions</h3>
			</div>
			<div class="panel-body">
				<?php if (count($actions) > 0): ?>
					<table class="table">
						  <tr>
						  	<th>Created by</th>
						  	<th>Action type</th>
						  	<th>Comments</th>
						  	<th>Planned date</th>
						  	<th>Actioned date</th>
						  	<!-- <th>Window</th> -->
						  	<th>Cancelled date</th>
						  	<th>Last updated</th>
						  		
						  </tr>
					<?php foreach ($actions as $action): 
					 // print_r('<pre>');print_r($action);print_r('</pre>');

					?>
						  <tr <?php 
						  		if($action->cancelled_at)
                                  {
                                    echo 'class="danger"';
                                  }
                                  elseif($action->planned_at)
                                  {
                                    echo 'class="success"';
                                  }
                                  elseif($action->actioned_at)
                                  {
                                    echo 'class="warning"';
                                  }
						  		?>
						  	>
						  	<td><?php echo $system_users[$action->user_id]?></td>
						  	<td><?php echo $action_types_array[$action->action_type_id]; ?></td>
						  	<td><?php echo $action->comments;?></td>
						  	<td><?php echo $action->planned_at?></td>
						  	<td><?php echo $action->actioned_at?></td>
						  	<!-- <td><?php echo $action->window?></td> -->
						  	<td><?php echo $action->cancelled_at?></td>
						  	<td><?php echo $action->updated_at?></td>
						  </tr>
					<?php endforeach ?>
					</table>
				<?php else: ?>
					<div class="col-md-12">
					<hr>
						<h4>No actions found for this company</h4>
					</div>
				<?php endif; ?>
		  </div>
		</div>
	</div>
</div>

