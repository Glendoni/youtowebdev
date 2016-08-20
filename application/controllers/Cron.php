<?php
class Cron extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        // this controller can only be called from the command line
        
        //ACCESS NEEDS TO BE GIVEN TO SERVER IP ADDRESS
    if (!$this->input->is_cli_request()) //show_error('Direct access is not allowed');
       
        $this->load->helper('date');
        $this->load->model('Cron_model');
    }
 
    function update_marketing_clicks()
    {
        // $this->Cron_model->update_marketing_clicks();
    }
    
    function daily_data_clean_up()
    {
        $this->Cron_model->prospects_not_in_sector();
    }
    
    function remove_contacts_from_marketing($con)
    {
        $this->Cron_model->remove_contacts_from_marketing();
    }
    
    function remove_customer_contacts_from_marketing()
    {
        //$this->Cron_model->remove_customer_contacts_from_marketing();
    }

    function retrieve_segment_events()
    {
        $this->Cron_model->generate_segment_events();
    }
  function csvreader()
  {
    $this->Cron_model->csvreader();
  }

function turnoverEmployees(){
    
    
     $this->Cron_model->turnoverEmployees();
}  
    
function turnoverCompanies(){
    
    
     $this->Cron_model->turnoverCompanies();
}  
    
    

    //AUTOPILOT
     //This should maybe once or twice a day -  Checks and adds email campaign list to database from AP RUN first
    function create_email_campaign_listing() 
    {
      $this->Cron_model->create_email_campaign_listing();  
    }
    function update_email_events()  //Call this function every 5mins
    {
      $this->Cron_model->update_email_events();  
    }
    
    
    function pipelineCronChecker()  //Call this function every 5mins
    {
      $this->Cron_model->cronPipeline();  
    }
    
        function turnoverCompaniesWithoutTurnover(){
    
    
     $this->Cron_model->cronPipelineWithoutTurnover();
} 
    
    //CSV
     function ippone($lmt = 100 ,$oft= 0,$debug = false)
  {
    $this->Cron_model->ipp($lmt,$oft,$debug);
  }
       function ipptwo($lmt = 200 ,$oft= 100,$debug = false)
  {
    $this->Cron_model->ipp($lmt,$oft,$debug);
  }
       function ippthree($lmt = 300 ,$oft= 200,$debug = false)
  {
    $this->Cron_model->ipp($lmt,$oft,$debug);
  }
       function ippfour($lmt = 400 ,$oft= 300,$debug = false)
  {
    $this->Cron_model->ipp($lmt,$oft,$debug);
  }
       function ippfive($lmt = 500 ,$oft= 400,$debug = false)
  {
    $this->Cron_model->ipp($lmt,$oft,$debug);
  }
       function ippsix($lmt = 600 ,$oft= 500,$debug = false)
  {
    $this->Cron_model->ipp($lmt,$oft,$debug);
  }
         function ippseven($lmt = 700 ,$oft= 600,$debug = false)
  {
    $this->Cron_model->ipp($lmt,$oft,$debug);
  }
}