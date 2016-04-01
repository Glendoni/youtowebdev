<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading profile-heading" style="
    background-color: #FC6F65;
">
            <h3 style="
    float: right;
"><a href="<?php echo base_url(); ?>tagging/categories">Show Categories</a></h3>   <h3 >Add Tag</h3>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
       <?php  
$attributes = array( 'class'=>'form-horizontal');
$hidden = array('create_contact_form'=>'1','user_id'=>$current_user['id']);
echo form_open('/add_category',$attributes,$hidden); 
?>
<div class="form-group">
	
	<div class="col-sm-6">
        <label class="control-label" for="name">Tag Name</label>
	  <input type="text" class="form-control"  required="required" name="name" id="name" placeholder="" value="<?php echo isset($_POST['name'])?$_POST['name']:''; ?>">
	</div>
    
    
    <div class="col-sm-6">
        <label for="emp_count" class="control-label">Status</label>
    <?php
        
        $catStatus = array('opt1'=>'active','opt2'=>'non-active' );
    echo form_dropdown('company_class', $catStatus, (isset($_POST['company_class'])?$_POST['company_class']:'') ,'class="form-control"');
    ?>
    </div>
</div>

 
<div class="form-group"> 
	<div class="modal-footer">
	        	<button type="submit" class="btn btn-primary btn-block">Add Tags</button>
	      	</div>
</div>
            
            
            
            

<?php echo form_close(); ?>
            
            <hr />
                  <div class="row">
      <div class="col-lg-12">
    <h4>Tags List</h4>
                      </div>
</div>
        </div>
        <!-- /.panel-body -->
        
       
    </div>
    <!-- /.panel -->
      
   
  </div>
    
    
 
</div>




 