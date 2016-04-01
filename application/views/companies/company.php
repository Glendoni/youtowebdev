<?php  $company = $companies[0]; ?>
<?php if (!empty($_GET['campaign_id'])): 
$campaign_id = $_GET['campaign_id'];
endif; ?>
		<?php if (!isset($company['id'])): ?>
<div class="alert alert-danger" role="alert">This company is no longer active.</div>
			<?php endif; ?>
<?php //hide core page content if no company is found ?>
<?php if (isset($company['id'])): ?>
<div class="page-results-list">
<div class="top-info-holder">
    <div class="row">
		<?php if (isset($company['parent_name'])): ?>
			<div class="subsidiary">
			<span class="label label-danger"><a href="<?php echo site_url();?>companies/company?id=<?php echo $company['parent_id'];?>" target="_blank">Subsidiary of <?php echo $company['parent_name'];?> <i class="fa fa-external-link"></i></a></span>
			</div>
			<?php elseif (isset($company['parent_registration'])): ?>
				<div class="subsidiary">
			<span class="label label-danger"><a href="https://beta.companieshouse.gov.uk/company/<?php echo $company['parent_registration'];?>" target="_blank">Parent Registration: <?php echo $company['parent_registration'];?> <i class="fa fa-external-link"></i></a></span>
			</div>
		<?php endif; ?>
	<h2 class="company-header">
		<?php $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );echo str_replace($words, ' ',$company['name']); ?>
	<?php if(isset($company['assigned_to_name']) and !empty($company['assigned_to_name'])): ?>
		<?php if($company['assigned_to_id'] == $current_user['id']) : ?>	
			<?php  $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'], 'page_number' => (isset($current_page_number))? $current_page_number:'');
			echo form_open('companies/unassign',array('name' => 'assignto', 'class'=>'assign-to-form', 'style'=>'display: inline;'),$hidden); ?>
			<button type="submit" class="assigned-star ladda-button" data-style="expand-right" data-size="1">
<i class="fa fa-star"></i>
</button>
			<?php echo form_close(); ?>
		<?php endif; ?>
	<?php else: ?>
	<?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'], 'page_number' => (isset($current_page_number))? $current_page_number:'');
	echo form_open(site_url().'companies/assignto',array('name' => 'assignto', 'class'=>'assign-to-form', 'style'=>'display: inline;'),$hidden); ?>
	<button type="submit" assignto="<?php echo $current_user['name']; ?>" class="unassigned-star ladda-button" data-style="expand-right" data-size="1">
<i class="fa fa-star-o"></i>
</button>
	<?php echo form_close(); ?>
	<?php endif; ?>
</h2>

<!--END ASSIGN-->

	
	<?php if (isset($company['trading_name'])): ?>
<h5 class="trading-header">
<?php echo $company['trading_name'];?>
</h5>
	<?php endif; ?>
	</div><!--END ROW-->

	<div class="row" style="margin-top:5px; text-align:center;">
	<?php if(!empty($company['pipeline'])): ?>
	<span class="label pipeline label-<?php echo str_replace(' ', '', $company['pipeline']); ?>">#<?php echo $company['pipeline']?>
	<?php endif; ?>
	<?php if (isset($company['customer_from'])&&($company['pipeline']=='Customer')):?>
		from <?php echo date("d/m/y",strtotime($company['customer_from']));?>
		<?php endif; ?>
		</span>
	<?php if(isset($company['assigned_to_name'])): ?>
		<span class="label label-assigned"
		<?php $user_icon = explode(",", ($company['image']));echo "style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'";?>>
        <i class="fa fa-star"></i>
<?php echo $company['assigned_to_name']; ?>
        </span>
	<?php else: ?>
	<?php endif; ?>
	</div><!--END ROW-->

	<!-- POPUP BOXES -->
	<?php $this->load->view('companies/edit_box.php',array('company'=>$company)); ?>
	<?php $this->load->view('companies/create_contact_box.php',array('company'=>$company)); ?>
	<?php $this->load->view('companies/create_address_box.php',array('company'=>$company)); ?>

	<!-- // POPUP BOXES -->
</div><!--END TOP INFO HOLDER-->

    
   
<div class="panel panel-primary" style="padding-top: 30px;">
	<div class="panel-body">
    	<div class="row"><!--FINISHED AT THE END OF PANEL-->
		<div class="col-sm-9">
		<div class="row">
