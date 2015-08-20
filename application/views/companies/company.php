<?php  $company = $companies[0]; ?>
<div class="page-results-list">
<div class="top-info-holder">
	<?php if (isset($company['parent_registration'])): ?>
		<div style="height: 1px; background-color: #d9534f; text-align: center; margin:30px 0; ">
		<span class="label label-danger" style="position: relative; top: -10px;">Subsidiary of <?php echo $company['parent_registration'];?></span>
			</div>

	<?php endif; ?>
	<h2 class="company-header">
	<?php echo $company['name'];?>
	</h2>

			<div class="row" style="margin-top:5px; text-align:center;">

	<span class="label label-<?php echo str_replace(' ', '', $company['pipeline']); ?>"><?php echo $company['pipeline']?>
	<?php if (isset($company['customer_from'])):?>
		from <?php echo date("d/m/y",strtotime($company['customer_from']));?>
		<?php endif; ?>
		</span>
	<?php if(isset($company['assigned_to_name'])): ?>
		<span class="label label-assigned"
		<?php $user_icon = explode(",", ($system_users_images[$company['assigned_to_id']]));echo "style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'";?>>
        <?php echo $company['assigned_to_name']; ?>
        </span>
	<?php else: ?>
	<?php endif; ?>
</div>
	<!-- POPUP BOXES -->
	<?php $this->load->view('companies/edit_box.php',array('company'=>$company)); ?>
	<?php $this->load->view('companies/create_contact_box.php',array('company'=>$company)); ?>
	<?php $this->load->view('companies/create_address_box.php',array('company'=>$company)); ?>

	<!-- // POPUP BOXES -->
</div><!--END TOP INFO HOLDER-->

