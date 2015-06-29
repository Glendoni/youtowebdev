	<div class="modal fade" id="create_address_<?php echo $company['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="Create Address" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Address</h4>
            </div>
            <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'create_address'=>'1', 'page_number' => (isset($current_page_number))? $current_page_number:'');
				echo form_open(site_url().'companies/create_address',array('onSubmit'=>'return validateContactForm();','name' => 'create_address', 'class'=>'create_address','role'=>"form" ),$hidden); ?>
            <div class="modal-body">
                <div class="row">
                <div class="alert alert-danger" id="error_box" style="display:none;" role="alert"></div>
                <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="control-label">Address*</label>                            
                            <input type="text" name="address" value="<?php echo isset($address->address)?$address->address:''; ?>" class="form-control">
                        </div>
                </div>
                 <div class="col-md-6">
                        <div class="form-group">
                        <?php  
                            
                                    echo form_label('Type', 'address_types');
                                    echo form_dropdown('address_types', $address_types, (isset($address->type)?$address->type:'Trading Address') ,'class="form-control"' );?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country" class="control-label">Country</label>     
                            <?php
                             echo form_dropdown('country_id', $country_options, (isset($address->country_id)?$address->country_id:'') ,'class="form-control"' );?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="control-label">Phone</label>                            
                            <input type="text" name="phone" value="<?php echo isset($address->phone)?$address->phone:''; ?>" maxlength="50" class="form-control">
                        </div>
                    </div>
            </div>
            </div>
            <div class="modal-footer">
            	<button type="submit" class="btn btn-sm btn-primary btn-block ladda-button submit_btn" edit-btn="editbtn<?php echo $company['id']; ?>" loading-display="loading-display-<?php echo $company['id']; ?>" data-style="expand-right" data-size="1">
		        	<span class="ladda-label"> Add Address </span>
		    	</button>                
                
            </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

