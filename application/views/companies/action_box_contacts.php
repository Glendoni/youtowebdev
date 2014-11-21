<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editContact_<?php echo $contact->id; ?>">
    edit 
</button>
<button type="button" class="btn btn-info btn-xs">
    <i class="fa fa-envelope"></i> send email 
</button>

<div class="modal fade" id="editContact_<?php echo $contact->id; ?>" tabindex="-1" role="dialog" aria-labelledby="Edit <?php echo $contact->name; ?>" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        	<h4 class="modal-title">Edit Contact <?php echo ucfirst($contact->name);?></h4>
	      	</div>
	      	<?php $hidden = array('contact_id' => $contact->id , 'user_id' => $current_user['id'],'update_contact'=>'1','company_id'=>$contact->company_id );
				 echo form_open(site_url().'contacts/update', 'name="update_contact" class="form" role="form"',$hidden); ?>
	      	<div class="modal-body">
	      		<div class="row">
					<div class="col-md-6">
	                    <div class="form-group">
	                        <label for="role" class="control-label">Role*</label>                            
	                        <input type="text" name="role" value="<?php echo isset($contact->role)?$contact->role:''; ?>" maxlength="50" class="form-control">
	                    </div>
	                </div>
					 <div class="col-md-6">
	                    <div class="form-group">
	                        <label for="name" class="control-label">Name*</label>                            
	                        <input type="text" name="name" value="<?php echo isset($contact->name)?$contact->name:''; ?>" maxlength="50" class="form-control">
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="form-group">
	                        <label for="email" class="control-label">Email</label>                            
	                        <input type="text" name="email" value="<?php echo isset($contact->email)?$contact->email:''; ?>" maxlength="50" class="form-control">
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="form-group">
	                        <label for="phone" class="control-label">Phone</label>                            
	                        <input type="text" name="phone" value="<?php echo isset($contact->phone)?$contact->phone:''; ?>" maxlength="50" class="form-control">
	                    </div>
	                </div>
				 </div>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        	<button type="submit" class="btn btn-primary">Save changes</button>
	      	</div>
	      	<?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>