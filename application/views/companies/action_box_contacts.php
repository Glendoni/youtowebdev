
<?php if($contact->linkedin_id): ?>
<a href="<?php echo $contact->linkedin_id; ?>" target="_blank" type="button" class="btn btn-xs" style="background-color:#0077b5; color:#fff;">
    <i class="fa fa-linkedin-square"></i> LinkedIn
</a>
<?php endif;?>


<?php if($contact->email): ?>
<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#send-email<?php echo $contact->id; ?>">
   Send Email 
</button>
<?php endif;?>
<?php if (!empty($contact->eff_to)): ?>
<span class="label label-danger">Left Company</span>
<?php else: ?>
<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editContact_<?php echo $contact->id; ?>">
 Edit 
</button>
<?php endif; ?><!--END IF EFF-TO COMPLETED-->

<div class="modal draggable-modal fade" id="send-email<?php echo $contact->id; ?>" tabindex="-1" role="dialog" aria-labelledby="Send email to <?php echo ucfirst($contact->first_name).' '.ucfirst($contact->last_name) ?>" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        	<h4 class="modal-title">Send email to <?php echo ucfirst($contact->first_name).' '.ucfirst($contact->last_name);?></h4>
	      	</div>
	      	<?php $hidden = array('contact_id' => $contact->id , 'user_id' => $current_user['id'],'send_email'=>'1','company_id'=>$contact->company_id);
				 echo form_open_multipart(site_url().'email_templates/send_email', 'name="send_email" onsubmit="return validate_form_email(this);" class="form" role="form"',$hidden); ?>
	      	<div class="modal-body" id="template_box">
	      		<div class="row">
					<div class="col-md-12">
	                    <div class="form-group">
	                        <label for="role" class="control-label">Select Template</label>                            
	                        <select class="form-control template_selector" name="template_selector" required>
	                        <option value=""></option>
							  <?php foreach ($email_templates as $email_template): ?>
							  	<option value="<?php echo $email_template->id?>"><?php echo ucfirst($email_template->name)?></option>
							  <?php endforeach; ?>	 
							</select>
	                    </div>
	                </div>
	                <div class="col-md-12">
	                    <div class="form-group">
	                        <label for="name" class="control-label">Email Subject</label>
	                        <?php foreach ($email_templates as $email_template): ?>
                			<input type="text" name="subject_<?php echo $email_template->id; ?>" style="display:none;" class="form-control info_box template_<?php echo $email_template->id; ?>" value="<?php echo $email_template->subject; ?>" >
						  	<?php endforeach; ?>
	                    </div>
	                </div>
					<div class="col-md-12">
	                    <div class="form-group">
	                        <label for="name" class="control-label">Email Body</label>
	                        <?php foreach ($email_templates as $email_template): ?>
                			<textarea class="form-control info_box template_<?php echo $email_template->id; ?>" rows="18" cols="50" name="message_<?php echo $email_template->id; ?>" style="display:none;"><?php echo $email_template->message; ?></textarea>
						  	<?php endforeach; ?>
	                    </div>
	                </div>
	                <div class="col-md-12">
	                	<div class="form-group">
	                		<label class="control-label"> Attachements</label>
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
	                        <label for="email" class="control-label">Extra Attachments</label>                            
	                        <input type="file" name="files[]" multiple>
	                    </div>
	                </div>
				 </div>
	      	</div>
	      	<div class="modal-footer">
	        	 <button type="button" class="btn btn-default" data-dismiss="modal" style="display:none;">Close</button>
                <button type="submit" class="btn btn-sm btn-primary btn-block  "  data-style="expand-right" data-size="1">
                    <span class="ladda-label">Send Email</span>
                </button>
	      	</div>
	      	<?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="editContact_<?php echo $contact->id; ?>" tabindex="-1" role="dialog" aria-labelledby="Edit <?php echo ucfirst($contact->first_name).' '.ucfirst($contact->last_name) ?>" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        	<h4 class="modal-title">Edit Contact <?php echo ucfirst($contact->first_name).' '.ucfirst($contact->last_name);?></h4>
	      	</div>
	      	<?php $hidden = array('contact_id' => $contact->id , 'user_id' => $current_user['id'],'update_contact'=>'1','company_id'=>$contact->company_id );
				 echo form_open(site_url().'contacts/update', 'name="update_contact" class="form" role="form"',$hidden); ?>
	      	<div class="modal-body">
	      		<div class="row">
						<div class="col-md-2">
	                    <div class="form-group">
	      		<?php  
                            
			echo form_label('Title', 'title_options');
						echo form_dropdown('title_options', $title_options, (isset($address->type)?$address->type:'') ,'class="form-control"' );?>
						</div>
						</div>

					<div class="col-md-5">
	                    <div class="form-group">

	                    


	                        <label for="name" class="control-label">First Name*</label>                            
	                        <input type="text" name="first_name" value="<?php echo isset($contact->first_name)?$contact->first_name:''; ?>" maxlength="50" class="form-control">
	                    </div>
	                </div>
	                <div class="col-md-5">
	                    <div class="form-group">
	                        <label for="name" class="control-label">Last Name*</label>                            
	                        <input type="text" name="last_name" value="<?php echo isset($contact->last_name)?$contact->last_name:''; ?>" maxlength="50" class="form-control">
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="form-group">
	                        <label for="role" class="control-label">Role*</label>                            
	                        <input type="text" name="role" value="<?php echo isset($contact->role)?$contact->role:''; ?>" maxlength="50" class="form-control">
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
	                <div class="col-md-6">
	                    <div class="form-group">
	                        <label for="linkedin_id" class="control-label">LinkedIn ID</label>                            
	                        <input type="text" name="linkedin_id" value="<?php echo isset($contact->linkedin_id)?$contact->linkedin_id:''; ?>" maxlength="200" class="form-control">
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="form-group">
						<label for="marketing" class="control-label">Opt-Out of Email Marketing </label>   
                        <select name="marketing_opt_out" class="form-control">
                            <option value="0" <?php if(empty($contact->email_opt_out_date)): ?>selected=""<?php endif; ?>>No</option>
                            <option value="1" <?php if(!empty($contact->email_opt_out_date)): ?>selected=""<?php endif; ?>>Yes</option>
                        </select>
                        <!-- PASS OPT OUT DATE IF SET TO STOP BEING OVERWRITTEN-->
                        <?php if(!empty($contact->email_opt_out_date)): ?>
						<input type="hidden" name="opt_out_check" value="<?php echo $contact->email_opt_out_date; ?>" />
                        <?php endif; ?>
						</div>
	                </div>
                      <div class="col-md-6">
	                    <div class="form-group">
						<label for="eff_to" class="control-label">Status</label>   
                        <select name="eff_to" class="form-control">
                            <option value="0" selected="">Active</option>
                            <option value="1">Left</option>
                        </select>
						</div>
	                </div>
				 </div>
	      	</div>


	      	
	      	<div class="modal-footer">
	        	<button type="submit" class="btn btn-sm btn-warning btn-block">Save</button>
	      	</div>
            <div class="modal-footer">
            <div><small>
             <?php echo $contact->updated_by? '<b>Last Updated:</b>'. $contact->contact_updated_at.' - '.$contact->updated_by  : ''; ?></small></div><div><small>
                <b>Contact Created:</b> <?php echo $contact->contact_created_at; ?> - <?php echo $contact->created_by; ?></small></div>
                
            </div>
	      	<?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
