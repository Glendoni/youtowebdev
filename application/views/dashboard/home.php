    <!-- /.row -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Dashboard</h1>
        </div>
        <div class="col-lg-12">
                  <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-search fa-fw"></i> Date Range Search</span> 
          </div>
             
          <div class="panel-body">
            <div class="clearfix"></div>
            <form class="form-inline" role="form">
            <div class="col-md-4">
            <div class="form-group">
            <label for="start-date">Start Date:</label>
            <input type="text" class="form-control" id="start_date" data-date-format="DD-MM-YYYY" name="start_date" placeholder="" value="<?php echo  date('d-m-Y',strtotime($dates['start_date']));?>"></div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
            <label for="end-date">End Date:</label>
            <input type="text" class="form-control" id="end_date" data-date-format="DD-MM-YYYY" name="end_date" placeholder="" value="<?php echo  date('d-m-Y',strtotime($dates['end_date']));?>">
            </div>
            </div>
            <div class="col-md-4">
            <input type="hidden" name="search" value="<?php if (isset($_GET['search'])){echo $_GET['search'];} else {echo "1";};?>">
            <?php if (isset($_GET['user'])) { ?>
             <input type="hidden" name="user" value="<?php echo $_GET['user'];?>"> <?php
             };?>
            <button type="submit" class="btn btn-success btn-block">Search</button>
            </form>
            </div>
          </div>
        </div><!--END PANEL-->

        <?php if ($_GET['search']==2) { ?>
<!--GET SEARCH DATES TO DISPLAY-->

<div class="panel panel-default">
              <div class="panel-heading">
                <?php echo $end_date;?><i class="fa fa-user"></i></i> User Stats <div class="pull-right" style="font-weight:300;">
                (<?php echo date('D jS M y',strtotime($dates['start_date']));?> - <?php echo date('D jS M y',strtotime($dates['end_date']));?>)</div>
              </div>
             
              <div class="panel-body">
                  <div class="clearfix"></div>
                  <div clas="list-group">

                    <?php if(empty($stats)) : ?>
                    <p>You have no recent activity.</p>
                    <?php else: ?>
                    <!-- Nav tabs -->

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div class="col-md-12">
                      <div class="row list-group-item">
                         <div class="col-md-3">
                           <strong>Deals</strong><div class="pull-right"><span class="badge badge-warning"><?php echo count($getuserplacements)?></span></div>
                        </div>
                         <div class="col-md-3">
                           <strong>Proposals</strong><div class="pull-right"><span class="badge badge-warning"><?php echo count($getuserproposals)?></span></div>
                        </div>
                        <div class="col-md-3">
                          <strong>Meetings</strong><div class="pull-right"><span class="badge badge-warning"><?php echo count($getusermeetings)?></span></div>
                          </div>
                          <div class="col-md-3"> 
                           <strong>Pitches</strong><div class="pull-right"><span class="badge badge-warning"><?php echo count($getuserpitches)?></span></div>
                        </div>
                        </div>
                          <div class="row list-group-item">
                            
                            <div class="col-md-3">
                             <?php foreach ($getuserplacements as $get_user_placements): ?>
                            <li class="user-stat-holder">
                            <div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_placements['id'] ?>"  target="_blank"><?php echo $get_user_placements['name'];?></a></div>
                            <div class="user-stat company action_date" style="margin-bottom:5px;">
                            <?php echo  date('D jS M y',strtotime($get_user_placements['actioned_at']));?></div>
                             <span class="label pipeline-label label-success"><?php echo $get_user_placements['username'];?></span>
                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3"> 

                            <?php foreach ($getuserproposals as $get_user_proposals): ?>
                            <li class="user-stat-holder">
                            <div class="user-stat company"><div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_proposals['id'] ?>"  target="_blank"><?php echo $get_user_proposals['name'];?></a></div>
                            <div class="user-stat company action_date">
                            <?php echo  date('D jS M y',strtotime($get_user_proposals['created_at']));?></div>
                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3">
                            <?php foreach ($getusermeetings as $get_user_meetings): ?>
                              <li class="user-stat-holder">
                            <div class="user-stat company <?php if ($get_user_meetings['meeting_actioned'] > '0'): ?>actioned<?php endif; ?>"><a href="companies/company?id=<?php echo $get_user_meetings['id'] ?>"  target="_blank"><?php echo $get_user_meetings['name'];?></a></div>
                            <div class="user-stat company action_date">
                            <?php echo  date('D jS M y',strtotime($get_user_meetings['created_at']));?></div>
                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3"> 
                            <?php foreach ($getuserpitches as $get_user_pitches): ?>

                              <li class="user-stat-holder">
                            <div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_pitches['id'] ?>"  target="_blank"><?php echo $get_user_pitches['name'];?></a></div>
                            <div class="user-stat company action_date">
                            <?php echo  date('D jS M y',strtotime($get_user_pitches['actioned_at']));?></div>
                            </li>
                            <?php endforeach ?>
                            </div>
                          </div>     
                      </div><!--END THIS TAB-->
                      </div>
                      <?php endif ?>
                      </div>
                      </div>
                      </div><!--END PANEL-->
                      <?php };?>
              <div class="panel panel-default">
              <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Weekly Stats
              </div>
             
              <div class="panel-body">
                  <div class="clearfix"></div>
                  <div clas="list-group">

                    <?php if(empty($stats)) : ?>
                    <p>You have no recent activity.</p>
                    <?php else: ?>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                      <li <?php if ($_GET['search'] < '1'): ?>class="active"<?php endif; ?>><a href="#this" role="tab" data-toggle="tab">This Week</a></li>
                      <li><a href="#currentmonth" role="tab" data-toggle="tab">This Month</a></li>
                      <?php if ($_GET['search'] > '0'): ?>
                      <li <?php if ($_GET['search'] > '0'): ?>class="active"<?php endif; ?>><a href="#searchresults" role="tab" data-toggle="tab">Search Results</a></li>
                      <?php endif; ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div class="tab-pane <?php if ($_GET['search'] < '1'): ?>active<?php endif; ?>" id="this">
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
                          <strong>Meetings</strong><br>
                          <Small> Booked (Attended)</Small>
                          </div>
                          <div class="col-md-2 text-center"> 
                           <strong>Pitches</strong>
                        </div>
                        <div class="col-md-2 text-center">
                           <strong>Pipeline Added</strong>
                        </div>
                        </div>
                        <?php foreach ($stats as $stat): ?>
                          <div class="row list-group-item">
                            <div class="col-md-2"> 
                            <?php echo $stat['name'];?>
                            </div>
                            <div class="col-md-2 text-center">
                            <a href = "?search=2&user=<?php echo $stat['user'];?>&period=week&start_date=<?php echo $_GET['start_date']?>&end_date=<?php echo $_GET['end_date']?>"><span class="badge"><?php echo $stat['deals'];?></a></span>
                            </div>
                            <div class="col-md-2 text-center"> 
                            <?php echo $stat['proposals'];?>
                            </div>
                            <div class="col-md-2 text-center">
                            <?php echo $stat['meetingbooked'];?> (<?php echo $stat['meetingcount'];?>)
                            </div>
                            <div class="col-md-2 text-center"> 
                            <?php echo $stat['introcall'];?>
                            </div>
                            <div class="col-md-2 text-center">
                              <?php echo $stat['pipelinecount'];?>
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
                          <strong>Meetings</strong><br>
                          <Small> Booked (Attended)</Small>
                          </div>
                          <div class="col-md-2 text-center"> 
                           <strong>Pitches</strong>
                        </div>
                        <div class="col-md-2 text-center">
                           <strong>Pipeline Added</strong>
                        </div>
                        </div>
                       <?php foreach ($thismonthstats as $thismonthstat): ?>
                          <div class="row list-group-item">
                          <div class="col-md-2"> 
                          <?php echo $thismonthstat['name'];?>
                          </div>
                          <div class="col-md-2 text-center">
                          <a href = "?search=2&user=<?php echo $thismonthstats['user'];?>&period=month&start_date=<?php echo $_GET['start_date']?>&end_date=<?php echo $_GET['end_date']?>"><span class="badge"><?php echo $thismonthstat['deals'];?></span></a>
                          </div>
                          <div class="col-md-2 text-center"> 
                          <?php echo $thismonthstat['proposals'];?>
                          </div>
                          <div class="col-md-2 text-center">
                          <?php echo $thismonthstat['meetingbooked'];?> (<?php echo $thismonthstat['meetingcount'];?>)
                          </div>
                          <div class="col-md-2 text-center"> 
                          <?php echo $thismonthstat['introcall'];?>
                          </div>
                        
                          <div class="col-md-2 text-center">
                          <?php echo $thismonthstat['pipelinecount'];?>
                          </div>
                          </div>
                         
                      <?php endforeach ?>
                      
                      </div>
                    </div>

                    <div class="tab-pane <?php if ($_GET['search'] > '0'): ?>active<?php endif; ?>" id="searchresults">
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
                          <strong>Meetings</strong><br>
                          <Small> Booked (Attended)</Small>
                          </div>
                          <div class="col-md-2 text-center"> 
                           <strong>Pitches</strong>
                        </div>
                        <div class="col-md-2 text-center">
                           <strong>Pipeline Added</strong>
                        </div>
                        </div>

                       <?php foreach ($getstatssearch as $getstatssearch): ?>
                          <div class="row list-group-item">
                          <div class="col-md-2"> 
                          <?php echo $getstatssearch['name'];?>
                          </div>
                          <div class="col-md-2 text-center">
                          <a href = "?search=2&user=<?php echo $getstatssearch['user'];?>&period=&start_date=<?php echo $_GET['start_date']?>&end_date=<?php echo $_GET['end_date']?>"><span class="badge"><?php echo $getstatssearch['deals'];?></span></a>
                          </div>
                          <div class="col-md-2 text-center"> 
                          <?php echo $getstatssearch['proposals'];?>
                          </div>
                          <div class="col-md-2 text-center">
                          <?php echo $getstatssearch['meetingbooked'];?> (<?php echo $getstatssearch['meetingcount'];?>)
                          </div>
                          <div class="col-md-2 text-center"> 
                          <?php echo $getstatssearch['introcall'];?>
                          </div>
                        
                          <div class="col-md-2 text-center">
                          <?php echo $getstatssearch['pipelinecount'];?>

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
                <i class="fa fa-filter"></i></i> Pipeline
              </div>
             
              <div clas="list-group">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="active"><a href="#individual_pipeline" role="tab" data-toggle="tab">My Pipeline</a></li>
                      <li><a href="#team_pipeline" role="tab" data-toggle="tab">Team Pipeline</a></li>
      </ul>
                      <div class="tab-content">
                      <div class="tab-pane active" id="individual_pipeline">
