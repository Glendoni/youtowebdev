<?php  $company = $companies[0]; ?>
<div class="row page-results-list">

<div class="top-info-holder">
	<h2 class="company-header">
	<?php echo $company['name'];?>
	</h2>
	<?php if (isset($company['parent_registration'])): ?>
		<span class="label label-danger">Subsidiary of <?php echo $company['parent_registration'];?></span>
	<?php endif; ?>
	<?php if (isset($company['pipeline'])): ?>
		<span class="label pipeline-label label-<?php echo str_replace(' ', '', $company['pipeline']); ?>">
		<?php if ($company['pipeline']=='Blacklisted'): ?>
		<?php echo $company['pipeline'] ?> - Do Not Call - See Comments
		<?php else: ?>
		<?php echo $company['pipeline'] ?></span>
		<?php endif; ?>
	<?php endif; ?>
	<!-- POPUP BOXES -->
	<?php $this->load->view('companies/edit_box.php',array('company'=>$company)); ?>
	<?php $this->load->view('companies/create_contact_box.php',array('company'=>$company)); ?>
	<?php $this->load->view('companies/create_address_box.php',array('company'=>$company)); ?>

	<!-- // POPUP BOXES -->
</div>
<div class="panel <?php if(isset($company['assigned_to_name'])): ?> panel-primary <?php else: ?> panel-default <?php endif; ?> company">
	<?php if(isset($company['assigned_to_name'])): ?>

	<div class="panel-heading profile-heading text-center"  <?php if(isset($company['assigned_to_name'])): ?> <?php $user_icon = explode(",", ($system_users_images[$company['assigned_to_id']]));echo "style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'";?><?php else: ?> <?php endif; ?>>
        <h3>Assigned to <?php echo $company['assigned_to_name']; ?></h3>
    </div>
	<?php endif; ?>
	<div class="panel-body">
    	<div class="row">
			<div class="col-sm-9">
		<div class="row">
		<div class="col-sm-12">
				<strong>Address</strong>
				<p style="margin-bottom:0;">
                <?php echo isset($company['address'])?$company['address']:'-'; ?>  
				</p>
		</div><!--END ADDRESS-->
		<div class="col-xs-6 col-md-4" style="margin-top:10px;">
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
		<div class="col-xs-6" style="margin-top:10px;">
				<strong>Company Name</strong>
				<p style="margin-bottom:0;">	
				<?php echo $company['name']; ?>
				</p>
		</div><!--END NAME-->
				
		
        <div class="col-xs-6 col-md-4" style="margin-top:10px;">
        		<strong>Phone Number</strong>
        		<p style="margin-bottom:0;">
        		<?php echo isset($company['phone'])?$company['phone']:'-'; ?>                
           		</p>
			</div><!--END PHONE NUMBER-->
		<div class="col-xs-6 col-md-4" style="margin-top:10px;">
				<strong>Class</strong>
				<p style="margin-bottom:0;">	
		            <!--CLASS IF APPLICABLE-->
		            <?php if (isset($company['class'])): ?>
						<span class="label label-info"><?php echo $companies_classes[$company['class']] ?></span>	
					<?php else: ?>
						-
		            <?php endif; ?>
	            </p>
			</div>

		</div><!--END ROW-->
        </div><!--CLOSE MD-9-->
		<div class="col-sm-3">
		<!--Check if company is blacklisted - if so hide the actions boxes -->
		<?php if ($company['pipeline']=='Blacklisted'): ?>
		<?php else: ?>
		<?php $this->load->view('companies/actions_box.php',array('company'=>$company)); ?>
		<?php if (isset($company['url'])): ?>
		<a class="btn btn-default btn-sm btn-block" href="<?php $parsed = parse_url($company['url']); if (empty($parsed['scheme'])) { echo 'http://' . ltrim($company['url'], '/'); }else{ echo $company['url']; } ?>" target="_blank">
				<strong>Web:</strong> <?php echo str_replace("http://"," ",str_replace("www.", "", $company['url']))?>
		</a>
			<?php endif; ?>
		<!-- LINKS AND BTN -->
			<?php if (isset($company['registration'])): ?>
			<a class="btn  btn-info btn-sm btn-block duedil" href="https://www.duedil.com/company/<?php echo $company['registration'] ?>" target="_blank">Duedil</a>
			<?php endif; ?>
			<?php if (isset($company['linkedin_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block linkedin" href="https://www.linkedin.com/company/<?php echo $company['linkedin_id'] ?>"  target="_blank">LinkedIn</a>
			<?php endif; ?>
		<?php endif; ?>
        </div><!--CLOSE COL-MD-3-->
		<div class="col-md-12">
			<hr>
		</div>

		<div class="row col-md-12">
				<!-- TURNOVER -->
		<div class="col-sm-3 col-xs-6 centre">
			<strong>Turnover</strong>
			<p class="details" style="margin-bottom:5px;">
				£<?php echo isset($company['turnover'])? number_format (round($company['turnover'],-3)):'0';?>
			            	<span class="label label-default" ><?php  echo isset($company['turnover_method'])?$company['turnover_method']:'';?></span>
</p>	
        </div>
        <div class="col-sm-2 col-xs-6 centre">
        	<strong>Founded</strong>
			<p class="details">
				<?php echo isset($company['eff_from'])?$company['eff_from']:''; ?>
			</p>
		</div>

		<!-- CONTACTS -->
		<div class="col-sm-2 col-xs-6 centre">
			<strong>Contacts</strong>			
			<?php if (isset($company['contacts_count'])): ?>
			<p class="details"><?php echo $company['contacts_count'];?> </p>
			<?php else: ?>
			<p class="details">0 </p>
			<?php endif; ?>
		</div>

		<!-- EMPLOYEES -->
		<div class="col-sm-2 col-xs-6 centre">
			<strong>Employees</strong>
			<?php if (isset($company['emp_count'])): ?>
			<p class="details"><?php echo $company['emp_count'];?> </p>
			<?php else: ?>
			<p class="details">Unknown</p>
			<?php endif; ?>
		</div> 

		<!-- SECTORS -->
		<div class="col-sm-3 col-xs-12 centre">
			<strong>Sectors</strong> 
			<?php 
			if(isset($company['sectors'])){
				foreach ($company['sectors'] as $key => $name) {
					echo '<p class="details" style="margin-bottom:0;">'.$name.'</p>';
				}
			} else {
			echo '<p class="details" style="margin-bottom:0; ">Unknown</p>';
			}
			?>
		</div>
		</div>

		<div class="col-md-12">
			<hr>
		</div>

       
		<!-- MORTGAGES -->


		
		<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">
		<h3 class="panel-title">Mortgages</h3>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
		<?php if(!empty($company['mortgages'])): ?>
			<table class="table table-hover">
			<thead>
				<tr>
					<th class="col-md-6">Provider</th>
					<th class="col-md-3" style="text-align:center;">Status</th>
					<th class="col-md-3" style="text-align:center;">Started</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($company['mortgages'] as $mortgage):?>
				<tr <?php echo $mortgage['stage']==MORTGAGES_SATISFIED? 'class="danger"' : 'class="success"' ?> >
					<td class="col-md-6" ><?php echo $mortgage['name']; ?><div style="font-size:11px;"><?php echo $mortgage['type']; ?></div></td>
					<td class="col-md-3" style="text-align:center;"><span class="label label-<?php echo $mortgage['stage']==MORTGAGES_SATISFIED? 'default' : 'success' ?>"><?php echo $mortgage['stage']; ?><?php if(!empty($mortgage['eff_to'])){echo ' on '.$mortgage['eff_to'];} ?></span></td>
					<td class="col-md-3" style="text-align:center;"><?php echo $mortgage['eff_from']; ?></td>

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
		<!-- /.panel-body -->
		</div>
		</div>

<!--ADDRESSES-->
		<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading" id="contacts">
		Addresses
		<div class="pull-right">
		<div class="btn-group">
		<button  class="btn btn-success edit-btn btn-xs" data-toggle="modal" id="create_address_<?php echo $company['id']; ?>"  data-target="#create_address_<?php echo $company['id']; ?>" >
        <span class="ladda-label"> Add Address </span>
		</button>
		</div>
		</div>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
		<?php if(isset($addresses) and !empty($addresses)) : ?>


		<table class="table table-hover">
	      <thead>
	        <tr>
	          <th class="col-md-6">Address</th>
	          <th class="col-md-2">Type</th>
	          <th class="col-md-2">Phone</th>
				<th class="col-md-2"></th>

	        </tr>
	      </thead>
	      <tbody>
	      	<?php foreach ($addresses as $address): ?>
	      	<tr>
				<td class="col-md-6"><?php echo $address->address;?></td>
				<td class="col-md-3"><?php echo $address->type;?></td>
				<td class="col-md-2"><?php echo $address->phone; ?></td>
				<td  class="col-md-3">
		      	<div class=" pull-right ">
	            <?php $this->load->view('companies/action_box_addresses.php',array('address'=>$address)); ?>
	            </div>
	            </td>
        	</tr>
			<?php endforeach; ?>  
	      </tbody>
	    </table>
	    <?php else: ?>
			<div class="alert alert-info" style="margin-top:10px;">
                No address data.
            </div>
		<?php endif; ?>

		</div>
		<!-- /.panel-body -->
		</div>
		</div>


		<!--CONTACTS-->

		<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading" id="contacts">
		Contacts
		<div class="pull-right">
		<div class="btn-group">
		<button  class="btn btn-success edit-btn btn-xs" data-toggle="modal" id="create_contact_<?php echo $company['id']; ?>"  data-target="#create_contact_<?php echo $company['id']; ?>" >
        <span class="ladda-label"> Add Contact </span>
		</button>
		</div>
		</div>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
		<?php if(isset($contacts) and !empty($contacts)) : ?>


		<table class="table table-hover">
	      <thead>
	        <tr>
	          <th class="col-md-3">Name</th>
	          <th class="col-md-2">Role</th>
	          <th class="col-md-2">Email</th>
	          <th class="col-md-2">Phone</th>
	          <th class="col-md-3"></th>
	        </tr>
	      </thead>
	      <tbody>
	      	<?php foreach ($contacts as $contact): ?>
	      	<tr>
				<td class="col-md-3"><?php echo ucfirst($contact->first_name).' '.ucfirst($contact->last_name); ?></td>
				<td class="col-md-2"><?php echo ucfirst($contact->role); ?></td>
				<td class="col-md-2"><?php echo $contact->email; ?></td>
				<td class="col-md-2"><?php echo $contact->phone; ?></td>
				<td  class="col-md-3">
		      	<div class=" pull-right ">
				<?php if ($company['pipeline']=='Blacklisted'): ?>
				<?php else: ?>
	            <?php $this->load->view('companies/action_box_contacts.php',array('contact'=>$contact)); ?>
	        	<?php endif; ?>
	            </div>
	            </td>
        	</tr>
			<?php endforeach; ?>  
	      </tbody>
	    </table>
	    <?php else: ?>
			<div class="alert alert-info" style="margin-top:10px;">
                No contacts registered.
            </div>
		<?php endif; ?>

		</div>
		<!-- /.panel-body -->
		</div>
		</div>
		<div class="col-md-12">
		<div class="panel panel-info ">
		  <div class="panel-heading"><h3 class="panel-title">Completed & Follow Up Actions</h3></div>
		  <div class="panel-body">
		   <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'done'=>'1');
			echo form_open(site_url().'actions/create', 'name="create" class="form" role="form"',$hidden); ?>
			<div class="row">
			<div class="col-md-3">
				<div class="form-group ">
					<label>Completed Action</label>
					<select id="action_type_completed" name="action_type_completed" class="form-control" onchange="commentChange()">
						<?php foreach($action_types_done as $action ): ?>
						  <option value="<?php echo $action->id; ?>"><?php echo $action->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col-md-3">

			<?php if(isset($contacts) and !empty($contacts)) : ?>
				<div class="form-group ">
					<label>Contact</label>
					<select name="contact_id" class="form-control">
						<option value=""></option>
						<?php foreach($contacts as $contact ): ?>
						  <option value="<?php echo $contact->id; ?>"><?php echo ucfirst($contact->first_name).' '.ucfirst($contact->last_name); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			
			<?php endif; ?>
			</div>
				<script>
				function commentChange() 	{
					var contact_type = document.getElementById("action_type").value;
						if (contact_type == '16' || contact_type == '9' ){
						$(".completed-details").attr('required', false)
    										}     
    					else{
						$(".completed-details").attr('required', true)
       						}        
											}
				</script>
				 <div class="col-md-3">
					<div class="form-group ">
						<label>Follow Up Action</label>

						<select name="action_type_planned" class="form-control">
						<option value="0">--- No Follow Up ---</option>

							<?php foreach($action_types_planned as $action ): ?>

							  <option value="<?php echo $action->id; ?>"><?php echo $action->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
	                </div>
	                <div class="col-md-3">
						<div class="form-group " >
							<label>Follow Up Date</label>
							<input type="text" class="form-control" id="planned_at" data-date-format="YYYY/MM/DD H:m" name="planned_at" placeholder="">
						</div>
	                </div>
			<div class="col-md-12">
				<div class="form-group ">
					<label>Outcome</label>
					<textarea class="form-control completed-details" name="comment" rows="3" required="required"></textarea>
				</div>
				<button type="submit" name="save" class="btn btn-success form-control">Save</button>
			</div>
			<?php echo form_close(); ?>
			</div>
		  </div>
		</div>
		</div>
		


<div class="">
	<div class="col-md-12" >
		<div class="panel panel-default ">
			<div class="panel-heading">
			Actions
			</div>
			<div class="panel-body">

				<div class="row">
				    <div class="col-sm-12 col-md-12">
				        <!-- Nav tabs -->
				        <ul class="nav nav-tabs">
				            <li class="active"><a href="#outstanding" data-toggle="tab"><i class="fa fa-cogs"></i>  Outstanding <span class="label label-warning"><?php echo count($actions_outstanding);?></span></a></li>
				            <li><a href="#completed" data-toggle="tab"><i class="fa fa-check"></i> Completed <span class="label label-success"><?php echo count($actions_completed);?></span></a></li>
				            <?php if (count($actions_cancelled) > 0): ?>
				            <li><a href="#cancelled" data-toggle="tab"><i class="fa fa-ban"></i> Cancelled <span class="label label-danger">
				            <?php echo count($actions_cancelled);?></span></a></li>
							<?php else: ?>
							<?php endif; ?>
							<?php if (count($actions_marketing) > 0): ?>
				            <li><a href="#marketing" data-toggle="tab"><i class="fa fa-paper-plane-o"></i> Marketing <span class="label label-default">
				            <?php echo count($actions_marketing);?></span></a></li>
							<?php else: ?>
							<?php endif; ?>
				            <li class="pull-right"><a href="#comments" data-toggle="tab"><i class="fa fa-check"></i> Comments <span class="label label-success"><?php echo count($comments);?></span></a></li>
				        </ul>
				        <!-- Tab panes -->
				        <div class="tab-content">
				            <div class="tab-pane fade in active" id="outstanding">
				               <?php if (count($actions_outstanding) > 0): ?>
								<ul class="list-group">
								<?php foreach ($actions_outstanding as $action_outstanding): 
								 // print_r('<pre>');print_r($action);print_r('</pre>');
								 $created_date_formatted = date("l jS F y",strtotime($action_outstanding->created_at))." @ ".date("H:i",strtotime($action_outstanding->created_at));
								 $actioned_date_formatted = date("l jS F y",strtotime($action_outstanding->actioned_at))." @ ".date("H:i",strtotime($action_outstanding->actioned_at));
								 $planned_date_formatted = date("l jS F y",strtotime($action_outstanding->planned_at))." @ ".date("H:i",strtotime($action_outstanding->planned_at));
								 $cancelled_at_formatted = date(" jS F y",strtotime($action_outstanding->cancelled_at))." @ ".date("H:i",strtotime($action_outstanding->cancelled_at));
								 $now = date(time());
								?>
								<!-- OUTSTANDING -->
				<li class="list-group-item">
					<div class="row" style="padding: 15px 0">
						<div class="col-md-12 ">
							<div class="col-xs-2 col-md-1 profile-heading">
								<span>
									<?php $user_icon = explode(",", ($system_users_images[$action_outstanding->user_id])); echo "<div class='circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
								</span>
							</div>
							<div class="col-xs-6 col-md-5">
								<h4 style="margin:0;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $action_outstanding->id ?>" aria-expanded="false" aria-controls="collapse<?php echo $action_outstanding->id ?>">
									<?php echo $action_types_array[$action_outstanding->action_type_id]; ?>
                                    </a>
								<div class="mic-info">
								Created By: <?php echo $system_users[$action_outstanding->user_id]?> on <?php echo $created_date_formatted?>
								</div>
       							</h4>
							</div><!--END COL-MD-5-->
							<div class="col-xs-4 col-md-6">
							<!--SHOW CONTACT NAME-->
                            <?php if($action_outstanding->contact_id):?><span class="label label-primary" style="font-size:11px; margin:0 10px;  "><?php echo $option_contacts[$action_outstanding->contact_id]; ?></span>
                            <?php endif; ?>
								<?php if($action_outstanding->cancelled_at) : ?>
								<span class="label label-default" style="font-size:11px; margin-left:10px;">Cancelled on <?php echo $cancelled_at_formatted ?></span>
								<?php elseif(strtotime($action_outstanding->planned_at) > $now and !isset($action_outstanding->actioned_at)) : ?>
								<span class="label label-warning" style="font-size:11px; margin-left:10px;">Due on <?php echo $planned_date_formatted ?> </span>
								<?php $hidden = array('action_id' => $action_outstanding->id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled','outcome' => '' ,'company_id' => $company['id']); echo form_open(site_url().'actions/edit', 'name="cancel_action"  class="cancel_action pull-right" style="margin-left:5px;" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action_outstanding->id.'" role="form"',$hidden); ?>
<button class="btn btn-danger" ><i class="fa fa-trash-o fa-lg"></i> </button>
<?php echo form_close(); ?>
<?php $hidden = array('action_id' => $action_outstanding->id , 'user_id' => $current_user['id'], 'action_do' => 'completed', 'outcome' => '' ,'company_id' => $company['id']);
echo form_open(site_url().'actions/edit', 'name="completed_action"  class="completed_action pull-right" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action_outstanding->id.'" style="display:inline-block;" role="form"',$hidden); ?><button class="btn btn-success"><i class="fa fa-check fa-lg"></i> </button> <?php echo form_close(); ?>
								<?php elseif(strtotime($action_outstanding->planned_at) < $now and !isset($action_outstanding->actioned_at)):?>
								<span class="label label-danger" style="font-size:11px; margin-left:10px;"><b>Overdue</b> - Due on <?php echo $planned_date_formatted ?> </span>
								<?php $hidden = array('action_id' => $action_outstanding->id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled','outcome' => '' ,'company_id' => $company['id'] ); echo form_open(site_url().'actions/edit', 'name="cancel_action"  class="cancel_action pull-right" style="margin-left:5px;" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action_outstanding->id.'" role="form"',$hidden); ?><button class="btn btn-danger" ><i class="fa fa-trash-o fa-lg"></i> </button>
<?php echo form_close(); ?><?php $hidden = array('action_id' => $action_outstanding->id , 'user_id' => $current_user['id'], 'action_do' => 'completed', 'outcome' => '' ,'company_id' => $company['id']); echo form_open(site_url().'actions/edit', 'name="completed_action"  class="completed_action pull-right" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action_outstanding->id.'" style="display:inline-block;" role="form"',$hidden); ?><button class="btn btn-success"><i class="fa fa-check fa-lg"></i> </button> <?php echo form_close(); ?><?php elseif($action_outstanding->actioned_at): ?>
<span class="label label-success pull-right" style="font-size:11px; margin-left:10px;">Completed on <?php echo $action_outstandinged_date_formatted ?></span><?php endif; ?>

                            
                            </div>
									  			
				                              
				                           
				                            <div class="col-md-12">
											<div id="collapse<?php echo $action_outstanding->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $action_outstanding->id ?>">
											<?php if (!empty($action_outstanding->comments)):?>
											<div class="comment-text speech" >
											<div class="triangle-isosceles top">
											<?php echo $action_outstanding->comments ?>
											<?php if (!empty($action_outstanding->outcome)):?>
											<table style="width:100%">
											<tr>
											<td style="width:35%"><hr/></td>
											<td style="width:20%;vertical-align:middle; text-align: center; font-size:11px; color: #222;"> Outcome </td>
											<td style="width:35%"><hr/></td>
											</tr>
											</table>
											<?php echo $action_outstanding->outcome ?>
											<?php endif; ?>
											</div>
											</div>
											<?php endif; ?>
											</div>
											
											<div id="action_outcome_box_<?php echo $action_outstanding->id ?>" style="display:none;">
											<hr>
											<textarea class="form-control" name="outcome" placeholder="Add action outcome" rows="3" style="margin-bottom:5px;"></textarea>
											<button class="btn btn-primary btn-block"><i class="fa fa-check fa-lg"></i> Send</button>

											</div>
											</div><!--END ACTIONS-->   
				                        </div>
				                        </div>
				                </li>
				                <?php endforeach ?>
				                </ul>
							<?php else: ?>
								<div class="col-md-12">
									<h4 style="margin: 50px 0 40px 0; text-align: center;">No outstanding actions found for this company</h4>
								</div>
							<?php endif; ?>
				            </div>
				            <div class="tab-pane fade in" id="completed">
				               <?php if (count($actions_completed) > 0): ?>
								<ul class="list-group">
								<?php foreach ($actions_completed as $action_completed): 
	 // print_r('<pre>');print_r($action);print_r('</pre>');
								 $created_date_formatted = date("l jS F y",strtotime($action_completed->created_at))." @ ".date("H:i",strtotime($action_completed->created_at));
								 $actioned_date_formatted = date("l jS F y",strtotime($action_completed->actioned_at))." @ ".date("H:i",strtotime($action_completed->actioned_at));
								 $cancelled_at_formatted = date(" jS F y",strtotime($action_completed->cancelled_at))." @ ".date("H:i",strtotime($action_completed->cancelled_at));
								 $now = date(time());
								?>
				
								<!-- COMPLETED -->
								<?php if ($action_completed->action_type_id == 19): ?>
									<?php
										$arr = explode(' ',trim($action_completed->comments));
										$pipeline_updated = $arr[3];
										?><li class="list-group-item pipeline-update <?php echo $pipeline_updated;?>"><?php echo $action_completed->comments ?>
				                                on <?php echo date("l jS F y",strtotime($action_completed->actioned_at))." @ ".date("H:i",strtotime($action_completed->actioned_at)); ?></span></li>
									<?php else: ?>
				                <li class="list-group-item">
					<div class="row" style="padding: 15px 0">
						<div class="col-md-12 ">
							<div class="col-xs-2 col-md-1 profile-heading">
								<span>
									<?php $user_icon = explode(",", ($system_users_images[$action_completed->user_id])); echo "<div class='circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
								</span>
							</div>
							<div class="col-xs-6 col-md-5">
								<h4 style="margin:0;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $action_completed->id ?>" aria-expanded="false" aria-controls="collapse<?php echo $action_completed->id ?>">
									<?php echo $action_types_array[$action_completed->action_type_id]; ?>
                                    </a>
								<div class="mic-info">
								Created By: <?php echo $system_users[$action_completed->user_id]?> on <?php echo $created_date_formatted?>
											</div>
											</h4>
											</div><!--END COL-MD-5-->
											<div class="col-xs-4 col-md-6" style="text-align:right;">
											<!--SHOW CONTACT NAME-->
											<?php if($action_completed->contact_id):?><span class="label label-primary" style="font-size:11px; margin-left:10px;  "><?php echo $option_contacts[$action_completed->contact_id]; ?></span>
											<?php endif; ?>
											<span class="label label-success" style="font-size:11px; margin-left:10px;">Completed on <?php echo date("l jS F y",strtotime($action_completed->actioned_at))." @ ".date("H:i",strtotime($action_completed->actioned_at)); ?></span>
											</div>
											<div class="col-md-12">
											<div id="collapse<?php echo $action_completed->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $action_completed->id ?>">
											<?php if (!empty($action_completed->comments)):?>
											<div class="comment-text speech" >
											<div class="triangle-isosceles top">
											<?php echo $action_completed->comments ?>
											<?php if (!empty($action_completed->outcome)):?>
											<table style="width:100%">
											<tr>
											<td style="width:35%"><hr/></td>
											<td style="width:20%;vertical-align:middle; text-align: center; font-size:11px; color: #222;"> Outcome </td>
											<td style="width:35%"><hr/></td>
											</tr>
											</table>
											<?php echo $action_completed->outcome ?>
											<?php endif; ?>
											</div>
											</div>
											<?php endif; ?>
											</div>
											
											<div id="action_outcome_box_<?php echo $action_completed->id ?>" style="display:none;">
											<hr>
											<textarea class="form-control" name="outcome" placeholder="Add action outcome" rows="3" style="margin-bottom:5px;"></textarea>
											<button class="btn btn-primary btn-block"><i class="fa fa-check fa-lg"></i> Send</button>

											</div>
											</div><!--END ACTIONS-->   
				                        </div>
				                        </div>
				                </li>
				            <?php endif; ?><!--END LOOP IF STATEMENT RE. PIPELINE UPDATES-->

				                <?php endforeach ?>

				                </ul>
							<?php else: ?>
								<div class="col-md-12">
									<h4 style="margin: 50px 0 40px 0; text-align: center;">No completed actions found for this company</h4>
								</div>
							<?php endif; ?>
				            </div>
				            <div class="tab-pane fade in" id="cancelled">
						<?php if (count($actions_cancelled) > 0): ?>
								<ul class="list-group">
								<?php foreach ($actions_cancelled as $action_cancelled): 
								 $created_date_formatted = date("l jS F y",strtotime($action_cancelled->created_at))." @ ".date("H:i",strtotime($action_cancelled->created_at));
								 $cancelled_at_formatted = date(" jS F y",strtotime($action_cancelled->cancelled_at))." @ ".date("H:i",strtotime($action_cancelled->cancelled_at));
								?>
								<!-- CANCELLED -->
				                <li class="list-group-item">
					<div class="row" style="padding: 15px 0">
						<div class="col-md-12 ">
							<div class="col-xs-2 col-md-1 profile-heading">
								<span>
									<?php $user_icon = explode(",", ($system_users_images[$action_cancelled->user_id])); echo "<div class='circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
								</span>
							</div>
							<div class="col-xs-6 col-md-5">
								<h4 style="margin:0;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $action_cancelled->id ?>" aria-expanded="false" aria-controls="collapse<?php echo $action_cancelled->id ?>">
									<?php echo $action_types_array[$action_cancelled->action_type_id]; ?>
                                    </a>
								<div class="mic-info">
								Created By: <?php echo $system_users[$action_cancelled->user_id]?> on <?php echo $created_date_formatted?>
											</div>
											</h4>
											</div><!--END COL-MD-6-->
											<div class="col-xs-4 col-md-6" style="text-align:right;">
											<!--SHOW CONTACT NAME-->
											<?php if($action_cancelled->contact_id):?><span class="label label-primary" style="font-size:11px; margin-left:10px;  "><?php echo $option_contacts[$action_cancelled->contact_id]; ?></span>
											<?php endif; ?>
											<span class="label label-danger" style="font-size:11px; margin-left:10px;">Cancelled on <?php echo $cancelled_at_formatted ?></span>
											</div>
											<div class="col-md-12">
											<div id="collapse<?php echo $action_cancelled->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $action_cancelled->id ?>">
											<?php if (!empty($action_cancelled->comments)):?>
											<div class="comment-text speech" >
											<div class="triangle-isosceles top">
											<?php echo $action_cancelled->comments ?>
											<?php if (!empty($action_cancelled->outcome)):?>
											<table style="width:100%">
											<tr>
											<td style="width:35%"><hr/></td>
											<td style="width:20%;vertical-align:middle; text-align: center; font-size:11px; color: #222;"> Outcome </td>
											<td style="width:35%"><hr/></td>
											</tr>
											</table>
											<?php echo $action_cancelled->outcome ?>
											<?php endif; ?>
											</div>
											</div>
											<?php endif; ?>
											</div>
											
											<div id="action_outcome_box_<?php echo $action_cancelled->id ?>" style="display:none;">
											<hr>
											<textarea class="form-control" name="outcome" placeholder="Add action outcome" rows="3" style="margin-bottom:5px;"></textarea>
											<button class="btn btn-primary btn-block"><i class="fa fa-check fa-lg"></i> Send</button>

											</div>
											</div><!--END ACTIONS-->   
				                        </div>
				                        </div>
				                </li>
				                <?php endforeach ?>
				                </ul>
							<?php else: ?>
								<div class="col-md-12">
									<h4 style="margin: 50px 0 40px 0; text-align: center;">No completed actions found for this company</h4>
								</div>
							<?php endif; ?>
				            </div>
								<!-- MARKETING -->
				             <div class="tab-pane fade in" id="marketing">
							<?php if (count($actions_marketing) > 0): ?>
								<ul class="list-group">
								<?php foreach ($actions_marketing as $actions_marketing): 
								 $created_date_formatted = date("l jS F y",strtotime($actions_marketing['date_sent']));
								?>
				                <li class="list-group-item" style="padding:0;">
				                 
				                        <div class="row" style="padding: 15px 0">
						<div class="col-md-12 ">
					
							<div class="col-xs-6 col-md-4">
								<h4 style="margin:0;">
								<?php echo $actions_marketing['campaign_name'];?>
								<div class="mic-info">
								Sent By: <?php echo $actions_marketing['email'];?></br>
								Sent On: <?php echo $created_date_formatted?>
								</div>
								</h4>
								</div><!--END COL-MD-4-->
								<div class="col-xs-6 col-md-4">
								<?php
								if (($actions_marketing['opened']>'0') || ($actions_marketing['clicked']>'0')): ?>
								<span class="label label-success">Opened</span>
								<?php else: ?>
								<span class="label label-danger">Not Opened</span>
								<?php endif; ?>
								<?php
								if (($actions_marketing['clicked']>'0')): ?>
								<span class="label label-success">Clicked</span>
								<?php else: ?>
								<span class="label label-warning">Not Clicked</span>
								<?php endif; ?>
								<?php
								if (($actions_marketing['unsubscribed']>'0')): ?>
								<span class="label label-danger">Unsubscribed</span>
								<?php else: ?>
								<?php endif; ?>
								</div>
								<div class="col-xs-12 col-md-4">
								<?php if($actions_marketing['first_name']):?><span class="label label-primary" style="font-size:11px;  "><?php echo $actions_marketing['first_name']." ". $actions_marketing['last_name']; ?></span>
											<?php endif; ?>

											
				                        </div>
				                        </div>
				                </li>
				                <?php endforeach ?>
				                </ul>
							<?php else: ?>
								<div class="col-md-12">
									<h4 style="margin: 50px 0 40px 0; text-align: center;">No completed actions found for this company</h4>
								</div>
							<?php endif; ?>
				            </div>
				            <div class="tab-pane fade in" id="comments">
				            

							<?php if (count($comments) > 0): ?>
								<ul class="list-group">
	        				<?php foreach ($comments as $comment):
	        				// print_r('<pre>');print_r($action);print_r('</pre>');
							 $created_date_formatted = date("d/m/y",strtotime($comment->created_at));
							?>
							<li class="list-group-item">
							<div class="row">
							<div class="col-md-12 ">
							<h4 style="margin-bottom:0;"><?php echo $system_users[$comment->user_id]?></h4><small class="text-muted">
							<i class="fa fa-calendar fa-fw"></i> <?php echo $created_date_formatted?></small>
							</div>
							<div class="col-md-12 ">
							<p>
							<?php echo isset($comment->comments)? $comment->comments:'No comments'; ?>
							</p>
	                        </div>
	                        </div>
	                        </li>
	        			<?php endforeach ?>
	        			</ul>
	        		<?php else: ?>
					No Comments
					<?php endif; ?>
					<?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'done'=>'1');
					echo form_open(site_url().'actions/create', 'name="create" class="" role=""',$hidden); ?>
		            <div class="input-group">
		            	<input type="hidden" name="action_type" value="7">
	                    <input id="btn-input" type="text" class="form-control input-sm" name="comment" placeholder="Type your comments here...">
	                    <span class="input-group-btn">
	                        <button class="btn btn-warning btn-sm" id="btn-chat">
	                            Send
	                        </button>
	                    </span>
	            	</div>
	            </form>





				            </div>
				        </div>
				        <!-- Ad -->
				    </div>
				</div>
			<!--END TABS-->
		  	</div>
		</div>
	</div>

	
    
    
    
</div>
</div><!--CLOSE ROW-->
</div>
</div>