
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
                <label>Full Name *</label>
                <input type="text" class="form-control" name="name" value="<?php echo $current_user['name'] ?>" >
                </div>
                <div class="form-group col-md-6"> 
                  <label>Role*</label>
                  <input type="text" class="form-control" name="role" value="<?php echo $current_user['role'] ?>" > 
                </div>
                <div class="form-group col-md-6">  
                  <label>Email *</label>
                  <input type="text" class="form-control" name="email" value="<?php echo $current_user['email'] ?>" > 
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
                <hr>
                </div>
<?php 
$user_icon = explode(",", ($current_user['image'])); 
        $backgroundcolour = $user_icon[1]; 
        $foregroundcolour = $user_icon[2];?>

                <div class="form-group col-md-6">  
                  <label>Background Colour</label>
                <input type="color" name="user-fg" class="form-control" onchange="clickColor(0, -1, -1, 5)" value="<?php echo $backgroundcolour;?>"></div>   
                <div class="form-group col-md-6">  
                  <label>Foreground Colour</label>
                <input type="color" name="user-bg" class="form-control" onchange="clickColor(0, -1, -1, 5)" value="<?php echo $foregroundcolour;?>"></div>   

                <div class="form-group col-md-12">
                <hr>
                </div>

                <div class="form-group col-md-6">            
                <label>Gmail Account</label>
                <input type="text" class="form-control" name="gmail_account" value="<?php echo $current_user['gmail_account'] ?>" >
                </div>
                <div class="form-group col-md-6">  
                  <label>Gmail Password</label><?php if (!empty($current_user['gmail_password'])): ?> <span class="label label-success"> Active </span><?php endif; ?>
                  <input type="password" class="form-control" name="gmail_password" value="" placeholder="Enter a new password here." autocomplete="off"> 
                </div>
                                <div class="form-group col-md-12">
                <hr>
                </div>
                <div class="form-group col-md-12">
                  <button class="btn btn-primary" name="update_profile">Save</button>
                </div>

            </form>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
</div>