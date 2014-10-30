<?php  $company = $companies[0]; ?>
<div class="row page-results-list">
<div class="top-info-holder">
	<h2 class="company-header">
	<?php 
		$words = array( 'Limited', 'LIMITED', 'LTD','ltd','Ltd' );
		echo str_replace($words, ' ',$company['name']); 
	?>
	</h2>
	<?php if (isset($company['pipeline'])): ?>
	<span class="label pipeline-label label-<?php echo str_replace(' ', '', $companies_pipeline[$company['pipeline']]); ?>"><?php echo $companies_pipeline[$company['pipeline']] ?></span>
	<?php endif; ?>
	<!-- POPUP BOXES -->
	<?php $this->load->view('companies/edit_box.php',array('company'=>$company)); ?>
	<?php $this->load->view('companies/create_contact_box.php',array('company'=>$company)); ?>
	<!-- // POPUP BOXES -->
</div>
<div class="panel <?php if(isset($company['assigned_to_name'])): ?> panel-primary <?php else: ?> panel-default <?php endif; ?> company">
	<?php if(isset($company['assigned_to_name'])): ?>
	<div class="panel-heading text-center" >
        <span class="assigned-image-holder" style="max-width:30px; float:left;">
        	<img src="<?php echo asset_url();?>images/profiles/<?php echo isset($system_users_images[$company['assigned_to_id']])? $system_users_images[$company['assigned_to_id']]:'none' ;?>.jpg" class="img-circle img-responsive" alt="" />
        </span>
        <span style="line-height:28px;">
        Assigned to <?php echo $company['assigned_to_name']; ?> 
        </span>    
    </div>
	<?php endif; ?>
	<div class="panel-body">
    	<div class="row">
    	<div class="col-md-12">
        <div class="col-md-8 col-sm-6">
			<strong>
				Address
			</strong>
			<p style="margin-bottom:0;">
			<i class="fa fa-map-marker"></i>
			<a class="btn btn-link" style="padding-left:0px;" data-toggle="modal" data-target="#map_<?php echo $company['id']; ?>">
				<?php echo $company['address']; ?>
			</a>
			</p>
			<div class="modal fade" id="map_<?php echo $company['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="Map">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			        <h4 class="modal-title"><?php echo $company['name']; ?></h4>
			      </div>
			      <div class="modal-body">
			        <iframe width="670" height="400" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo urlencode($company['address']); ?>&key=AIzaSyAwACBDzfasRIRmwYW0KJ4LyFD4fa4jIPg&zoom=10"></iframe>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div><!--CLOSE MD-8-->
		<div class="col-md-4 col-sm-6">
			<?php $this->load->view('companies/actions_box.php',array('company'=>$company)); ?>
        </div><!--CLOSE COL-MD-4-->
        </div><!--CLOSE COL-MD-12-->
        </div><!--CLOSE ROW-->



		<div class="row">
		<div class="col-md-12">
			<div class="col-md-8 col-sm-4" style="margin-top:10px;">
    			<strong>Company Name</strong>
				<p style="margin-bottom:0;">	
				<?php echo $company['name']; ?>
         		</p>
    		</div>
    		<div class="col-sm-4" style="margin-top:10px;">
			<strong>Company Number</strong>
			<p style="margin-bottom:0;">	
			 <!--COMPANY NUMBER IF APPLICABLE-->
                <?php if (isset($company['registration'])): ?>
				<?php echo $company['registration']; ?>
				<?php else: ?>
				-
                <?php endif; ?>
         	</p>
        	</div>
        	<div class="col-sm-4" style="margin-top:10px;">
        		<strong>Phone Number</strong>
        		<p style="margin-bottom:0;">
        		<?php echo isset($company['phone'])?$company['phone']:'-'; ?>                
           		</p>
			</div>
    		<div class="col-sm-4" style="margin-top:10px;">
    			<strong>Website</strong>
    			<p style="margin-bottom:0;">
				<?php if (isset($company['url'])): ?>
				<a class="btn btn-link" style="padding:0;" href="<?php $parsed = parse_url($company['url']); if (empty($parsed['scheme'])) { echo 'http://' . ltrim($company['url'], '/'); }else{ echo $company['url']; } ?>" target="_blank"><i class="fa fa-home"></i>
				<?php echo str_replace("http://"," ",str_replace("www.", "", $company['url']))?>
				</a>
				<?php else: ?>
				-
            	<?php endif; ?>
            	</p>
			</div>
        	<div class="col-sm-4" style="margin-top:10px;">
				<strong>Segment</strong>
				<p style="margin-bottom:0;">	
		            <!--SEGMENT IF APPLICABLE-->
		            <?php if (isset($company['class'])): ?>
						<span class="label label-info"><?php echo $companies_classes[$company['class']] ?></span>	
					<?php else: ?>
						-
		            <?php endif; ?>
	            </p>
			</div>
			
        	</div>
        </div><!--END ROW-->
      
        



		<div class="col-md-12">
			<hr>
		</div>
		<!-- TURNOVER -->
		<div class="col-md-2 centre">
		<strong>Turnover</strong>
			<p class="details" style="margin-bottom:5px;">
				£<?php echo isset($company['turnover'])? number_format (round($company['turnover'],-3)):'0';?></p>
                <h6 style="margin-top:0;"><span class="label label-default" ><?php  echo isset($company['turnover_method'])?$company['turnover_method']:'';?></span></h6>		
            </div>
        <div class="col-md-2 centre">
        <strong>Founded</strong>
        <p class="details">
			<?php echo $company['eff_from'] ?>
        </p>
		</div>
		<!-- EMPLOYEES -->
		<div class="col-md-2 centre">
			<strong>Employees</strong>
			<?php if (isset($company['emp_count'])): ?>
			<p class="details"><?php echo $company['emp_count'];?> </p>
			<?php endif; ?>
		</div>

		<!-- SECTORS -->
		<div class="col-md-3 centre">
			<strong>Sectors</strong> 
			<?php 
			if(isset($company['sectors'])){
				foreach ($company['sectors'] as $key => $name) {
					echo '<p style="margin-bottom:0;">'.$name.'</p>';
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
			
        <div class="col-md-12">
			<hr>
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
		<div class="col-md-12">
			<hr style="padding-bottom:20px;">
		</div>
		<?php if(isset($contacts) and !empty($contacts)) : ?>
		<div class="col-md-12">
		<table class="table ">
	      <thead>
	        <tr>
	          <th>Role</th>
	          <th>Name</th>
	          <th>Email</th>
	          <th>Phone</th>
	          <th></th>
	        </tr>
	      </thead>
	      <tbody>
	      	<?php foreach ($contacts as $contact): ?>
	      	<tr>
				<td><?php echo $contact->role; ?></td>
				<td><?php echo $contact->name; ?></td>
				<td><?php echo $contact->email; ?></td>
				<td><?php echo $contact->phone; ?></td>
				<td>
				<span class="assigned-image-holder" style="max-width:30px; float:right;">
				<img src="<?php echo asset_url();?>images/profiles/<?php echo isset($system_users_images[$contact->created_by])? $system_users_images[$contact->created_by]:'none' ;?>.jpg" class="img-circle img-responsive" alt="" />
	        	</span>
	        	</td>
        	</tr>
			<?php endforeach; ?>  
	      </tbody>
	    </table>
		</div>
		<?php endif; ?>
		<div class="col-md-12">
			<hr style="padding-bottom:20px;">
		</div>
		<div class="col-md-6">
		<div class="panel panel-success ">
		  <div class="panel-heading">
		    <h3 class="panel-title">Done</h3>
		  </div>
		  <div class="panel-body">
		   <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'done'=>'1');
			echo form_open(site_url().'actions/create', 'name="create" class="form" role="form"',$hidden); ?>
			<div class="row">
			<div class="col-md-6">
				<div class="form-group ">
					<label>Type</label>
					<select name="action_type" class="form-control">
						<?php foreach($action_types_done as $action ): ?>
						  <option value="<?php echo $action->id; ?>"><?php echo $action->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<?php if(isset($contacts) and !empty($contacts)) : ?>
			<div class="col-md-6">
				<div class="form-group ">
					<label>Contact</label>
					<select name="contact_id" class="form-control">
						<option value=""></option>
						<?php foreach($contacts as $contact ): ?>
						  <option value="<?php echo $contact->id; ?>"><?php echo $contact->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<?php endif; ?>
			<div class="col-md-12">
				<div class="form-group ">
					<label>Outcome</label>
					<textarea class="form-control" name="comment" rows="6"></textarea>
				</div>
				<button type="submit" name="save" class="btn btn-success form-control">Save</button>
			</div>
			<?php echo form_close(); ?>
			</div>
		  </div>
		</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-info">
			  <div class="panel-heading">
			    <h3 class="panel-title">Follow Up</h3>
			  </div>
			  <div class="panel-body">
			   <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'follow_up'=>'1');
						 echo form_open(site_url().'actions/create', 'name="create" class="form" role="form"',$hidden); ?>
				<div class="row">
	            <div class="col-md-6">
					<div class="form-group ">
						<label>Type</label>
						<select name="action_type" class="form-control">
							<?php foreach($action_types_planned as $action ): ?>
							  <option value="<?php echo $action->id; ?>"><?php echo $action->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
	                </div>
	                <div class="col-md-6">
						<div class="form-group " >
							<label>Planned For</label>
							<input type="text" class="form-control" id="planned_at" data-date-format="YYYY/MM/DD H:m" name="planned_at" placeholder="">
						</div>
	                </div>
	                <?php if(isset($contacts) and !empty($contacts)) : ?>
	                <div class="col-md-6">
						<div class="form-group ">
							<label>Contact</label>
							<select name="contact_id" class="form-control">
								<option value=""></option>
								<?php foreach($contacts as $contact ): ?>
								  <option value="<?php echo $contact->id; ?>"><?php echo $contact->name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<?php endif; ?>
	                <div class="col-md-12">
						<div class="form-group ">
							<label>Note</label>
							<textarea class="form-control" name="comment" rows="6"></textarea>
						</div>
						<button type="submit" name="save" class="btn btn-primary form-control">Schedule</button>
				</div>
	            </div>
				<?php echo form_close(); ?>
			  </div>
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
                                  		<?php $hidden = array('action_id' => $action->id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled','outcome' => '' ,'company_id' => $company['id']);
					                    echo form_open(site_url().'actions/edit', 'name="cancel_action"  class="cancel_action pull-right" style="margin-left:5px;" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action->id.'" role="form"',$hidden); ?>
					                    <button class="btn btn-danger" ><i class="fa fa-trash-o fa-lg"></i> </button>
					                    <?php echo form_close(); ?>

                                  		<?php $hidden = array('action_id' => $action->id , 'user_id' => $current_user['id'], 'action_do' => 'completed', 'outcome' => '' ,'company_id' => $company['id']);
					               		echo form_open(site_url().'actions/edit', 'name="completed_action"  class="completed_action pull-right" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action->id.'" style="display:inline-block;" role="form"',$hidden); ?>
					                    <button class="btn btn-success"><i class="fa fa-check fa-lg"></i> </button> 
					                    <?php echo form_close(); ?>
									<?php elseif(strtotime($action->planned_at) < $now and !isset($action->actioned_at)):?>
                                  		<span class="label label-danger" style="font-size:11px; margin-left:10px;"><b>Overdue</b> - Due on <?php echo $planned_date_formatted ?> </span>
                                  		<?php $hidden = array('action_id' => $action->id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled','outcome' => '' ,'company_id' => $company['id'] );
					                    echo form_open(site_url().'actions/edit', 'name="cancel_action"  class="cancel_action pull-right" style="margin-left:5px;" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action->id.'" role="form"',$hidden); ?>
					                    <button class="btn btn-danger" ><i class="fa fa-trash-o fa-lg"></i> </button>
					                    <?php echo form_close(); ?>

                                  		<?php $hidden = array('action_id' => $action->id , 'user_id' => $current_user['id'], 'action_do' => 'completed', 'outcome' => '' ,'company_id' => $company['id']);
					               		echo form_open(site_url().'actions/edit', 'name="completed_action"  class="completed_action pull-right" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action->id.'" style="display:inline-block;" role="form"',$hidden); ?>
					                    <button class="btn btn-success"><i class="fa fa-check fa-lg"></i> </button> 
					                    <?php echo form_close(); ?>
					                    
                                   	<?php elseif($action->actioned_at): ?>
                                   		<span class="label label-success pull-right" style="font-size:11px; margin-left:10px;">Completed on <?php echo $actioned_date_formatted ?></span>
									<?php endif; ?>
									<?php if($action->contact_id):?>
										<span class="label label-warning pull-right" style="font-size:11px; margin-left:10px;"><i class="fa fa-users"></i> <?php echo $option_contacts[$action->contact_id]; ?></span>
										
									<?php endif; ?>

						  			</h4>
                                    <div class="mic-info">
                                        Created By: <?php echo $system_users[$action->user_id]?> on <?php echo $created_date_formatted?>
                                    </div>
                                </div>
                                
								
								<div class="comment-text speech col-md-12" >
	                                <div class="triangle-isosceles top">
										<?php echo isset($action->comments)? $action->comments:'No comments'; ?>  
                                        <?php if (!empty($action->outcome)):?>
											<table style="width:100%">
											<tr>
											<td style="width:45%"><hr/></td>
											<td style="width:10%;vertical-align:middle; text-align: center; font-size:11px; color: #222;"><span class="glyphicon glyphicon-chevron-down"></span> Outcome <span class="glyphicon glyphicon-chevron-down"></span></td>
											<td style="width:45%"><hr/></td>
											</tr>
											</table>
											<?php echo $action->outcome ?>
										<?php endif; ?>
									</div>
									
								</div>
								
								<div class="col-md-12" id="action_outcome_box_<?php echo $action->id ?>" style="display:none;">
								<hr>
								<textarea class="form-control" name="outcome" placeholder="Add action outcome" rows="3" style="margin-bottom:5px;"></textarea>
								<button class="btn btn-primary btn-block"><i class="fa fa-check fa-lg"></i> Send</button>

								</div>
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
