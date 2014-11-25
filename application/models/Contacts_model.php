<?php
class Contacts_model extends CI_Model {

	function get_all()
	{
		$query = $this->db->get('contacts');	
		return $query->result();
	}

	function get_contact_by_id($id)
	{
		$query = $this->db->get_where('contacts',array('id'=>$id));	
		return $query->row();
	}

	function get_contact_by_name($first_name)
	{
		$query = $this->db->get_where('contacts',array('first_name'=>$first_name));	
		return $query->result();
	}

	function get_contact_by_email($email)
	{
		$query = $this->db->get_where('contacts',array('email'=>$email));	
		return $query->result();
	}

	function get_contacts($company_id)
	{
		$query = $this->db->get_where('contacts',array('company_id'=>$company_id));	
		return $query->result();
	}


	function create_contact($first_name,$last_name,$email,$role,$company_id,$created_by,$phone=NULL)
	{
        $contact->first_name = $first_name; // please read the below note
        $contact->last_name = $last_name;
        $contact->email = $email;
        $contact->phone = $phone;
        $contact->role = $role;
        $contact->company_id = $company_id;
        $contact->created_by = $created_by;
        $this->db->insert('contacts', $contact);
        $new_id = $this->db->insert_id();
        $rows = $this->db->affected_rows();
	    return $rows;
    }

    function update($post){
    	$contact->first_name   = $post['first_name']; // please read the below note
    	$contact->last_name = $post['last_name'];
        $contact->role = $post['role'];
        $contact->email = $post['email'];
        $contact->phone = $post['phone'];
        $contact->updated_by = $user_id;
        $contact->updated_at = date('Y-m-d H:i:s');
			
        $this->db->where('id', $post['contact_id']);
		$this->db->update('contacts',$contact);
        if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
		} 
    }
}