<?php
class Api extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        // this controller can only be called from the command line
        
        //ACCESS NEEDS TO BE GIVEN TO SERVER IP ADDRESS
    if (!$this->input->is_cli_request()) //show_error('Direct access is not allowed');
        
        $this->load->model('Api_model');
    }
    
    function index(){
     
    }
    
    function test_endpoint(){
           
      /* @@@@
        Your Hash: 764f427e0f687d987f6a0f5c5324cdbd
        Your String: baselistfusion
        @@@ */ 
       // 
        $res = array();
        $payload = json_decode(file_get_contents('php://input'), true);
        $headers = $_SERVER;
        $data = array(
                        'companyRegistration' => $payload['companyRegistration'], 
                        'sonovate3Id' => $payload['sonovate3Id'], 
                        'token' => $headers['HTTP_TOKEN']
                    );
        
         
        if($headers['HTTP_TOKEN'] === "764f427e0f687d987f6a0f5c5324cdbd"){
           $data_insert_res = $this->Api_model->logAgent($data); //save data
            if($data_insert_res){
             
                $res =  []; //return resonse '('.json_encode($data).')';
                
                header('Content-Type: application/json');
                echo $_GET['callback'] . json_encode($res);
            }else{
                
                header($_SERVER['SERVER_PROTOCOL'] . ' 401 Unauthorized', true, 401);
            }
           
        }else{
                header($_SERVER['SERVER_PROTOCOL'] . '500 Internal Server Error', true, 500);
        }
        
       
    }
    
    function get_company_placements()
    {
        $department = array('support', 'development');
        if($this->input->get('zd_id')) {
          $comp_reg_num = $this->input->get('comp_reg_num');
        } 
       $response =  $this->Api_model->get_placement_data($comp_reg_num);
       echo  $response;
       
    }
    
function testerbearer(){
        
$curl = curl_init();

curl_setopt_array($curl, array(
  //CURLOPT_URL => "https://invoicing-api-dev.sonovate.com/api/agencyStats/?companyRegNumber=10259659",
    
   CURLOPT_URL=> "https://members.sonovate.com/api/agencyStats/?companyRegNumber=09528980",
   CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "authorization: Basic YmFzZWxpc3Q6ck5tbGdNYUE4bnBPV1dNcWR1Nk0xMlVaN0RNaEF6X0lnSFQyRnNyNXFYcGlFSkVpVk5uOHhZSUlFQjlmOUJaTms4SHBaYlVZSGpUYVJXOEVrRU4yTk1CZEFBQQ==",
            "cache-control: no-cache"
          ),
        ));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
        
        
    }
    
    function testerbasic(){
        
$curl = curl_init();

curl_setopt_array($curl, array(
  //CURLOPT_URL => "https://invoicing-api-dev.sonovate.com/api/agencyStats/?companyRegNumber=10259659",
    
   CURLOPT_URL=> "https://members.sonovate.com/api/agencyStats/?companyRegNumber=09528980",
   CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer YmFzZWxpc3Q6ck5tbGdNYUE4bnBPV1dNcWR1Nk0xMlVaN0RNaEF6X0lnSFQyRnNyNXFYcGlFSkVpVk5uOHhZSUlFQjlmOUJaTms4SHBaYlVZSGpUYVJXOEVrRU4yTk1CZEFBQQ==",
            "cache-control: no-cache"
          ),
        ));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
        
        
    }
    
function testerstaging(){
        
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://invoicing-api-dev.sonovate.com/api/agencyStats/?companyRegNumber=10259659",
    CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "authorization: Basic YmFzZWxpc3Q6ck5tbGdNYUE4bnBPV1dNcWR1Nk0xMlVaN0RNaEF6X0lnSFQyRnNyNXFYcGlFSkVpVk5uOHhZSUlFQjlmOUJaTms4SHBaYlVZSGpUYVJXOEVrRU4yTk1CZEFBQQ==",
            "cache-control: no-cache"
          ),
        ));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
        
        
    }
    
}