<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading profile-heading">
            <h3>Add Company</h3>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
       <?php  
$attributes = array('name' => 'create_company_form', 'class'=>'form-horizontal create_company_form');
$hidden = array('create_company_form'=>'1','user_id'=>$current_user['id']);
echo form_open('',$attributes,$hidden); 
?>
<div class="form-group">
	
	<div class="col-sm-6">
        <label class="control-label" for="name">Company Name</label>
	  <input type="text" class="form-control"  required="required" name="name" id="name" placeholder="" value="<?php echo isset($_POST['name'])?$_POST['name']:''; ?>">
	</div>
    
    
    <div class="col-sm-6">
        <label for="emp_count" class="control-label">Class</label>
    <?php
    echo form_dropdown('company_class', $companies_classes, (isset($_POST['company_class'])?$_POST['company_class']:'') ,'class="form-control company_class"');
    ?>
    </div>
</div>
<!--<div class="form-group">
	<label class="control-label col-sm-2" for="linkedin_id">Linkedin ID:</label>
	<div class="col-sm-10">
	  <input type="text" class="form-control" name="linkedin_id" id="linkedin_id" value="<?php echo isset($_POST['linkedin_id'])?$_POST['linkedin_id']:''; ?>">
	</div>
</div>
<div class="form-group">
	<label class="control-label col-sm-2" for="Registration">Registration:</label>
	<div class="col-sm-10">
	  <input type="text" class="form-control" name="registration" id="Registration" value="<?php echo isset($_POST['registration'])?$_POST['registration']:''; ?>">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-sm-2" for="eff_from">Incorporated date</label>
	<div class="col-sm-10">
	  <input type="text" class="form-control" placeholder="Y-m-d" name="eff_from" id="eff_from" value="<?php echo isset($_POST['eff_from'])?$_POST['eff_from']:''; ?>">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-sm-2" for="url">Website:</label>
	<div class="col-sm-10">
	  <input type="text" class="form-control" name="url" id="url" value="<?php echo isset($_POST['url'])?$_POST['url']:''; ?>">
	</div>
</div>
<div class="form-group">
	<label class="control-label col-sm-2" for="ddlemployeesink">Employees:</label>
	<div class="col-sm-10">
	  <input type="text" class="form-control" name="employees" id="employees" value="<?php echo isset($_POST['employees'])?$_POST['employees']:''; ?>">
	</div>
</div>
<div class="form-group">
	<label class="control-label col-sm-2" for="phone">Phone:</label>
	<div class="col-sm-10">
	  <input type="phone" class="form-control" name="phone" id="phone" value="<?php echo isset($_POST['phone'])?$_POST['phone']:''; ?>">
	</div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2">Recruitment Type</label>
    <div class="col-sm-10"> 
        <span class="button-checkbox" id="contract">
            <button type="button" class="btn btn-default" data-color="primary" id="contract"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Contract</button>
            <input type="checkbox" name="contract" value="1" id="contract" class="hidden" <?php echo isset($_POST['contract'])? 'checked': '' ; ?> >                          
        </span>
        <span class="button-checkbox" id="contract">
            <button type="button" class="btn btn-default" data-color="primary" id="permanent"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Permanent</button>
            <input type="checkbox" name="perm" value="1" id="permanent" class="hidden" <?php echo isset($_POST['perm'])? 'checked': '' ; ?> >
        </span>
    </div>
</div>-->
 
<div class=" form-group ">
   
    <div class="col-sm-12"> 
         <label for="address" class="control-label cr_address ">Address</label>
    	<input type="text" name="address" required="required" value="<?php echo isset($_POST['address'])?$_POST['address']:''; ?>" id="address" maxlength="200" class="form-control cr_address">
    </div>
</div>
<div class=" form-group ">
	
	<div class="col-sm-6">
        <label for="emp_count" class="control-label">Country</label>
    <?php
    echo form_dropdown('country_id', $country_options, (isset($post['country_options'])?$post['country_options']:'') ,'class="form-control"');
    ?>
    </div>
    
   
    <div class="col-sm-6">  
         <label for="type" class="control-label">Type</label>
<?php echo form_dropdown('address_types', $address_types, (isset($address->type)?$address->type:'') ,'class="form-control tradingType"' );?>    
    </div>
    
    
    
</div>
<!--<div class="form-group">
	<label class="control-label col-sm-2" for="phone">Latitude:</label>
	<div class="col-sm-3">
	  <input type="text" class="form-control" name="lat"  value="<?php echo isset($_POST['lat'])?$_POST['lat']:''; ?>">
	</div>
	<label class="control-label col-sm-2" for="phone">Longitude:</label>
	<div class="col-sm-3">
	  <input type="text" class="form-control" name="lng"  value="<?php echo isset($_POST['lng'])?$_POST['lng']:''; ?>">
	</div>
</div>-->
            
          
<div class=" form-group ">
    
	</div>
  <div class="tradingTypeOptions cr_address">  
   <div class="form-group">
        <div class="col-sm-6">
            <label class="control-label">Add Trading Address</label> </br>
          <input type="radio" name="tradingArr" class="tradingArr" value="1" > The Same as Registered</br>
          <input type="radio" name="tradingArr" class="tradingArr" value="2"> Add New</br>
          <input type="radio" name="tradingArr" class="tradingArr def"  checked="checked" value="3"> Complete Later
        </div>
    </div>
      
    </div>

<div class="addrTrading cr_address_trading">
<div class=" form-group ">

    <div class="col-sm-6">  
    <label for="address" class="control-label">Trading Address</label>
        <input type="text" name="tradingAddress" value="<?php echo isset($_POST['tradingAddress'])?$_POST['tradingAddress']:''; ?>" id="tradingAddress" maxlength="200" class="form-control">
    </div>
    </div>

    </div>
                       

<!-- <div class=" form-group ">
    <label for="turnover" class="control-label col-sm-2">Turnover</label>
    <div class="col-sm-10">                            
    	<input type="text" name="turnover" value="" id="turnover" maxlength="50" class="form-control">
    </div>
</div>

<div class=" form-group ">
    <label for="emp_count" class="control-label col-sm-2">Employees</label>      
    <div class="col-sm-10">                      
    	<input type="text" name="emp_count" value="" id="emp_count" maxlength="50" class="form-control">
    </div>
</div>



<div class="form-group">
	<label class="control-label col-sm-2">Sectors</label>
	<div class="col-sm-10">



	<?php 	
	foreach ($sectors_list as $key => $value): ?>
		<span class="button-checkbox">
	        <button type="button" class="btn btn-checkbox" data-color="primary" >&nbsp;<?php echo $value; ?></button>
	        <input type="checkbox" name="add_sectors[]" value="<?php echo $key; ?>" class="hidden" <?php echo (isset($company['sectors']) and array_key_exists($key,$company['sectors']))? 'checked': '' ; ?>  />
	    </span>
	<?php endforeach ?>
	</div>
</div> -->
 
<div class="form-group"> 
	<div class="modal-footer">
	        	<button type="submit" class="btn btn-primary btn-block">Add Company</button>
	      	</div>
</div>


<?php echo form_close(); ?>
        </div>
        <!-- /.panel-body -->
        
       
    </div>
    <!-- /.panel -->
  </div>
    
</div>




 