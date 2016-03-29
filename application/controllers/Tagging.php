<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tagging extends MY_Controller {
	public $userid;
    public $jqScript;
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
        $this->userid = $this->data['current_user']['id']; 
        
        $this->jqScript =  '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>' ;
        //$this->input->get('id')
        ///$this->input->post(),$this->data['current_user']['id']
		 $this->load->model('Tagging_model');
$this->load->helper('url');
        $this->load->library('form_validation');
	}
	
   function index()
{
      $call_taggin_js_file =    asset_url().'js/tagging.js';
   //echo file_exists(base_url().'assets/tagging.js');
       $this->data['test'] =   $call_taggin_js_file ;
       $this->data['jq'] = $this->jqScript;
       $this->data['so'] =  $this->Tagging_model->add_category();
       	$this->data['main_content'] = 'tagging/home';
		$this->load->view('layouts/default_layout', $this->data);	
       
}	
    
    //Add Categories
    public function categories($route =false)
    {
    
        if($this->input->post() != NULL){
            
            $this->form_validation->set_rules('name', 'Name', 'required');
            
            $rap = $this->input->post();
            header('Content-Type: application/json');
            $name = $this->input->post('name'); 
            $eff_from = $this->input->post('eff_from');
            $eff_to = $this->input->post('eff_to');
            
            $master_cat_id =  $this->input->post('masterID')?  $this->input->post('itemid') : ''; 
            
            $msg = false;
            $checkEffTo =true;
            
            if($route != 'addTag') {
            $checkName = $this->Tagging_model->checkCategoryName($name,$master_cat_id);
            }else{
                $checkName = $this->Tagging_model->checkTagName($name,$master_cat_id);
            }
            $checkEffFrom = $this->Tagging_model->check_if_date_in_past(date('Y-m-d',strtotime($this->input->post('eff_from'))));
            
            if($eff_to){
             $checkEffTo = $this->Tagging_model->check_if_date_in_past(date('Y-m-d',strtotime($this->input->post('eff_to'))));
            }
            
            //Codeignighter does not support pre date check validation
           
           
              if(!$name){
                 $msg['catName'] = 'This field is required!';
            } 
           
             if(!$this->input->post('eff_from')){
                    $msg['eff_from'] = 'This field is required!';
                }
            
            
                if(!$route){
                $msg['missing_action'] = $route;
            } 
            
            
            if($route != 'edit'){
                if(!$checkName){
                     $msg['catName'] = 'This name is already taken!';
                } 

                if(!$checkEffFrom){
                    $msg['eff_from'] = 'dates cannot be set in the past';
                }

                if(isset( $checkEffTo)){
                if(!$checkEffTo){
                    $msg['eff_to'] = 'dates cannot be set in the past';
                } }
                
            }
    
            if(!$msg ){
               
                if($route == 'create') { 
                    $this->Tagging_model->add_category($this->input->post(),$this->userid); 
                }
                if($route == 'edit') {
                    $this->Tagging_model->update_category($this->input->post(),$this->userid); 
                }
                 if($route == 'sub') {
                    $this->Tagging_model->create_sub($this->input->post(),$this->userid); 
                }
                 if($route == 'addTag') {
                    $this->Tagging_model->add_tag($this->input->post(),$this->userid); 
                }
                if($route == 'editTag') {
                    $this->Tagging_model->edit_tag($this->input->post(),$this->userid); 
                }
                
                 if($route == 'deleteTag') {
                    $this->Tagging_model->delete_tag($this->input->post(),$this->userid); 
                }
                
                
                
                
                    echo json_encode(array('success' =>$rap ));         
             }else{
                 echo json_encode(array('error' =>$msg )); 
             }
            
              exit();
		}
            
        
            $call_taggin_js_file =    asset_url().'js/tagging.js';
            //echo file_exists(base_url().'assets/tagging.js');
            $this->data['jq'] =  $this->jqScript;
            $this->data['test'] =   $call_taggin_js_file ;
            $post= array();
            $post['userID'] = $this->userid;
            if($route){
            //echo $this->Tagging_model->$route($post);
            }
            $this->data['main_content'] = 'tagging/categories';
            $this->load->view('layouts/default_layout', $this->data);  
        
    }
    
    
    public function update(){
        
        
        
        
    }
    
    public function tags($route,$post)
    {
        
        $post= array();
        $post['userID'] = $this->userid;
        
      //  print_r($this->post());
        
         $this->data['main_content'] = 'tagging/tags';
       $this->load->view('layouts/default_layout', $this->data); 
 //echo $this->Tagging_model->$route($post); 
    }
    
    public function contacts($post,$route)
    {
        $post= array();
        $post['userID'] = $this->userid;
        
 echo $this->Tagging_model->$route($post); 
    }
    
    
    

    
    
    public function distroy($id)
    {
       
            echo $this->Tagging_model->delete_tag($id); 
    }
    
    
    
    
    
    
    
    
    
 function test($id =false){
     //echo 'Glen';
    echo  $this->Tagging_model->show_category($id);
     
 }
    
    
    function gettags($id){
        
        //Get main tag listing
        echo  $this->Tagging_model->getEditTags($id); 
        
        
    }
    function showtags($id){
        
        
        echo  $this->Tagging_model->show_tag($id); 
        
        
    }
     function _test(){ //loads data
     
    echo  $this->Tagging_model->show_category();
     
 }

}