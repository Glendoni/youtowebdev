<?php
class Campaigns_model extends CI_Model {
	

	// GETS
	function get_all_shared_campaigns($user_id=False)
	{
		$this->db->select('name,id');
		$this->db->from('campaigns');
		$this->db->where('shared', 'True');
		if($user_id) $this->db->where('user_id !=', $user_id);
		$this->db->order_by("name", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_private_campaigns()
	{
		$query = $this->db->get_where('campaigns', array('shared' => 'False'));
		return $query->result();
	}

	function get_campaigns_for_user($user_id)
	{
		$this->db->select('name,id');
		$this->db->from('campaigns');
		$this->db->where('user_id', $user_id);
		$this->db->order_by("name", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_campaign_by_id($id)
	{
		$this->db->select('name,id,criteria,shared');
		$this->db->from('campaigns');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	// UPDATES


	// INSERTS
	public function create_from_post($name,$shared,$user_id,$post) 
	{	
		$data['name'] = $name;	
		$data['user_id'] = $user_id;
		$data['campaign_user_id'] = $user_id;
		$data['criteria'] =  serialize($post);
		$data['shared'] = $shared;
		$data['eff_from'] = date('Y-m-d');
		$data['created_by'] = $user_id;

		$this->db->insert('campaigns', $data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			//return user if insert was successful 
			$compaign_id = $this->db->insert_id();
			return $compaign_id;
		}
	}

	// DELETES


}