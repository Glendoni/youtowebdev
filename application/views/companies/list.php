
<?php if(empty($companies)): ?>
	<div class="alert alert-warning">No companies found</div>
<?php else: ?>

<?php  foreach ( $companies as $company):  ?>
<?php $this->load->view('companies/edit_box.php',array('company'=>$company)); ?>
<?php $this->load->view('companies/create_contact_box.php',array('company'=>$company)); ?>
<div class="panel <?php if(isset($company['assigned_to_name'])): ?> panel-primary <?php else: ?> panel-default <?php endif; ?> company">
	<?php if(isset($company['assigned_to_name'])): ?>

	<div class="panel-heading profile-heading text-center"  <?php if(isset($company['assigned_to_name'])): ?> <?php $user_icon = explode(",", ($system_users_images[$company['assigned_to_id']]));echo "style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'";?><?php else: ?> <?php endif; ?>>
        <h3>Assigned to <?php echo $company['assigned_to_name']; ?></h3>
    </div>
	<?php endif; ?>
	<div class="panel-body">
    <div class="row">
		<div class="col-md-9">
			<h3 class="name" style="margin-top: 0px;margin-bottom: 0;">
				<a href="<?php echo site_url();?>companies/company?id=<?php echo $company['id'];?>">
					<?php 
					$words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
					echo str_replace($words, ' ',$company['name']); 
					?>
				</a>
			</h3>
			<?php if (isset($company['class'])): ?>				
		<span class="label pipeline-label label-<?php echo str_replace(' ', '', $companies_pipeline[$company['pipeline']]); ?>"><?php echo $companies_pipeline[$company['pipeline']] ?></span>
		<?php endif; ?>
<hr>
		<div class="row col-md-12">
		<strong>Address</strong>
			<p style="margin-bottom:0;">
				<?php echo $company['address']; ?>
			</p>
        </div><!--CLOSE MD-12-->



			<div class="row col-md-8" style="margin-top:10px;">
    			<strong>Company Name</strong>
				<p style="margin-bottom:0;">	
				<?php echo $company['name']; ?>
         		</p>
    		</div>
    		<div class="col-md-4" style="margin-top:10px;">
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
        	<div class="row col-md-4" style="margin-top:10px;">
        		<strong>Phone Number</strong>
        		<p style="margin-bottom:0;">
        		<?php echo isset($company['phone'])?$company['phone']:'-'; ?>                
           		</p>
			</div>
    		<div class="col-md-4" style="margin-top:10px;">
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
        	<div class="col-md-4" style="margin-top:10px;">
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
		<div class="col-md-3"><div class="col-md-12" style="padding-right:0;">
		<?php $this->load->view('companies/actions_box.php',array('company'=>$company)); ?>
				<!-- LINKS AND BTN -->
		
			<?php if (isset($company['ddlink'])): ?>
			<a class="btn  btn-info btn-sm btn-block duedil" href="<?php echo $company['ddlink'] ?>" target="_blank">Duedil</a>
			<?php endif; ?>
			<?php if (isset($company['linkedin_id'])): ?>
			<a class="btn  btn-info btn-sm btn-block linkedin" href="https://www.linkedin.com/company/<?php echo $company['linkedin_id'] ?>"  target="_blank">LinkedIn</a>
			<?php endif; ?>
		</div>
			
		</div>
		</div>
		<div class="row">
        <!--ADDRESS-->
        
                
		<div class="col-md-12">
			<hr>
		</div>
        </div>
		
        <div class="row">
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

		<!-- CONTACTS -->
		<div class="col-md-2 centre">
			<strong>Contacts</strong>			
			<?php if (isset($company['contacts_count'])): ?>
			<p class="details"><?php echo $company['contacts_count'];?> </p>
			<?php else: ?>
			<p class="details">0 </p>
			<?php endif; ?>
		</div>

		<!-- EMPLOYEES -->
		<div class="col-md-2 centre">
			<strong>Employees</strong>
			<?php if (isset($company['emp_count'])): ?>
			<p class="details"><?php echo $company['emp_count'];?> </p>
			<?php else: ?>
			<p class="details">Unknown</p>
			<?php endif; ?>
		</div>

		<!-- SECTORS -->
		<div class="col-md-4">
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

		<div class="row">
            
		<!-- MORTGAGES -->
			
			<div class="col-md-12">
		<?php if(!empty($company['mortgages'])): ?>
			<table class="table table-hover" style="font-size:12px">
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
					<td class="col-md-6" ><?php echo $mortgage['name']; ?>

					<span class="label label-default" style="margin-left: 20px;
  padding: 1px 10px;"><?php echo $mortgage['type']; ?></span>
</td>
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
		</div>
        </div>
	</div>
<?php endforeach; ?>
<?php endif; ?>