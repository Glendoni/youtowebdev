<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zendesk extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		// load database
        //$this->load->database();
        // load form validation library
        $this->load->library('form_validation');
        $this->load->model('Zendesk_model');
         $this->load->helper(array('form', 'url','zendeskv3'));
	}

    public function index()
    {
        // allow only Ajax request 
      
		//$this->data['full_container'] = True;
		//$this->load->view('layouts/default_layout', $this->data);
        
    }   
    function add_user_to_campaign_test(){
        //$post = $this->input->post(); 
      //     $output =  $this->Evergreen_model->add_new_user_to_evergreen_campaign($post);
    //  echo '<pre>'; print_r($post); echo '</pre>';
        //echo $post;  
         $response  = sonovate_zendesk(false, false,'get_all_tickets_regarding_a_specific_user');  
       echo $response;
    }
    
    
    
      function get_tickets(){
        $zd_id = $this->input->post('zd_id'); 
          //$zd_id = 3168131466;
           
      //     $output =  $this->Evergreen_model->add_new_user_to_evergreen_campaign($post);
    //  echo '<pre>'; print_r($post); echo '</pre>';
        //echo $post;   1434885626
         echo $response  = sonovate_zendesk($zd_id, false, false,'get_all_tickets_regarding_a_specific_user');  
         //echo json_encode($response);
          
          
          /*
          $response   =  json_decode($response);
         
          
          
          echo '<br><br>';
              foreach($response->tickets as $item => $value){
//echo $item->custom_fields;
                        foreach($value->custom_fields  as $key => $val){
 
                           echo $val->id.'<br>'; 
                            
                        };


}
          
      echo '<pre>'; print_r($response); echo '</pre>';
          
              
       */ 

          
          
          
          
    }
    
    function get_company_placements()
    {
        $department = array('support', 'development');
        if(in_array($this->data['current_user']['department'],$department ) && ( $this->input->post('zd_id'))) {
          $zd_id = $this->input->post('zd_id');
        }
         $response  = sonovate_zendesk($zd_id, false, false,'get_all_tickets_placements');  
        echo json_encode($response);
    }
 
    
    
    
    
    
    
    function _get_placement(){
        
        
        
       return array('Tester' => 'Glendon');
        
        
    } 
    
    
    
    
    
    
    
    
    
}