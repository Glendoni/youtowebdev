<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Baselist</title>

    <!-- Bootstrap Core CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo asset_url();?>css/sb-admin-2.css" rel="stylesheet">
    <link href="<?php echo asset_url();?>css/style.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo asset_url();?>css/plugins/timeline.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo asset_url();?>css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.5.1.css">

    <!-- Custom Fonts -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- BTN animation -->
    <link href="<?php echo asset_url();?>css/ladda.min.css" rel="stylesheet">

    <!-- PAGE LOADING BAR 
    <link href="<?php echo asset_url();?>css/pace.css" rel="stylesheet">-->

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
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Baselist</a>
            </div>
            <!-- Top Menu Items -->
            <?php if (isset($current_user)): ?>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
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
                </li>
                <li class="dropdown">
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
                    <!-- /.dropdown-tasks -->
                </li>
                   <!-- /.dropdown -->
                <li class="dropdown">
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
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
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
                    <!-- /.dropdown-alerts -->
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $current_user['name'] ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="login/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php endif; ?>

            <?php if(!isset($hide_side_nav)): ?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!-- <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                        </li> -->
                        <li>
                            <a class="active" href="<?php echo site_url();?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
            
                        <!-- <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    
                                </li>
                            </ul>
                          
                        </li> -->
                        <li>
                            <a href="#"><i class="fa fa-search fa-fw"></i> Search<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="alert alert-warning alert-dismissible" style="display:none;" id="empty_form_error" role="alert">
                                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                              <strong>Warning!</strong> Please enter a value
                                            </div>
                                            <?php echo form_open('/companies', 'id="main_search" novalidate="novalidate" name="main_search" class="" role="form"'); ?>
                                            <?php echo form_hidden('main_search','1');?>
                                            <?php if ($_POST['main_search']): ?>
                                                <a class="btn btn-link pull-right" href="<?php echo site_url();?>">
                                                    <span class="glyphicon glyphicon-remove"></span> Clear fields
                                                </a>
                                            <?php endif; ?>
                                            <div class='form-row'>
                                                <div class="col-md-12 form-group ">
                                                    <?php  echo form_label('Agency Name', 'agency_name', array('class'=>'control-label')); ?>
                                                    <?php echo form_input(array('name' => 'agency_name', 'id' => 'agency_name', 'maxlength' => '50','class'=>'col-md-12 form-control'), set_value('agency_name',''));?>

                                                </div>
                                            </div>
                                             <div class='form-row'>
                                             <div class="col-md-6 form-group"> 
                                                <?php  echo form_label('Age ', 'company_age_from', array('class'=>'control-label')); ?>
                                                <div class="input-group "> 
                                                <!-- <div class="input-group-addon">From</div> -->
                                                <?php echo form_input(array('name' => 'company_age_from', 'id' => 'company_age_from', 'maxlength' => '100','class'=>'form-control','placeholder'=>'from year'), set_value('company_age_from',''));?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group"> 
                                                <?php  echo form_label(' _', 'company_age_to', array('class'=>'control-label','style'=>'color:white;')); ?>
                                                <div class="input-group" style='margin-left:5px;'> 
                                                <!-- <div class="input-group-addon">To</div> -->
                                                <?php echo form_input(array('name' => 'company_age_to', 'id' => 'company_age_to', 'maxlength' => '100','class'=>'form-control','placeholder'=>'to year'), set_value('company_age_to',''));?>
                                                </div>
                                            </div>
                                            </div>

                                            <div class='form-row'>
                                             <div class="col-md-6 form-group"> 
                                                <?php  echo form_label('Turnover (£)', 'turnover_from', array('class'=>'control-label')); ?>
                                                <div class="input-group "> 
                                                <!-- <div class="input-group-addon">From</div> -->
                                                <?php echo form_input(array('name' => 'turnover_from', 'id' => 'turnover_from', 'maxlength' => '100','class'=>'form-control','placeholder'=>'0'), set_value('turnover_from',''));?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group"> 
                                                <?php  echo form_label(' _', 'turnover_to', array('class'=>'control-label','style'=>'color:white;')); ?>
                                                <div class="input-group" style='margin-left:5px;'> 
                                                <!-- <div class="input-group-addon">To</div> -->
                                                <?php echo form_input(array('name' => 'turnover_to', 'id' => 'turnover_to', 'maxlength' => '100','class'=>'form-control','placeholder'=>'10000'), set_value('turnover_to',''));?>
                                                </div>
                                            </div>
                                            </div>

                                                                                      
                                            
                                             <div class='form-row'>
                                                <div class="col-md-12 form-group">
                                                <?php
                                                echo form_label('Mortgage provider', 'providers');
                                                echo form_dropdown('providers', $providers_options, $providers_default,'class="form-control"');
                                                ?>
                                             </div>
                                            </div>

                                            <div class='form-row'>
                                             <div class="col-md-6 form-group"> 
                                                <?php  echo form_label('Anniversary', 'mortgage_from', array('class'=>'control-label')); ?>
                                                <div class="input-group "> 
                                                <!-- <div class="input-group-addon">From</div> -->
                                                <?php echo form_input(array('name' => 'mortgage_from', 'id' => 'mortgage_from', 'maxlength' => '100','class'=>'form-control','placeholder'=>'0'), set_value('mortgage_from',''));?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group"> 
                                                <?php  echo form_label(' _', 'mortgage_to', array('class'=>'control-label','style'=>'color:white;')); ?>
                                                <div class="input-group" style='margin-left:5px;'> 
                                                <!-- <div class="input-group-addon">To</div> -->
                                                <?php echo form_input(array('name' => 'mortgage_to', 'id' => 'mortgage_to', 'maxlength' => '100','class'=>'form-control','placeholder'=>'100'), set_value('mortgage_to',''));?>
                                                </div>
                                            </div>
                                            </div>
                                            <div class='form-row'>
                                                <div class="col-md-12 form-group">
                                                <?php 
                                                echo form_label('Sectors', 'sectors');
                                                echo form_multiselect('sectors[]', $sectors_options, $sectors_default,'class="form-control"');
                                                ?>
                                                </div>
                                            </div>
                                            <div class='form-row'>
                                             <div class="col-md-6 form-group"> 
                                                <?php  echo form_label('Employees ', 'employees_from', array('class'=>'control-label')); ?>
                                                <div class="input-group "> 
                                                <!-- <div class="input-group-addon">From</div> -->
                                                <?php echo form_input(array('name' => 'employees_from', 'id' => 'employees_from', 'maxlength' => '100','class'=>'form-control','placeholder'=>'0'), set_value('employees_from',''));?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group"> 
                                                <?php  echo form_label(' _', 'employees_to', array('class'=>'control-label','style'=>'color:white;')); ?>
                                                <div class="input-group" style='margin-left:5px;'> 
                                                <!-- <div class="input-group-addon">To</div> -->
                                                <?php echo form_input(array('name' => 'employees_to', 'id' => 'employees_to', 'maxlength' => '100','class'=>'form-control','placeholder'=>'100'), set_value('employees_to',''));?>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <input type="submit" class="loading-btn btn btn-primary btn-block " value="Search" name="submit">
                                            <?php if (validation_errors()): ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo validation_errors(); ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php if($search_results_in_session = $this->session->userdata('companies')): ?>
                        <li>
                            <a class="" href="<?php echo site_url();?>companies/refreshsearch"><i class="fa fa-refresh"></i> Refresh search</a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <a href="#"><i class="glyphicon glyphicon-floppy-saved"></i> Saved searches <span class="badge"><?php echo count($own_campaigns); ?></span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                            <?php foreach ($own_campaigns as $campaign):?>
                                <li><a href="<?php echo site_url();?>campaigns/display/?id=<?php echo $campaign->id; ?>"><?php echo $campaign->name; ?></a></li>
                            <?php endforeach; ?>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-globe"></span> Shared searches <span class="badge"><?php echo count($shared_campaigns); ?></span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                            <?php foreach ($shared_campaigns as $campaign):?>
                                <li><a href="<?php echo site_url();?>campaigns/display/?id=<?php echo $campaign->id; ?>"><?php echo $campaign->name; ?></a></li>
                            <?php endforeach; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            
            <!-- /.navbar-collapse -->
            <?php endif; ?>
        </nav>

        <div id="page-wrapper">
            <div class="container-fluid">
            <?php $msg = $this->session->flashdata('message'); if($msg): ?>
                <div class="alert alert-<?php echo $this->session->flashdata('message_type'); ?> alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?php echo $msg ?>
                </div>
            <?php endif; ?>