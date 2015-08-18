<div class="col-md-12" style="background-color:#fff; margin-top:-20px; padding:10px 0; border-bottom:1px solid #e7e7e7; margin-bottom:20px;border-left:1px solid #e7e7e7; margin-bottom:20px;border-right:1px solid #e7e7e7; margin-bottom:20px;">
<div class="col-sm-9 col-sm-offset-3">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs dashboard" role="tablist">
    <li role="presentation" class="active"><button href="#team_stats" aria-controls="team_stats" role="tab" data-toggle="tab" class="btn btn-primary btn-sm" style="margin-right:10px;">Stats</button></li>
    <li role="presentation"><button href="#calls" aria-controls="calls" role="tab" data-toggle="tab" class="btn btn-primary btn-sm" style="margin-right:10px;">Calls & Meetings</button></li>
    <li role="presentation"><button href="#pipeline" aria-controls="pipeline" role="tab" data-toggle="tab" class="btn btn-primary btn-sm"style="margin-right:10px;">Pipeline</button></li>
    <!--<li role="presentation"><button href="#assigned" aria-controls="assigned" role="tab" data-toggle="tab" class="btn btn-primary btn-sm">Assigned Companies</button></li>-->
  </ul>
  </div>
</div>



<div class="col-sm-3 clearfix no-padding">
<div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">My Campaigns <span class="badge pull-right"><?php echo count($private_campaigns); ?></span></h3>
                                </div>
                              <div class="panel-body" style="padding:0;">
                                <ul class="list-group" style="margin-bottom:0;">
                                    <!-- PRIVATE SEARCHES -->
                                    <?php foreach ($private_campaigns as $campaign):?>
                                    <li class="no-padding" style="padding: 0 5px;">
                                      <a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $campaign->id; ?>" class="load-saved-search" <?php echo strlen($campaign->name) > 36 ? 'title="'.$campaign->name.'">':">" ?><span class="name"  style="margin-right: 10px;"><?php echo strlen($campaign->name) > 36 ? substr($campaign->name,0,36).'...' : $campaign->name?></span>
                                            <span class="badge small-badge pull-right"><?php echo $campaign->campaigncount; ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                  
                                    </ul>
                                </div>
                            </div>
                      
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Team Campaigns <span class="badge pull-right"><?php echo count($shared_campaigns); ?></span>
                                    </h3>    
                                </div>
                              <div class="panel-body" style="padding:0;">
                                <ul class="list-group">
                                <!-- SHARED SEARCHES -->
                                <?php foreach ($shared_campaigns as $campaign):?>
                                    <?php 
                                    $user_icon = explode(",", $campaign->image);
                                    $bg_colour = $user_icon[1];
                                    $bg_colour_text = $user_icon[2];
                                    $bg_colour_name = $user_icon[0];?>
                                    <li class="no-padding" style="padding: 0 5px;">
                                        <a href="<?php echo site_url();?>campaigns/display_campaign/?id=<?php echo $campaign->id; ?>" class="load-saved-search"  <?php echo strlen($campaign->name) > 33 ? 'title="'.$campaign->name.'">':">" ?>
                                        <span class="label label-info" style="margin-right:3px;background-color: <?php echo $bg_colour; ?>;font-size:8px; color: <?php echo $bg_colour_text;?>"><b><?php echo $bg_colour_name; ?></b></span>
                                            <span class="name"  style="margin-right: 5px;">
                         <?php echo strlen($campaign->name) > 33 ? substr($campaign->name,0,33).'...' : $campaign->name?></span>
                                <span class="badge small-badge pull-right"><?php echo $campaign->campaigncount; ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                              </div>
                            </div>

                            </div>



<div class="col-sm-9">

