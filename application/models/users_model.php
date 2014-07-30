<?php
class Users_model extends CI_Model {
	

	// GETS

	// returns a user for a given id
	public function getUser($id) 
	{
		$query = $this->db->get_where('users', array('id' => $id), 1);
		return $query->row_array();
	}
	
	public function getUserByEmail($email)
	{
		$query = $this->db->get_where('users', array('email' => $email), 1);
		return $query->result();
	}
	
	public function getUserLogin($email,$password)
	{
		$query = $this->db->get_where('users', array('email' => $email,'password'=>md5($password)), 1);
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
	public function insertUser($data,$md5 = True)
	{
		$user = $this->getUserByEmail($data['email']);
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