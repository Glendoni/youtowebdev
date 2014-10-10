<?php  $company = $companies[0]; 
 // print_r('<pre>');print_r($company);print_r('</pre>');
?>
<style>
.mic-info { color: #666666;font-size: 11px;margin-top: 5px; }


.triangle-isosceles {
  position:relative;
  padding:15px;
  margin:1em 0 3em;
  color:#000;
  -webkit-border-radius:5px;
  -moz-border-radius:5px;
  border-radius:5px;
}

/* Variant : for top positioned triangle
------------------------------------------ */

.triangle-isosceles.top {
	border:#d1d1d1 1px solid;
}
/* creates triangle */
.triangle-isosceles:after {
  content:"";
  position:absolute;
  bottom:-15px; /* value = - border-top-width - border-bottom-width */
  left:50px; /* controls horizontal position */
  border-width:15px 15px 0; /* vary these values to change the angle of the vertex */
  border-style:solid;
  border-color:#f3961c transparent;
  /* reduce the damage in FF3.0 */
  display:block;
  width:0;
}
.triangle-isosceles.top:after {
  top:-15px; /* value = - border-top-width - border-bottom-width */
  left:50px; /* controls horizontal position */
  bottom:auto;
  left:auto;
  border-width:0 15px 15px; /* vary these values to change the angle of the vertex */
  border-color:#d1d1d1 transparent;
}

</style>
<div class="row page-results-list">
	<h2 class="page-header">
	<?php echo $company['name']; ?>
	<?php if (isset($company['url'])): ?>
	<a class="btn btn-link" href="<?php $parsed = parse_url($company['url']); if (empty($parsed['scheme'])) { $company['url'] = 'http://' . ltrim($company['url'], '/'); echo $company['url'];}else{ echo $company['url']; } ?>" target="_blank"><?php echo $company['url'] ?></a>
	<?php endif; ?>
	</h2>
	<?php $this->load->view('companies/edit_box.php',array('company'=>$company)); ?>

<div class="panel <?php if(isset($company['assigned_to_name'])): ?> panel-primary <?php else: ?> panel-default <?php endif; ?> company">
	<?php if(isset($company['assigned_to_name'])): ?>
	<div class="panel-heading text-center" >
        <span class="assigned-image-holder" style="max-width:30px; float:left;"><img src="<?php echo asset_url();?>images/profiles/<?php echo isset($system_users_images[$company['assigned_to_id']])? $system_users_images[$company['assigned_to_id']]:'none' ;?>.jpg" class="img-circle img-responsive" alt="" /></span>
        <span style="line-height:28px;">
        Assigned to <?php echo $company['assigned_to_name']; ?> 
        </span>    
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
			<?php if (isset($company['class'])): ?>
				<h3><span class="label label-info"><?php echo $companies_classes[$company['class']] ?></span></h3>
			<?php endif; ?>
			<h3 class="name">
				Address
			</h3>
			<small><?php echo $company['address']; ?> 
			<?php if (isset($company['address_lat']) and isset($company['address_lng'])): ?>
			<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#map_<?php echo $company['id']; ?>">
			  map
			</button> 
			</small>
			
			<div class="modal fade" id="map_<?php echo $company['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="Map">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			        <h4 class="modal-title"><?php echo $company['name']; ?></h4>
			      </div>
			      <div class="modal-body">
			        <iframe width="500" height="400" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $company['address_lat']; ?>,<?php echo $company['address_lng']; ?>&key=AIzaSyAwACBDzfasRIRmwYW0KJ4LyFD4fa4jIPg&zoom=16"></iframe>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
			<?php endif; ?>
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
		<div class="col-md-3 centre">
			<strong>Employees</strong>
			<?php if (isset($company['emp_count'])): ?>
			<h3 class="details"><strong><span class="label label-info"><?php echo $company['emp_count'];?> </span></strong></h3>
			<?php endif; ?>
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
					<th class="col-md-2">Started</th>
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
	<div class="col-md-6">
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
			<textarea class="form-control" name="comment" rows="8"></textarea>
		</div>
		<div class="form-group " >
		<label> </label>
		<button type="submit" name="save" class="btn btn-success form-control">Save</button>
		</div>
		<?php echo form_close(); ?>
	  </div>
	</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-info">
		  <div class="panel-heading">
		    <h3 class="panel-title">Follow Up</h3>
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
					<label>Planned For</label>
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
	<div class="col-md-12" >
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h3 class="panel-title">Actions</h3>
			</div>
			<div class="panel-body">
				<?php if (count($actions) > 0): ?>
					<ul class="list-group">
					<?php foreach ($actions as $action): 
					 // print_r('<pre>');print_r($action);print_r('</pre>');
					 $created_date_formatted = date("l jS F y",strtotime($action->created_at))." @ ".date("H:i",strtotime($action->created_at));
					 $actioned_date_formatted = date("l jS F y",strtotime($action->actioned_at))." @ ".date("H:i",strtotime($action->actioned_at));
					 $planned_date_formatted = date("l jS F y",strtotime($action->planned_at))." @ ".date("H:i",strtotime($action->planned_at));
					 $cancelled_at_formatted = date(" jS F y",strtotime($action->cancelled_at))." @ ".date("H:i",strtotime($action->cancelled_at));
					 $now = date(time());

					?>

                    <li class="list-group-item">
                        <div class="row" style="padding: 15px 0">
                            <div class="col-xs-2 col-md-1">
                                <img src="<?php echo asset_url();?>images/profiles/<?php echo isset($system_users_images[$action->user_id])? $system_users_images[$action->user_id]: 'none' ;?>.jpg " class="img-circle img-responsive" alt="" /></div>
                            <div class="col-xs-10 col-md-11">
                                <div>
                                    <h4 style="margin:0;"><?php echo $action_types_array[$action->action_type_id]; ?> 
                                    <?php if($action->cancelled_at) : ?>
                                  		<span class="label label-default" style="font-size:11px; margin-left:10px;">Cancelled on <?php echo $cancelled_at_formatted ?></span>
                                  	<?php elseif(strtotime($action->planned_at) > $now and !isset($action->actioned_at)) : ?>
                                  		<span class="label label-warning" style="font-size:11px; margin-left:10px;">Due on <?php echo $planned_date_formatted ?> </span>
									<?php elseif(strtotime($action->planned_at) < $now and !isset($action->actioned_at)):?>
                                  		<span class="label label-danger" style="font-size:11px; margin-left:10px;"><b>Overdue</b> - Due on <?php echo $planned_date_formatted ?> </span>
                                   	<?php elseif($action->actioned_at): ?>
                                   		<span class="label label-success" style="font-size:11px; margin-left:10px;">Completed on <?php echo $actioned_date_formatted ?></span>
									<?php endif; ?>
						  			</h4>
                                    <div class="mic-info">
                                        Created By: <?php echo $system_users[$action->user_id]?> on <?php echo $created_date_formatted?>
                                    </div>
                                </div>
                                
								<?php if (!empty($action->comments)):?>
								<div class="comment-text speech" style="margin-top: 30px;">
                                <div class="triangle-isosceles top">
									<?php echo $action->comments ?>
								</div>
								</div>
								<?php endif; ?>
								</div><!--END ACTIONS-->   
                            </div> 
                    </li>
                    <?php endforeach ?>
                    </ul>
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
</div>

