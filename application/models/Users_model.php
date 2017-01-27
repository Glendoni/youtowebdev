<?php
class Users_model extends MY_Model {
	

	// GETS
	function get_users_for_select() 
	{	
		$this->db->select('id, name, image');
		$this->db->where('eff_to', null);
		$query = $this->db->get('users');
		$users[0] = ' ';
		foreach ($query->result_array() as $row)
		{
			$users[$row['id']] = $row['name'];
			$images[$row['id']] = $row['image'];		  
		}
		return array('users'=>$users,'images'=>$images);
	}
	// returns a user for a given id
	function get_sales_users_for_select() 
	{	
		$this->db->select('id, name, image');
		$this->db->where('eff_to', null);
		$this->db->where('department', 'sales');
		$query = $this->db->get('users');
		$users[0] = ' ';
		foreach ($query->result_array() as $row)
		{
			$users[$row['id']] = $row['name'];
			$images[$row['id']] = $row['image'];		  
		}
		return array('users'=>$users,'images'=>$images);
	}
	// returns a user for a given id
	function get_user($id) 
	{
		$limit = 1;
		$query = $this->db->get_where('users', array('id' => $id), $limit);
		return $query->row_array();
	}

	function get_user_by_email($email)
	{	
		$limit = 1;
		$query = $this->db->get_where('users', array('email' => $email), $limit);
		return $query->result();
	}

		function get_user_image()
	{
			if (!empty($_GET['user'])) {
	 	$sql = "select u.image, u.name as \"username\"
				from users u
				where u.id = '".$_GET['user']."' limit 1";
		$query = $this->db->query($sql);

		    return $query->result(); /* returns an object */
		}
	}
	
	function get_user_login($email,$password)
	{	
		$limit = 1;
		$query = $this->db->get_where('users', array('eff_to'=>NULL,'email' => $email,'password'=>md5($password)), $limit);
		return $query->result();
	}

	function update_last_login($logged_in_user_id)
	{	
		$sql = "update users set last_login = now(), unsuccessful_login_attempts = '0' where id = '$logged_in_user_id'";
		$query = $this->db->query($sql);
	}
	function update_last_unsuccessful_login($email)
	{	
		$sql = "update users set last_unsuccessful_login_attempt = now(), unsuccessful_login_attempts = unsuccessful_login_attempts + 1 where email = '$email'";
		$query = $this->db->query($sql);
		$sql = "select unsuccessful_login_attempts
				from users u
				where u.email = '$email' limit 1";
		$query = $this->db->query($sql);
		return $query->result(); /* returns an object */
	}
	function disable_user($email)
	{	

		$user->eff_to = date('Y-m-d');
        $this->db->where('email', $email);
		$this->db->update('users',$user);
	}


	// UPDATES

	function update($data,$user_id,$image_updated=FALSE){
        
        
       

		//GET INITIALS OF USER//
		$words = explode(" ",$data['name'] );
		foreach ($words as $w) {
  		 	  $initials .= $w[0];
		};
		$fgcolour = !empty($data['user-fg'])?$data['user-fg']:'#FFFFF';
		$bgcolour = !empty($data['user-fg'])?$data['user-bg']:'#FF0000';
		$image = $initials.','.$fgcolour.','.$bgcolour;
		//$this->load->library('encrypt');

        $role = rtrim($data['role']," "); // removes empty space on rightside of string ltrim removes empty space on the left before string
        
        /*
		$data = array(
			
			'name' => $data['name'],
			'email' => $data['email'],
			 
			'mobile' => !empty($data['mobile'])?$data['mobile']:Null,
			'linkedin' => !empty($data['linkedin'])?$data['linkedin']:Null,
			 
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $user_id,
			'image' => $image,
			//'gmail_account' => $data['gmail_account'],
			'new_window' => $data['new_window']
			
/*'name' => $data['name'],
			'email' => $data['email'],
			'phone' => !empty($data['phone'])?$data['phone']:Null,
			'mobile' => !empty($data['mobile'])?$data['mobile']:Null,
			'linkedin' => !empty($data['linkedin'])?$data['linkedin']:Null,
			'role' => !empty($data['role'])? ltrim($role):Null,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $user_id,
			'image' => $image,
			//'gmail_account' => $data['gmail_account'],
			'new_window' => $data['new_window'],
			'permission' => !empty($data['permission'])?$data['permission']:Null,
            
          


			);
        */

    $insert['name'] = $data['name'];
    $insert['email'] =  $data['email'];
        $insert['phone'] =  $data['phone'];
    $insert['mobile'] =  !empty($data['mobile'])?$data['mobile']:Null;
    $insert['linkedin'] =  !empty($data['linkedin'])?$data['linkedin']:Null;
    $insert['updated_at'] =  date('Y-m-d H:i:s');
    $insert['updated_by'] =  $user_id;
    $insert['image'] =  $image;
    $insert['new_window'] =  $data['new_window'];
    if(trim($data['updatepassword'])) {
        
        $insert['password'] =  md5($data['updatepassword']);
        $insert['temp_password'] = null;
    }
    

          
        
        
		$this->db->where('id', $user_id);
		$this->db->update('users',$insert);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
					$this->session->set_userdata('system_users_images',$current_user['id']);

			return True;

		} 
	}

	function update_settings($data,$user_id){
        
    
		$this->load->library('encrypt');
       
		$data = array(
			'gmail_account' => $data['gmail_account'],
			'gmail_password' => $this->encrypt->encode($data['gmail_password'])
			);

		$this->db->where('id', $user_id);
		$this->db->update('users',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return false;
		}else{
			return true;
		} 
	}


	// INSERTS

	/* User array:
		$data['name']
		$data['email']
		$data['password']
		$data['active'] // True or False
		$data['type']
	*/

	function insert_user($data,$md5 = True)
	{
		$user = $this->get_user_by_email($data['email']);
		if(!$user){ 
			if($md5){
				$data['password'] = md5($data['password']);
			}
			
			$this->db->insert('users', $data);
			if($this->db->affected_rows() !== 1){
				$this->addError($this->db->_error_message());
				return false;
			}else{
				//return user if insert was successful 
				$user_id = $this->db->insert_id();
				return $user_id;
			}
			
		}else{
		    return false;
		}
	}

