<?php
class Actions_model extends CI_Model {
	

	// GETS
	public function get_actions($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			);
		$this->db->order_by('cancelled_at desc,planned_at asc');
		$query = $this->db->get_where('actions', $data);
		return $query->result_object();
	}

	public function get_pending_actions($user_id){
		$data = array(
			'actions.user_id' => $user_id,
			'actioned_at' => NULL,
			'cancelled_at' => NULL,
			);
		
		$this->db->select('company_id, actions.id "action_id",comments,planned_at,action_type_id,name "company_name",');
		$this->db->join('companies', 'companies.id = actions.company_id');
		$this->db->order_by('cancelled_at desc,planned_at asc');
		$query = $this->db->get_where('actions', $data);
		return $query->result();

	}

	public function get_action_types_array()
	{

		$this->db->select("id,name");
		$query = $this->db->get('action_types');
		foreach($query->result() as $row)
		{
		  $array[$row->id] = $row->name;
		} 	
		return $array;


	}

	public function get_action_types_done()
	{
		$query = $this->db->get_where('action_types',array('type'=>'Done'));
		return $query->result_object();
	}

	public function get_action_types_planned()
	{	
		$query = $this->db->get_where('action_types',array('type'=>'Planned'));
		return $query->result_object();
	}
	

	// UPDATES

	public function set_action_state($action_id,$user_id,$state,$outcome)
	{
		if($state == 'completed')
		{
			$data = array(
			'outcome' => $outcome,
			'actioned_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $user_id,
			);
		}

		if($state == 'cancelled')
		{
			$data = array(
			'cancelled_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $user_id,
			);
		}

		$this->db->where('id',$action_id);
		$this->db->update('actions',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
		} 
	}

	

	// INSERTS
	public function create($post)
	{
		// created_at,updated_at,created_by
		$data = array(
			'company_id' 	=> $post['company_id'],
			'user_id' 		=> $post['user_id'],
			'comments'		=> $post['comment'],
			'planned_at'	=> ($post['planned_at']? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
			'window'		=> ($post['window']?$post['window']:NULL),
			'created_by'	=> $post['user_id'],
			'action_type_id'=> $post['action_type'],
			'actioned_at'	=> (!isset($post['actioned_at']) && !isset($post['planned_at'])?date('Y-m-d H:i:s'):NULL),
			'created_at' 	=> date('Y-m-d H:i:s'),
			);
		
		$query = $this->db->insert('actions', $data);
		return $this->db->insert_id();
	}
	
	// DELETES
	public function delete_campaign($id,$user_id)
	{
		$data = array(
			'eff_to' => date('Y-m-d'),
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $user_id,
			);
		$this->db->where('id',$id);
		$this->db->update('campaigns',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
		} 
	}

}