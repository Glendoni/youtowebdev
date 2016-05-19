     <?php foreach ($lastmonthstats as $lastmonthstat): ?>
                          <div class="row list-group-item stats-row active-<?php echo $lastmonthstat['active'];?>">
                            <div class="col-xs-2 col-md-1">
                            <a href = "?search=2&user=<?php echo $lastmonthstat['user'];?>&period=lastmonth"> 
                            <?php $user_icon = explode(",",$lastmonthstat['image']); echo "<div class='circle name-circle' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
                            </a>
                            </div>
                            <div class="col-xs-2 col-md-1 text-center">
                            <a href = "?search=2&user=<?php echo $lastmonthstat['user'];?>&period=lastmonth"><span class="badge lm-deals" style="background-color:#428bca;"><?php echo $lastmonthstat['deals'];?></span></a>
                            </div>
                              <div class="col-xs-2 col-md-1 text-center"> 
                              <?php echo '<div class="badge lm-proposals" style="background-color:#45AE7C;">'.$lastmonthstat['proposals'].'</div>';?>
                              </div>
                              <div class="col-xs-2 col-md-2 text-center"> 
                            <span class="lm-demobookedcount"><?php echo $lastmonthstat['demobookedcount'];?></span> / <span class="lm-democount"><?php echo $lastmonthstat['democount'];?></span>
                            </div>
                            <div class="col-xs-1 col-md-1 text-center">
                            <span class="lm-meetingbooked"><?php echo $lastmonthstat['meetingbooked'];?></span> / <span class="lm-meetingcount"><?php echo $lastmonthstat['meetingcount'];?></span>
                            </div>
                            <div class="col-xs-2 col-md-2 text-center"> 
                            <span class="lm-salescall"><?php echo $lastmonthstat['salescall'];?></span> / <span class="lm-introcall"><?php echo $lastmonthstat['introcall'];?></span>
                            </div>
                            <div class="col-md-2 hidden-xs text-center">
                              <span class="lm-key_review_added"><?php echo $lastmonthstat['key_review_added'];?></span> / <span class="lm-key_review_occuring"><?php echo $lastmonthstat['key_review_occuring'];?></span>
                            </div>
                            <div class="col-md-1 hidden-xs text-center">
                              <span class="lm-duediligence"><?php echo $lastmonthstat['duediligence'];?></span>
                            </div>
                          </div> <!--END ROW-->    
                      <?php endforeach ?>