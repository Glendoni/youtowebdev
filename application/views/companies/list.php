<?php if(empty($companies)): ?>
	<div class="alert alert-warning">No companies found</div>
<?php else: ?>


<?php $i = 0; foreach ( $companies as $company):  ?>
<?php $this->load->view('companies/edit_box.php',array('company'=>$company)); ?>
<?php $this->load->view('companies/create_contact_box.php',array('company'=>$company)); ?>
<!--ANCHOR OFFSET-->
<a class="anchor" id="<?php echo $company['id'];?>"></a>
<div class="panel <?php if(isset($company['assigned_to_name'])): ?> panel-primary <?php else: ?> panel-default <?php endif; ?> company companylistings">
	<div class="panel-body">
    <div class="row">
		<div class="col-sm-12 ">
				<?php if (isset($company['parent_name'])): ?>
			<div class="subsidiary">
			<span class="label label-danger"><a href="<?php echo site_url();?>companies/company?id=<?php echo $company['parent_id'];?>"  <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?>>Subsidiary of <?php echo $company['parent_name'];?> <i class="fa fa-external-link"></i></a></span>
			</div>
			<?php elseif (isset($company['parent_registration'])): ?>
				<div class="subsidiary">
			<span class="label label-danger"><a href="https://beta.companieshouse.gov.uk/company/<?php echo $company['parent_registration'];?>" target="_blank">Parent Registration: <?php echo $company['parent_registration'];?> <i class="fa fa-external-link"></i></a></span>
			</div>
		<?php endif; ?>
            
            
            
			<h2 class="company-header">
			<a href="<?php echo site_url();?>companies/company?id=<?php echo $company['id'];?><?php echo !empty($current_campaign_id)?'&campaign_id='.$current_campaign_id:''; ?>" <?php if(($current_user['new_window']=='t')): ?> target="_blank"<?php endif; ?> class="compa"  data-camp="pos<?php echo $i++ ; ?>" comp="<?php echo $company['id'];?>"><?php $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );echo str_replace($words, ' ',$company['name']); ?></a>
		<!-- THIS IS ME -->    
       <?php $bgcolor =  explode(',',$current_user['image']) ?>
            <?php if(isset($company['assigned_to_name']) and !empty($company['assigned_to_name'])): ?>
		<?php if($company['assigned_to_id'] == $current_user['id']) : ?>	
			<?php  $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'], 'page_number' => (isset($current_page_number))? $current_page_number:'');
			echo form_open('companies/unassign',array('name' => 'assignto', 'class'=>'assign-to-form favForm'.$company['id'].'', 'style'=>'display: inline;'),$hidden); ?>
    
   
    
			<button type="submit" class="assigned-star ladda-button" data-style="expand-right" data="<? echo $company['id']; ?>"  style="color:<?php echo $bgcolor[1]; ?>;" data-size="1">
              
                <i class="fa fa-star star_assigned<? echo $company['id']; ?>"></i>
            </button>
			<?php echo form_close(); ?>
     
		<?php endif; ?>
	
            <?php else: ?>
    
            <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'], 'page_number' => (isset($current_page_number))? $current_page_number:'');
	   echo form_open(site_url().'companies/assignto',array('name' => 'assignto', 'class'=>'assign-to-form favForm'.$company['id'].'', 'style'=>'display: inline;'),$hidden); ?>
	<button type="submit" assignto="<?php echo $current_user['name']; ?>" class="unassigned-star ladda-button" data="<? echo $company['id']; ?>" data-style="expand-right"  data-size="1">
        
        <?php //echo '<h2> '. $company['id']. ' </h2>'; ?>
        
        <i class="fa fa-star star_assigned<? echo $company['id']; ?>" style="color:#DCDCDC;"></i>
    </button>
    
	<?php echo form_close(); ?>
	<?php endif; ?>
</h2>
            
        
            
             <!-- THIS IS ME END-->    



	<?php if (isset($company['trading_name'])): ?>
	<h5 class="trading-header" style="text-align:center;">
<?php echo $company['trading_name'];?>
</h5>
	<?php endif; ?>
			</div>
			<div class="col-sm-12 label-assigned<?php echo $company['id'];?>" style="margin-top:5px; margin-bottom: 15px; text-align:center;">
