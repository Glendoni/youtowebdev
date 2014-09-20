    <!-- /.row -->
    <div class="row">
        <h1 class="page-header">Dashboard</h1>
        
      
      <div class="col-lg-8">
          <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fa fa-bell fa-fw"></i> Your Calls & Meetings <span class="label label-primary pull-right"><?php echo count($pending_actions)?></span> 
              </div>
             
              <div class="panel-body">
                  <div class="clearfix"></div>
                  <div clas="list-group">
                    <?php foreach ($pending_actions as $action): 
                        // print_r('<pre>');print_r($action);print_r('</pre>');
                        // die;
                      ?>
                          <div class="row list-group-item">
                            <div class="col-md-3"> 
                              <a href="<?php echo site_url();?>companies/company?id=<?php echo $action->company_id;?>" > <?php echo $action->company_name;?></a>
                            </div>
                            <div class="col-md-2">
                              <?php echo $action_types_array[$action->action_type_id]; ?>
                            </div>
                            <div class="col-md-3"> 
                              <?php echo date("D jS M ",$action->actioned_at);?> @ <?php echo date("g:i",$action->actioned_at);?>
                            </div>
                            <div class="col-md-4">
                              <?php $hidden = array('action_id' => $action->action_id , 'user_id' => $current_user['id'], 'action_do' => 'completed', 'outcome' => '');
                               echo form_open(site_url().'actions/edit', 'name="completed_action"  class="completed_action" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action->action_id.'" style="display:inline-block;" role="form"',$hidden); ?>
                               <button class="btn btn-success"><i class="fa fa-check fa-lg"></i> Completed</button> 
                               </form>
                               <?php $hidden = array('action_id' => $action->action_id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled','outcome' => '' );
                               echo form_open(site_url().'actions/edit', 'name="cancel_action"  class="cancel_action" style="display:inline-block;" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action->action_id.'" role="form"',$hidden); ?>
                               <button class="btn btn-danger" ><i class="fa fa-trash-o fa-lg"></i> Delete</button>
                               </form>
                            </div>
                          </div>
                          <div class="row list-group-item" id="action_outcome_box_<?php echo $action->action_id ?>" style="display:none;">
                          <label>Outcome</label>
                          <textarea class="form-control" name="outcome" rows="3" style="margin-bottom:5px;"></textarea>
                          <button class="btn btn-primary pull-right"><i class="fa fa-check fa-lg"></i> Send</button>
                          </div>
                      <?php endforeach ?>
                  </div>
              </div>
          </div>
      </div>
  </div>