<div class="panel panel-primary" style="padding-top: 30px;">
	<div class="panel-body">
    	<div class="row">
			<div class="col-sm-9">
		<div class="row">
		<div class="col-sm-12" style="margin-bottom:10px;">
				<label>Company Name</label>
				<p style="margin-bottom:0;">	
				<?php echo $company['name']; ?>
				</p>
		</div><!--END NAME-->
		<div class="col-sm-12" style="margin-top:10px;">
				<label>Address</label>
				<p style="margin-bottom:0;">
                <?php echo isset($company['address'])?'<a href="http://maps.google.com/?q='.urlencode($company['address']).'" target="_blank">'.$company['address'].'<span style="    line-height: 15px;font-size: 10px;padding-left: 5px;"><i class="fa fa-external-link"></i></span></a>':'-'; ?>  
				</p><hr>
		</div><!--END ADDRESS-->
		
		<div class="col-xs-6" style="margin-top:10px;">
			<label>Company Number</label>
			<p>	
			 <!--COMPANY NUMBER IF APPLICABLE-->
			<?php echo isset($company['registration'])?$company['registration']:'-'; ?>
         	</p>
        	</div>

        	<div class="col-xs-6" style="margin-top:10px;">
        	<label>Founded</label>
			<p>	
				<?php echo isset($company['eff_from'])?$company['eff_from']:'-'; ?>
			</p>
		</div>
	
		
        <div class="col-xs-6" style="margin-top:10px;">
        		<label>Phone Number</label>
        		<p>
        		<?php echo isset($company['phone'])?$company['phone']:''; ?>                
           		</p>
			</div><!--END PHONE NUMBER-->
		<div class="col-xs-6 col-md-4" style="margin-top:10px;">
				<label>Class</label>
				<p>	
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
		<?php $this->load->view('companies/actions_box_list.php',array('company'=>$company)); ?>
		<?php if (isset($company['url'])): ?>
		<a class="btn btn-default btn-sm btn-block btn-url" href="<?php $parsed = parse_url($company['url']); if (empty($parsed['scheme'])) { echo 'http://' . ltrim($company['url'], '/'); }else{ echo $company['url']; } ?>" target="_blank">
				<label style="margin-bottom:0;">Web:</label> <?php echo str_replace("http://"," ",str_replace("www.", "", $company['url']))?>
		</a>
			<?php endif; ?>
		<!-- LINKS AND BTN -->
			<?php if (isset($company['registration'])): ?>
			<a class="btn  btn-info btn-sm btn-block endole" href="http://www.endole.co.uk/company/<?php echo $company['registration'] ?>" target="_blank">Endole</a>
			<?php endif; ?>
			<?php if (isset($company['linkedin_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block linkedin" href="https://www.linkedin.com/company/<?php echo $company['linkedin_id'] ?>"  target="_blank">LinkedIn</a>
			<?php endif; ?>
			<?php if (($current_user['department']) =='support' && isset($company['zendesk_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block zendesk" href="https://sonovate.zendesk.com/agent/organizations/<?php echo $company['zendesk_id'] ?>"  target="_blank">ZenDesk</a>
			<?php endif; ?>

		<?php endif; ?>
        </div><!--CLOSE COL-MD-3-->
		<div class="col-md-12">
			<hr>
		</div>

		<div class="row">
		<!-- TURNOVER -->
		<!-- TURNOVER -->
		<div class="col-xs-4 col-sm-3 centre">
			<strong><span style="text-transform: capitalize"><?php echo isset($company['turnover_method'])?$company['turnover_method']:'';?></span>
Turnover</strong>
			<p class="details" style="margin-bottom:5px;">
				<?php echo isset($company['turnover'])? '£'.number_format (round($company['turnover'],-3)):'Unknown';?>
			</p>
        </div>
        <div class="col-xs-4 col-sm-2 centre">
        	<strong>Founded</strong>
			<p class="details">
				<?php echo isset($company['eff_from'])?$company['eff_from']:''; ?>
			</p>
		</div>

		<!-- CONTACTS -->
		<div class="col-xs-4 col-sm-2 centre">
			<strong>Contacts</strong>			
			<?php if (isset($company['contacts_count'])): ?>
			<p class="details"><?php echo $company['contacts_count'];?> </p>
			<?php else: ?>
			<p class="details">0 </p>
			<?php endif; ?>
		</div>

		<!-- EMPLOYEES -->
		<div class="col-xs-4 col-sm-2 centre">
			<strong>Employees</strong>
			<?php if (isset($company['emp_count'])): ?>
			<p class="details"><?php echo $company['emp_count'];?> </p>
			<?php else: ?>
			<p class="details">Unknown</p>
			<?php endif; ?>
		</div>

		<!-- SECTORS -->
		<div class="col-xs-4 col-sm-3">
			<strong>Sectors</strong> 
			<?php 
			if(isset($company['sectors'])){
				foreach ($company['sectors'] as $key => $name) {
					echo '<p class="details" style="margin-bottom:0; text-align:left;">'.$name.'</p>';
				}
			}
			?>
		</div>

		<div class="col-md-12">
			<hr>
		</div>

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
					<th class="col-md-3" style="text-align:center;">Started</th>
					<th class="col-md-3" style="text-align:center;">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($company['mortgages'] as $mortgage):?>
				<tr <?php echo $mortgage['stage']==MORTGAGES_SATISFIED? 'class="danger"' : 'class="success"' ?> >
					<td class="col-md-6" ><?php echo $mortgage['name']; ?><div style="font-size:11px;"><?php echo $mortgage['type']; ?></div></td>
					
					<td class="col-md-3" style="text-align:center;">
					<?php
$mortgages_start  = $mortgage['eff_from'];$date_pieces = explode("/", $mortgages_start);$formatted_mortgage_date = $date_pieces[2].'/'.$date_pieces[1].'/'.$date_pieces[0];echo date("F Y",strtotime($formatted_mortgage_date));
?></td><td class="col-md-3" style="text-align:center;"><span class="label label-<?php echo $mortgage['stage']==MORTGAGES_SATISFIED? 'default' : 'success' ?>"><?php echo $mortgage['stage']; ?><?php if(!empty($mortgage['eff_to'])){echo ' on '.$mortgage['eff_to'];} ?></span></td>



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


		<!--CAMPAIGNS-->
		<?php if(isset($campaigns) and !empty($campaigns)) : ?>
		<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading" id="contacts">
		Campaigns
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
		<table class="table table-hover">
	      <thead>
	        <tr>
	          <th class="col-md-6">Name</th>
	          <th class="col-md-3">Owner</th>
	          <th class="col-md-3">Created</th>
	        </tr>
	      </thead>
	      <tbody>
	      	<?php foreach ($campaigns as $campaign): ?>
	      	<tr>
				<td class="col-md-6"><a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $campaign->id;?>"><?php echo $campaign->campaign_name;?></a></td>
				<td class="col-md-3"><?php echo $campaign->name;?></td>
				<td class="col-md-2"><?php echo date("d/m/y",strtotime($campaign->created_at));?></td>
				<td  class="col-md-3">
	            </td>
        	</tr>
			<?php endforeach; ?>  
	      </tbody>
	    </table>
		

		</div>
		<!-- /.panel-body -->
		</div>
		</div>
		<?php endif; ?>


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
	          <th class="col-md-2 mobile-hide">Role</th>
	          <th class="col-md-2">Email</th>
	          <th class="col-md-2">Phone</th>
	          <th class="col-md-3"></th>
	        </tr>
	      </thead>
	      <tbody>
	      	<?php foreach ($contacts as $contact): ?>
	      	<tr>
				<td class="col-md-3"><?php echo ucfirst($contact->first_name).' '.ucfirst($contact->last_name); ?></td>
				<td class="col-md-2 mobile-hide"><?php echo ucfirst($contact->role); ?></td>
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
		   <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'done'=>'1', 'class_check' => $companies_classes[$company['class']],);
			echo form_open(site_url().'actions/create', 'name="create" class="form" role="form"',$hidden); ?>
			<!--THE BELOW PASSES THE CLASS FIELD ACROSS PURELY FOR VALIDATION - IF THERE IS A BETTER WAY OF DOING THIS THEN IT NEEDS TO BE HERE-->
			
			<!--VALIDATION ERROR IF NO ACTION IS SELECTED-->
			<?php $msg = $this->session->flashdata('message_action'); if($msg): ?>
        <div id="action-error" class="alert alert-<?php echo $this->session->flashdata('message_type'); ?> alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?php echo $msg ?>
        </div>
    <?php endif; ?><!--END VALIDATION-->
<div class="row">
			<div class="col-md-3">
				<div class="form-group ">
					<label>New Actions</label>

					<select id="action_type_completed" name="action_type_completed" class="form-control" onchange="commentChange()">
						<option value="">--- Select an Action ---</option>
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
						<option value="">--- Select a Contact ---</option>
						<?php foreach($contacts as $contact ): ?>
						  <option value="<?php echo $contact->id; ?>"><?php echo ucfirst($contact->first_name).' '.ucfirst($contact->last_name); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			
			<?php endif; ?>
			</div>
				
				 <div class="col-md-3">
					<div class="form-group ">
						<label>Follow Up Action</label>

						<select id="action_type_planned" name="action_type_planned" class="form-control" onchange="dateRequired()">
						<option value="">--- No Follow Up ---</option>
							<?php foreach($action_types_planned as $action ): ?>
							  <option value="<?php echo $action->id; ?>"><?php echo $action->name; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
	                </div>
	                <div class="col-md-3">
						<div class="form-group " >
							<label>Follow Up Date</label>
							<input type="text" class="form-control follow-up-date" id="planned_at" data-date-format="YYYY/MM/DD H:m" name="planned_at" placeholder="">
						</div>
	                </div>
			<div class="col-md-12">
				<div class="form-group ">
					<label>Outcome</label>
					<textarea class="form-control completed-details" name="comment" rows="3" required="required"><?php echo $_GET['message'];?></textarea>
				</div>
				<button type="submit" name="save" class="btn btn-success form-control">Save</button>
			</div>
			<?php echo form_close(); ?>
			</div>
		  </div>
		</div>
		</div>
			<div class="col-md-12" >
		<div class="panel panel-default " id="actions">
			<div class="panel-heading">
			Action History
			</div>
			<div class="panel-body">

				<div class="row">
				    <div class="col-sm-12 col-md-12">
				        <!-- Nav tabs -->
				        <ul class="nav nav-tabs">
							<li><a href="#all" data-toggle="tab">All <span class="label label-primary">
							<?php echo count($get_actions);?></span></a></li>
				            <li class="active"><a href="#outstanding" data-toggle="tab">Outstanding <span class="label label-warning"><?php echo count($actions_outstanding);?></span></a></li>
				            <li><a href="#completed" data-toggle="tab">Completed <span class="label label-success"><?php echo count($actions_completed);?></span></a></li>
				            <?php if (count($actions_cancelled) > 0): ?>
				            <li><a href="#cancelled" data-toggle="tab">Cancelled <span class="label label-danger">
				            <?php echo count($actions_cancelled);?></span></a></li>
							<?php else: ?>
							<?php endif; ?>
							<?php if (count($actions_marketing) > 0): ?>
				            <li><a href="#marketing" data-toggle="tab">Marketing <span class="label label-default">
				            <?php echo count($actions_marketing);?></span></a></li>
							<?php else: ?>
							<?php endif; ?>
				            <li><a href="#comments" data-toggle="tab"> Comments <span class="label label-success"><?php echo count($comments);?></span></a></li>
				        </ul>
				        <!-- Tab panes -->
				        <div class="tab-content">


				        							

				        <!-- OUTSTANDING -->
<div class="tab-pane fade in active" id="outstanding">
		<?php if (count($actions_outstanding) > 0): ?>
				<ul class="list-group">
								<?php foreach ($actions_outstanding as $action_outstanding): 
								 $created_date_formatted = date("l jS F y",strtotime($action_outstanding->created_at))." @ ".date("H:i",strtotime($action_outstanding->created_at));
								 $actioned_date_formatted = date("l jS F y",strtotime($action_outstanding->actioned_at))." @ ".date("H:i",strtotime($action_outstanding->actioned_at));
								 $planned_date_formatted = date("l jS F y",strtotime($action_outstanding->planned_at))." @ ".date("H:i",strtotime($action_outstanding->planned_at));
								 $cancelled_at_formatted = date(" jS F y",strtotime($action_outstanding->cancelled_at))." @ ".date("H:i",strtotime($action_outstanding->cancelled_at));
								 $now = date(time());
								?>
						<li class="list-group-item">
							<div class="row" style="padding: 15px 0">
								<div class="col-md-12 ">
									<div class="col-xs-2 col-md-1 profile-heading">
									<?php $user_icon = explode(",", ($system_users_images[$action_outstanding->user_id])); echo "<div class='circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
								</div>
							<div class="col-xs-6 col-md-5">
								<h4 style="margin:0;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $action_outstanding->action_id ?>" aria-expanded="false" aria-controls="collapse<?php echo $action_outstanding->action_id ?>">
									<?php echo $action_types_array[$action_outstanding->action_type_id]; ?><?php if(strtotime($action_outstanding->planned_at) < $now and !isset($action_outstanding->actioned_at)):?>
								<span class="label label-danger" style="font-size:11px; margin-left:10px;"><b>Overdue</b></span>
								<?php endif ?>
                                    </a>
								<div class="mic-info">
								Created By: <?php echo $system_users[$action_outstanding->user_id]?> on <?php echo $created_date_formatted?>
								</div>
								 <?php if(!empty($action_outstanding->first_name)) : $contact_details_for_calendar = urlencode('Meeting with '.$action_outstanding->first_name.' '.$action_outstanding->last_name).'%0A'.urlencode($action_outstanding->email.' '.$action_outstanding->phone).'%0D%0D';?>
                              <?php endif ?>

								<div style="clear:both;"><small><a class="btn btn-default btn-xs add-to-calendar" href="http://www.google.com/calendar/event?action=TEMPLATE&text=<?php echo urlencode($action_types_array[$action_outstanding->action_type_id].' | '.$action_outstanding->name); ?>&dates=<?php echo date("Ymd\\THi00",strtotime($action_outstanding->planned_at));?>/<?php echo date("Ymd\\THi00\\Z",strtotime($action_outstanding->planned_at));?>&details=<?php echo $contact_details_for_calendar;?>%0D%0D<?php echo urlencode('http://baselist.herokuapp.com/companies/company?id='.$action_outstanding->company_id);?>%0D%0DAny changes made to this event are not updated in Baselist."target="_blank" rel="nofollow">Add to Calendar</a></small></div>
       							</h4>
							</div><!--END COL-MD-5-->
							<div class="col-xs-4 col-md-6">
							<!--SHOW CONTACT NAME-->
                            <?php if($action_outstanding->contact_id):?><span class="label label-primary" style="font-size:11px; margin:0 10px;  "><?php echo $action_outstanding->first_name.' '.$action_outstanding->last_name; ?></span>
                            <?php endif; ?>
					
								<?php if(strtotime($action_outstanding->planned_at) > $now and !isset($action_outstanding->actioned_at)) : ?>
								<span class="label label-warning" style="font-size:11px; margin-left:10px;"><?php echo $planned_date_formatted ?> </span>
								<?php $hidden = array('action_id' => $action_outstanding->action_id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled','outcome' => '' ,'company_id' => $company['id']); echo form_open(site_url().'actions/edit', 'name="cancel_action"  class="cancel_action pull-right" style="margin-left:5px;" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action_outstanding->action_id.'" role="form"',$hidden); ?>
<button class="btn btn-danger btn-sm" ><i class="fa fa-trash-o fa-sm"></i> </button>
<?php echo form_close(); ?>
<?php $hidden = array('action_id' => $action_outstanding->action_id , 'user_id' => $current_user['id'], 'action_do' => 'completed', 'outcome' => '' ,'action_type_id_outcome' =>'','company_id' => $company['id']);
echo form_open(site_url().'actions/edit', 'name="completed_action"  class="completed_action pull-right" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action_outstanding->action_id.'" style="display:inline-block;" role="form"',$hidden); ?><button class="btn btn-success btn-sm"><i class="fa fa-check fa-sm"></i> </button> <?php echo form_close(); ?>
								<?php elseif(strtotime($action_outstanding->planned_at) < $now and !isset($action_outstanding->actioned_at)):?>
								<span class="label label-danger" style="font-size:11px; margin-left:10px;"><b>Overdue</b> <?php echo $planned_date_formatted ?> </span>
<!--CANCELLED BUTTON-->
								<?php $hidden = array('action_id' => $action_outstanding->action_id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled','outcome' => '' ,'company_id' => $company['id'] ); echo form_open(site_url().'actions/edit', 'name="cancel_action"  class="cancel_action pull-right" style="margin-left:5px;" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action_outstanding->action_id.'" role="form"',$hidden); ?><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-sm"></i> </button>
<?php echo form_close(); ?>
<!--COMPLETED BUTTON-->
<?php $hidden = array('action_id' => $action_outstanding->action_id , 'user_id' => $current_user['id'], 'action_do' => 'completed', 'outcome' => '' ,'company_id' => $company['id']); echo form_open(site_url().'actions/edit', 'name="completed_action"  class="completed_action pull-right" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action_outstanding->action_id.'" style="display:inline-block;" role="form"',$hidden); ?>
<button class="btn btn-success btn-sm"><i class="fa fa-check fa-sm"></i> </button><?php echo form_close(); ?>
<?php elseif($action_outstanding->actioned_at): ?>
<span class="label label-success pull-right" style="font-size:11px; margin-left:10px;">Completed on <?php echo $action_outstandinged_date_formatted ?></span><?php endif; ?>

                            
                            </div>
									  			
				                              
				                           
				                            <div class="col-md-12">
											<div id="collapse<?php echo $action_outstanding->action_id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $action_outstanding->action_id ?>">
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
											
											<div id="action_outcome_box_<?php echo $action_outstanding->action_id ?>" style="display:none;">
											<hr>
											

											<textarea class="form-control" name="outcome" placeholder="Add action outcome" rows="3" style="margin-bottom:5px;"></textarea>
											<button class="btn btn-primary btn-block"><i class="fa fa-check fa-sm"></i> Send</button>

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


<!-- COMPLETED -->
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
				
								<?php if ($action_completed->action_type_id == 19): ?>
									<?php $arr = explode(' ',trim($action_completed->comments));$pipeline_updated = $arr[3];?><li class="list-group-item pipeline-update <?php echo $pipeline_updated;?>"><?php echo $action_completed->comments ?>
				                                on <?php echo date("l jS F y",strtotime($action_completed->actioned_at))." @ ".date("H:i",strtotime($action_completed->actioned_at)); ?></li>
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
											<?php echo nl2br($action_completed->comments) ?>
											<?php if (!empty($action_completed->outcome)):?>
											<hr>
											<?php echo $action_completed->outcome ?>
											<?php endif; ?>
											</div>
											</div>
											<?php endif; ?>
											</div>
											<div id="action_outcome_box_<?php echo $action_completed->id ?>" style="display:none;">
											<hr>
											<textarea class="form-control" name="outcome" placeholder="Add action outcome" rows="3" style="margin-bottom:5px;"></textarea>
											<button class="btn btn-primary btn-block"><i class="fa fa-check fa-sm"></i> Send</button>

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
				            								<!-- CANCELLED -->

				            <div class="tab-pane fade in" id="cancelled">
						<?php if (count($actions_cancelled) > 0): ?>
								<ul class="list-group">
								<?php foreach ($actions_cancelled as $action_cancelled): 
								 $created_date_formatted = date("l jS F y",strtotime($action_cancelled->created_at))." @ ".date("H:i",strtotime($action_cancelled->created_at));
								 $cancelled_at_formatted = date(" jS F y",strtotime($action_cancelled->cancelled_at))." @ ".date("H:i",strtotime($action_cancelled->cancelled_at));
								?>
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
											<button class="btn btn-primary btn-block"><i class="fa fa-check fa-sm"></i> Send</button>

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

				            <!--ALL ACTIONS -->

				<div class="tab-pane fade in" id="all">
				<?php if (count($get_actions) > 0): ?>
					<ul class="list-group">
					<?php foreach ($get_actions as $get_action):?>
						<?php if ($get_action->action_type_id == 19): ?>
									<?php $arr = explode(' ',trim($get_action->comments));$pipeline_updated = $arr[3];?><li class="list-group-item pipeline-update <?php echo $pipeline_updated;?>"><?php echo $get_action->comments ?>
				                                on <?php echo date("l jS F y",strtotime($get_action->actioned_at))." @ ".date("H:i",strtotime($get_action->actioned_at)); ?></li>
									<?php else: ?>

					<li class="list-group-item">
					<div class="row" style="padding: 15px 0">
						<div class="col-md-12 ">
							<div class="col-xs-2 col-md-1 profile-heading">
								<span>
									<?php $user_icon = explode(",", ($get_action->image)); echo "<div class='circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
								</span>
							</div>
							<div class="col-xs-6 col-md-5">
								<h4 style="margin:0;"><?php if ($get_action->action_type_id <> 20): ?><a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $get_action->id ?>all" aria-expanded="false" aria-controls="collapse<?php echo $get_action->id ?>all"><?php echo $get_action->campaign_name; ?></a>
                                    <?php else: ?>
                                    	<div style="margin-right: 10px;margin-top: -15px;font-size: 10px;float: left;"><span class="label label-default">Marketing</span></div>><?php echo $get_action->campaign_name; ?>
                                    <?php endif; ?>

								<div class="mic-info">
								Created By: <?php echo $get_action->name?> on <?php echo date('l jS F y',strtotime($get_action->created_at));?>
											</div>
											</h4>
											</div><!--END COL-MD-6-->
											<div class="col-xs-4 col-md-6" style="text-align:right;">
											<!--SHOW CONTACT NAME-->
											<?php if($get_action->contact_id):?><span class="label label-primary" style="font-size:11px; margin-left:10px;  "><?php echo $get_action->first_name.' '.$get_action->last_name; ?></span>
											<?php endif; ?>
											</div>
											<div class="col-md-12">
											<div id="collapse<?php echo $get_action->id ?>all" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $get_action->id ?>">
											<?php if (!empty($get_action->comments)):?>
											<div class="comment-text speech" >
											<div class="triangle-isosceles top">
											<?php echo $get_action->comments ?>
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
											
											<div id="action_outcome_box_<?php echo $get_action->id ?>" style="display:none;">
											<hr>
											

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
									<h4 style="margin: 50px 0 40px 0; text-align: center;">1No completed actions found for this company</h4>
								</div>
							<?php endif; ?>
				            </div>

				            <!--ALL ACTIONS-->

				            


								<!-- MARKETING -->
				             <div class="tab-pane fade in" id="marketing">
							<?php if (count($actions_marketing) > 0): ?>
								<ul class="list-group">
								<?php foreach ($actions_marketing as $actions_marketing): 
								 $created_date_formatted = date("l jS F y",strtotime($actions_marketing['date_sent']));
								?>
<li class="list-group-item">
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
							<div class="col-md-12">

				            

							<?php if (count($comments) > 0): ?>
							<ul class="list-group">
	        				<?php foreach ($comments as $comment):
							
							?>
							<li class="list-group-item">
							<div class="row">
							<div class="col-xs-10 col-md-11">
                                <div>
                                    <div class="mic-info">
                                        By: <?php echo $system_users[$comment->user_id]?> on <?php echo date("j M Y",strtotime($comment->created_at));?>
                                    </div>
                                </div>
                                <div class="comment-text" style="margin-top:10px;">
                                    <?php echo $comment->comments; ?>
                                </div>
                          
	                        </div>
	                        </div>
	                        </li>
	        			<?php endforeach ?>
	        			</ul>
	        		<?php else: ?>

	        		<div style="margin:10px 0;">
					<h4 style="margin: 50px 0 40px 0; text-align: center;">No Comments</h4>
					</div>
					<?php endif; ?>
					</div>
					<?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'done'=>'1');
					echo form_open(site_url().'actions/create', 'name="create" class="" role=""',$hidden); ?>
		            	<input type="hidden" name="action_type_completed" value="7">
		            	<div class="col-md-10">					
	                    <input id="btn-input" type="text" class="form-control input-md" name="comment" placeholder="Type your comment here...">
	                    </div>
	                    <div class="col-md-2">	
	                        <button class="btn btn-primary btn-md btn-block" id="btn-chat">
	                            Comment
	                        </button>
	                    </div>
			            </form>
				            </div>
				        </div>
				        <!-- End Tab Content -->
				    </div>
				</div>
			<!--END TABS-->
		  	</div>
		</div>
	</div>

	
    
    
    

</div><!--CLOSE ROW-->
</div>
</div>