<?php if(isset($company['pipeline'])): ?>
	<span class="label pipeline label-<?php echo str_replace(' ', '', $company['pipeline']); ?>"><?php echo $company['pipeline']?>
	<?php endif; ?>
		<?php if (isset($company['customer_from'])&&($company['pipeline']=='Customer')):?>
		from <?php echo date("d/m/y",strtotime($company['customer_from']));?>
        
         <?php  
            $number  = $company['initial_rate'];
 
        //$number = 5.00;
       $number =  preg_match('[-+]?([0-9]*\.[0]+|[0]+', $number) ? false : $number;

        echo $number ? '<span class="initial_rate_found">  - &#64;'.($number*100).'%</span>' : '<span class="initial_rate_not_found"> - Rate Not Set</span>' ;  ?>
        
		<?php endif; ?>
		</span>
		    
	<?php if(isset($company['assigned_to_name'])): ?>
		<span class="label label-assigned " id="label-assigned<?php echo $company['id'];?>"
		<?php $user_icon = explode(",", ($company['image']));echo "style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'";?>>
        <i class="fa fa-star"  style="color:<?php echo $user_icon[2]; ?>;"></i>
<?php echo $company['assigned_to_name']; ?>
        </span>
	<?php else: ?>
	<?php endif; ?>
                
               <?php if($company['customer_to']){  ?>
            <span class="label pipeline label-<?php echo str_replace(' ', '', $company['pipeline']); ?> cancelledPill">
                Cancelled <?php echo date('d/m/Y',strtotime($company['customer_to'])); ?>
            </span>
    <?php } ?>
	</div>
        
        
		<div class="col-sm-9">
		<div class="row padding-bottom">
<div class="col-sm-12 action-details">
<div class="row padding-bottom"> 
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
<div><strong> Scheduled</strong></div>
<?php if (empty($company['planned_at2'])): ?>
	None
<?php else: ?>
	<div class="action_type"><?php echo $company['action_name2']." by ".$company['action_user2']; ?></div>

	<div class="action_date_list">
<?php echo date("l jS F Y",strtotime($company['planned_at2']));?>
</div>
<?php
$now = time ();
    $compdate = explode('T',$company['planned_at2']);
$your_date = strtotime($compdate[0]);
if ($your_date < $now){; 
     $datediff = $now - $your_date;
     $daysoverdue = floor($datediff/(60*60*24));?>
<div><span class="label label-danger" style="font-size:10px;">
<?php   if ($daysoverdue > 1) {echo $daysoverdue." Days";} elseif($daysoverdue == 1){  echo $daysoverdue." Day";   }else{echo "";};?>  Overdue </span></div>

<?php } else {}?>
<?php endif; ?>

