<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="apple-touch-icon-precomposed" sizes="180x180" href="<?php echo asset_url();?>images/apple-icon.png" />

    <title><?php echo (isset($page_title))? $page_title: 'Baselist'; ?></title>
    
    <?php if (ENVIRONMENT  =='staging'){?>
    <link rel="icon" type="image/png" href="<?php echo asset_url();?>images/favicon-staging.jpg">

    <?php
} else {?>

    <link rel="icon" type="image/png" href="<?php echo asset_url();?>images/favicon.jpg">
<?php
}; ?>

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
<!--<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">-->

<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
<!-- Brand and toggle get grouped for better mobile display -->
<!--<div class="navbar-header">-->
<div class="col-sm-3 col-md-3">
<a class="navbar-brand" href="/" ><img src="<?php echo asset_url();?>images/baselist-logotype-black-transparent-bg.png" style="width:120px;">
<?php if (isset($current_user)): ?>
<div style="font-size: 10px;font-weight: 300;text-align: right;float: right;line-height: 40px;padding-left: 5px;">Version 2.18</div>
<?php endif; ?>
</a>
</div>


            <div class="col-sm-3 col-sm-push-6">
            <!-- Top Menu Items -->
            <?php if (isset($current_user)): ?>

            <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
               <a href="#" class="dropdown-toggle user-profile" data-toggle="dropdown">

                    <?php $user_icon = explode(",", ($current_user['image'])); echo "<div class='circle' style='float: left;margin-top: 0px;margin-right: 10px;width: 20px;height: 20px;border-radius: 15px;font-size: 8px;line-height: 20px;text-align: center;font-weight: 700;background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$user_icon[0]."</div>";?>
                    <?php echo $current_user['name'] ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo site_url(); ?>users/profile"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <!-- <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li> -->
                        <li>
                            <a href="<?php echo site_url(); ?>users/settings"><i class="fa fa-fw fa-envelope"></i> Email Settings</a>
                        </li>
                        <li>
                            <a href="https://status.heroku.com/" target="_blank"><i class="fa fa-fw fa-tasks"></i> Hosting Status</a>
                        </li>
                        <li class="divider"></li>
                        <?php if ($current_user['permission'] == 'admin'): ?>
                <li>
                    <a href="<?php echo base_url(); ?>companies/create_company" ><i class="fa fa-plus-circle"></i> add company</a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>email_templates/" ><i class="fa fa-envelope"></i> email templates</a>
                </li>
                <li class="divider"></li>
                <?php endif; ?>
                        <li>
                            <a href="<?php echo site_url(); ?>login/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php endif; ?>

            </div>



