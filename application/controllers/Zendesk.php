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
    function add_user_to_campaign(){
        //$post = $this->input->post(); 
      //     $output =  $this->Evergreen_model->add_new_user_to_evergreen_campaign($post);
    //  echo '<pre>'; print_r($post); echo '</pre>';
        //echo $post;  
         $response  = sonovate_zendesk(false, false,'get_all_tickets_regarding_a_specific_user');  
       
    }
 
    
    function get_placement(){
        
        
        
       return array('Tester' => 'Glendon');
        
        
    } 
    
    
    
    
    
    
    
    
    
}