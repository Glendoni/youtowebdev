    <!-- /.row -->
    <div class="row">
        <h1 class="page-header">Dashboard</h1>
        <div class="col-md-4">
        
        </div>
      
        <div class="">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-database fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo count($pending_actions)?></div>
                            <div>Pending actions</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <div class="clearfix"></div>
                        <div clas="list-group">
                        <table class="table">
                          <tr>
                            <th>Created by</th>
                            <th>Action type</th>
                            <th>Comments</th>
                            <th>Actioned at</th>
                            <th>Planned at</th>
                            <th>Window</th>
                            <th>Cancelled at</th>
                            <th>Last updated</th>
                            <th></th>
                          </tr>
                            <?php foreach ($pending_actions as $action): 
                             // print_r('<pre>');print_r($action);print_r('</pre>');

                            ?>
                                  <tr <?php echo  ($action->planned_at? 'class="success"':'class="danger"')?>>
                                    <td><?php echo $system_users[$action->user_id]?></td>
                                    <td><?php echo $action_types_array[$action->action_type_id]; ?></td>
                                    <td><?php echo $action->comments;?></td>
                                    <td><?php echo $action->actioned_at?></td>
                                    <td><?php echo $action->planned_at?></td>
                                    <td><?php echo $action->window?></td>
                                    <td><?php echo $action->cancelled_at?></td>
                                    <td><?php echo $action->updated_at?></td>
                                    <td><?php $hidden = array('action_id' => $action->id , 'user_id' => $current_user['id'], 'action_do' => 'complete' );
                                     echo form_open(site_url().'actions/edit', 'name="completed_action" class="completed_action inline" role="form"',$hidden); ?>
                                     <button class="btn btn-success">Completed</button> 
                                     </form>

                                     <?php $hidden = array('action_id' => $action->id , 'user_id' => $current_user['id'] , 'action_do' => 'cancel' );
                                     echo form_open(site_url().'actions/edit', 'name="cancel_action" class="cancel_action inline" role="form"',$hidden); ?>
                                     <button class="btn btn-danger">Cancel</button>
                                     </form>

                                     </td>
                                  </tr>
                            <?php endforeach ?>
                            </table>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        
   
    </div>