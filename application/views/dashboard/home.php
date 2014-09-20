    <!-- /.row -->
    <div class="row">
        <h1 class="page-header">Dashboard</h1>
        <div class="col-md-4">
        
        </div>
      
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-bell fa-fw"></i> Your Calls & Meetings <span class="label label-primary pull-right"><?php echo count($pending_actions)?></span> 
                </div>
               
                    <div class="panel-footer">
                        <div class="clearfix"></div>
                        <div clas="list-group">
                        <ul class="list">
                          <?php foreach ($pending_actions as $action): 
                              // print_r('<pre>');print_r($action);print_r('</pre>');
                              // die;
                            ?>
                                <li <?php 
                                  if($action->cancelled_at)
                                  {
                                    echo 'class="danger"';
                                  }
                                  elseif($action->planned_at)
                                  {
                                    echo 'class="success"';
                                  }
                                  elseif($action->actioned_at)
                                  {
                                    echo 'class="warning"';
                                  }
                                   ?>
                                   >
                                  <div class="col-md-3"> 
                                    <a href="<?php echo site_url();?>companies/company?id=<?php echo $action->company_id;?>" > <?php echo $action->company_name;?></a>
                                  </div>
                                  <div class="col-md-3">
                                    <?php echo $action_types_array[$action->action_type_id]; ?>
                                  </div>
                                  <div class="col-md-2"> 
                                    <?php echo date("l jS M ",$action->actioned_at);?> @ <?php echo date("g:i",$action->actioned_at);?>
                                  </div>
                                  <div class="col-md-4">

                                    <?php $hidden = array('action_id' => $action->id , 'user_id' => $current_user['id'], 'action_do' => 'completed' );
                                     echo form_open(site_url().'actions/edit', 'name="completed_action" class="completed_action " style="display:inline-block;" role="form"',$hidden); ?>
                                     <button class="btn btn-success"><i class="fa fa-check fa-lg"></i> Completed</button> 
                                     </form>

                                     <?php $hidden = array('action_id' => $action->id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled' );
                                     echo form_open(site_url().'actions/edit', 'name="cancel_action" class="cancel_action inline" style="display:inline-block;" role="form"',$hidden); ?>
                                     <button class="btn btn-danger" ><i class="fa fa-trash-o fa-lg"></i> Delete</button>
                                     </form>
                                  </div>
                                </li>
                            <?php endforeach ?>
                        </ul>
                        </div>
                    </div>
            </div>
        </div>

        
   
    </div>