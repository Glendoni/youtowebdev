	<div class="modal fade" id="editModal<?php echo $company['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="Edit <?php echo $company['name']; ?>" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        	<?php $hidden = array('company_id' => $company['id'] , 'user_id' => $current_user['id'],'edit_company'=>'1' );
				 echo form_open(site_url().'companies/edit', 'name="edit_company" class="edit_company" role="form"',$hidden); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Edit <?php echo isset($company['name'])?$company['name']:'';; ?></h4>
            </div>
            <div class="modal-body">
            <div class="row">
            <div class="col-sm-6 col-md-8">
            <div class=" form-group ">
                        <label for="trading_name" class="control-label">Trading Name</label>                            
                        <input type="text" name="trading_name" value="<?php echo isset($company['trading_name'])?$company['trading_name']:''; ?>" id="trading_name" maxlength="50" class="form-control" placeholder="Enter Trading Name">
            </div>
            </div>

            <div class="col-sm-6 col-md-4">
                    <div class=" form-group ">
                    <?php  
                            if (($company['pipeline']=="Customer") || ($company['pipeline']=="Proposal")){ 
                                echo form_label('Pipeline', 'company_pipeline');
                                ?>
                                <span class="label pipeline-label label-<?php echo str_replace(' ', '', $company['pipeline']); ?>" style="display: block;clear: left;padding: 11px; margin:0;"><?php echo $company['pipeline'] ?></span>
                                <input type="hidden" name="company_pipeline" value="<?php echo $company['pipeline'];?>" />

                                <?php
                                } else {
                                    echo form_label('Pipeline', 'company_pipeline');
                                    echo form_dropdown('company_pipeline', $companies_pipeline, (isset($company['pipeline'])?$company['pipeline']:'') ,'class="form-control"' );
                                };
                                
                                ?>
                    </div>
                </div>
                </div>
                            <div class="row">

              <div class="col-sm-6 col-md-4">
                    <div class=" form-group ">
                    <?php
                    echo form_label('Class', 'company_class');
                    echo form_dropdown('company_class', $companies_classes, (isset($company['class'])?$company['class']:'') ,'class="form-control"');
                    ?>
                    </div>
                </div>

                <?php 
                if (in_array($company['pipeline'], $show_sources))
                  {?>

                <div class="col-sm-6 col-md-4">
                    <div class=" form-group ">
                    <?php
                    echo form_label('Source', 'company_source');
                    echo form_dropdown('company_source', $company_sources, (isset($company['source'])?$company['source']:'') ,'class="form-control"');
                    ?>
                    <input type="hidden" name="original_source" value="<?php echo $company['source'];?>" />
                    <input type="hidden" name="original_source_date" value="<?php echo $company['source_date'];?>" />

                    </div>
                </div>
                <?php 
                  }
                else
                  {}
                ?>
                
              <div class="col-sm-6 col-md-4">
                                  <div class=" form-group ">

                    <label for="url" class="control-label">Recruitment Type</label>
                    <div class="tag-holder">  
                    <div></div>
                        <span class="button-checkbox" id="contract">
                            <button type="button" class="btn btn-default" data-color="primary" id="contract"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Contract</button>
                            <input type="checkbox" name="contract" value="1" id="contract" class="hidden" <?php echo isset($company['contract'])? 'checked': '' ; ?> >                          
                        </span>
                        <span class="button-checkbox" id="contract">
                            <button type="button" class="btn btn-default" data-color="primary" id="permanent"><i class="state-icon glyphicon glyphicon-unchecked"></i>&nbsp;Permanent</button>
                            <input type="checkbox" name="perm" value="1" id="permanent" class="hidden" <?php echo isset($company['perm'])? 'checked': '' ; ?> >
                        </span>
                    </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-md-4">
                    <div class=" form-group ">
                        <label for="url" class="control-label">Website</label>                            
                        <input type="text" name="url" value="<?php echo isset($company['url'])?$company['url']:''; ?>" id="url" maxlength="50" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class=" form-group ">
                        <label for="phone" class="control-label">Phone</label>                            
                        <input type="text" name="phone" value="<?php echo isset($company['phone'])?$company['phone']:''; ?>" id="phone" maxlength="50" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class=" form-group ">
                                <label for="turnover" class="control-label">Turnover</label>                            
                                <input type="text" name="turnover" value="" id="turnover" maxlength="50" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="turnover" class="control-label">Method</label>   
                            <select name="method" class="form-control">
                            <option value=""></option>
                            <option value="actual">Actual</option>
                            <option value="projected">Projected</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class=" form-group ">
                        <label for="linkedin_id" class="control-label">Linkedin ID</label>                            
                        <input type="text" name="linkedin_id" value="<?php echo isset($company['linkedin_id'])?$company['linkedin_id']:''; ?>" id="linkedin_id" maxlength="50" class="form-control">
                    </div>
                </div>
                <?php if (isset($company['emp_count']) == False ):?>
                <div class="col-sm-6 col-md-4">
                    <div class=" form-group ">
                        <label for="emp_count" class="control-label">Employees</label>                            
                        <input type="text" name="emp_count" value="" id="emp_count" maxlength="50" class="form-control">
                    </div>
                </div>
                <?php endif; ?>

                
                
                <div class="col-md-12">
                <hr style="margin-top:10px;">
					<label for="url" class="control-label">Sectors</label>
					<div class="tag-holder">
					<?php 	
					foreach ($sectors_list as $key => $value): ?>
						<span class="button-checkbox">
					        <button type="button" class="btn btn-checkbox" data-color="primary" >&nbsp;<?php echo $value; ?></button>
					        <input type="checkbox" name="add_sectors[]" value="<?php echo $key; ?>" class="hidden" <?php echo (isset($company['sectors']) and array_key_exists($key,$company['sectors']))? 'checked': '' ; ?>  />
					    </span>
					<?php endforeach ?>
					</div>
            
				</div>
				</div>
				<div class="modal-loading-display text-center " id="loading-display-<?php echo $company['id']; ?>" style="display:none;">
					<span class="btn btn-default btn-lg" ><i class="fa fa-refresh fa-spin"></i></span>
				</div>
			</div>
            
            <div class="modal-footer">
            	<button type="submit" class="btn btn-sm btn-success btn-block ladda-button submit_btn" edit-btn="editbtn<?php echo $company['id']; ?>" loading-display="loading-display-<?php echo $company['id']; ?>" data-style="expand-right" data-size="1">
		        	<span class="ladda-label"> Save changes </span>
		    	</button>                
                
            </div>
            <div class="modal-footer">
                <small><b>Record Created:</b> <?php echo date("d/m/y",strtotime($company['created_at']));?> | <b>Last Updated:</b>
            <?php echo isset($company['updated_at'])?date("d/m/y",strtotime($company['updated_at'])):'Never'; ?>

            </small>
            </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>