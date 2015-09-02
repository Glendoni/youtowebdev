
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-green">
        <div class="panel-heading profile-heading">
            <h3>Settings</h3>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <?php echo form_open('');?>
              <div class="form-group col-md-6">            
                <label>Gmail Account</label>
                <input type="text" class="form-control" name="gmail_account" value="<?php echo $current_user['gmail_account'] ?>" >
                </div>
                <div class="form-group col-md-6">  
                  <label>Gmail Password</label><?php if (!empty($current_user['gmail_password'])): ?> <span class="label label-success"> Active </span><?php endif; ?>
                  <input type="password" class="form-control" name="gmail_password" value="" > 
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