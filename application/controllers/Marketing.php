<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marketing extends MY_Controller {
	
    //public $DB1;
    
	function __construct() {
		parent::__construct();
        $this->load->model('Marketing_model');
		// Some models are already been loaded on MY_Controller
		// $DB1 = $this->load->database('autopilot',true);
	}
	
	public function index() 
	{
        
        $debug = true;
        
        if($debug){
        $obj =   $this->getCompanyHouseDetails("https://api2.autopilothq.com/v1/lists");
            echo  '<fieldset><legend>Get Lists</legend>';
            foreach($obj as $item  => $value){

                foreach($value as $item  => $value){
                    echo $value['list_id'] . '<br>';
                    echo $value['title'] . '<br><br>';
                }
            };
            echo  '</fieldset>'; 
        }
        
           if($debug){
                $obj =   $this->getCompanyHouseDetails("https://api2.autopilothq.com/v1/triggers");
                   echo  '<fieldset><legend>Get Triggers</legend>';

                foreach($obj as $item  => $value){
                    foreach($value as $item  => $value){

                        echo $value['trigger_id'] . '<br>'.
                             $value['journey'] . '<br>'.
                             $value['trigger_type'] . '<br><br>';

                    }
                };

                echo  '</fieldset>';
           }
        
        if($debug){
        $obj =   $this->getCompanyHouseDetails("https://api2.autopilothq.com/v1/account");
        echo  '<fieldset><legend>Get Account Holder  Info</legend>'. $obj['fullName']  . '<br>'. $obj['email']. '</fieldset>'; 
        
        }
        
        if($debug){
         $obj =   $this->getCompanyHouseDetails("https://api2.autopilothq.com/v1/account");
        echo  '<fieldset><legend>Get Account Holder  Info</legend>'. $obj['fullName']  . '<br>'. $obj['email']. '</fieldset>'; 
        
        }
        
        if($debug){
           $obj = $this->getCompanyHouseDetails("https://api2.autopilothq.com/v1/contact/person_8BDF812D-26B1-4031-8612-219766835EEF");
        
        echo  '<fieldset><legend>Get Contact on List</legend>';
        
       
        
        echo $obj['Name'].'<br>';
        
        echo $obj['lists'][0];
      

       echo  '</fieldset>'; 
    }
    
    
    $obj = $this->getCompanyHouseDetails("https://api2.autopilothq.com/v1/list/contactlist_Segment Contacts/contacts/");
   echo $obj? 'true' : 'false'; 
        
        var_dump($obj);
    }
    
    
    
    
    
    
    public function loaddata(){
      
        header('Content-Type: application/json');
    
         //print file_get_contents('application/cache/autopilot_segment_events');
        //$this->generate_segment_events();
        //echo $this->Marketing_model->autopilot_segment(); // $this->get_current_user_id()));
   echo json_encode($this->Actions_model->get_marketing_actions_two($this->get_current_user_id()));
         
    }
    
    
     public function getCompanyHouseDetails($url = 0) 
	{
 
            $server_output = array();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_GET, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = 'autopilotapikey: ff0941e036d54b7a8a1894bed15662fc';
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $server_output = curl_exec ($ch);
            $result  = json_decode($server_output, true);
             return  $result; 
            curl_close ($ch); 
     }
    
    public function autopilotActions($id){
        
        
       $comp_name =  $this->Companies_model->get_company_from_id($id);
    
        
        $words = array( 'Limited', 'LIMITED', 'LTD','ltd','Ltd', '\'' );
        
        
        
           $comp_name = str_replace($words, '', $comp_name );
        
        //echo trim($comp_name);
        header('Content-Type: application/json');
       //$marketing_events = $this->Marketing_model->actions_performed_new($comp_name);
        $marketing_events  = $this->Actions_model->get_actions_marketing($id);
        
        echo json_encode($marketing_events);
    }
    
    
   
    

    
    
}