<?php if ($_GET['search']==2) { ?>
<!--GET SEARCH DATES TO DISPLAY-->

<div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">User Stats<div class="pull-right" style="font-weight:300;">
                (<?php echo date('D jS M y',strtotime($dates['start_date']));?> - <?php echo date('D jS M y',strtotime($dates['end_date']));?>)</div></h3> 
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
                           <strong>Call Activity</strong><div class="pull-right"><span class="badge badge-warning"><?php echo count($getuserpitches)?></span></div>
                        </div>
                        </div>
                          <div class="row list-group-item">
                            
                            <div class="col-md-3">
                             <?php foreach ($getuserplacements as $get_user_placements): ?>
                            <li class="user-stat-holder">
                            <div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_placements['id'] ?>"><?php echo $get_user_placements['name'];?></a></div>
                            <div class="user-stat company action_date" style="margin-bottom:5px;">
                            <?php echo  date('D jS M y',strtotime($get_user_placements['actioned_at']));?></div>
                             <span class="label pipeline-label label-success"><?php echo $get_user_placements['username'];?></span>
                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3"> 

                            <?php foreach ($getuserproposals as $get_user_proposals): ?>
                            <li class="user-stat-holder">
                            <div class="user-stat company"><div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_proposals['id'] ?>" ><?php echo $get_user_proposals['name'];?></a></div>
                            <div class="user-stat company action_date">
                            <?php echo  date('D jS M y',strtotime($get_user_proposals['created_at']));?></div>
                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3">
                            <?php foreach ($getusermeetings as $get_user_meetings): ?>
                              <li class="user-stat-holder">
                            <div class="user-stat company <?php if ($get_user_meetings['meeting_actioned'] > '0'): ?>actioned<?php endif; ?>"><a href="companies/company?id=<?php echo $get_user_meetings['id'] ?>" ><?php echo $get_user_meetings['name'];?></a></div>
                            <div class="user-stat company action_date">
                            <?php echo  date('D jS M y',strtotime($get_user_meetings['created_at']));?></div>
                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3"> 
                            <?php foreach ($getuserpitches as $get_user_pitches): ?>

                              <li class="user-stat-holder">
                            <div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_pitches['id'] ?>"  ><?php echo $get_user_pitches['name'];?></a></div>
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


  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="team_stats">
      <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Team Stats</h3>
              </div>
             
              <div class="panel-body">
                  <div class="clearfix"></div>
                  <div class="list-group">

                    <?php if(empty($stats)) : ?>
                    <p>You have no recent activity.</p>
                    <?php else: ?>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                      <li <?php if ($_GET['search'] < '1'): ?>class="active"<?php endif; ?>><a href="#this" role="tab" data-toggle="tab">This Week</a></li>
                      <li><a href="#lastweek" role="tab" data-toggle="tab">Last Week</a></li>
                      <li><a href="#currentmonth" role="tab" data-toggle="tab">This Month</a></li>
                      <li><a href="#lastmonth" role="tab" data-toggle="tab">Last Month</a></li>
                      <?php if ($_GET['search'] > '0'): ?>
                      <li <?php if ($_GET['search'] > '0'): ?>class="active"<?php endif; ?>><a href="#searchresults" role="tab" data-toggle="tab">Search Results</a></li>
                      <?php endif; ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div class="tab-pane <?php if ($_GET['search'] < '1'): ?>active<?php endif; ?>" id="this">
                      <div class="col-sm-12">                      
                      <div class="row list-group-item">

                      <div class="col-sm-2"> 
                           <strong>Name</strong>
                        </div>
                         <div class="col-sm-1 text-center">
                           <strong>Deals</strong>
                        </div>
                         <div class="col-sm-1 text-center">
                           <strong>Proposals</strong>
                        </div>
                        <div class="col-sm-2 text-center">
                          <strong>Meetings</strong><br>
                          <Small> Booked (Attended)</Small>
                          </div>
                          <div class="col-sm-2 text-center"> 
                           <strong>Call Activity</strong><br>
                           <Small> Total Calls (Intro)</Small>
                        </div>
                        <div class="col-sm-1 text-center">
                           <strong>Pipeline Added</strong>
                        </div>
                        <div class="col-sm-2 text-center"> 
                           <strong>Review Months</strong><br>
                           <Small>Added / Occuring</Small>
                        </div>
                        <div class="col-sm-1 text-center">
                           <strong>DueDil</strong>
                        </div>
                        </div>
                        <?php foreach ($stats as $stat): ?>
                          <div class="row list-group-item">
                            <div class="col-sm-2"> 
                            <?php $user_icon = explode(",",$stat['image']); echo "<div class='circle' style='float: left;margin-top: -5px;margin-right: 10px;width: 35px;height: 35px;border-radius: 30px;font-size: 12px;line-height: 35px;text-align: center;font-weight: 700;background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>

                            </div>
                            <div class="col-sm-1 text-center">
                            <a href = "?search=2&user=<?php echo $stat['user'];?>&period=week"><span class="badge" style="background-color:#00B285;"><?php echo $stat['deals'];?></a></span>
                            </div>
                            <div class="col-sm-1 text-center"> 
                            <?php echo $stat['proposals'];?>
                            </div>
                            <div class="col-sm-2 text-center">
                            <?php echo $stat['meetingbooked'];?> (<?php echo $stat['meetingcount'];?>)
                            </div>
                            <div class="col-sm-2 text-center"> 
                            <?php echo $stat['salescall'];?>
                            (<?php echo $stat['introcall'];?>)
                            </div>
                            <div class="col-sm-1 text-center">
                              <?php echo $stat['pipelinecount'];?>
                            </div>
                            <div class="col-sm-2 text-center">
                              <?php echo $stat['key_review_added'];?> / <?php echo $stat['key_review_occuring'];?>
                            </div>
                            <div class="col-sm-1 text-center">
                              <?php echo $stat['duediligence'];?>
                            </div>
                          </div>     
                      <?php endforeach ?>
                      </div>
                      </div><!--END THIS TAB-->

                      <div class="tab-pane" id="lastweek">
                      <div class="col-md-12">
                        <div class="row list-group-item">
                          <div class="col-md-2"> 
                           <strong>Name</strong>
                        </div>
                         <div class="col-md-1 text-center">
                           <strong>Deals</strong>
                        </div>
                         <div class="col-md-1 text-center">
                           <strong>Proposals</strong>
                        </div>
                        <div class="col-md-2 text-center">
                          <strong>Meetings</strong><br>
                          <Small> Booked (Attended)</Small>
                          </div>
                          <div class="col-md-2 text-center"> 
                           <strong>Call Activity</strong><br>
                           <Small> Total Calls (Intro)</Small>
                        </div>
                        <div class="col-md-1 text-center">
                           <strong>Pipeline Added</strong>
                        </div>
                        <div class="col-md-2 text-center"> 
                           <strong>Review Months</strong><br>
                           <Small>Added / Occuring</Small>
                        </div>
                        <div class="col-md-1 text-center">
                           <strong>DueDil</strong>
                        </div>
                        </div>
                        <?php foreach ($lastweekstats as $lastweekstats): ?>
                          <div class="row list-group-item">
                            <div class="col-md-2"> 
                            <?php $user_icon = explode(",",$lastweekstats['image']); echo "<div class='circle' style='float: left;margin-top: -5px;margin-right: 10px;width: 35px;height: 35px;border-radius: 30px;font-size: 12px;line-height: 35px;text-align: center;font-weight: 700;background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>

                            </div>
                            <div class="col-md-1 text-center">
                            <a href = "?search=2&user=<?php echo $lastweekstats['user'];?>&period=lastweek"><span class="badge" style="background-color:#00B285;"><?php echo $lastweekstats['deals'];?></a></span>
                            </div>
                            <div class="col-md-1 text-center"> 
                            <?php echo $lastweekstats['proposals'];?>
                            </div>
                            <div class="col-md-2 text-center">
                            <?php echo $lastweekstats['meetingbooked'];?> (<?php echo $lastweekstats['meetingcount'];?>)
                            </div>
                            <div class="col-md-2 text-center"> 
                            <?php echo $lastweekstats['salescall'];?>
                            (<?php echo $lastweekstats['introcall'];?>)
                            </div>
                            <div class="col-md-1 text-center">
                              <?php echo $lastweekstats['pipelinecount'];?>
                            </div>
                            <div class="col-md-2 text-center">
                              <?php echo $lastweekstats['key_review_added'];?> / <?php echo $lastweekstats['key_review_occuring'];?>
                            </div>
                            <div class="col-md-1 text-center">
                              <?php echo $lastweekstats['duediligence'];?>
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
                         <div class="col-md-1 text-center">
                           <strong>Deals</strong>
                        </div>
                         <div class="col-md-1 text-center">
                           <strong>Proposals</strong>
                        </div>
                        <div class="col-md-2 text-center">
                          <strong>Meetings</strong><br>
                          <Small> Booked (Attended)</Small>
                          </div>
                          <div class="col-md-2 text-center"> 
                           <strong>Call Activity</strong><br>
                           <Small> Total Calls (Intro)</Small>
                        </div>
                        <div class="col-md-1 text-center">
                           <strong>Pipeline Added</strong>
                        </div>
                        <div class="col-md-2 text-center"> 
                           <strong>Review Months</strong><br>
                           <Small>Added / Occuring</Small>
                        </div>
                        <div class="col-md-1 text-center">
                           <strong>DueDil</strong>
                        </div>
                        </div>
                        <?php foreach ($thismonthstats as $thismonthstats): ?>
                          <div class="row list-group-item">
                            <div class="col-md-2"> 
                            <?php $user_icon = explode(",",$thismonthstats['image']); echo "<div class='circle' style='float: left;margin-top: -5px;margin-right: 10px;width: 35px;height: 35px;border-radius: 30px;font-size: 12px;line-height: 35px;text-align: center;font-weight: 700;background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>

                            </div>
                            <div class="col-md-1 text-center">
                            <a href = "?search=2&user=<?php echo $thismonthstats['user'];?>&period=thismonth"><span class="badge"  style="background-color:#00B285;"><?php echo $thismonthstats['deals'];?></a></span>
                            </div>
                            <div class="col-md-1 text-center"> 
                            <?php echo $thismonthstats['proposals'];?>
                            </div>
                            <div class="col-md-2 text-center">
                            <?php echo $thismonthstats['meetingbooked'];?> (<?php echo $thismonthstats['meetingcount'];?>)
                            </div>
                            <div class="col-md-2 text-center"> 
                            <?php echo $thismonthstats['salescall'];?>
                            (<?php echo $thismonthstats['introcall'];?>)
                            </div>
                            <div class="col-md-1 text-center">
                              <?php echo $thismonthstats['pipelinecount'];?>
                            </div>
                            <div class="col-md-2 text-center">
                              <?php echo $thismonthstats['key_review_added'];?> / <?php echo $thismonthstats['key_review_occuring'];?>
                            </div>
                            <div class="col-md-1 text-center">
                              <?php echo $thismonthstats['duediligence'];?>
                            </div>
                          </div>     
                      <?php endforeach ?>
                      
                      </div>
                    </div>

                    <div class="tab-pane" id="lastmonth">
                      <div class="col-md-12">
                        <div class="row list-group-item">
                          <div class="col-md-2"> 
                           <strong>Name</strong>
                        </div>
                         <div class="col-md-1 text-center">
                           <strong>Deals</strong>
                        </div>
                         <div class="col-md-1 text-center">
                           <strong>Proposals</strong>
                        </div>
                        <div class="col-md-2 text-center">
                          <strong>Meetings</strong><br>
                          <Small> Booked (Attended)</Small>
                          </div>
                          <div class="col-md-2 text-center"> 
                           <strong>Call Activity</strong><br>
                           <Small> Total Calls (Intro)</Small>
                        </div>
                        <div class="col-md-1 text-center">
                           <strong>Pipeline Added</strong>
                        </div>
                        <div class="col-md-2 text-center"> 
                           <strong>Review Months</strong><br>
                           <Small>Added / Occuring</Small>
                        </div>
                        <div class="col-md-1 text-center">
                           <strong>DueDil</strong>
                        </div>
                        </div>
                        <?php foreach ($lastmonthstats as $lastmonthstats): ?>
                          <div class="row list-group-item">
                            <div class="col-md-2"> 
                            <?php $user_icon = explode(",",$lastmonthstats['image']); echo "<div class='circle' style='float: left;margin-top: -5px;margin-right: 10px;width: 35px;height: 35px;border-radius: 30px;font-size: 12px;line-height: 35px;text-align: center;font-weight: 700;background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>

                            </div>
                            <div class="col-md-1 text-center">
                            <a href = "?search=2&user=<?php echo $lastmonthstats['user'];?>&period=lastmonth"><span class="badge"  style="background-color:#00B285;"><?php echo $lastmonthstats['deals'];?></a></span>
                            </div>
                            <div class="col-md-1 text-center"> 
                            <?php echo $lastmonthstats['proposals'];?>
                            </div>
                            <div class="col-md-2 text-center">
                            <?php echo $lastmonthstats['meetingbooked'];?> (<?php echo $lastmonthstats['meetingcount'];?>)
                            </div>
                            <div class="col-md-2 text-center"> 
                            <?php echo $lastmonthstats['salescall'];?>
                            (<?php echo $lastmonthstats['introcall'];?>)
                            </div>
                            <div class="col-md-1 text-center">
                              <?php echo $lastmonthstats['pipelinecount'];?>
                            </div>
                            <div class="col-md-2 text-center">
                              <?php echo $lastmonthstats['key_review_added'];?> / <?php echo $lastmonthstats['key_review_occuring'];?>
                            </div>
                            <div class="col-md-1 text-center">
                              <?php echo $lastmonthstats['duediligence'];?>
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
                         <div class="col-md-1 text-center">
                           <strong>Deals</strong>
                        </div>
                         <div class="col-md-1 text-center">
                           <strong>Proposals</strong>
                        </div>
                        <div class="col-md-2 text-center">
                          <strong>Meetings</strong><br>
                          <Small> Booked (Attended)</Small>
                          </div>
                          <div class="col-md-2 text-center"> 
                           <strong>Call Activity</strong><br>
                           <Small> Total Calls (Intro)</Small>
                        </div>
                        <div class="col-md-1 text-center">
                           <strong>Pipeline Added</strong>
                        </div>
                        <div class="col-md-2 text-center"> 
                           <strong>Review Months</strong><br>
                           <Small>Added / Occuring</Small>
                        </div>
                        <div class="col-md-1 text-center">
                           <strong>DueDil</strong>
                        </div>
                        </div>

                        <?php foreach ($getstatssearch as $getstatssearch): ?>
                          <div class="row list-group-item">
                            <div class="col-md-2"> 
                            <?php $user_icon = explode(",",$getstatssearch['image']); echo "<div class='circle' style='float: left;margin-top: -5px;margin-right: 10px;width: 35px;height: 35px;border-radius: 30px;font-size: 12px;line-height: 35px;text-align: center;font-weight: 700;background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>

                            </div>
                            <div class="col-md-1 text-center">
                            <a href = "?search=2&user=<?php echo $getstatssearch['user'];?>&period=week&start_date=<?php echo $_GET['start_date']?>&end_date=<?php echo $_GET['end_date']?>"><span class="badge" style="background-color:#00B285;"><?php echo $getstatssearch['deals'];?></a></span>
                            </div>
                            <div class="col-md-1 text-center"> 
                            <?php echo $getstatssearch['proposals'];?>
                            </div>
                            <div class="col-md-2 text-center">
                            <?php echo $getstatssearch['meetingbooked'];?> (<?php echo $getstatssearch['meetingcount'];?>)
                            </div>
                            <div class="col-md-2 text-center"> 
                            <?php echo $getstatssearch['salescall'];?>
                            (<?php echo $getstatssearch['introcall'];?>)
                            </div>
                            <div class="col-md-1 text-center">
                              <?php echo $getstatssearch['pipelinecount'];?>
                            </div>
                            <div class="col-md-2 text-center">
                              <?php echo $getstatssearch['key_review_added'];?> / <?php echo $getstatssearch['key_review_occuring'];?>
                            </div>
                            <div class="col-md-1 text-center">
                              <?php echo $getstatssearch['duediligence'];?>
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
          <h3 class="panel-title">Date Range Search</h3>
          </div>
          <div class="panel-body">
            <div class="clearfix"></div>

            <form class="form-inline" role="form">
            <div class="form-group col-md-4">
            <label for="start-date">Start Date:</label>
            <input type="text" class="form-control" id="start_date" data-date-format="DD-MM-YYYY" name="start_date" placeholder="" value="<?php echo  date('d-m-Y',strtotime($dates['start_date']));?>">
            </div>
            <div class="form-group col-md-4">
            <label for="end-date">End Date:</label>
            <input type="text" class="form-control" id="end_date" data-date-format="DD-MM-YYYY" name="end_date" placeholder="" value="<?php echo  date('d-m-Y',strtotime($dates['end_date']));?>">
            </div>
            <div class="form-group col-md-4">
            <input type="hidden" name="search" value="<?php if (isset($_GET['search'])){echo $_GET['search'];} else {echo "1";};?>">
            <?php if (isset($_GET['user'])) { ?>
             <input type="hidden" name="user" value="<?php echo $_GET['user'];?>"> <?php
             };?>
            <button type="submit" class="btn btn-success btn-block">Search</button>
            </div>
            </form>
          </div>
        </div><!--END PANEL-->

    </div>
    <div role="tabpanel" class="tab-pane" id="calls"><div class="panel panel-default">
              <div class="panel-heading">
              <h3 class="panel-title">My Calls & Meetings<span class="badge pull-right"><?php echo count($pending_actions); ?></span></h3>
              </div>
             
              <div class="panel-body no-padding">
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
                          <div class="row list-group-item <?php if( strtotime($action->planned_at) < strtotime('today')  ) { echo ' delayed';} ?> " style="font-size:12px;">
                            <div class="col-md-4"> 
                              <a href="<?php echo site_url();?>companies/company?id=<?php echo $action->company_id;?>"> <?php echo $action->company_name;?></a>
                              <?php if(!empty($action->first_name)) { $contact_details_for_calendar = urlencode('Meeting with '.$action->first_name.' '.$action->last_name).'%0A'.urlencode($action->email.' '.$action->phone).'%0D%0D';?>
                              <div style="clear:both"><?php echo $action->first_name.' '.$action->last_name;?></div>
                              <?php } else { $contact_details_for_calendar="";};?>
                            </div>
                            <div class="col-md-2">
                              <?php echo $action_types_array[$action->action_type_id]; ?>
                            </div>
                            <div class="col-md-2 text-center">
                            <?php echo date("H:i",strtotime($action->planned_at));?>
                              <strong><?php echo date("d/m/y",strtotime($action->planned_at));?></strong>
                              <div style="clear:both;"><small><a class="btn btn-default btn-xs add-to-calendar" href="http://www.google.com/calendar/event?action=TEMPLATE&text=<?php echo urlencode($action_types_array[$action->action_type_id].' | '.$action->company_name); ?>&dates=<?php echo date("Ymd\\THi00",strtotime($action->planned_at));?>/<?php echo date("Ymd\\THi00\\Z",strtotime($action->planned_at));?>&details=<?php echo $contact_details_for_calendar;?><?php echo urlencode('http://baselist.herokuapp.com/companies/company?id='.$action->company_id);?>%0D%0DAny changes made to this event are not updated in Baselist."target="_blank" rel="nofollow">Add to Calendar</a></small></div>
                            </div>
                            <div class="col-md-4" style="text-align:right;">
                              <?php $hidden = array('action_id' => $action->action_id , 'user_id' => $current_user['id'], 'action_do' => 'completed', 'outcome' => '' , 'company_id' => $action->company_id);
                               echo form_open(site_url().'actions/edit', 'name="completed_action"  class="completed_action" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action->action_id.'" style="display:inline-block;" role="form"',$hidden); ?>
                               <button class="btn btn-xs btn-success">Completed</button> 
                               </form>
                               <?php $hidden = array('action_id' => $action->action_id , 'user_id' => $current_user['id'] , 'action_do' => 'cancelled','outcome' => '' , 'company_id' => $action->company_id);
                               echo form_open(site_url().'actions/edit', 'name="cancel_action"  class="cancel_action" style="display:inline-block;" onsubmit="return validateActionForm(this)" outcome-box="action_outcome_box_'.$action->action_id.'" role="form"',$hidden); ?>
                               <button class="btn btn-xs btn-danger" >Cancel</button>
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
          </div><!--END OF PANEL--></div>
    <div role="tabpanel" class="tab-pane" id="pipeline">
      <div class="panel panel-default">
              <div class="panel-heading">
              <h3 class="panel-title">Pipeline</h3>
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
                            <div class="panel panel-default">
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
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinecontactedindividual['company_id'] ?>">
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelinecontactedindividual['company_name']); 
                            ?>
                            </a></div>
                           <small><?php echo $pipelinecontactedindividual['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
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
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelineproposalindividual['company_id'] ?>">
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelineproposalindividual['company_name']); 
                            ?>
                          </a></div>
                            <small><?php echo $pipelineproposalindividual['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->


              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
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
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinecustomerindividual['company_id'] ?>">
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelinecustomerindividual['company_name']); 
                            ?></a></div>
                            <small><?php echo $pipelinecustomerindividual['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
                  <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
                            <div class="panel-heading">
                            Lost <?php if (!isset($_GET['start_date'])) { echo"<small>(This Month)</small>";}?> <div class="pull-right"><span class="badge badge-warning"><?php echo count($pipelinelostindividual)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinelostindividual as $pipelinelostindividual): ?>
                                                     
                            <div class='col-md-12 pipeline-days overdue'><strong>Lost</strong></div>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinelostindividual['company_id'] ?>">
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelinelostindividual['company_name']); 
                            ?></a></div>
                           <small><?php echo $pipelinelostindividual['username'] ?></small>
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
                            <div class="panel panel-default">
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
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinecontacted['company_id'] ?>">
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelinecontacted['company_name']); 
                            ?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinecontacted['pipeline']); ?>"><?php echo $pipelinecontacted['pipeline'] ?></span> <small><?php echo $pipelinecontacted['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
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
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelineproposal['company_id'] ?>">
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelineproposal['company_name']); 
                            ?>
                            </a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelineproposal['pipeline']); ?>"><?php echo $pipelineproposal['pipeline'] ?></span> <small><?php echo $pipelineproposal['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->


              <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
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
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinecustomer['company_id'] ?>">
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelinecustomer['company_name']); 
                            ?></a></div>
                            <span class="label pipeline-label label-<?php echo str_replace(' ', '', $pipelinecustomer['pipeline']); ?>"><?php echo $pipelinecustomer['pipeline'] ?></span> <small><?php echo $pipelinecustomer['username'] ?></small>
                            </div>
                            </div>
                          <?php endforeach ?>
                            </div>
                            </div><!--END PANEL-->
              </div><!--END COL-MD-3-->
                  <div class="col-md-3 pipeline-holder ">
                            <div class="panel panel-default">
                            <div class="panel-heading">
                            Lost <?php if (!isset($_GET['start_date'])) { echo"<small>(This Month)</small>";}?> <div class="pull-right"><span class="badge badge-warning"><?php echo count($pipelinelost)?></span></div>
                            </div>
                            <div class="panel-body" style="padding:0; background-color:#DDDDDD;">
                            <?php foreach ($pipelinelost as $pipelinelost): ?>
                                                     
                            <div class='col-md-12 pipeline-days overdue'><strong>Lost</strong></div>
                            <div class="col-md-12 pipeline-bottom">
                            <div style="font-size=16px; font-weight:600;"><a href="companies/company?id=<?php echo $pipelinelost['company_id'] ?>">
                            
                            <?php 
                            $words = array( ' Limited', ' LIMITED', ' LTD',' ltd',' Ltd' );
                            echo str_replace($words, ' ',$pipelinelost['company_name']); 
                            ?>
                            </a></div>
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
          </div><!--END PANEL-->

    </div>
  </div>

