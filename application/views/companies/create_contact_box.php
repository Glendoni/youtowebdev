	<div class="modal draggable-modal fade" id="create_contact_<?php echo $company['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="Create Contant" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo isset($company['name'])?$company['name']:''; ?></h4>
                </div>
                    <?php 
                        $hidden = array(
                            'company_id' => $company['id'] ,
                            'user_id' => $current_user['id'],
                            'create_contact'=>'1',
                            'page_number' => (isset($current_page_number))? $current_page_number:'');
				            echo form_open(
                                site_url().'contacts/create_contact',
                                array(
                                    'onSubmit'=>'return validateContactForm();',
                                    'name' => 'create_contact',
                                    'class'=>'create_contact',
                                    'role'=>"form",
                                    'autocomplete'=>"off"
                                ),
                                $hidden
                            ); 
                    ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="alert alert-danger" id="error_box" style="display:none;" role="alert"></div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <?php  
                                    echo form_label('Title', 'title_options');
                                    echo form_dropdown('title', $title_options, (isset($address->type)?$address->type:'') ,'class="form-control"' );
                                ?>
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
                            <div class=" form-group ">
                                <label for="role" class="control-label">Role *</label>                            
                                <input type="text" name="role" value="" id="role" maxlength="50" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="email" class="control-label">Email</label>
                                <input type="text" name="email" value="" id="email" maxlength="50" class="form-control" autocomplete="off" >
                                <?php echo validation_errors(); ?>  
                                <div id="message" class="alert alert-warning" role="alert">...</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="control-label">Phone </label>                            
                                <input type="phone" name="phone" value="" id="phone" maxlength="50" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" form-group ">
                                <label for="linkedin_id" class="control-label">LinkedIn ID </label>                            
                                <input type="linkedin_id" name="linkedin_id" value="" id="linkedin_id" maxlength="100" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="reports" class="control-label">Reports needed</label>   
                                <div class="reports">
                                    <label><input type="checkbox" name="report_extensions" value="report_extensions">Extensions</label>
                                </div>
                                <div class="reports">
                                    <label><input type="checkbox" name="report_timesheets_storage" value="report_timesheets_storage">Timesheets Charger</label>
                                </div>
                                <div class="reports">
                                    <label><input type="checkbox" name="report_timesheets_processed" value="report_timesheets_processed">Timesheets Processed</label>
                                </div>
                                <div class="reports">
                                    <label><input type="checkbox" name="report_sales_ledger" value="report_sales_ledger">Sales Ledger</label>
                                </div>
                                <div class="reports">
                                    <label><input type="checkbox" name="report_commision" value="report_commision">Commission</label>
                                </div>
                                <div class="reports">
                                    <label><input type="checkbox" name="report_age_debtor" value="report_age_debt_ledger">Age Debt Ledger</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
            	    <button type="submit" class="btn btn-sm btn-primary btn-block ladda-button submit_btn addcontact" edit-btn="editbtn<?php echo $company['id']; ?>" loading-display="loading-display-<?php echo $company['id']; ?>" data-style="expand-right" data-size="1">
		        	    <span class="ladda-label">Add Contact </span>
		    	    </button>                
                </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

