	<div class="modal draggable-modal fade" id="serviceoffering" tabindex="-1" role="dialog" aria-labelledby="Create Contant" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                
                
                   
            <?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'edit_service_level'=>'1', 'class_check' => $company['class'], 'pipeline_check' => $company['pipeline']);
                 echo form_open(site_url().'companies/edit', 'name="edit_service_level" class="edit_company" role="form"',$hidden); ?>
                
                
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo isset($company['name'])?$company['name']:''; ?></h4>
                </div>
              
                <div class="modal-body">
                    <div class="row">
                        <div class="alert alert-danger" id="error_box" style="display:none;" role="alert"></div>
                      
                           <div class="col-sm-6 col-md-2">
                        <div class=" form-group ">
                            <label for="phone" class="control-label">Funding Type</label> 
                            <span class="button-checkbox">
                                <button type="button"  class="btn    btn-default enterpriseBoxBtn" data-color="success"><i class="state-icon undefined"></i> &nbsp;CONFIDENTIAL</button>
                                <input type="checkbox" name="confidential_flag" value="1" class="hidden" <?php echo $company['confidential_flag']?  'checked=\"checked\"' : "" ; ?>
                            </span>
                        </div>
                    </div>

        <div class="col-md-12 target_sectors" style="margin-top:10px;">
            <label for="sectors" class="control-label">Service Level </label>
            <div class="tag-holder">  
                <?php  
                    $confidential_flag = '';

                foreach ($bespoke_target_sectors_list as $key => $value): 

                    if(array_key_exists($key,$company['sectors'])) array_push($bespokeArr, 1); 
                ?>

                    <span class="button-checkbox bespoke_checkbox">
                    <button type="button" id="bespoke_checkbox" class="btn btn-checkbox checkbox_bespoke" data-color="success" >&nbsp;<?php echo $value; ?></button>
                    <input type="checkbox" name="add_sectors[]" value="<?php echo $key; ?>" class="hidden" <?php echo (isset($company['sectors']) and array_key_exists($key,$company['sectors']))? 'checked': '' ; ?>  />
                    </span>

                <?php endforeach ?>
            </div>
        </div>
        <input type="hidden" id="bespokeEval" value="<?php echo $current_user['department']; ?>" >
       
                        
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

