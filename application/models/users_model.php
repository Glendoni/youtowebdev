<?php
class Users_model extends CI_Model {
	

	// GETS
	public function get_users_for_select() 
	{	
		$this->db->select('id, name, image');
		$this->db->where('active', 'True');
		$query = $this->db->get('users');
		$users[0] = ' ';
		foreach ($query->result_array() as $row)
		{
			$users[$row['id']] = array('name'=>$row['name'],'image'=>$row['image']);		  
		}
		return $users;
	}
	// returns a user for a given id
	public function get_user($id) 
	{
		$limit = 1;
		$query = $this->db->get_where('users', array('id' => $id), $limit);
		return $query->row_array();
	}
	
	public function get_user_by_email($email)
	{	
		$limit = 1;
		$query = $this->db->get_where('users', array('email' => $email), $limit);
		return $query->result();
	}
	
	public function get_user_login($email,$password)
	{	
		$limit = 1;
		$query = $this->db->get_where('users', array('email' => $email,'password'=>md5($password)), $limit);
		return $query->result();
	}

	// UPDATES


	// INSERTS

	/* User array:
		$data['name']
		$data['email']
		$data['password']
		$data['active'] // True or False
		$data['type']
	*/
	public function insert_user($data,$md5 = True)
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



	// DELETES


}