<?php
class Actions_model extends CI_Model {
	

	// GETS
	public function get_actions($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			);
		$query = $this->db->get_where('actions', $data);
		return $query->result_object();
	}

	public function get_action_types()
	{
		$query = $this->db->get('action_types');
		return $query->result_object();
	}
	

	// UPDATES

	

	// INSERTS
	public function create($post)
	{
		// created_at,updated_at,created_by
		$data = array(
			'company_id' => $post['company_id'],
			'user_id' => $post['user_id'],
			'comments'=> $post['comment'],
			'planned_at'=> ($post['planned_at']? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
			'window'=> ($post['window']?$post['window']:NULL),
			'created_by'=> $post['user_id'],
			'action_type_id'=> $post['action_type'],
			'actioned_at'=> ($post['actioned_at']?date('Y-m-d H:i:s',strtotime($post['actioned_at'])):date('Y-m-d H:i:s')),
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