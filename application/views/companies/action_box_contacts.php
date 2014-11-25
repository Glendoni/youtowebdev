<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editContact_<?php echo $contact->id; ?>">
    edit 
</button>
<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#send-email<?php echo $contact->id; ?>">
    <i class="fa fa-envelope"></i> send email 
</button>

<div class="modal fade" id="send-email<?php echo $contact->id; ?>" tabindex="-1" role="dialog" aria-labelledby="Send email to <?php echo $contact->name; ?>" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        	<h4 class="modal-title">Send email to <?php echo ucfirst($contact->name);?></h4>
	      	</div>
	      	<?php $hidden = array('contact_id' => $contact->id , 'user_id' => $current_user['id'],'send_email'=>'1','company_id'=>$contact->company_id);
				 echo form_open_multipart(site_url().'email_templates/send_email', 'name="send_email" class="form" role="form"',$hidden); ?>
	      	<div class="modal-body" id="template_box">
	      		<div class="row">
					<div class="col-md-12">
	                    <div class="form-group">
	                        <label for="role" class="control-label">Select template:</label>                            
	                        <select class="form-control" name="template_selector" id="template_selector">
	                        <option value="0">-</option>
							  <?php foreach ($email_templates as $email_template): ?>
							  	<option value="<?php echo $email_template->id?>"><?php echo ucfirst($email_template->name)?></option>
							  <?php endforeach; ?>	 
							</select>
	                    </div>
	                </div>
					 <div class="col-md-12">
	                    <div class="form-group">
	                        <label for="name" class="control-label">Email body:</label>
	                        <?php foreach ($email_templates as $email_template): ?>
                			<textarea class="form-control info_box template_<?php echo $email_template->id; ?>" rows="18" cols="50" name="message_<?php echo $email_template->id; ?>" style="display:none;"><?php echo $email_template->message; ?></textarea>
						  	<?php endforeach; ?>	                            
	                        
	                    </div>
	                </div>
	                <div class="col-md-12">
	                	<div class="form-group">
	                		<label class="control-label"> Attachements:</label>
                			<?php foreach ($email_templates as $email_template): ?>
                			<div class="template_<?php echo $email_template->id; ?> info_box" style="display:none;">
						  		<?php $attchs = json_decode($email_template->attachments);?>
						  		<?php if ($attchs): ?>
						  		<?php foreach ($attchs as $attch):?>
						  			<p><?php echo preg_replace('/^.+[\\\\\\/]/', '', $attch); ?></p>
						  		<?php endforeach;?>
						  	<?php endif; ?>	
						  	</div>
						  	<?php endforeach; ?>	
	                	</div>
	                </div>
	                <div class="col-md-12">
	                    <div class="form-group">
	                        <label for="email" class="control-label">Extra attachments:</label>                            
	                        <input type="file" name="files[]" multiple>
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
