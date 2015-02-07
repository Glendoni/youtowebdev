    <!-- /.row -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Dashboard</h1>
        </div>
        <div class="col-lg-12">
          


      
      <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Weekly Stats</span> 
              </div>
             
              <div class="panel-body">
                  <div class="clearfix"></div>
                  <div clas="list-group">

                    <?php if(empty($stats)) : ?>
                    <p>You have no recent activity.</p>
                    <?php else: ?>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                      <li <?php if ($_GET['search'] <> '1'): ?>class="active"<?php endif; ?>><a href="#this" role="tab" data-toggle="tab">This Week</a></li>
                      <li><a href="#currentmonth" role="tab" data-toggle="tab">This Month</a></li>
                      <?php if ($_GET['search'] == '1'): ?>
                      <li <?php if ($_GET['search'] == '1'): ?>class="active"<?php endif; ?>><a href="#searchresults" role="tab" data-toggle="tab">Search Results</a></li>
                      <?php endif; ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div class="tab-pane <?php if ($_GET['search'] <> '1'): ?>active<?php endif; ?>" id="this">
                      <div class="col-md-12">

                      
                      <div class="row list-group-item">

                      <div class="col-md-2"> 
                           <strong>Name</strong>
                        </div>
                         <div class="col-md-2 text-center">
                           <strong>Deals</strong>
                        </div>
                         <div class="col-md-2 text-center">
                           <strong>Proposals</strong>
                        </div>
                        <div class="col-md-2 text-center">
                          <strong>Meetings Booked</strong>
                          </div>
                          <div class="col-md-2 text-center"> 
                          <strong>Meetings Attended</strong>
                        </div>
                        <div class="col-md-2 text-center">
                           <strong>Pitches</strong>
                        </div>
                        </div>
                        <?php foreach ($stats as $stat): ?>
                          <div class="row list-group-item">
                            <div class="col-md-2"> 
                            <?php echo $stat['name'];?>
                            </div>
                            <div class="col-md-2 text-center">
                            <span class="badge"><?php echo $stat['deals'];?></span>
                            </div>
                            <div class="col-md-2 text-center"> 
                            <?php echo $stat['proposals'];?>
                            </div>
                            <div class="col-md-2 text-center">
                            <?php echo $stat['meetingbooked'];?>
                            </div>
                            <div class="col-md-2 text-center"> 
                            <?php echo $stat['meetingcount'];?>
                            </div>
                            <div class="col-md-2 text-center">
                            <?php echo $stat['introcall'];?>
                            </div>
                          </div>     
                      <?php endforeach ?>
                      </div>
                      </div><!--END THIS TAB-->
                      <div class="tab-pane" id="currentmonth">
                      <div class="col-md-12">
                        <div class="row list-group-item">
                         <div class="col-md-2"> 
                           <strong>Name</strong>
                        </div>
                         <div class="col-md-2 text-center">
                           <strong>Deals</strong>
                        </div>
                         <div class="col-md-2 text-center">
                           <strong>Proposals</strong>
                        </div>
                        <div class="col-md-2 text-center">
                          <strong>Meetings Booked</strong>
                          </div>
                          <div class="col-md-2 text-center"> 
                          <strong>Meetings Attended</strong>
                        </div>
                        <div class="col-md-2 text-center">
                           <strong>Pitches</strong>
                        </div>
                        </div>
                       <?php foreach ($thismonthstats as $thismonthstat): ?>
                          <div class="row list-group-item">
                          <div class="col-md-2"> 
                          <?php echo $thismonthstat['name'];?>
                          </div>
                          <div class="col-md-2 text-center">
                          <span class="badge"><?php echo $thismonthstat['deals'];?></span>
                          </div>
                          <div class="col-md-2 text-center"> 
                          <?php echo $thismonthstat['proposals'];?>
                          </div>
                          <div class="col-md-2 text-center">
                          <?php echo $thismonthstat['meetingbooked'];?>
                          </div>
                          <div class="col-md-2 text-center"> 
                          <?php echo $thismonthstat['meetingcount'];?>
                          </div>
                        
                          <div class="col-md-2 text-center">
                          <?php echo $thismonthstat['introcall'];?>
                          </div>
                          </div>
                         
                      <?php endforeach ?>
                      
                      </div>
                    </div>

                    <div class="tab-pane <?php if ($_GET['search'] == '1'): ?>active<?php endif; ?>" id="searchresults">
                      <div class="col-md-12">
                        <div class="row list-group-item">
                         <div class="col-md-2"> 
                           <strong>Name</strong>
                        </div>
                         <div class="col-md-2 text-center">
                           <strong>Deals</strong>
                        </div>
                         <div class="col-md-2 text-center">
                           <strong>Proposals</strong>
                        </div>
                        <div class="col-md-2 text-center">
                          <strong>Meetings Booked</strong>
                          </div>
                          <div class="col-md-2 text-center"> 
                          <strong>Meetings Attended</strong>
                        </div>
                        <div class="col-md-2 text-center">
                           <strong>Pitches</strong>
                        </div>
                        </div>

                       <?php foreach ($getstatssearch as $getstatssearch): ?>
                          <div class="row list-group-item">
                          <div class="col-md-2"> 
                          <?php echo $getstatssearch['name'];?>
                          </div>
                          <div class="col-md-2 text-center">
                          <span class="badge"><?php echo $getstatssearch['deals'];?></span>
                          </div>
                          <div class="col-md-2 text-center"> 
                          <?php echo $getstatssearch['proposals'];?>
                          </div>
                          <div class="col-md-2 text-center">
                          <?php echo $getstatssearch['meetingbooked'];?>
                          </div>
                          <div class="col-md-2 text-center"> 
                          <?php echo $getstatssearch['meetingcount'];?>
                          </div>
                        
                          <div class="col-md-2 text-center">
                          <?php echo $getstatssearch['introcall'];?>
                          </div>
                          </div>
                         
                      <?php endforeach ?>
                      
                      </div>
                    </div><!--END THIS TAB-->

                    </div>
                    <?php endif ?>
                  </div>
              </div>

          </div><!--END PANEL-->

          <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-search fa-fw"></i> Date Range Search</span> 
          </div>
             
          <div class="panel-body">
            <div class="clearfix"></div>
            <form class="form-inline" role="form">
            <div class="form-group">
            <label for="start-date">Start Date:</label>
            <input type="text" class="form-control" id="start_date" data-date-format="DD-MM-YYYY" name="start_date" placeholder="" value="<?php echo $_GET['start_date']?>">    </div>
            <div class="form-group">
            <label for="end-date">End Date:</label>
            <input type="text" class="form-control" id="end_date" data-date-format="DD-MM-YYYY" name="end_date" placeholder="" value="<?php echo $_GET['end_date']?>">
            </div>
            <input type="hidden" name="search" value="1">
            <button type="submit" class="btn btn-success">Submit</button>
            </form>
          </div>
        </div><!--END PANEL-->

          <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fa fa-bell fa-fw"></i> Your Calls & Meetings <span class="label label-primary pull-right"><?php echo count($pending_actions)?></span> 
              </div>
             
              <div class="panel-body">
              <div class="col-md-12">
                  <div class="clearfix"></div>
                  <div clas="list-group">

                    <?php if(empty($pending_actions)) : ?>
                    <p>You have no recent activity.</p>
                    <?php else: ?>

                    <?php foreach ($pending_actions as $action): 
                         // print_r('<pre>');print_r($action);print_r('</pre>');
                        // die;
                      ?>
                          <div class="row list-group-item <?php if( strtotime($action->planned_at) < strtotime('today')  ) { echo ' delayed';} ?> ">
                            <div class="col-md-3"> 
                              <a href="<?php echo site_url();?>companies/company?id=<?php echo $action->company_id;?>" target="_blank"> <?php echo $action->company_name;?></a>
                            </div>
                            <div class="col-md-2">
                              <?php echo $action_types_array[$action->action_type_id]; ?>
                            </div>
                            <div class="col-md-3"> 
                              <?php echo date("D jS M ",strtotime($action->planned_at));?> @ <?php echo date("g:i",strtotime($action->planned_at));?>
                            </div>
                            <div class="col-md-4">
                              <?php $hidden = array('action_id' => $action->action_id , 'user_id' => $current_user['id'], 'action_do' => 'completed', 'outcome' => '' , 'company_id' => $action->company_id);
                               echo form_open(site_url().'actions/edit', 'name="completed_action"  class="completed_action" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action->action_id.'" style="display:inline-block;" role="form"',$hidden); ?>
                               <button class="btn btn-success"><i class="fa fa-check fa-lg"></i> Completed</button> 
                               </form>
                               <?php $hidden = array('action_id' => $action->action_id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled','outcome' => '' , 'company_id' => $action->company_id);
                               echo form_open(site_url().'actions/edit', 'name="cancel_action"  class="cancel_action" style="display:inline-block;" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action->action_id.'" role="form"',$hidden); ?>
                               <button class="btn btn-danger" ><i class="fa fa-trash-o fa-lg"></i> Cancel</button>
                               </form>
                            </div>
                          </div>
                          <div class="row list-group-item" id="action_outcome_box_<?php echo $action->action_id ?>" style="display:none;">
                          <label>Outcome</label>
                          <textarea class="form-control" name="outcome" rows="3" style="margin-bottom:5px;"></textarea>
                          <button class="btn btn-primary pull-right"><i class="fa fa-check fa-lg"></i> Send</button>
                          </div>
                      <?php endforeach ?>
                    <?php endif ?>
                  </div>
              </div>
              </div>
          </div>
      </div>
      <!-- <div class="col-lg-4">
        <div class="panel panel-default">
          <div class="panel-heading">
              <i class="fa fa-bell fa-fw"></i> Notifications Panel
          </div>
          <div class="panel-body">
              <div class="list-group">
                  <a href="#" class="list-group-item">
                      <i class="fa fa-comment fa-fw"></i> New Comment
                      <span class="pull-right text-muted small"><em>4 minutes ago</em>
                      </span>
                  </a>
                  
              </div>
          </div>
        </div>
    </div> -->
  </div>
  