function get_all_users($userid){

    $sql = 'SELECT id, name, department FROM users WHERE active=true  and department not in ( \'hr\',\'data\', \'development\') or  id='.$userid.' order by department desc , name asc';
    $query = $this->db->query($sql);
    return $query->result_array();

    
}

function privilages_insert_user($post,$user_id,$genrated_password)
	{
		$user = $this->get_user_by_email($post['email']);
        $tablemax = $this->get_table_max();
        
      
		if(!$user){ 
            
                $data = array(  
                    'id' => $tablemax,
                    'password' =>  md5($genrated_password),
                    'eff_from' =>  date('Y-m-d', strtotime($post['eff_from'])),
                    'eff_to' =>  (!empty($post['eff_to'])? date('Y-m-d', strtotime($post['eff_to'])): null),
                    'name' =>  $post['name'],
                    'department' =>  $post['department'],
                    'created_by' => $user_id,
                    'email' =>  $post['email'],
                    'role' =>  $post['role'],
                    'phone' =>  (!empty($post['phone'])?$post['phone']:NULL),
                    'mobile' =>  (!empty($post['mobile'])?$post['mobile']:NULL),
                    'linkedin' => (!empty($post['linkedin'])?$post['linkedin']:NULL),
                    'temp_password' =>  $genrated_password
                );


                $this->db->insert('users', $data);
            
            }
			if($this->db->affected_rows() !== 1){
				$this->addError($this->db->_error_message());
                
             
				return false;
			}else{
				//return user if insert was successful 
				//$user_id = $this->db->insert_id();
				 return $user_id;
			}
			
		 
		 
	}

    function get_users_privilages($id){
        
        $sql = "SELECT distinct  u.id,u.name,u.department, u.role, u.phone, u.temp_password, u.mobile, u.eff_from,u.eff_to, u.linkedin, u.email ,T1.id as created_by, T1.name as created_by_name, T2.updated_by, T2.name as updated_by_name,
        CASE when T2.temp_password is not null then '' else u.temp_password  END  \"display_temp_password\" 
from users u
JOIN (select id, created_by, name from users ) T1
ON u.created_by = T1.id
LEFT JOIN (select id, updated_by,temp_password, name from users ) T2
ON u.updated_by = T2.id
WHERE u.active=true 

AND  u.id=$id
order by u.name, u.department

 ";
        
        
         $query = $this->db->query($sql);
   
        return $query->row_array();
        
        
    }
    
            function update_user($data,$user_id)
            {

                
                $user = $this->get_user_by_email($data['email']);
$data['updated_by'] = $user_id;
$data['eff_from']  = date('Y-m-d', strtotime($data['eff_from']));
                $data['eff_to']  = (!empty($data['eff_to'])? date('Y-m-d', strtotime($data['eff_to'])): null);
               if($user[0]->id){
                $this->db->where('id', $user[0]->id);
                $this->db->update('users', $data);
                
               }
                if($this->db->affected_rows() !== 1){
                $this->addError($this->db->_error_message());
                return false;
                }else{
                //return user if insert was successful 
               // $user_id = $this->db->insert_id();
                return true;
                }


            }
    
	function get_table_max()
	{	
		 $sql = "select max(id) from users";
		$query = $this->db->query($sql);

		    $user =  $query->result(); /* returns an object */
       return ($user[0]->max + 1);
		 
	}
    
    
    
function getUsersList(){
    $sql = "SELECT * FROM users WHERE active=true order by name, department";
		$query = $this->db->query($sql);

		    return $query->result(); /* returns an object */
    
    
}    
	// DELETES


}