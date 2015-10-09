<?php
class Cron extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        // this controller can only be called from the command line
        //if (!$this->input->is_cli_request()) show_error('Direct access is not allowed');
        $this->load->helper('date');
        $this->load->model('Cron_model');
    $this->Cron_model->connect_to_wordpress_database();


    }
 
    function update_marketing_clicks()
    {
        $this->Cron_model->update_marketing_clicks();
    }
        function daily_data_clean_up()
    {
        $this->Cron_model->prospects_not_in_sector();
    }
            function remove_contacts_from_marketing($con)
    {
        $this->Cron_model->remove_contacts_from_marketing();
    }
    

}