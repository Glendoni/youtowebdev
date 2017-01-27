
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-green">
        <div class="panel-heading profile-heading">
            <h3>Profile</h3>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <?php echo form_open_multipart('');?>
            <div class="col-md-12">
            <h4 style="font-weight:700;">About Me</h4>
            <hr>
            </div>
            <div class="form-group col-md-6">

                <label>Full Name *</label>
                <input type="text" class="form-control" name="name" value="<?php echo $current_user['name'] ?>" >
                </div>
                <div class="form-group col-md-6"> 
                  <label>Role*</label>
                  <input type="text" class="form-control" name="role" readonly value="<?php echo $current_user['role'] ?>" > 
                </div>
                <div class="form-group col-md-6">  
                  <label>Email *</label>
                  <input type="text" class="form-control" name="email" readonly value="<?php echo $current_user['email'] ?>" > 
                </div>
                <div class="form-group col-md-6">  
                  <label>Direct Contact Number *</label>
                  <input type="text" class="form-control" name="phone" value="<?php echo $current_user['phone'] ?>" > 
                </div>
                <div class="form-group col-md-6">  
                  <label>Mobile</label>
                  <input type="text" class="form-control" name="mobile" id="mobile" value="<?php echo $current_user['mobile'] ?>" > 
                       <br>
                    <label class="userupdatepassword">Change password</label>
                        <input type="checkbox" class="userupdatepassword" id="userupdatepassword" >
                </div>   
                <div class="form-group col-md-6">  
                  <label>LinkedIn username</label>
                  <input type="text" class="form-control" name="linkedin" value="<?php echo $current_user['linkedin'] ?>" > 
                        
                 
                </div>
            
            <div class="col-md-12   ">

</div>
            
            
             <div class=" form-group col-md-6 updatepassword">  
                  <label>New Password </label>
                  <input type="password" class="form-control updatepasswordinput pass_enter" name="updatepassword"  value="" > 
                     <label><span class="passwordsdonotmatch"> Passwords do not match</span></label>
                </div>
                <div class="form-group col-md-6 updatepassword">  
                  <label>Re-enter Password</label>
                  <input type="password" class="form-control updatepasswordinput re_pass_enter"  value="" > 
                    
                </div>

                <div class="col-md-12">
                <hr>
            <h4 style="font-weight:700;">UX Configuration</h4>
            <hr>
            </div>
                <?php 
                  $user_icon = explode(",", ($current_user['image'])); 
                  $backgroundcolour = $user_icon[1]; 
                  $foregroundcolour = $user_icon[2];
                ?>

                <div class="form-group col-md-6">  
                  <label>Background Colour</label>
                <input type="color" name="user-fg" class="form-control" onchange="clickColor(0, -1, -1, 5)" value="<?php echo $backgroundcolour;?>"></div>   
                <div class="form-group col-md-6">  
                  <label>Foreground Colour</label>
                <input type="color" name="user-bg" class="form-control" onchange="clickColor(0, -1, -1, 5)" value="<?php echo $foregroundcolour;?>"></div>
                <div class="form-group col-md-6">  
                  <label>Open Companies in...</label>

<select name="new_window" class="form-control">
                  <option value="0" <?php if(($current_user['new_window']=='f')): ?> selected="selected"<?php endif; ?>
>Same Tab</option>
                  <option value="1" <?php if(($current_user['new_window']=='t')): ?> selected="selected"<?php endif; ?>
>New Tab</option>
                  </select>
                </div>
    

<?php if (ENVIRONMENT  =='staging' || ENVIRONMENT  =='development'){?>

<div class="col-md-12" style="display:none">
                <hr>
            <h4 style="font-weight:700;">Testing</h4>
            <hr>
            </div>

                <div class="form-group col-md-6" style="display:none">  
                  <label>Role Type</label>

                  <select name="permission" class="form-control">
                  <option value="admin" <?php if(($current_user['permission']=='admin')): ?> selected="selected"<?php endif; ?>
>Admin</option>
                  <option value="" <?php if(($current_user['permission']=='')): ?> selected="selected"<?php endif; ?>
>Normal User</option>
                  </select>

                </div>
                <div class="col-md-12">
                <hr>
                </div>
<?php };?>
                <!--<div class="form-group col-md-6">            
                <label>Gmail Account</label>
                <input type="text" class="form-control" name="gmail_account" value="<?php echo $current_user['gmail_account'] ?>" >
                </div>
                <div class="form-group col-md-6">  
                  <label>Gmail Password</label><?php if (!empty($current_user['gmail_password'])): ?> <span class="label label-success"> Active </span><?php endif; ?>
                  <input type="password" class="form-control" name="gmail_password" value="" placeholder="Enter a new password here." autocomplete="off"> 
                </div>-->

                <div class="form-group col-md-12">
                
                  <button class="btn btn-sm btn-warning btn-block" id="update_profile" name="update_profile">Save</button>
                </div>

            </form>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
</div>