<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> <?php echo (isset($page_title))? $page_title: 'Baselist'; ?></title>
    
    <link rel="icon" type="image/png" href="<?php echo asset_url();?>images/favicon.jpg">
    

    <!-- Timeline CSS -->
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/plugins/timeline.css" rel="stylesheet"> -->

    <!-- MetisMenu CSS -->
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet"> -->


    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/bootstrap-datetimepicker.css">
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/bootstrap.min.css" rel="stylesheet"> 
    <!-- Bootstrap Core CSS -->
    <!-- <link href="<?php echo asset_url();?>css/font-awesome.min.css" rel="stylesheet"> -->
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/style.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/morris-5.1.css">

    <!-- BTN animation -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/ladda.min.css" rel="stylesheet">

    <!-- PAGE LOADING BAR -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url();?>css/pace.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"> -->


    <!-- Custom Fonts -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/" >Baselist <span style="font-size:12px; font-weight:300;">v2.00</span></a>
            </div>
            <!-- Top Menu Items -->
            <?php if (isset($current_user)): ?>
            <ul class="nav navbar-top-links navbar-right">
                <!-- <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo $current_user['name'] ?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo $current_user['name'] ?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo $current_user['name'] ?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li> -->
                <!-- <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                   
                </li> -->
                   <!-- /.dropdown -->
                 <!--<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li> 
                    </ul>
                    
                </li>-->
                <?php if ($current_user['permission'] == 'admin'): ?>
                <li>
                    <a href="<?php echo base_url(); ?>companies/create_company" ><i class="fa fa-plus-circle"></i> add company</a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>email_templates/" ><i class="fa fa-envelope"></i> email templates</a>
                </li>
                <?php endif; ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                    <?php $user_icon = explode(",", ($system_users_images[$current_user['id']])); echo "<div class='circle' style='float: left;margin-top: 0px;margin-right: 10px;width: 20px;height: 20px;border-radius: 15px;font-size: 8px;line-height: 20px;text-align: center;font-weight: 700;background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
                    <?php echo $current_user['name'] ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo site_url(); ?>users/profile"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <!-- <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li> -->
                        <li>
                            <a href="<?php echo site_url(); ?>users/settings"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo site_url(); ?>login/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php endif; ?>
            <!--TOP SEARCH BAR-->
            <?php if (isset($_GET['id'])) { 
                $company = $companies[0];
                $search_default = $company['name'];
                } else {
    $search_default = $this->input->post('agency_name');
}?>

    <div class="col-lg-7 col-lg-offset-3 col-md-7 col-md-offset-3 large-form-holder clearfix">
            <div class="input-group" id="adv-search">
             <?php echo form_open(site_url().'companies', 'id="main_search" novalidate="novalidate" name="main_search" class="" role="form"'); ?>
                                    <?php echo form_hidden('main_search','1');?>
                                    


                    <input name="agency_name" id="agency_name" type="text" onkeyup="ajaxSearch();" class="form-control large-search-height large-search" autocomplete="off" value="<?php echo $search_default;?>" placeholder="Search Baselist">
                    <div class="alert alert-warning alert-dismissible" style="display:none;" id="empty_form_error" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                    <strong>Warning!</strong> Please enter at least one search criteria.
                    </div>          
                      <div id="suggestions">
                      <div id="autoSuggestionsList"></div>
                      </div>
                       <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <div class="dropdown dropdown-lg ">
                            <button href="#credits" type="button" class="toggle btn btn-default dropdown-toggle large-search-height" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                        </div>
                        
                    <input type="submit" class="loading-btn btn btn-primary " value="Go" name="submit">
                        <?php if (validation_errors()): ?>
                        <div class="alert alert-danger" role="alert">
                        <?php echo validation_errors(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if (!isset($_GET['id']) && (isset($_POST['main_search']) || (isset($_GET['search'])))) : ?>
                                        <div class="col-md-12 no-padding" style="margin-top:20px;">
                                            <a class="btn btn-block clear-fields" href="<?php echo site_url();?>">
                                                <span class="glyphicon glyphicon-remove"></span> Clear fields
                                            </a>
                                        </div>
                                    <?php endif; ?>
            <div id="credits" class="well hidden advanced-search">
<div class="form-row" style="margin-bottom:50px;"> 
                                         <?php  echo form_label('Age (Months) ', 'company_age_from', array('class'=>'control-label')); ?>
                                         <div class="form-group" >
                                            <div class="col-xs-6 col-md-6 no-padding"> 
                                            <?php echo form_input(array('name' => 'company_age_from', 'id' => 'company_age_from', 'maxlength' => '100','class'=>'form-control','placeholder'=>'From'), set_value('company_age_from',$this->input->post('company_age_from')));?>
                                            </div>
                                            <div class="col-xs-6 col-md-6 no-padding">
                                            <?php echo form_input(array('name' => 'company_age_to', 'id' => 'company_age_to', 'maxlength' => '100','class'=>'form-control','placeholder'=>'To'), set_value('company_age_to',$this->input->post('company_age_to')));?>    
                                            </div>
                                        </div>
                                    </div><!--END FORM ROW-->
                                    <div class='form-row' style="margin-bottom:50px;"> 
                                    <?php  echo form_label('Turnover (£)', 'turnover_from', array('class'=>'control-label')); ?>
                                     <div class="form-group"> 
                                        <div class="col-xs-6 col-md-6 no-padding"> 
                                        <?php echo form_input(array('name' => 'turnover_from', 'id' => 'turnover_from', 'maxlength' => '100','class'=>'form-control number','placeholder'=>'From'), set_value('turnover_from',$this->input->post('turnover_from')));?>
                                        </div>
                                        <div class="col-xs-6 col-md-6 no-padding">
                                         <?php echo form_input(array('name' => 'turnover_to', 'id' => 'turnover_to', 'maxlength' => '100','class'=>'form-control number','placeholder'=>'To'), set_value('turnover_to',$this->input->post('turnover_to')));?>   
                                        </div>
                                    </div>
                                    </div><!--END FORM ROW-->

                                    <div class='form-row'>
                                        <div class="form-group">
                                        <?php
                                        echo form_label('Mortgage Provider', 'providers');
                                        echo form_dropdown('providers', $providers_options, ($this->input->post('providers')?$this->input->post('providers'):$providers_default) ,'class="form-control"');
                                    
                                        ?>
                                        
                                        </div>
                                    </div><!--END FORM ROW-->
                                    <div class='form-row'>
                                        <div class="form-group">
                                        <?php 
                                        echo form_label('Sectors', 'sectors');
                                        echo form_dropdown('sectors', $sectors_search, ($this->input->post('sectors')?$this->input->post('sectors'):$sectors_default),'class="form-control"');
                                        ?>
                                        </div>
                                    </div><!--END FORM ROW-->
                                    <div class='form-row'>
                                        <div class="form-group">
                                            <?php
                                            echo form_label('Assigned', 'assigned');
                                            echo form_dropdown('assigned', $system_users, ($this->input->post('assigned')?$this->input->post('assigned'):$assigned_default) ,'class="form-control"');
                                            ?>
                                         </div> 
                                    </div>
                                    <div class='form-row'>
                                        <div class="form-group">
                                            <?php

                                            echo form_label('Pipeline', 'pipeline');
                                                echo form_multiselect('pipeline[]', $pipeline_options,
                                                    ($this->input->post('pipeline')?$this->input->post('pipeline'):$pipeline_default),'class="form-control"');?>
                                         </div> 
                                    </div>
                                    <div class='form-row'>
                                        <div class="form-group">
                                            <?php
                                                echo form_label('Class', 'class');
                                                echo form_dropdown('class', $class_options, ($this->input->post('class')?$this->input->post('class'):$class_default) ,'class="form-control"');
                                                ?>         
                                         </div> 
                                    </div>
                                    
                                    <div class='form-row'>
                                        <div class="col-md-6 no-padding">
                                            <?php
                                            echo form_label('Contacted', 'contacted');
                                            echo form_dropdown('contacted', $exclude_options, ($this->input->post('contacted')?$this->input->post('contacted'):' ') ,'class="form-control include-exclude-drop"');
                                            ?>
                                         </div> 

                                         <div class="col-md-6 no-padding"> 
                                         <label>Last # days</label>
                                            <?php   
                                            echo form_input(array('name' => 'contacted_days', 'id' => 'contacted_days', 'maxlength' => '100','class'=>'form-control','placeholder'=>'','type'=>'number','min'=>'0'), set_value('contacted_days',$this->input->post('contacted_days')));?>
                                        
                                        </div>
                                    </div><!--END FORM ROW-->
                                    <div class="form-row" style="padding-top:50px;">
                                    <input type="submit" class="loading-btn btn btn-primary btn-block" value="Go" name="submit"  style="margin-top: 30px;">

</div>
</div><!--END ADVANCED SEARCH-->
</div>
<?php echo form_close(); ?>


           
        </nav>