<?php
class Cron extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        // this controller can only be called from the command line
        if (!$this->input->is_cli_request()) show_error('Direct access is not allowed');
                $this->load->helper('date');

            $this->load->model('Cron_model');

    }
 
    function update_marketing_clicks()
    {
        $this->Cron_model->update_marketing_clicks();
    }
}