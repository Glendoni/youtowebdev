<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evergreen extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		// load database
        $this->load->database();
        // load form validation library
        $this->load->library('form_validation');
        $this->load->model('Evergreen_model');
	}

    public function index()
    {
        // allow only Ajax request 
        $this->data['main_content'] = 'evergreens/evergreen';
		$this->data['full_container'] = True;
		$this->load->view('layouts/default_layout', $this->data);
        
    }
    
     public function admin()
    {
        // allow only Ajax request    
     
        $this->data['main_content'] = 'evergreens/evergreen';
		$this->data['full_container'] = True;
		$this->load->view('layouts/default_layout', $this->data);
        
    }
    
    function updateTagCampaignRun()
    { //updates the campaign with 5 more 
        
        $user_id =  $this->get_current_user_id();
        
        
        $current_campaign_id =  $this->input->post('campid');
         $evergreenID =  $this->input->post('evergreen');
         
        
        
       // echo $user_id . ' - '.$current_campaign_id . ' - ' .$evergreenID;
      
        //echo json_encode(array('success' => $user_id));
        
        
        //echo  'Hlendn '.$evergreenID;
       echo  json_encode($this->Evergreen_model->updateTagCampaign($current_campaign_id,$user_id,$evergreenID));
        
    }
	   
    function getMyEvergreenCampaign()
    { //Gets the evergreen campaign 
         $user_id =  $this->get_current_user_id();
        echo json_encode($this->Evergreen_model->getMyEvergreenCampaign($user_id));
       
    }
    
    function campaigncountCheckerRun()
    {
        
        echo json_encode($this->Evergreen_model->campaigncountChecker());
        
    }
    
    
    function test(){
       
        $out  = $this->Evergreen_model->evergreenHeaderInfo(1,4);
            if(!$out[0]['remaining']){
                    echo 'YEss';
}
        
    }
    
    
    function testlimiter(){
        
 
        
        
    }
    
    
    
    
function read_evergreens(){

    
   $output =  $this->Evergreen_model->read_evergreens();
    
   // echo '<pre>'; print_r($output); echo '</pre>';
    
      echo  json_encode($output);

}
   
    
    
function get_evergreens(){

    
    
     $evergreen_id = $this->input->post('evergreen_id');
    
    $output =  $this->Evergreen_model->get_evergreens($evergreen_id);
    
   // echo '<pre>'; print_r($output); echo '</pre>';
    
      echo  json_encode($output);

}    
    
    
    function get_evergreens_users(){

    
    
     $evergreen_id = $this->input->post('evergreen_id');
    
    $output =  $this->Evergreen_model->get_evergreens_users($evergreen_id);
    
   // echo '<pre>'; print_r($output); echo '</pre>';
    
      echo  json_encode($output);

} 
    
    
    
function update_evergreens(){
$post = $this->input->post(); 
    
   //echo $this->data['current_user']['id'];
      $output =  $this->Evergreen_model->update_evergreens($post, $this->data['current_user']['id']);
    
  echo  json_encode($output);
//echo '<pre>'; print_r($post); echo '</pre>';
    
    

} 
   
    
    function test_evergreens(){

    
   $output =  $this->Evergreen_model->read_evergreens();
    
    echo '<pre>'; print_r($output[5]['sql']); echo '</pre>';
    
      // echo  json_encode($this->Evegreen_model->read_evergreens());

} 
    
    
    
    
    
    
    
    
    
}