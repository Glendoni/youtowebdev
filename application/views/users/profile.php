
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-green">
        <div class="panel-heading profile-heading">
            <h3>Profile</h3>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <?php echo form_open_multipart('');?>
                <div class="form-group col-md-6">  
                  <label>Role*</label>
                  <input type="text" class="form-control" name="role" value="<?php echo $current_user['role'] ?>" > 
                </div>
                <div class="form-group col-md-6">  
                  <label>Email *</label>
                  <input type="text" class="form-control" name="email" value="<?php echo $current_user['email'] ?>" > 
                </div>
                <div class="form-group col-md-6">            
                <label>Full Name *</label>
                <input type="text" class="form-control" name="name" value="<?php echo $current_user['name'] ?>" >
                </div>
                
                <div class="form-group col-md-6">  
                  <label>Direct Contact Number *</label>
                  <input type="text" class="form-control" name="phone" value="<?php echo $current_user['phone'] ?>" > 
                </div>
                <div class="form-group col-md-6">  
                  <label>Mobile</label>
                  <input type="text" class="form-control" name="mobile" value="<?php echo $current_user['mobile'] ?>" > 
                </div>   
                <div class="form-group col-md-6">  
                  <label>LinkedIn username</label>
                  <input type="text" class="form-control" name="linkedin" value="<?php echo $current_user['linkedin'] ?>" > 
                </div>
                      
                <div class="form-group col-md-12">
                  <button class="btn btn-primary" name="update_profile">Update</button>
                </div>
            </form>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
</div>