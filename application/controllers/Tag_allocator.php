<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag_allocator extends MY_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->model('Tag_allocator_model');
        $this->load->model('Tagging_model');
	}


	public function pre_start_up(){
        
        
        
        
       // echo $this->Tag_allocator_model->get_all();
        $pre_start =  $this->Tag_allocator_model->not_placing_contract(); //ok
        $pre_start =  $this->Tag_allocator_model->placing_perm_contrators(); //ok
        $pre_start =  $this->Tag_allocator_model->placing_contract(); //
        
        
        //echo '<pre>'; print_r($pre_start); echo '</pre>';
        
        
        
        
        
    }
 
   
    
}