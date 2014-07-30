<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Search</h4>
                </div>
                <div class="panel-body">
                    <?php
                    echo form_open('/companies', 'id="main_search" name="main_search"');

                    echo form_label_open('Agency Name', 'agency_name', FALSE);
                    echo form_input(array('name' => 'agency_name', 'id' => 'agency_name', 'maxlength' => '50'), set_value('agency_name',''));
                    echo form_label_close();
            
                            
                    echo form_label_open('Turnover From', 'turnover_from', FALSE);
                    echo form_input(array('name' => 'turnover_from', 'id' => 'turnover_from', 'maxlength' => '100'), set_value('turnover_from','0'));
                    echo form_label_close();

                    echo form_label_open('Turnover To', 'turnover_to', FALSE);
                    echo form_input(array('name' => 'turnover_to', 'id' => 'turnover_to', 'maxlength' => '10'), set_value('turnover_to','0'));
                    echo form_label_close();
                    
                    echo form_label_open('Employees from', 'employees_from', FALSE);
                    echo form_input(array('name' => 'employees_from', 'id' => 'employees_from', 'maxlength' => '100'), set_value('employees_from','0'));
                    echo form_label_close();

                    echo form_label_open('Employees to', 'employees_to', FALSE);
                    echo form_input(array('name' => 'employees_to', 'id' => 'employees_to', 'maxlength' => '100'), set_value('employees_to','0'));
                    echo form_label_close();

                    echo form_label_open('Company age from', 'company_age_from', FALSE);
                    echo form_input(array('name' => 'company_age_from', 'id' => 'company_age_from', 'maxlength' => '100'), set_value('company_age_from',''));
                    echo form_label_close();

                    echo form_label_open('Company age to', 'company_age_to', FALSE);
                    echo form_input(array('name' => 'company_age_to', 'id' => 'company_age_to', 'maxlength' => '100'), set_value('company_age_to',''));
                    echo form_label_close();

                    echo form_label_open('Selectors', 'sectors', FALSE);
                    echo form_multiselect('sectors[]', $sectors_options, $sectors_default);
                    echo form_label_close();

                    echo form_label_open('Current provider', 'providers', FALSE);
                    echo form_dropdown('providers', $providers_options, $providers_default);
                    echo form_label_close();

                    echo form_label_open('Anniversary Rage from ', 'mortgage_from', FALSE);
                    echo form_input(array('name' => 'mortgage_from', 'id' => 'mortgage_from', 'maxlength' => '100'), set_value('mortgage_from',''));
                    echo form_label_close();

                    echo form_label_open('Anniversary Rage to', 'mortgage_to', FALSE);
                    echo form_input(array('name' => 'mortgage_to', 'id' => 'mortgage_to', 'maxlength' => '100'), set_value('mortgage_to',''));
                    echo form_label_close();
                    
                    echo form_submit('submit', 'Submit', 'class="btn btn-primary"');
                ?>
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
</div>