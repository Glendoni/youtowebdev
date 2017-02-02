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
     
        print_r($_SERVER);
        
        
        foreach($_SERVER as $item => $value){
            
            echo $item .' '.$value.'<br>';
        }
    }
    
    function test_endpoint(){
           
      /* @@@@
        Your Hash: 764f427e0f687d987f6a0f5c5324cdbd
        Your String: baselistfusion
        @@@ */ 
       // 
        $res = array();
        $headers = $_SERVER;
        $data = array(
                        'companyRegistration' => $headers['HTTP_COMPANYREGISTRATION'], 
                        'sonovate3Id' => $headers['HTTP_SONOVATE3ID'], 
                        'token' => $headers['HTTP_TOKEN']
                    );
        
        
        // print_r($_SERVER);
        
        
        //foreach($_SERVER as $item => $value){
            
           // echo $item .' '.$value.'<br>';
        //}
        
         //print_r($headers);
        if($headers['HTTP_TOKEN'] === "764f427e0f687d987f6a0f5c5324cdbd"){
           $data_insert_res = $this->Api_model->logAgent($data); //save data
            if($data_insert_res){
             $res =  $_GET['callback'] . json_encode($data); //return resonse '('.json_encode($data).')';
            }else{
                
                $res = 'Sorry something went wrong!' ;
            }
           
        }else{
            $res = 'Cannot connect to Baselist';
        }
        echo $res;
        
    }
    
}