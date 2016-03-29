<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editAddress_<?php echo $address->addressid; ?>">Edit

</button>
<div class="modal draggable-modal fade" id="editAddress_<?php echo $address->addressid; ?>" tabindex="-1" role="dialog" aria-labelledby="Edit Address" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        	<h4 class="modal-title">Edit Address</h4>
	      	</div>
	      	<?php $hidden = array('address_id' => $address->addressid , 'user_id' => $current_user['id'],'update_address'=>'1','company_id'=>$address->company_id );
				 echo form_open(site_url().'companies/update_address', 'name="update_address" class="form" role="form"',$hidden); ?>
	      	<div class="modal-body">
	      		<div class="row">
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
						echo form_dropdown('address_types', $address_types, (isset($address->type)?$address->type:'') ,'class="form-control"' );?>
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
	        	<button type="submit" class="btn btn-sm btn-warning btn-block">Save</button>
	      	</div>
            <div class="modal-footer">
            <div><small>
            <?php echo $address->addresses_updated_at? '<b>Last Updated:</b> - '.$address->addresses_updated_at. ' '.$address->updated_by_user : ''; ?></small></div><div><small><b>Address Created:</b> <?php echo $address->addresses_created_at; ?>  - <?php echo $address->created_by_user; ?></small></div>
                
            </div>
	      	<?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
