<?php
class Actions_model extends CI_Model {
	

	// GETS
	public function get_actions($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			);
		$this->db->order_by('cancelled_at desc,planned_at desc');
		$query = $this->db->get_where('actions', $data);
		return $query->result_object();
	}

	public function get_pending_actions($user_id){
		// $data = array(
		// 	'actions.user_id' => $user_id,
		// 	'actioned_at' => NULL,
		// 	'cancelled_at' => NULL,
		// 	);
		
		$this->db->select('company_id, actions.id "action_id",comments,planned_at,action_type_id,name "company_name",');
		$this->db->where('actions.user_id',$user_id);
		$this->db->where('actioned_at',NULL);
		$this->db->where('cancelled_at',NULL);
		$this->db->join('companies', 'companies.id = actions.company_id');
		$this->db->order_by('cancelled_at desc,planned_at asc');
		$query = $this->db->get('actions');
		// var_dump($query);
		return $query->result_object();

	}

	
	public function get_recent_stats(){
		$start_date = date('Y-m-d 00:00:00',strtotime('monday this week'));
		$end_date = date('Y-m-d 23:59:59',strtotime('sunday this week'));
		$sql = "select U.name,
		    count(*) total,
			    sum(case when action_type_id = '4' then 1 else 0 end) introcall,

		    sum(case when action_type_id = '7' then 1 else 0 end) commentcount,
		    sum(case when action_type_id = '5' OR action_type_id = '5' then 1 else 0 end) callcount,
		    sum(case when action_type_id = '11' then 1 else 0 end) CallBackCount,
		    sum(case when action_type_id = '10' then 1 else 0 end) meetingcount
		from actions A

		INNER JOIN users U
		on A.user_id = U.id

		where actioned_at > '$start_date' AND actioned_at < '$end_date' AND cancelled_at is null group by U.name order by total desc";

		$query = $this->db->query($sql);

		return $query->result_array();

	}
	
	public function get_last_week_stats(){
		$start_date_last = date('Y-m-d 00:00:00',strtotime('monday last week'));
		$end_date_last = date('Y-m-d 23:59:59',strtotime('sunday last week'));
		$last_week_sql = "select U.name,
		    count(*) total,
			    sum(case when action_type_id = '4' then 1 else 0 end) introcall,

		    sum(case when action_type_id = '7' then 1 else 0 end) commentcount,
		    sum(case when action_type_id = '5' OR action_type_id = '5' then 1 else 0 end) callcount,
		    sum(case when action_type_id = '11' then 1 else 0 end) CallBackCount,
		    sum(case when action_type_id = '10' then 1 else 0 end) meetingcount
		from actions A

		INNER JOIN users U
		on A.user_id = U.id

		where actioned_at > '$start_date_last' AND actioned_at < '$end_date_last' AND cancelled_at is null
		group by U.name order by total desc";

		
		//$this->db->select('company_id, actions.id "action_id",comments,planned_at,action_type_id,name "company_name",');
		//$this->db->join('companies', 'companies.id = actions.company_id');
		//$this->db->order_by('cancelled_at desc,planned_at asc');
		$last_week_query = $this->db->query($last_week_sql);

		return $last_week_query->result_array();

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
			'comments'		=> ($post['comment']?$post['comment']:NULL),
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