<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privilege extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
        
        
            $this->load->model('Users_model');
      
        
	}
	
	public function index() 
	{	
		// Clear search in session 
		 
        
             //$this->load->model('Tagets_model');
         //echo $this->Targets_model->privileges_role(); 
           //echo  APPPATH . 'controllers/*' . EXT;
        
        $frontend_taging_js =    asset_url().'js/privileges.js';
        $this->data['privileges'] =  $frontend_taging_js;
        $this->data['main_content'] = 'privilege/privileges';
		$this->load->view('layouts/default_layout', $this->data);	
       
        
    }
    
 
 
    
   public function addUser(){
       
        $contact_info = $this->input->post();
       $psw = explode(' ', $contact_info['name']); 
        $pswd  = $psw[0][0];
       $genrated_password = $this->GeraHash(8);
       $data  = $this->input->post();
       $pswd = array('password' => $contact_info);
       $data = array_merge($pswd,$data);
       
       
       //echo 'Create';
       
       //print_r($data);
        //echo json_encode($contact_info);
        echo  json_encode($this->Users_model->privilages_insert_user($data,$this->data['current_user']['id'],$genrated_password));
        
    }
    
       public function updateUser(){
       
        $contact_info = $this->input->post();
       $psw = explode(' ', $contact_info['name']); 
        $pswd  = $psw[0][0];
   
       $data  = $this->input->post();
       //$pswd = array('password' => $contact_info);
      // $data = array_merge($pswd,$data);
       
          // echo 'Update';
           //print_r($data);
        //echo json_encode($contact_info);
           
       
           
           $output = $this->Users_model->update_user($data,$this->data['current_user']['id']);
       echo  json_encode(array('success' => $output , 'status' => 200));
        
    }
    
    
    function GeraHash($qtd){ 
            //Under the string $Caracteres you write all the characters you want to be used to randomly generate the code. 
            $Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789'; 
            $QuantidadeCaracteres = strlen($Caracteres); 
            $QuantidadeCaracteres--; 

            $Hash=NULL; 
            for($x=1;$x<=$qtd;$x++){ 
            $Posicao = rand(0,$QuantidadeCaracteres); 
            $Hash .= substr($Caracteres,$Posicao,1); 
            } 

            return $Hash; 
    } 
    
    
    function getusers(){
        
      echo json_encode($this->Users_model->getUsersList());        
        
        
    }
    
    
     function getuser($id){
        $contact_info = $this->input->post();
         
       //echo   json_encode($contact_info);
     echo json_encode($this->Users_model->get_users_privilages($contact_info['userid']));        
        
        
    }
    
    
    
    function userget(){
           
        //$limit = 1;
		//$query = $this->db->get_where('users', array('email' => $email), $limit);
		//$result = $query->result();
        
          $id = 92;
        
        $sql = "SELECT distinct  u.id,u.name,u.department, u.role, u.phone, u.temp_password,  u.mobile, u.eff_from,u.eff_to, u.linkedin, u.email ,T1.id as created_by, T1.name as created_by_name, T2.updated_by, T2.name as updated_by_name,
        CASE when T2.updated_by is not null then '' else u.password  END  \"display_temp_password\" 
from users u
JOIN (select id, created_by, name from users ) T1
ON u.created_by = T1.id
LEFT JOIN (select id, updated_by, name from users ) T2
ON u.updated_by = T2.id
WHERE u.active=true 

AND  u.id=$id
order by u.name, u.department

 ";
        
        
         $query = $this->db->query($sql);
   
        $row=  $query->row_array();
        
        echo $row['display_temp_password'];
        
       print_r($row);
        
        
    }
    
    //echo json_encode($prev);

     //}
    
    
 

}