<?php if (isset($current_user)): ?>
<!--TOP SEARCH BAR-->
<?php if (isset($_GET['id'])) { 
$company = $companies[0];
$search_default = $company['name'];
} else {
$search_default = $this->input->post('agency_name');
}?>

    <div class="col-sm-6 col-md-6 col-sm-pull-3 large-form-holder clearfix">
            <div class="" id="adv-search">
             <?php echo form_open(site_url().'companies', 'id="main_search" novalidate="novalidate" name="main_search" class="" role="form"'); ?>
                <?php echo form_hidden('main_search','1');?>
                                    


                    <input name="agency_name" id="agency_name" type="text" onkeyup="ajaxSearch();" class="form-control large-search-height large-search" autocomplete="off" value="<?php echo trim($search_default);?>" placeholder="Search Baselist">
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
                        
                    <input type="submit" class="loading-btn btn btn-warning " value="Go" name="submit" style="width: 100%;">
                        <?php if (validation_errors()): ?>
                        <div class="alert alert-danger" role="alert">
                        <?php echo validation_errors(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
<?php if (isset($_POST['main_search'])): ?>
                                    <div class='form-row'>
                                        <div class="col-md-12 form-group ">
                                            <a class="btn btn-block clear-fields" href="<?php echo site_url();?>">
                                                <span class="glyphicon glyphicon-remove"></span> Clear Search
                                            </a>
                                        </div>
                                    </div>
                                    <?php endif; ?>
            <?php if (!isset($_GET['id']) && (isset($_POST['main_search']) || (isset($_GET['search'])))) : ?>
                                <!--         <div class="col-md-12 no-padding" style="margin-top:20px;">
                                            <a class="btn btn-block clear-fields" href="<?php echo site_url();?>">
                                                <span class="glyphicon glyphicon-remove"></span> Clear fields
                                            </a>
                                        </div> -->
                                    <?php endif; ?>
                    <div id="credits" class="well hidden advanced-search">
                            <div class="form-row" style="margin-bottom:50px;">
                                    <div class="col-xs-6 col-md-6 no-padding">
                                         <?php  echo form_label('Company Age (Months) ', 'company_age_from', array('class'=>'control-label')); ?>
                                         <div class="form-group" >
                                            <div class="col-xs-6 col-md-6 no-padding"> 
                                            <?php echo form_input(array('name' => 'company_age_from', 'id' => 'company_age_from', 'maxlength' => '100','class'=>'form-control','placeholder'=>'From'), set_value('company_age_from',$this->input->post('company_age_from')));?>
                                            </div>
                                            <div class="col-xs-6 col-md-6 no-padding">
                                            <?php echo form_input(array('name' => 'company_age_to', 'id' => 'company_age_to', 'maxlength' => '100','class'=>'form-control','placeholder'=>'To'), set_value('company_age_to',$this->input->post('company_age_to')));?>    
                                            </div>
                                        </div>
                                    </div>
                           
                                    <div class="col-xs-6 col-md-6 no-padding">
                                <?php  echo form_label('Turnover (£)', 'turnover_from', array('class'=>'control-label')); ?>
                                         <div class="form-group"> 
                                        <div class="col-xs-6 col-md-6 no-padding"> 
                                        <?php echo form_input(array('name' => 'turnover_from', 'id' => 'turnover_from', 'maxlength' => '100','class'=>'form-control number','placeholder'=>'From'), set_value('turnover_from',$this->input->post('turnover_from')));?>
                                        </div>
                                        <div class="col-xs-6 col-md-6 no-padding">
                                         <?php echo form_input(array('name' => 'turnover_to', 'id' => 'turnover_to', 'maxlength' => '100','class'=>'form-control number','placeholder'=>'To'), set_value('turnover_to',$this->input->post('turnover_to')));?>   
                                        </div>
                                    </div>
                                    </div>
                            </div><!--END FORM ROW-->



                                    <div class='form-row'>
                                        <div class="form-group">
                                            <div class="col-xs-6 col-md-6 no-padding"> 

                                        <?php
                                        echo form_label('Provider', 'providers');
                                        echo form_dropdown('providers', $providers_options, ($this->input->post('providers')?$this->input->post('providers'):$providers_default) ,'class="form-control"');
                                    
                                        ?>
                                            </div>
                                        </div>
                                    </div><!--END FORM ROW-->
                                    <div class='form-row'>
                                        <div class="form-group">
                                        <div class="col-xs-6 col-md-6 no-padding">
                                        <?php 
                                        echo form_label('Sectors', 'sectors');
                                        echo form_dropdown('sectors', $sectors_search, ($this->input->post('sectors')?$this->input->post('sectors'):$sectors_default),'class="form-control"');
                                        ?>
                                        </div>
                                        </div>
                                    </div><!--END FORM ROW-->
                                    <div class='form-row'>
                                        <div class="form-group">
                                            <?php
                                            echo form_label('Favourites', 'assigned');
                                            echo form_dropdown('assigned', $sales_users, ($this->input->post('assigned')?$this->input->post('assigned'):$assigned_default) ,'class="form-control"');
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
                                    <input type="submit" class="loading-btn btn btn-warning btn-block" value="Go" name="submit"  style="margin-top: 30px;">

</div>
</div><!--END ADVANCED SEARCH-->
</div>


            

<?php echo form_close(); ?>
<?php endif; ?>

           
        </nav>