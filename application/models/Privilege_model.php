<?php
class Privilege_model extends CI_Model {         


function privileges($cntr){
      $words = array('_construct', 'index','add_notification','__construct','et_message_success','clear_saved_search_from_session','seve_current_search','get_current_user_id','get_current_search','refresh_search_results','set_message_success','set_message_info
','set_message_warning','set_message_action_error','set_message_error','clear_search_results','process_search_result','isMobileBrowser
' ,'is_ajax_request', 'get_instance','set_message_info', 'isMobileBrowser', 'clear_campaign_from_session', '_index','_valid_registration', '_valid_name','previleges', 'privilege');
              
       $class_methods = get_class_methods($cntr);
        foreach ($class_methods as $method_name) {
            
            if(!in_array($method_name,$words)){
            $a[$method_name]  = $method_name;
            }
        }

         return  json_encode($a);  
             
} 
    
    
    
    
    function savePrev($privileges){
        
        $data = array(
           'name' => 'Test',
           'privileges' => $privileges,
          
            'updated_by' => 31,
            'active' => true
        );
        $this->db->where('id', 11);
        $this->db->update('permission', $data);
        
        
    }
    
      function getPrev($id = 11){
        
      $query = $this->db->query("SELECT privileges FROM permission WHERE id= 11 LIMIT 1");
      
          if ($query->num_rows() > 0)
              {
                 $row = $query->row(); 
      
                 return $row->privileges;
      
              }
          }
       
     

  function getPrevUserGroups(){
        
     $query = $this->db->query("SELECT name,id FROM permission ");
     
     

       return $query->result_array();
    }
      }





    
    
    
 
    