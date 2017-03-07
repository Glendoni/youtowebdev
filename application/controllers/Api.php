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
    
}