
<?php if(empty($companies)): ?>
	<div class="alert alert-warning">No companies found</div>
<?php else: ?>

<?php  foreach ( $companies as $company):  ?>
<?php $this->load->view('companies/edit_box.php',array('company'=>$company)); ?>
<?php $this->load->view('companies/create_contact_box.php',array('company'=>$company)); ?>
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
		<div class="col-md-7">
			<h3 class="name" style="margin-top: 0px;margin-bottom: 10px;">
				<a href="<?php echo site_url();?>companies/company?id=<?php echo $company['id'];?>" target="_blank">
					<?php 
					$words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
					echo str_replace($words, ' ',$company['name']); 
					?>
				</a>
			</h3>
			<?php if (isset($company['class'])): ?>				
			<h4>
				<span class="label label-info"><?php echo $companies_classes[$company['class']] ?></span>
			</h4>
			<?php endif; ?>
		</div>
		<div class="col-md-5">
		<?php $this->load->view('companies/actions_box.php',array('company'=>$company)); ?>
		</div>
		</div>
		<div class="row">
        <!--ADDRESS-->
        <div class="col-md-12">
        	<p style="display:inline;">
				<i class="fa fa-map-marker"></i>
				<a class="btn btn-link" target="_blank" style="padding-left:0px;" href="http://maps.google.com/maps?q=<?php echo urlencode($company['address']); ?>&z=17">
					<?php echo isset($company['address'])?$company['address']:''; ?>
				</a>
			</p>
			<?php if (isset($company['phone'])): ?>
			<p style="display:inline;">
				<i class="fa fa-phone-square"></i> 
				<a class="btn btn-link" style="padding-left:0px;" href="tel:<?php echo $company['phone']; ?>">
				<?php echo $company['phone']; ?>
				</a> 
			</p>
        	<?php endif; ?>
        	<!--WEBSITE IF APPLICABLE-->
	        <?php if (isset($company['url'])): ?>
			<p style="display:inline;">
			<i class="fa fa-globe"></i>
			<a class="btn btn-link" style="padding-left:0px;" href="<?php $parsed = parse_url($company['url']); if (empty($parsed['scheme'])) { echo 'http://' . ltrim($company['url'], '/'); }else{ echo $company['url']; } ?>" target="_blank">
			<?php echo str_replace("http://"," ",str_replace("www.", "", $company['url']))?>
			</a>
			</p>
			<?php endif; ?>

			<?php if(isset($company['contacts_count'])): ?>
				<p style="display:inline;">
				<i class="fa fa-users"></i> <?php echo $company['contacts_count']; ?>
				</p>
			<?php endif; ?>
        </div>              
                
		<div class="col-md-12">
			<hr>
		</div>
		
		<!-- TURNOVER -->
		<div class="col-md-2 centre">
			<strong>Turnover</strong>
			<p class="details" style="margin-bottom:5px;">
				£<?php echo isset($company['turnover'])? number_format (round($company['turnover'],-3)):'0';?>
			</p>
            <h6 style="margin-top:0;">
            	<span class="label label-default" ><?php  echo isset($company['turnover_method'])?$company['turnover_method']:'';?></span>
            </h6>	
        </div>
        <div class="col-md-2 centre">
        	<strong>Founded</strong>
			<p class="details">
				<?php echo isset($company['eff_from'])?$company['eff_from']:''; ?>
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
	</div>
<?php endforeach; ?>
<?php endif; ?>