<div class="panel-body">
              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default contact">
                            <div class="panel-heading">
                            Initial Contact <div class="pull-right"><span class="badge"><?php echo count($pipelinecontactedindividual)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinecontactedindividual as $pipelinecontactedindividual): ?>
                            <div class="col-md-12 pipeline-details ">
                            <?php $now = time(); // or your date as well
                            $your_date = strtotime($pipelinecontactedindividual['created_at']);
                            $datediff = $now - $your_date;
                            $date_since = floor($datediff/(60*60*24));
                             if ($date_since<1){
                            $display_date = "<div class='col-md-12 pipeline-days ok'>Today</div>";
                             } 
                              else if ($date_since<2) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Day</div>";

                             }
                            else if ($date_since<20) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Days</div>";

                             }
                              else if ($date_since>19) {
                             $display_date = "<div class='col-md-12 pipeline-days overdue'><strong>OVERDUE:</strong> ".$date_since." Days</div>";
                             }
                            ?>

                            <?php echo $display_date;?>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinecontactedindividual['company_id'] ?>"  target="_blank">

                            <?php echo $pipelinecontactedindividual['company_name'];?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinecontactedindividual['pipeline']); ?>"><?php echo $pipelinecontactedindividual['pipeline'] ?></span> <small><?php echo $pipelinecontactedindividual['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default contact">
                            <div class="panel-heading">
                            Proposals <div class="pull-right"><span class="badge"><?php echo count($pipelineproposalindividual)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelineproposalindividual as $pipelineproposalindividual): ?>
                            <div class="col-md-12 pipeline-details ">
                            <?php $now = time(); // or your date as well
                            $your_date = strtotime($pipelineproposalindividual['created_at']);
                            $datediff = $now - $your_date;
                            $date_since = floor($datediff/(60*60*24));
                             if ($date_since<1){
                            $display_date = "<div class='col-md-12 pipeline-days ok'>Today</div>";
                             } 
                              else if ($date_since<2) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Day</div>";

                             }
                            else if ($date_since<20) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Days</div>";

                             }
                             else if (($date_since>14) && ($date_since<30)) {
                             $display_date = "<div class='col-md-12 pipeline-days warning'><strong>WARNING: </strong>".$date_since." Days</div>";

                             }
                              else if ($date_since>29) {
                             $display_date = "<div class='col-md-12 pipeline-days overdue'><strong>OVERDUE:</strong> ".$date_since." Days</div>";
                             }
                            ?>

                            <?php echo $display_date;?>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelineproposalindividual['company_id'] ?>"  target="_blank">

                            <?php echo $pipelineproposalindividual['company_name'];?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelineproposalindividual['pipeline']); ?>"><?php echo $pipelineproposalindividual['pipeline'] ?></span> <small><?php echo $pipelineproposalindividual['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->


              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default contact">
                            <div class="panel-heading">
                            Deals <div class="pull-right"><span class="badge"><?php echo count($pipelinecustomerindividual)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinecustomerindividual as $pipelinecustomerindividual): ?>
                            <div class="col-md-12 pipeline-details ">
                            <?php $now = time(); // or your date as well
                            $your_date = strtotime($pipelinecustomerindividual['created_at']);
                            $datediff = $now - $your_date;
                            $date_since = floor($datediff/(60*60*24));
                             if ($date_since<1){
                            $display_date = "<div class='col-md-12 pipeline-days ok'>Today</div>";
                             } 
                              else if ($date_since<2) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Day</div>";

                             }
                            else {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Days</div>";

                             }
                            ?>
                            <?php echo $display_date;?>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinecustomerindividual['company_id'] ?>"  target="_blank">
                            <?php echo $pipelinecustomerindividual['company_name'];?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinecustomerindividual['pipeline']); ?>"><?php echo $pipelinecustomerindividual['pipeline'] ?></span> <small><?php echo $pipelinecustomerindividual['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
                  <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default contact">
                            <div class="panel-heading">
                            Lost <?php if (!isset($_GET['start_date'])) { echo"<small>(This Month)</small>";}?> <div class="pull-right"><span class="badge badge-warning"><?php echo count($pipelinelostindividual)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinelostindividual as $pipelinelostindividual): ?>
                                                     
                            <div class='col-md-12 pipeline-days overdue'><strong>Lost</strong></div>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinelostindividual['company_id'] ?>"  target="_blank">

                            <?php echo $pipelinelostindividual['company_name'];?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinelostindividual['pipeline']); ?>"><?php echo $pipelinelostindividual['pipeline'] ?></span> <small><?php echo $pipelinelostindividual['username'] ?></small>
                            </div>
                            
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->


              
              </div>
                      </div><!--END THIS TAB-->
      <div class="tab-pane" id="team_pipeline">
