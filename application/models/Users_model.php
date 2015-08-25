<?php
class Users_model extends MY_Model {
	

	// GETS
	function get_users_for_select() 
	{	
		$this->db->select('id, name, image');
		$this->db->where('active', 'True');
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
		$query = $this->db->get_where('users', array('email' => $email,'password'=>md5($password)), $limit);
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
	}



	// UPDATES

	function update($data,$user_id,$image_updated=FALSE){
		$data = array(
			'name' => $data['name'],
			'email' => $data['email'],
			'phone' => !empty($data['phone'])?$data['phone']:Null,
			'mobile' => !empty($data['mobile'])?$data['mobile']:Null,
			'linkedin' => !empty($data['linkedin'])?$data['linkedin']:Null,
			'role' => !empty($data['role'])?$data['role']:Null,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $user_id,
			'image'=> $image_updated?$image_updated:Null,
			);

		$this->db->where('id', $user_id);
		$this->db->update('users',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
		} 
	}

	function update_settings($data,$user_id){
		$this->load->library('encrypt');
		$data = array(
			'gmail_account' => $data['gmail_account'],
			'gmail_password' => $this->encrypt->encode($data['gmail_password']),
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $user_id,
			);

		$this->db->where('id', $user_id);
		$this->db->update('users',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
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



	// DELETES


}