</div>
</div>
</div>


<div class="col-lg-12">
    <?php if ($_GET['search']==2) { ?>
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
                           <strong>Call Activity</strong><div class="pull-right"><span class="badge badge-warning"><?php echo count($getuserpitches)?></span></div>
                        </div>
                        </div>
                          <div class="row list-group-item">
                            
                            <div class="col-md-3">
                             <?php foreach ($getuserplacements as $get_user_placements): ?>
                            <li class="user-stat-holder">
                            <div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_placements['id'] ?>"><?php echo $get_user_placements['name'];?></a></div>
                            <div class="user-stat company action_date" style="margin-bottom:5px;">
                            <?php echo  date('D jS M y',strtotime($get_user_placements['actioned_at']));?></div>
                             <span class="label pipeline-label label-success"><?php echo $get_user_placements['username'];?></span>
                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3"> 

                            <?php foreach ($getuserproposals as $get_user_proposals): ?>
                            <li class="user-stat-holder">
                            <div class="user-stat company"><div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_proposals['id'] ?>" ><?php echo $get_user_proposals['name'];?></a></div>
                            <div class="user-stat company action_date">
                            <?php echo  date('D jS M y',strtotime($get_user_proposals['created_at']));?></div>
                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3">
                            <?php foreach ($getusermeetings as $get_user_meetings): ?>
                              <li class="user-stat-holder">
                            <div class="user-stat company <?php if ($get_user_meetings['meeting_actioned'] > '0'): ?>actioned<?php endif; ?>"><a href="companies/company?id=<?php echo $get_user_meetings['id'] ?>" ><?php echo $get_user_meetings['name'];?></a></div>
                            <div class="user-stat company action_date">
                            <?php echo  date('D jS M y',strtotime($get_user_meetings['created_at']));?></div>
                            </li>
                            <?php endforeach ?>
                            </div>
                            <div class="col-md-3"> 
                            <?php foreach ($getuserpitches as $get_user_pitches): ?>

                              <li class="user-stat-holder">
                            <div class="user-stat company"><a href="companies/company?id=<?php echo $get_user_pitches['id'] ?>"  ><?php echo $get_user_pitches['name'];?></a></div>
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
              
          
          



          
          
          
      </div>
  
