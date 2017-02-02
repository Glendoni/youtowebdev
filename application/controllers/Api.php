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
        
        $headers = apache_request_headers();
         print_r($headers);
        if($headers['token'] === "764f427e0f687d987f6a0f5c5324cdbd"){
            $data = array('companyRegistration' => $headers['companyRegistration'], 'sonovate3Id' => $headers['sonovate3Id'], 'token' => $headers['token']);
            $res = $_GET['callback'] . '('.json_encode($data).')';
            $this->Api_model->logAgent($data);
        }else{
            $res =  'Cannot connect to Baselist';
        }
        
        
        echo $res;
        
        
    }
    
    }