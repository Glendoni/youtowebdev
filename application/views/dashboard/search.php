    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Search
                </div>
                <div class="panel-body">
                    <?php echo form_open('/companies', 'id="main_search" name="main_search" class="" role="form"'); ?>
                    <div class='form-row'>
                        <div class="col-md-12 form-group ">
                            <?php  echo form_label('Agency Name', 'agency_name', array('class'=>'control-label')); ?>
                            <?php echo form_input(array('name' => 'agency_name', 'id' => 'agency_name', 'maxlength' => '50','class'=>'col-md-12 form-control'), set_value('agency_name',''));?>

                        </div>
                    </div>
                    <div class='form-row'>
                     <div class="col-md-6 form-group"> 
                        <?php  echo form_label('Turnover', 'turnover_from', array('class'=>'control-label')); ?>
                        <div class="input-group "> 
                        <div class="input-group-addon">From</div>
                        <?php echo form_input(array('name' => 'turnover_from', 'id' => 'turnover_from', 'maxlength' => '100','class'=>'form-control'), set_value('turnover_from',''));?>
                        </div>
                    </div>
                    <div class="col-md-6 form-group"> 
                        <?php  echo form_label(' _', 'turnover_to', array('class'=>'control-label','style'=>'color:white;')); ?>
                        <div class="input-group" style='margin-left:5px;'> 
                        <div class="input-group-addon">To</div>
                        <?php echo form_input(array('name' => 'turnover_to', 'id' => 'turnover_to', 'maxlength' => '100','class'=>'form-control'), set_value('turnover_to',''));?>
                        </div>
                    </div>
                    </div>

                    <div class='form-row'>
                     <div class="col-md-6 form-group"> 
                        <?php  echo form_label('Employees', 'employees_from', array('class'=>'control-label')); ?>
                        <div class="input-group "> 
                        <div class="input-group-addon">From</div>
                        <?php echo form_input(array('name' => 'employees_from', 'id' => 'employees_from', 'maxlength' => '100','class'=>'form-control'), set_value('employees_from',''));?>
                        </div>
                    </div>
                    <div class="col-md-6 form-group"> 
                        <?php  echo form_label(' _', 'employees_to', array('class'=>'control-label','style'=>'color:white;')); ?>
                        <div class="input-group" style='margin-left:5px;'> 
                        <div class="input-group-addon">To</div>
                        <?php echo form_input(array('name' => 'employees_to', 'id' => 'employees_to', 'maxlength' => '100','class'=>'form-control'), set_value('employees_to',''));?>
                        </div>
                    </div>
                    </div>

                    <div class='form-row'>
                     <div class="col-md-6 form-group"> 
                        <?php  echo form_label('Company age', 'company_age_from', array('class'=>'control-label')); ?>
                        <div class="input-group "> 
                        <div class="input-group-addon">From</div>
                        <?php echo form_input(array('name' => 'company_age_from', 'id' => 'company_age_from', 'maxlength' => '100','class'=>'form-control'), set_value('company_age_from',''));?>
                        </div>
                    </div>
                    <div class="col-md-6 form-group"> 
                        <?php  echo form_label(' _', 'company_age_to', array('class'=>'control-label','style'=>'color:white;')); ?>
                        <div class="input-group" style='margin-left:5px;'> 
                        <div class="input-group-addon">To</div>
                        <?php echo form_input(array('name' => 'company_age_to', 'id' => 'company_age_to', 'maxlength' => '100','class'=>'form-control'), set_value('company_age_to',''));?>
                        </div>
                    </div>
                    </div>
                    <div class='form-row'>
                        <div class="col-md-12 form-group">
                        <?php 
                        echo form_label('Selectors', 'sectors');
                        echo form_multiselect('sectors[]', $sectors_options, $sectors_default,'class="form-control"');
                        ?>
                        </div>
                    </div>
                     <div class='form-row'>
                        <div class="col-md-12 form-group">
                        <?php
                        echo form_label('Current provider', 'providers');
                        echo form_dropdown('providers', $providers_options, $providers_default,'class="form-control"');
                        ?>
                     </div>
                    </div>

                    <div class='form-row'>
                     <div class="col-md-6 form-group"> 
                        <?php  echo form_label('Anniversary rage', 'mortgage_from', array('class'=>'control-label')); ?>
                        <div class="input-group "> 
                        <div class="input-group-addon">From</div>
                        <?php echo form_input(array('name' => 'mortgage_from', 'id' => 'mortgage_from', 'maxlength' => '100','class'=>'form-control'), set_value('mortgage_from',''));?>
                        </div>
                    </div>
                    <div class="col-md-6 form-group"> 
                        <?php  echo form_label(' _', 'mortgage_to', array('class'=>'control-label','style'=>'color:white;')); ?>
                        <div class="input-group" style='margin-left:5px;'> 
                        <div class="input-group-addon">To</div>
                        <?php echo form_input(array('name' => 'mortgage_to', 'id' => 'mortgage_to', 'maxlength' => '100','class'=>'form-control'), set_value('mortgage_to',''));?>
                        </div>
                    </div>
                    </div>

                    <?php echo form_submit('submit', 'Submit', 'class="btn btn-primary btn-block"');?>
                <?php echo form_close(); ?>
                    
                </div>
                <div class="panel-footer">
                    <?php if (validation_errors()): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>