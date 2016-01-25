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
        $marketing_events = $this->Marketing_model->autopilot_segment();
            
        print json_encode($marketing_events);
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
    
        
        $words = array( 'Limited', 'LIMITED', 'LTD','ltd','Ltd' );
        
        
        
          
        
        //echo trim($comp_name);
        header('Content-Type: application/json');
       $marketing_events = $this->Marketing_model->actions_performed($comp_name);
        
        echo json_encode($marketing_events);
    }
    
    public function olive(){
        
          
        
         $dbconn2 = pg_connect("host=localhost   dbname=baselist user=postgres password=postgres")
    or die('Could not connect: ' . pg_last_error());
        
        
        
        
        
        
        $dbconn = pg_connect("host=ec2-79-125-118-138.eu-west-1.compute.amazonaws.com port=5522 dbname=d7fvbgmrpjg4ba user=ucvie36u7gtubf password=p6lgogrt7mg89411qujnepsgfkf")
    or die('Could not connect: ' . pg_last_error());
        
        
       

// Performing SQL query
$query = "select DISTINCT  identifies.company,CONCAT(identifies.first_name,' ',identifies.last_name) as username, 
to_char(identifies.sent_at, 'DD/MM/YYYY') as Date ,send.event_text as sent, identifies.email,
 _open.event_text as opened, click.event_text as click, unsubscribe.event_text as opened, send.campaign
		From autopilot_baselist.identifies 
		LEFT JOIN  autopilot_baselist.tracks
		ON tracks.user_id  = identifies.user_id 
		LEFT JOIN  autopilot_baselist.send
		ON tracks.id  = send.id 
		LEFT JOIN  autopilot_baselist._open
		ON send.user_id = _open.user_id 
        LEFT JOIN  autopilot_baselist.click
		ON _open.user_id = click.user_id 
		LEFT JOIN  autopilot_baselist.unsubscribe
		ON _open.user_id = unsubscribe.user_id 
		WHERE identifies.sent_at >= '2016-01-20'  
        AND identifies.sent_at >= '2016-01-20' 
		AND  _open.campaign IS NOT null
        AND  identifies.company IS NOT null
          
      
    
        ";
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
 
            while ($row = pg_fetch_array($result)) 
            {

              $resultArray[] = $row; 
                 //echo  $row[0]." - ".$row[1]." - ".$row[2]." - ".$row[3]." - ".$row[4]." - ". $row[5]."<br>";
                
              array_push($resultArray,  $this->getuserdetails($row[0])).'<br>';
            } 
        echo  json_encode($resultArray);
        
    }
    
    
    public function getuserdetails($string){
        $this->load->helper('array');
       $query   =  $this->Companies_model->get_autocomplete($string);
        
        
     if($query->num_rows()){
       
        foreach ($query->result() as $row):
        return array('companyID' => $row->id);
         endforeach;
         }else{
         
                 
     }
   
    } 
    
    
}