<div class="col-sm-12 action-details">
<div class="row"> 
<div class="col-md-6 col-lg-6 col-sm-6">
<div><strong>Last Contact</strong></div>
<div>
<?php if (empty($company['actioned_at1'])): ?>
Never
<?php else: ?>
<div class="action_type"><?php echo $company['action_name1']." by ".$company['action_user1']; ?></div>
<div class="action_date_list">
<?php echo date("l jS F Y",strtotime($company['actioned_at1']));?>
<?php
$now = time (); // or your date as well
$your_date = strtotime($company['actioned_at1']);
$datediff = abs($now - $your_date);
$days_since = floor($datediff/(60*60*24));
if ($company['actioned_at1'] > 0){
	echo " (".$days_since." days ago)";
	} else {
	echo " (".$days_since." day ago)";;
	}
?></div>

<?php endif; ?>

</div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6">
<div><strong> Next Contact</strong></div>
<?php if (empty($company['planned_at2'])): ?>
	None
<?php else: ?>
	<div class="action_type"><?php echo $company['action_name2']." by ".$company['action_user2']; ?></div>

	<div class="action_date_list">
<?php echo date("l jS F Y",strtotime($company['planned_at2']));?>
</div>
<?php
$now = time (); // or your date as well
$your_date = strtotime($company['planned_at2']);
$days_since = floor($datediff/(60*60*24));
if ($your_date < $now){; ?>
<div><span class="label label-danger" style="font-size:10px;">Overdue</span></div><?php } else {}
?>
<?php endif; ?>

