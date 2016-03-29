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
		$data = array('company_id' => $company_id);
		//$this->db->where('eff_to >', 'now()');
		//$this->db->or_where('eff_to', null);
		$this->db->order_by("eff_to", "desc"); 
		$this->db->order_by("last_name", "asc"); 
		$query = $this->db->get_where('contacts', $data);
		return $query->result();
	}

function get_contacts_s($company_id)
	{
		$data = array('company_id' => $company_id);
		//$this->db->where('eff_to >', 'now()');
		//$this->db->or_where('eff_to', null);
    
    
$sql = "SELECT contacts.*, usr_created_by.name as created_by,  usr_updated_by.name as updated_by, to_char(contacts.updated_at, 'DD/MM/YYYY') as contact_updated_at, to_char(contacts.created_at, 'DD/MM/YYYY') as contact_created_at
FROM contacts
LEFT JOIN users as usr_updated_by  ON contacts.updated_by=usr_updated_by.id
LEFT JOIN users as usr_created_by  ON contacts.created_by=usr_created_by.id
WHERE contacts.company_id=".$company_id." order by last_name asc";
    
  
     $result = $this->db->query($sql);
      return    $result->result();
	}

    
    
    
    
	function create_contact($first_name,$last_name,$email,$role,$company_id,$created_by,$phone=NULL,$linkedin_id)
	{
    
        $role = rtrim($role," "); // removes empty space on rightside of string ltrim removes empty space on the left before string
        $contact->first_name = str_replace('\'', '&#39;', rtrim($first_name)); // please read the below note
        $contact->last_name = str_replace('\'', '&#39;', ltrim($last_name));
        $contact->email = !empty($email)?$email:NULL;
        $contact->phone = !empty($phone)?$phone:NULL;
        $contact->role =  ltrim($role);
        $contact->company_id = $company_id;
        $contact->created_by = $created_by;
        //$contact->linkedin_id = $linkedin_id;
        $parts = explode("?",$linkedin_id); 
		$li_id = $parts['0'];
		$contact->linkedin_id = $li_id;

        //if(strpos($linkedin_id, '&') !== false) {
		//$revised_linkedin_id = str_replace(array('.', ','), '' , preg_replace('/[^0-9,..]/i', '', $li_id));
		//} else {
		//$revised_linkedin_id = str_replace(array('.', ','), '' , preg_replace('/[^0-9,..]/i', '', $li_id));
		//}
        //$contact->linkedin_id = !empty($revised_linkedin_id)?$revised_linkedin_id:NULL;
		$this->db->insert('contacts', $contact);
        $new_id = $this->db->insert_id();
        $rows = $this->db->affected_rows();
	    return $rows;
    }

    function update($post)
    {

        $role = rtrim($post['role']," "); // removes empty space on rightside of string ltrim removes empty space on the left before string
        $contact->first_name   = str_replace('\'', '&#39;',rtrim($post['first_name'])); // please read the below note
    	$contact->last_name = str_replace('\'', '&#39;',ltrim($post['last_name']));
        $contact->role = ltrim($role);
        $contact->email = !empty($post['email'])?$post['email']:NULL;
        $contact->phone = !empty($post['phone'])?$post['phone']:NULL;
        $linkedin_id = $post['linkedin_id'];
        $parts = explode("?",$linkedin_id); 
		$li_id = $parts['0']; 
        //if(strpos($linkedin_id, '&') !== false) {
		//$revised_linkedin_id = str_replace(array('.', ','), '' , preg_replace('/[^0-9,..]/i', '', $li_id));
		//} else {
		//$revised_linkedin_id = str_replace(array('.', ','), '' , preg_replace('/[^0-9,..]/i', '', $li_id));
		//}
		if($post['eff_to'] == 1) {
        $contact->eff_to = date('Y-m-d');
		}
		else{};
		if (($post['marketing_opt_out'] == 1) && (empty($post['opt_out_check']))) { 
        $contact->email_opt_out_date = date('Y-m-d');
        $contact->email_opt_out_user = $post['user_id'];

		}
		else if (($post['marketing_opt_out'] == 0) && (!empty($post['opt_out_check']))){
		$contact->email_opt_out_date = NULL;
		$contact->email_opt_out_user = $post['user_id'];

		};
		//$contact->linkedin_id = (!empty($revised_linkedin_id)?$revised_linkedin_id:NULL);
		$contact->linkedin_id = $li_id;
        $contact->updated_by = $post['user_id'];
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