<?php if(empty($companies)): ?>
	<div class="alert alert-warning">No companies found</div>
<?php else: ?>
<?php  foreach ( $companies as $company):  ?>
<?php $this->load->view('companies/edit_box.php',array('company'=>$company)); ?>
<?php $this->load->view('companies/edit_box.php',array('company'=>$company)); ?>
<?php $this->load->view('companies/create_contact_box.php',array('company'=>$company)); ?>
<div class="panel <?php if(isset($company['assigned_to_name'])): ?> panel-primary <?php else: ?> panel-default <?php endif; ?> company">
	<div class="panel-body">
    <div class="row">
		<div class="col-sm-12">
			<?php if (isset($company['parent_registration'])): ?>
		<div style="height: 1px; background-color: #d9534f; text-align: center; margin:30px 0; ">
		<span class="label label-danger" style="position: relative; top: -10px;">Subsidiary of <?php echo $company['parent_registration'];?></span>
			</div>

	<?php endif; ?>
		<h2 class="company-header">
				<a href="<?php echo site_url();?>companies/company?id=<?php echo $company['id'];?>">
					<?php 
					$words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
					echo str_replace($words, ' ',$company['name']); 
					?>
				</a>
		</h2>
			</div>
			<div class="col-sm-12" style="margin-top:5px; text-align:center;">
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

	<hr>
	</div>
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
<div><strong> Next Planned Contact</strong></div>
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
<div><span class="label label-danger" style="font-size:11px;">Overdue</span></div><?php } else {}
?>
<?php endif; ?>

</div>
</div><!--END ROW-->
<hr>
</div>

 





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


		<div class="col-sm-3" style="margin-top:10px;">
		<?php $this->load->view('companies/actions_box_list.php',array('company'=>$company)); ?>
		<?php if (isset($company['url'])): ?>
		<a class="btn btn-default btn-sm btn-block btn-url" href="<?php $parsed = parse_url($company['url']); if (empty($parsed['scheme'])) { echo 'http://' . ltrim($company['url'], '/'); }else{ echo $company['url']; } ?>" target="_blank">
				<strong>Web:</strong> <?php echo str_replace("http://"," ",str_replace("www.", "", $company['url']))?>
		</a>
			<?php endif; ?>
			<?php if (isset($company['registration'])): ?>
			<a class="btn  btn-info btn-sm btn-block endole" href="http://www.endole.co.uk/company/<?php echo $company['registration'] ?>" target="_blank">Endole</a>
			<?php endif; ?>
			<?php if (isset($company['linkedin_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block linkedin" href="https://www.linkedin.com/company/<?php echo $company['linkedin_id'] ?>"  target="_blank">LinkedIn</a>
			<?php endif; ?>
			<?php if (($current_user['department']) =='support' && isset($company['zendesk_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block zendesk" href="https://sonovate.zendesk.com/agent/organizations/<?php echo $company['zendesk_id'] ?>"  target="_blank">ZenDesk</a>
		<?php endif; ?>
			<?php if (isset($company['sonovate_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block sonovate" href="https://members.sonovate.com/agency-admin/<?php echo $company['sonovate_id'] ?>/profile"  target="_blank">Sonovate 3.0</a>
			<?php endif; ?>
			</div><!--CLOSE MD-3-->
		</div>
		<div class="col-md-12">
			<hr>
		</div>
		
        		<div class="row">
		<div class="col-xs-12">
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
		</div>
		</div>

		<div class="col-md-12">
			<hr>
		</div>

		<div class="row">
            
		<!-- MORTGAGES -->
			
			<div class="col-md-12">
			<?php if(!empty($company['mortgages'])): ?>
			<table class="table table-hover" style="font-size:12px">
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
					<td class="col-md-6" ><?php echo $mortgage['name']; ?>
					<span class="label label-default" style="margin-left: 20px;padding: 1px 10px;"><?php echo $mortgage['type']; ?></span>
					</td>
					<td class="col-md-3" style="text-align:center;"><?php echo $mortgage['eff_from']; ?></td>
					<td class="col-md-3" style="text-align:center;"><!--<span class="label label-<?php echo $mortgage['stage']==MORTGAGES_SATISFIED? 'default' : 'success' ?>">--><strong><?php echo $mortgage['stage']; ?></strong><?php if(!empty($mortgage['eff_to'])){echo ' on '.$mortgage['eff_to'];} ?></span></td>

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
<?php endforeach; ?>
<?php endif; ?>