</div>
</div><!--END ROW-->
<hr>
</div>

	<?php if (isset($company['trading_name'])): ?>
		<div class="col-md-6">
				<label>Registered Name</label>
				<p>	
	
				<?php echo $company['name']; ?>
				</p>
		</div><!--END NAME-->
		<div class="col-md-6">
				<label>Trading Name</label>
				<p>	
				<?php echo $company['trading_name']; ?>
				</p>
		</div><!--END TRADING NAME-->
            
		<?php else: ?>
				<div class="col-md-6">
				<label>Registered Name</label>
				<p style="margin-bottom:10px;">	
				<?php echo $company['name']; ?>
				</p>
		</div><!--END NAME-->
		<?php endif; ?>
		<div class="col-md-6">
				<label>Registered Address</label>
				<p>	

                <?php echo isset($company['address'])?'<a href="http://maps.google.com/?q='.urlencode($company['address']).'" target="_blank">'.$company['address'].'<span style="    line-height: 15px;font-size: 10px;padding-left: 5px;"><i class="fa fa-external-link"></i></span></a>':'-'; ?>  
				</p>
		</div><!--END ADDRESS-->
		

            
            	<div class="col-md-6">
				<label>Phone</label>
				<p style="margin-bottom:0;">	
				<?php echo $company['phone']; ?>
				</p>
		</div><!--END TRADING NAME-->
            
		</div><!--END ROW-->
        </div><!--CLOSE MD-9-->
		<div class="col-sm-3">
		<!--Check if company is blacklisted - if so hide the actions boxes -->
		<?php if ($company['pipeline']=='Blacklisted'): ?>
		<?php else: ?>
		<?php $this->load->view('companies/actions_box.php',array('company'=>$company)); ?>

		<!-- LINKS AND BTN -->
			<?php if (isset($company['sonovate_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block sonovate" href="https://members.sonovate.com/agency-admin/<?php echo $company['sonovate_id'] ?>/profile"  target="_blank">Sonovate 3.0</a>
			<?php endif; ?>
	<?php if (($current_user['department']) =='support' && isset($company['zendesk_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block zendesk" href="https://sonovate.zendesk.com/agent/organizations/<?php echo $company['zendesk_id'] ?>"  target="_blank">ZenDesk</a>
			<?php endif; ?>
			<?php if (isset($company['linkedin_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block linkedin" href="https://www.linkedin.com/company/<?php echo $company['linkedin_id'] ?>"  target="_blank">LinkedIn</a>
            <?php else: ?>
		<?php $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
		$name_no_ltd = str_replace($words, '',$company['name']); ?>

              <a class="btn  btn-primary btn-sm btn-block" href="https://www.linkedin.com/vsearch/f?type=all&keywords=<?php echo  urlencode($name_no_ltd) ?>"  target="_blank">Search LinkedIn</a>
            <?php endif; ?>
					<?php if (isset($company['url'])): ?>
		<a class="btn btn-default btn-sm btn-block btn-url" href="<?php $parsed = parse_url($company['url']); if (empty($parsed['scheme'])) { echo 'http://' . ltrim($company['url'], '/'); }else{ echo $company['url']; } ?>" target="_blank">
		<label style="margin-bottom:0;"></label> <?php echo str_replace("http://"," ",str_replace("www.", "", $company['url']))?>
		</a>
		<?php endif; ?>
			<?php if (isset($company['registration'])): ?>
			<a class="btn  btn-info btn-sm btn-block companieshouse" href="https://beta.companieshouse.gov.uk/company/<?php echo $company['registration'] ?>" target="_blank">Companies House</a>
			<?php endif; ?>
		<?php endif; ?>
        </div><!--CLOSE COL-MD-3-->
		<div class="col-md-12">
			<hr>
		</div>
<div class="row padding-bottom">
		<div class="col-xs-6 col-md-3 centre" style="margin-top:10px;">
			<label>Company Number</label>
			<p>	
			 <!--COMPANY NUMBER IF APPLICABLE-->
			<?php echo isset($company['registration'])?$company['registration']:''; ?>
         	</p>
        	</div>

        	<div class="col-xs-6 col-md-3 centre" style="margin-top:10px;">
        	<label>Founded</label>
			<p>	
				<?php echo isset($company['eff_from'])?$company['eff_from']:''; ?>
			</p>
		</div>

        <div class="col-xs-6 col-md-3 centre" style="margin-top:10px;">
        		<label>Phone</label>
        		<p>
        		<?php echo isset($company['phone'])?$company['phone']:''; ?>                
           		</p>
			</div><!--END PHONE NUMBER-->
		<div class="col-xs-6 col-md-3 centre" style="margin-top:10px;">
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

		</div>
		<div class="row">
		<div class="col-xs-12">
		<!-- TURNOVER -->
		<div class="col-xs-4 col-sm-3 centre">
			<strong><span style="text-transform: capitalize"><?php echo isset($company['turnover_method'])?$company['turnover_method']:'';?></span> Turnover</strong>
			<p class="details" style="margin-bottom:5px;">
				<?php echo isset($company['turnover'])? '£'.number_format (round($company['turnover'],-3)):'';?>
			</p>
        </div>
		<!-- CONTACTS -->
		<div class="col-xs-4 col-sm-3 centre">
			<strong>Contacts</strong>			
			<?php if (isset($company['contacts_count'])): ?>
			<p class="details"><?php echo $company['contacts_count'];?> </p>
			<?php else: ?>
			<p class="details">0 </p>
			<?php endif; ?>
		</div>
		<!-- EMPLOYEES -->
		<div class="col-xs-4 col-sm-3 centre">
			<strong>Employees</strong>
			<?php if (isset($company['emp_count'])): ?>
			<p class="details"><?php echo $company['emp_count'];?> </p>
			<?php else: ?>
			<?php endif; ?>
		</div>
		<!-- SECTORS -->
		<div class="col-xs-4 col-sm-3 centre">
			<strong>Sectors</strong> 
			<?php
			if(isset($company['sectors'])){
		
				foreach ($company['sectors'] as $key => $name)
				{
				echo '<p class="details" style="margin-bottom:0; text-align:centre;">'.$name.'</p>';
				}
			}
			?>


<?php if (isset($company['perm'])): ?>
<p class="details" style="margin-bottom:0; text-align:centre;"><b>Permanent</b></p>
<?php endif; ?>
<?php if (isset($company['contract'])): ?>
<p class="details" style="margin-bottom:0; text-align:centre;"><b>Contract</b></p>
<?php endif; ?>
</div>
		</div>
		</div>
		</div>
		<div class="col-md-12">
			<hr>
		</div>

		
       
		<!-- MORTGAGES -->


		
		<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">
		Financials
		</div>
		<!-- /.panel-heading -->
 
		<div class="panel-body">
            
		<?php if(!empty($company['mortgages'])): ?>
			<table class="table table-hover">
			<thead>
				<tr>
					<th class="col-md-6">Mortgage Provider</th>
					<th class="col-md-3" style="text-align:center;">Started</th>
					<th class="col-md-3" style="text-align:center;">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($company['mortgages'] as $mortgage):?>
				<tr <?php echo $mortgage['stage']==MORTGAGES_SATISFIED? 'class="danger"' : 'class="success"' ?>>
				<td class="col-md-6" >
					<?php if(isset($mortgage['url'])) : ?>
						<a href="http://<?php echo $mortgage['url']; ?>" target="_blank"><?php echo $mortgage['name']; ?> <span style="font-size:10px;"><i class="fa fa-external-link"></i></span></a>
	    			<?php else: ?>
						<?php echo $mortgage['name']; ?>
					<?php endif; ?>
				<div style="font-size:10px;">
				<?php echo $mortgage['type']; ?>
				</div>
				</td>
				<td class="col-md-3" style="text-align:center;">
				<?php $mortgages_start  = $mortgage['eff_from'];$date_pieces = explode("/", $mortgages_start);$formatted_mortgage_date = $date_pieces[2].'/'.$date_pieces[1].'/'.$date_pieces[0];echo date("F Y",strtotime($formatted_mortgage_date));?>
				</td>
				<td class="col-md-3" style="text-align:center;">
				<?php echo ucfirst($mortgage['stage']); ?><?php if(!empty($mortgage['eff_to'])){echo ' on '.$mortgage['eff_to'];} ?>
				</td>



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
		<div class="panel-heading" id="addresses">
		Locations
		<div class="pull-right">
            
		<div class="btn-group">
            <button  class="btn btn-primary edit-btn btn-xs" data-toggle="modal" id="create_address_<?php echo $company['id']; ?>"  data-target="#create_address_<?php echo $company['id']; ?>" >
            <span class="ladda-label"> Add Location </span>
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
	          <th class="col-md-7">Address</th>
	          <th class="col-md-2">Type</th>
	          <th class="col-md-2">Phone</th>
				<th class="col-md-1"></th>

	        </tr>
	      </thead>
	      <tbody>
	      	<?php foreach ($addresses as $address): ?>
	      	<tr>
				<td class="col-md-6">
                 <a target="_blank" href="http://maps.google.com/?q=<?=$address->address; ?>" ><span class="mainAddress"><?=$address->address; ?></span><span style="line-height: 15px;font-size: 10px;padding-left: 5px;"><i class="fa fa-external-link"></i></span></a></td>
				<td class="col-md-3 mainAddrType"><?php echo $address->type;?></td>
				<td class="col-md-2 mainPhone"><?php echo $address->phone; ?></td>
				<td  class="col-md-3">
				<?php if ($address->type<>'Registered Address'): ?>
		      	<div class=" pull-right ">
	            <?php $this->load->view('companies/action_box_addresses.php',array('address'=>$address)); ?>
	            </div>
	            <?php else: ?>
	        	<?php endif; ?>
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
		<div class="panel-heading" id="campaigns">
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
		<button  class="btn btn-primary edit-btn btn-xs" data-toggle="modal" id="create_contact_<?php echo $company['id']; ?>"  data-target="#create_contact_<?php echo $company['id']; ?>" >
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
	          	<th class="col-md-2">Name</th>
	          	<th class="col-md-2">Role</th>
	          	<th class="col-md-3">Email</th>
				<th class="col-md-2">Phone</th>
				<th class="col-md-3"></th>


	        </tr>
	      </thead>
	      <tbody>
<?php foreach ($contacts as $contact): ?>
	      	<tr>
				<td class="col-md-2">
				<?php echo ucfirst($contact->first_name).' '.ucfirst($contact->last_name); ?>
				</td>
				<td class="col-md-2"><?php echo ucfirst($contact->role); ?></td>
				<td class="col-md-3"><?php echo $contact->email; ?>&nbsp;
	<?php if (!empty($contact->email_opt_out_date)): ?>
		<span class="label label-danger contact-opt-out">Email Marketing Opt-Out</span>
	<?php endif;?></td>
				<td  class="col-md-2"><?php echo $contact->phone; ?></td>
								<td  class="col-md-3"><div class="pull-right mobile-left actionsactionscontact-options">
				<?php if ($company['pipeline']=='Blacklisted'): ?>
				<?php else: ?>
	            <?php $this->load->view('companies/action_box_contacts.php',array('contact'=>$contact)); ?>
	        	<?php endif; ?>
	            </div></td>

        	</tr>
			<?php endforeach; ?>  
	      </tbody>
	    </table>

	    <?php else: ?>
			<div class="alert alert-info" style="margin-top:10px;">
                None
            </div>
		<?php endif; ?>

		</div>
		<!-- /.panel-body -->
		</div>
		</div>
        
        


		<!--ACTIONS-->
		<div class="col-md-12" id="add_action">
		<div class="panel panel-default ">
		  <div class="panel-heading">Add Action</div>
		  <div class="panel-body">
		   <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'done'=>'1','campaign_id' => $campaign_id, 'class_check' => $companies_classes[$company['class']],'source_check' => $company['source'],'sector_check' => count($company['sectors']),);
			echo form_open(site_url().'actions/create', 'name="create" class="form" role="form"',$hidden); ?>
			<!--THE BELOW PASSES THE CLASS FIELD ACROSS PURELY FOR VALIDATION - IF THERE IS A BETTER WAY OF DOING THIS THEN IT NEEDS TO BE HERE-->
			
			<!--VALIDATION ERROR IF NO ACTION IS SELECTED-->

			<div id="action-error" class="no-source alert alert-warning" role="alert" style="display:none">
            <strong>Source Required.</strong><br> To add a Deal or Proposal, please add a Source to this company.
            </div>

<div class="row">
			<div class="col-sm-3 col-md-3">
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
    
    
    <div class="col-sm-3 col-md-2 initialfee">
						<div class="form-group ">
							<label>Initial Fee</label>
							 
                            
                            
		<div class="input-group">
      	<input type="number" step="0.01" name="initialfee" class="form-control">
		<div class="input-group-addon">%</div>
		</div>
		</div>
		</div>
			<div class="col-sm-3 col-md-3  onInitialFee">

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
				
				 <div class="col-sm-3 col-md-3 onInitialFee">
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
	                <div class="col-sm-3 col-md-3">
						<div class="form-group " >
							<label>Follow Up Date</label>
							<input type="text" class="form-control follow-up-date" id="planned_at" data-date-format="YYYY/MM/DD H:m" name="planned_at" placeholder="">
						</div>
	                </div>
			<div class="col-sm-12 col-md-12">
				<div class="form-group ">
					<label>Outcome</label>
<textarea class="form-control completed-details" name="comment" rows="3" required="required"></textarea>
				</div>
				<button type="submit" name="no contno con" class="btn btn-primary form-control disable_no_source">Add Action</button>
			</div>
			<?php echo form_close(); ?>
			</div>
		  </div>
		</div>
		</div>
        
                  <!-- TAGGING  START-->
        
        <div class="tag-tabs">
  <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
			Tagging
			</div>
        <!-- /.panel-heading -->
        <div class="panel-body">
               
         <div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active activein"><a href="#cat1"  class="cat1" aria-controls="cat1" role="tab" data-toggle="tab"> </a></li>
    <li role="presentation"><a href="#cat2" class="cat2" aria-controls="cat2" role="tab" data-toggle="tab"> </a></li>
    <li role="presentation"><a href="#cat3"  class="cat3" aria-controls="cat3" role="tab" data-toggle="tab"> </a></li>
    <li role="presentation"><a href="#cat4"  class="cat4" aria-controls="cat4" role="tab" data-toggle="tab"> </a></li>
      <li role="presentation"><a href="#cat5"  class="cat5" aria-controls="cat5" role="tab" data-toggle="tab"> </a></li>
    <li role="presentation"><a href="#cat6"  class="cat6" aria-controls="cat6" role="tab" data-toggle="tab"> </a></li>
  </ul>

  <!-- Tab panes -->
             <div class=" col-lg-12 tafixed">
                  <p align="center" style="
    margin-left: 35px;
">Tags</p>
              
             </div>
             <div class="tadefault col-lg-12">
                 
                    <p>Tags are used to provide <span>Sonovate</span> with a better insigt into current and potential clients. Tags are snippets of text that describe a company's business. Tags are snippets of text that describe a company's business.  </p>
                </div>
             
             <div class="col-lg-6">
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="cat1">    
        <div class="col-lg-5">  
            <div id="" class="tagContainer"> 
                <ul class="list-group main">
                </ul>
            </div>
        </div>
    <div class="col-lg-5">  
        <div id="" class="tagContainer"> 
            <ul class="list-group sub">
            </ul>
        </div>
    </div>
 
</div>
<div role="tabpanel" class="tab-pane" id="cat2">
    <div class="col-lg-5">  
        <div id="" class="tagContainer"> 
            <ul class="list-group main">
            </ul>
        </div>
    </div>
    <div class="col-lg-5">  
        <div id="" class="tagContainer"> 
            <ul class="list-group sub">
            </ul>
        </div>
    </div>
   
</div>
<div role="tabpanel" class="tab-pane" id="cat3">
    <div class="col-lg-6">  
        <div id="" class="tagContainer"> 
            <ul class="list-group main">
            </ul>
        </div>
    </div>
    <div class="col-lg-5">  
        <div id="" class="tagContainer"> 
            <ul class="list-group sub">
            </ul>
        </div>
    </div>
    
</div>
<div role="tabpanel" class="tab-pane" id="cat4">
    <div class="col-lg-6">  
        <div id="" class="tagContainer"> 
            <ul class="list-group main">
            </ul>
        </div>
    </div>
    <div class="col-lg-5">  
        <div id="" class="tagContainer"> 
            <ul class="list-group sub">
            </ul>
        </div>
    </div>
    
</div>
<div role="tabpanel" class="tab-pane" id="cat5">
    <div class="col-lg-6">  
        <div id="" class="tagContainer"> 
            <ul class="list-group main">
            </ul>
        </div>
    </div>
    <div class="col-lg-5">  
        <div id="" class="tagContainer"> 
            <ul class="list-group sub">
            </ul>
        </div>
    </div>
   
</div>
<div role="tabpanel" class="tab-pane" id="cat6">
    <div class="col-lg-6">  
        <div id="" class="tagContainer"> 
            <ul class="list-group main">
            </ul>
        </div>
    </div>
    <div class="col-lg-5">  
        <div id="" class="tagContainer"> 
            <ul class="list-group sub">
            </ul>
        </div>
    </div>
   
</div>
</div>
             </div>    
</div>   
            <div class="col-lg-6"> 
                
                <h4 class="ta"></h4>
            
             
                <ul id="fetags">
                    
                    </ul>
                
                </div></div>
       
        </div>   
        </div>
       
    </div>
        
        
        <!--TAGGING END -->
        
        
        
        
			<div class="col-md-12" >
		<div class="panel panel-default " id="actions">
			<div class="panel-heading">
			Actions
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
							<?php if (count($actions_marketing) >= 0): ?>
				            <li><a href="#marketing" data-toggle="tab">Marketing <span class="label label-default marketingAcitonCtn">
				            <?php //echo count($actions_marketing);?>0</span></a></li>
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
						<div class="row">
							<div class="col-xs-2 col-md-1 profile-heading">
								<?php $user_icon = explode(",", ($action_outstanding->image)); echo "<div class='circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
							</div>
							<div class="col-xs-10 col-md-6">
								<h4 style="margin:0;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $action_outstanding->action_id ?>" aria-expanded="false" aria-controls="collapse<?php echo $action_outstanding->action_id ?>">
								<?php echo $action_types_array[$action_outstanding->action_type_id]; ?><?php if(strtotime($action_outstanding->planned_at) < $now and !isset($action_outstanding->actioned_at)):?>
								<?php endif ?>
									</a>
								</h4>
								<?php if( strtotime($action_outstanding->planned_at ) < strtotime('now') ) {?>
                                    <span class="label label-overdue">Overdue</span>
                                    <?php }; ?>
								<div class="mic-info">
								Created By: <?php echo $system_users[$action_outstanding->user_id]?> on <?php echo $created_date_formatted?>
								</div>
								 <?php if(!empty($action_outstanding->first_name)) : $contact_details_for_calendar = urlencode('Meeting with '.$action_outstanding->first_name.' '.$action_outstanding->last_name).'%0A'.urlencode($action_outstanding->email.' '.$action_outstanding->phone).'%0D%0D';?>
                              <?php endif ?>

								
       							
							</div><!--END COL-MD-6-->


							<div class="col-xs-12 col-md-5">
							<!--SHOW CONTACT NAME-->
                            <?php if($action_outstanding->contact_id):?><span class="label label-primary" style="font-size:10px; margin:0 10px;  "><?php echo $action_outstanding->first_name.' '.$action_outstanding->last_name; ?></span>
                            <?php endif; ?>
								<?php if(strtotime($action_outstanding->planned_at) > $now and !isset($action_outstanding->actioned_at)) : ?>
								<span class="label label-warning"><?php echo $planned_date_formatted ?> </span> 
								<span style="margin-top:0; margin-left:3px;"><small><a class="btn btn-default btn-xs add-to-calendar" href="http://www.google.com/calendar/event?action=TEMPLATE&text=<?php echo urlencode($action_types_array[$action_outstanding->action_type_id].' | '.$action_outstanding->company_name); ?>&dates=<?php echo date("Ymd\\THi00",strtotime($action_outstanding->planned_at));?>/<?php echo date("Ymd\\THi00\\Z",strtotime($action_outstanding->planned_at));?>&details=<?php echo $contact_details_for_calendar;?><?php echo urlencode('http://baselist.herokuapp.com/companies/company?id='.$action_outstanding->company_id);?>%0D%0DAny changes made to this event are not updated in Baselist. %0D%23baselist"target="_blank" rel="nofollow" style="margin-top:0; font-size:10px;">Add to Calendar</a></small></span>


								<?php $hidden = array('action_id' => $action_outstanding->action_id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled','outcome' => '' ,'company_id' => $company['id'],'campaign_id' => $campaign_id,); echo form_open(site_url().'actions/edit', 'name="cancel_action"  class="cancel_action pull-right" style="margin-left:5px;" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action_outstanding->action_id.'" role="form"',$hidden); ?>
<button class="btn btn-danger btn-sm" ><i class="fa fa-trash-o fa-sm"></i> </button>
<?php echo form_close(); ?>

<?php $hidden = array('action_id' => $action_outstanding->action_id , 'user_id' => $current_user['id'], 'action_do' => 'completed', 'outcome' => '' ,'action_type_id_outcome' =>'','company_id' => $company['id'],'campaign_id' => $campaign_id,);
echo form_open(site_url().'actions/edit', 'name="completed_action"  class="completed_action pull-right" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action_outstanding->action_id.'" style="display:inline-block;" role="form"',$hidden); ?><button class="btn btn-success btn-sm"><i class="fa fa-check fa-sm"></i> </button>
<?php echo form_close(); ?>


								<?php elseif(strtotime($action_outstanding->planned_at) < $now and !isset($action_outstanding->actioned_at)):?>
								<span class="label label-overdue" style="margin-left:10px;"><?php echo $planned_date_formatted ?> </span><span style="margin-top:0; margin-left:3px;"><small><a class="btn btn-default btn-xs add-to-calendar" href="http://www.google.com/calendar/event?action=TEMPLATE&text=<?php echo urlencode($action_types_array[$action_outstanding->action_type_id].' | '.$action_outstanding->company_name); ?>&dates=<?php echo date("Ymd\\THi00",strtotime($action_outstanding->planned_at));?>/<?php echo date("Ymd\\THi00\\Z",strtotime($action_outstanding->planned_at));?>&details=<?php echo $contact_details_for_calendar;?><?php echo urlencode('http://baselist.herokuapp.com/companies/company?id='.$action_outstanding->company_id);?>%0D%0DAny changes made to this event are not updated in Baselist. %0D%23baselist"target="_blank" rel="nofollow" style="margin-top:0; font-size:10px;">Add to Calendar</a></small></span>
<!--CANCELLED BUTTON-->
<?php $hidden = array('action_id' => $action_outstanding->action_id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled','outcome' => '' ,'company_id' => $company['id'],'campaign_id' => $campaign_id, ); echo form_open(site_url().'actions/edit', 'name="cancel_action"  class="cancel_action pull-right" style="margin-left:5px;" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action_outstanding->action_id.'" role="form"',$hidden); ?><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-sm"></i> </button>
<?php echo form_close(); ?>


<!--COMPLETED BUTTON-->
<?php $hidden = array('action_id' => $action_outstanding->action_id , 'user_id' => $current_user['id'], 'action_do' => 'completed', 'outcome' => '' ,'company_id' => $company['id'],'campaign_id' => $campaign_id,); echo form_open(site_url().'actions/edit', 'name="completed_action"  class="completed_action pull-right" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action_outstanding->action_id.'" style="display:inline-block;" role="form"',$hidden); ?>
<button class="btn btn-success btn-sm"><i class="fa fa-check fa-sm"></i> </button><?php echo form_close(); ?>
<?php elseif($action_outstanding->actioned_at): ?>
<span class="label label-success pull-right" style="font-size:10px; margin-left:10px;">Completed on <?php echo $action_outstandinged_date_formatted ?></span><?php endif; ?>

                            
                            </div>
									  			
				                              
				                           
							<div class="col-xs-12">
											<div id="collapse<?php echo $action_outstanding->action_id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $action_outstanding->action_id ?>">
											<?php if (!empty($action_outstanding->comments)):?>
											<div class="comment-text speech" >
											<div class="triangle-isosceles top">
											<?php echo $action_outstanding->comments ?>
											<?php if (!empty($action_outstanding->outcome)):?>
											<table style="width:100%">
											<tr>
											<td style="width:35%"><hr/></td>
											<td style="width:20%;vertical-align:middle; text-align: center; font-size:10px; color: #222;"> Outcome </td>
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
											<button class="btn btn-primary btn-block">Add Outcome</button>

											</div>
											</div><!--END ACTIONS-->   
				                        </div><!--END ROW-->
				                </li>
				                <?php endforeach ?>
				                </ul>
							<?php else: ?>
								<div class="col-md-12">
									<h4 style="margin: 50px 0 40px 0; text-align: center;">No Outstanding Actions</h4>
								</div>
							<?php endif; ?>
				            </div>    


        <!-- COMPLETED -->
				<div class="tab-pane fade in" id="completed">
				   	<?php if (count($actions_completed) > 0): ?>
						<ul class="list-group">
								<?php foreach ($actions_completed as $action_completed): 
								 $created_date_formatted = date("l jS F y",strtotime($action_completed->created_at))." @ ".date("H:i",strtotime($action_completed->created_at));
								 $actioned_date_formatted = date("l jS F y",strtotime($action_completed->actioned_at))." @ ".date("H:i",strtotime($action_completed->actioned_at));
								 $now = date(time());
								?>
				
						<?php if ($action_completed->action_type_id == 19): ?>
									<?php $arr = explode(' ',trim($action_completed->comments));$pipeline_updated = $arr[3];?><li class="list-group-item pipeline-update <?php echo $pipeline_updated;?>"><?php echo $action_completed->comments ?>
				                                on <?php echo date("l jS F y",strtotime($action_completed->created_at))." @ ".date("H:i",strtotime($action_completed->created_at)); ?></li>
									<?php else: ?>
						<li class="list-group-item">
							<div class="row" style="padding: 15px 0">
								<div class="col-md-12 ">
									<div class="col-xs-2 col-md-1 profile-heading">
										<span>
										<?php $user_icon = explode(",", ($action_completed->image)); echo "<div class='circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
										</span>
									</div>
							<div class="col-xs-6 col-md-5">
								<h4 style="margin:0;">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $action_completed->id ?>" aria-expanded="false" aria-controls="collapse<?php echo $action_completed->id ?>">
									<?php echo $action_types_array[$action_completed->action_type_id]; ?>
                                       
                                      <?php if($action_completed->action_type_id == 16){echo  ' ' . $company['initial_rate'] .'%';} ?>
                                    </a>
								<div class="mic-info">
								Created By: <?php echo $action_completed->name;?> on <?php echo $created_date_formatted?>
											</div>
											</h4>
											</div><!--END COL-MD-5-->
											<div class="col-xs-4 col-md-6" style="text-align:right;">
											<!--SHOW CONTACT NAME-->
											<?php if($action_completed->contact_id):?><span class="label label-primary" style="font-size:10px; margin-left:10px;  "><?php echo $action_completed->first_name.' '.$action_completed->last_name; ?></span>
											<?php endif; ?>
											<span class="label label-success" style="font-size:10px; margin-left:10px;">Completed on <?php echo date("l jS F y",strtotime($action_completed->actioned_at))." @ ".date("H:i",strtotime($action_completed->actioned_at)); ?></span>
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
										<?php $user_icon = explode(",", ($action_cancelled->image)); echo "<div class='circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
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
											<?php if($action_cancelled->contact_id):?><span class="label label-primary" style="font-size:10px; margin-left:10px;  "><?php echo $option_contacts[$action_cancelled->contact_id]; ?></span>
											<?php endif; ?>
											<span class="label label-danger" style="font-size:10px; margin-left:10px;">Cancelled on <?php echo $cancelled_at_formatted ?></span>
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
											<td style="width:20%;vertical-align:middle; text-align: center; font-size:10px; color: #222;"> Outcome </td>
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
                                    	<div style="margin-right: 10px;margin-top: -15px;font-size: 10px;float: left;"><span class="label label-default">Marketing</span></div>
                                    	<?php echo $get_action->campaign_name; ?>
                                    <?php endif; ?>

								<div class="mic-info">
								Created By: <?php echo $get_action->name?> on <?php echo date('l jS F y',strtotime($get_action->created_at));?>
											</div>
											</h4>
											</div><!--END COL-MD-6-->
											<div class="col-xs-4 col-md-6" style="text-align:right;">
											<!--SHOW CONTACT NAME-->
											<?php if($get_action->contact_id):?><span class="label label-primary" style="font-size:10px; margin-left:10px;  "><?php echo $get_action->first_name.' '.$get_action->last_name; ?></span>
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
											<td style="width:20%;vertical-align:middle; text-align: center; font-size:10px; color: #222;"> Outcome </td>
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
									<h4 style="margin: 50px 0 40px 0; text-align: center;">No completed actions found for this company</h4>
								</div>
							<?php endif; ?>
				            </div>

				            <!--ALL ACTIONS-->

				            


<!-- MARKETING -->
<div class="tab-pane fade in" id="marketing">
    <ul class="list-group statAction">
        <?php if (count($actions_marketing) > 0): ?>
           
            <?php else: ?>
            <div class="col-md-12 actionMsg">
            <h4 style="margin: 50px 0 40px 0; text-align: center;">No completed actions found for this company</h4>
            </div>
        <?php endif; ?>
    </ul>
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
<?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'done'=>'1','campaign_id' => $campaign_id,);
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
        
        
            

    <!-- /.panel -->
    
  </div>
        
	</div>
    
    
    
    
    
    
</div><!--CLOSE ROW-->
    
    
    


    
    
</div>
    
    
    <?php //hide core page END ?>
       <?php endif; ?>
 
    
    
</div>
 