<div class="panel-body">
              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default contact">
                            <div class="panel-heading">
                            Initial Contact <div class="pull-right"><span class="badge"><?php echo count($pipelinecontacted)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinecontacted as $pipelinecontacted): ?>
                            <div class="col-md-12 pipeline-details ">
                            <?php $now = time(); // or your date as well
                            $your_date = strtotime($pipelinecontacted['created_at']);
                            $datediff = $now - $your_date;
                            $date_since = floor($datediff/(60*60*24));
                             if ($date_since<1){
                            $display_date = "<div class='col-md-12 pipeline-days ok'>Today</div>";
                             } 
                              else if ($date_since<2) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Day</div>";

                             }
                            else if ($date_since<20) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Days</div>";

                             }
                              else if ($date_since>19) {
                             $display_date = "<div class='col-md-12 pipeline-days overdue'><strong>OVERDUE:</strong> ".$date_since." Days</div>";
                             }
                            ?>

                            <?php echo $display_date;?>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinecontacted['company_id'] ?>"  target="_blank">

                            <?php echo $pipelinecontacted['company_name'];?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinecontacted['pipeline']); ?>"><?php echo $pipelinecontacted['pipeline'] ?></span> <small><?php echo $pipelinecontacted['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default contact">
                            <div class="panel-heading">
                            Proposals <div class="pull-right"><span class="badge"><?php echo count($pipelineproposal)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelineproposal as $pipelineproposal): ?>
                            <div class="col-md-12 pipeline-details ">
                            <?php $now = time(); // or your date as well
                            $your_date = strtotime($pipelineproposal['created_at']);
                            $datediff = $now - $your_date;
                            $date_since = floor($datediff/(60*60*24));
                             if ($date_since<1){
                            $display_date = "<div class='col-md-12 pipeline-days ok'>Today</div>";
                             } 
                              else if ($date_since<2) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Day</div>";

                             }
                            else if ($date_since<20) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Days</div>";

                             }
                             else if (($date_since>14) && ($date_since<30)) {
                             $display_date = "<div class='col-md-12 pipeline-days warning'><strong>WARNING: </strong>".$date_since." Days</div>";

                             }
                              else if ($date_since>29) {
                             $display_date = "<div class='col-md-12 pipeline-days overdue'><strong>OVERDUE:</strong> ".$date_since." Days</div>";
                             }
                            ?>

                            <?php echo $display_date;?>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelineproposal['company_id'] ?>"  target="_blank">

                            <?php echo $pipelineproposal['company_name'];?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelineproposal['pipeline']); ?>"><?php echo $pipelineproposal['pipeline'] ?></span> <small><?php echo $pipelineproposal['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->


              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default contact">
                            <div class="panel-heading">
                            Deals <div class="pull-right"><span class="badge"><?php echo count($pipelinecustomer)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinecustomer as $pipelinecustomer): ?>
                            <div class="col-md-12 pipeline-details ">
                            <?php $now = time(); // or your date as well
                            $your_date = strtotime($pipelinecustomer['created_at']);
                            $datediff = $now - $your_date;
                            $date_since = floor($datediff/(60*60*24));
                             if ($date_since<1){
                            $display_date = "<div class='col-md-12 pipeline-days ok'>Today</div>";
                             } 
                              else if ($date_since<2) {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Day</div>";

                             }
                            else {
                             $display_date = "<div class='col-md-12 pipeline-days ok'>".$date_since." Days</div>";

                             }
                            ?>
                            <?php echo $display_date;?>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinecustomer['company_id'] ?>"  target="_blank">
                            <?php echo $pipelinecustomer['company_name'];?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinecustomer['pipeline']); ?>"><?php echo $pipelinecustomer['pipeline'] ?></span> <small><?php echo $pipelinecustomer['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
                  <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default contact">
                            <div class="panel-heading">
                            Lost <?php if (!isset($_GET['start_date'])) { echo"<small>(This Month)</small>";}?> <div class="pull-right"><span class="badge badge-warning"><?php echo count($pipelinelost)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinelost as $pipelinelost): ?>
                                                     
                            <div class='col-md-12 pipeline-days overdue'><strong>Lost</strong></div>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinelost['company_id'] ?>"  target="_blank">

                            <?php echo $pipelinelost['company_name'];?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinelost['pipeline']); ?>"><?php echo $pipelinelost['pipeline'] ?></span> <small><?php echo $pipelinelost['username'] ?></small>
                            </div>
                            
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
        </div>
        </div><!--END THIS TAB-->
      </div>
      </div>
          </div>



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
                            <div class="col-md-4" style="text-align:right;">
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
          </div><!--END OF PANEL-->
          
          
      </div>
  </div>
  
