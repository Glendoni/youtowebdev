<?php
class Actions_model extends CI_Model {
	

	// GETS
	public function get_actions($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			'actioned_at' => NULL,
			'cancelled_at' => NULL,
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
	public function create($company_id,$owner_id,$campaign_id=NULL,$comments=NULL,$planned_at=NULL,$window=False,$action_type_id,$actioned_at=False)
	{
		// created_at,updated_at,created_by
		$data = array(
			'company_id' => $company_id,
			'user_id' => $owner_id,
			'comments'=> $comments,
			'planned_at'=> ($planned_at? date('Y-m-d H:i:s',strtotime($planned_at)):NULL),
			'window'=> ($window?:''),
			'created_by'=> $owner_id,
			'action_type_id'=> $action_type_id,
			'actioned_at'=> ($actioned_at?date('Y-m-d H:i:s',strtotime($actioned_at)):NULL),
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