</div>
</div><!--END ROW-->
<hr>
</div>

	<?php if (isset($company['trading_name'])): ?>
		<div class="col-md-6">
				<label>Registered Name</label>
				<p style="margin-bottom:0;">	
				<?php echo $company['name']; ?>
				</p>
		</div><!--END NAME-->
		<div class="col-md-6">
				<label>Trading Name</label>
				<p style="margin-bottom:0;">	
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
				<p style="margin-bottom:10px;">
                <?php echo isset($company['address'])?'<a href="http://maps.google.com/?q='.urlencode($company['address']).'" target="_blank">'.$company['address'].'<span style="    line-height: 15px;font-size: 10px;padding-left: 5px;"><i class="fa fa-external-link"></i></span></a>':'-'; ?>  
				</p>
		</div><!--END ADDRESS-->
		

		</div><!--END ROW-->
        </div><!--CLOSE MD-9-->


		<div class="col-sm-3" style="margin-top:10px;">
		<?php $this->load->view('companies/actions_box_list.php',array('company'=>$company)); ?>
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
              <a class="btn  btn-primary btn-sm btn-block" href="https://www.linkedin.com/vsearch/f?type=all&keywords=<?php echo  urlencode($company['name']) ?>"  target="_blank">Search LinkedIn <i class="fa fa-search" aria-hidden="true"></i> </a>
            <?php endif; ?>
            
            
					<?php if (isset($company['url'])): ?>
		<a class="btn btn-default btn-sm btn-block btn-url" href="<?php $parsed = parse_url($company['url']); if (empty($parsed['scheme'])) { echo 'http://' . ltrim($company['url'], '/'); }else{ echo $company['url']; } ?>" target="_blank">
		<label style="margin-bottom:0;"></label> <?php echo str_replace("http://"," ",str_replace("www.", "", $company['url']))?>
		</a>
		<?php endif; ?>
			<?php if (isset($company['registration'])): ?>
			<a class="btn  btn-info btn-sm btn-block companieshouse" href="https://beta.companieshouse.gov.uk/company/<?php echo $company['registration'] ?>" target="_blank">Companies House</a>
			<?php endif; ?>
			</div><!--CLOSE MD-3-->
		</div>
 

		<div class="row details">
				<div class="col-md-12">
			<hr>
		</div>
		<div class="col-xs-6 col-md-3 " style="margin-top:10px;">
			<label>Company Number</label><br>
			<p class="registration_number">	
			 <!--COMPANY NUMBER IF APPLICABLE-->
			<?php echo isset($company['registration'])?$company['registration']:''; ?>
         	</p>
        	</div>

        	<div class="col-xs-6 col-md-3 " style="margin-top:10px;">
        	<label>Founded</label><br>
			<p>	
				<?php echo isset($company['eff_from'])?$company['eff_from']:''; ?>
			</p>
		</div>

  	<!-- CONTACTS -->
		<div class="col-xs-6 col-sm-3 " style="margin-top:10px;">
			<strong>Contacts</strong><br>			
			<?php if (isset($company['contacts_count'])): ?>
			<p class="details"><?php echo $company['contacts_count'];?> </p>
			<?php else: ?>
			<p class="details">-</p>
			<?php endif; ?>
		</div>
            
		<div class="col-xs-6 col-md-3 " style="margin-top:10px;">
				<label>Class</label><br>
				<p>	
		            <!--CLASS IF APPLICABLE-->
		            <?php if (isset($company['class']) && $company['class'] != 'Unknown' ): ?>
					 <?php echo $companies_classes[$company['class']] ?> 	
					<?php else: 
                    
                    echo '-';
                    
                    ?>
						
		            <?php endif; ?>
	            </p>
			</div>

		</div>
		
	<div class="row details">
		<!-- TURNOVER -->
		<div class="col-xs-6 col-sm-3 ">
			<strong><span style="text-transform: capitalize"><?php echo isset($company['turnover_method'])?$company['turnover_method']:'';?></span> Turnover</strong><br>
			<p class="details" style="margin-bottom:5px;">
				<?php echo isset($company['turnover'])? '£'.number_format (round($company['turnover'],-3)):'-';?>
			</p>
        </div>
	
	<!-- EMPLOYEES -->
		<div class="col-xs-4 col-sm-3">
			<strong>Employees</strong><br>
			<?php if (isset($company['emp_count'])): ?>
			<p class="details"><?php echo $company['emp_count'];?> </p>
			<?php else: ?>
            <p class="details">-</p>
			<?php endif; ?>
		</div>
		<!-- SECTORS -->
        <?php if(isset($company['sectors'])){
    
    
}else{
    
    
    
}
        
        ?>
		<div class="col-xs-6 col-sm-4">
			<strong>Sectors</strong> <br>
			<?php 
			if(isset($company['sectors'])){
				foreach ($company['sectors'] as $key => $name)
				{
				echo '<p class="detailsTagFormat" style="margin-bottom:0; text-align:centre;">'.$name.'</p>';
				}
			}
			?>
									<?php if (isset($company['perm'])): ?>

<p class="detailsTagFormat" style="margin-bottom:0; text-align:centre;">Permanent</p>

			<?php endif; ?>
								<?php if (isset($company['contract'])): ?>


			<p class="detailsTagFormat" style="margin-bottom:0; text-align:centre;">Contract</p>
						<?php endif; ?>
            
     
            <?php if ($company['perm'] == '' && $company['contract'] == '' && count($company['sectors']) ==0 ): ?>

<p class="detailsTagFormat" style="margin-bottom:0; text-align:centre;">-</p>
            
            
            <?php endif; ?>
            
            
		</div>
		</div>
	

	<div class="row padding-bottom">
		<!-- TAGS -->
        <div class="tagLists tagLists<?php echo $company['id'];?>">
        </div>
	</div>
		<hr>

		<div class="row">
            
		<!-- MORTGAGES -->
			
			<div class="col-md-12">
			<?php if(!empty($company['mortgages'])): ?>
			<table class="table table-hover" style="font-size:12px">
			<thead>
				<tr>
					<th class="col-md-6">Mortgage Provider</th>
					<th class="col-md-3" style="text-align:center;">Started</th>
					<th class="col-md-3" style="text-align:center;">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($company['mortgages'] as $mortgage):?>
				<tr <?php echo $mortgage['stage']==MORTGAGES_SATISFIED? 'class="danger"' : 'class="success"' ?> >
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
 <hr>


	</div>
<?php endforeach; ?>
<?php endif; ?>