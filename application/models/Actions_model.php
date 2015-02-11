<?php
class Actions_model extends MY_Model {
	

	// GETS
	function get_actions($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			);
		$this->db->where_not_in('action_type_id', 7);
		$this->db->order_by('actioned_at desc, cancelled_at desc,planned_at desc');
		$query = $this->db->get_where('actions', $data);
		return $query->result_object();
	}

	function get_actions_outstanding($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			);
		$this->db->where('planned_at IS NOT NULL', null);
		$this->db->where('actioned_at IS NULL', null);
		$this->db->where('cancelled_at IS NULL', null);
		$this->db->where_not_in('action_type_id', 7);
		$this->db->order_by('actioned_at desc, cancelled_at desc,planned_at desc');
		$query = $this->db->get_where('actions', $data);
		return $query->result_object();
	}

	function get_actions_completed($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			);
		$this->db->where('actioned_at IS NOT NULL', null);
		$this->db->where_not_in('action_type_id', 7);
		$this->db->order_by('actioned_at desc,planned_at desc');
		$query = $this->db->get_where('actions', $data);
		return $query->result_object();
	}

	function get_actions_cancelled($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			);
		$this->db->where('cancelled_at IS NOT NULL', null);
		$this->db->where_not_in('action_type_id', 7);
		$this->db->order_by('cancelled_at, planned_at desc');
		$query = $this->db->get_where('actions', $data);
		return $query->result_object();
	}

	function get_comments($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			);
		$this->db->where('action_type_id', '7');
		$this->db->order_by('actioned_at desc, cancelled_at desc,planned_at desc');
		$query = $this->db->get_where('actions', $data);
		return $query->result_object();
	}

	function get_pending_actions($user_id){		
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

	
	function get_recent_stats(){
		$start_date = date('Y-m-d 00:00:00',strtotime('monday this week'));
		$end_date = date('Y-m-d 23:59:59',strtotime('sunday this week'));
		$sql = "select U.name,
				sum(case when action_type_id = '4' AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) introcall,
		    	sum(case when (action_type_id = '5' OR action_type_id = '11') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) callcount,
		   		sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) meetingcount,
		    	sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) meetingbooked,
		    	sum(case when (action_type_id = '16') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) deals,
		    	sum(case when (action_type_id = '8') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) proposals
				from actions A
				INNER JOIN users U
				on A.user_id = U.id
				LEFT JOIN companies C
				on A.company_id = C.id
				where cancelled_at is null group by U.name order by deals desc,proposals desc,meetingbooked desc, introcall desc, name desc";
		$query = $this->db->query($sql);

		return $query->result_array();

	}

	function get_this_month_stats(){
		$start_date = date('Y-m-d 00:00:00',strtotime('first day of this month'));
		$end_date = date('Y-m-d 23:59:59',strtotime('last day of this month'));
		$sql = "select U.name,
				sum(case when action_type_id = '4' AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) introcall,
		    	sum(case when (action_type_id = '5' OR action_type_id = '11') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) callcount,
		   		sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) meetingcount,
		    	sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) meetingbooked,
		    	sum(case when (action_type_id = '16') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) deals,
		    	sum(case when (action_type_id = '8') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) proposals
				from actions A
				INNER JOIN users U
				on A.user_id = U.id
				LEFT JOIN companies C
				on A.company_id = C.id
				where cancelled_at is null group by U.name order by deals desc, meetingbooked desc, introcall desc,  name desc";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_stats_search(){

		 $start_date = date('Y-m-d 00:00:00',strtotime($_GET['start_date']));
		 $end_date = date('Y-m-d 00:00:00',strtotime($_GET['end_date']));
		 $sql = "select U.name,
				sum(case when action_type_id = '4' AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) introcall,
		    	sum(case when (action_type_id = '5' OR action_type_id = '11') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) callcount,
		   		sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) meetingcount,
		    	sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) meetingbooked,
		    	sum(case when (action_type_id = '16') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) deals,
		    	sum(case when (action_type_id = '8') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) proposals
				from actions A
				INNER JOIN users U
				on A.user_id = U.id
				LEFT JOIN companies C
				on A.company_id = C.id
				where cancelled_at is null group by U.name order by deals desc, meetingbooked desc, introcall desc,  name desc";
		$query = $this->db->query($sql);

		return $query->result_array();

	}

	function get_action_types_array()
	{

		$this->db->select("id,name");

		$query = $this->db->get('action_types');
		foreach($query->result() as $row)
		{
		  $array[$row->id] = $row->name;
		} 	
		return $array;

	}

	function get_action_types_done()
	{
		$ignore = array('19','7'); //EXCLUDE PIPELINE TRACKING AND COMMENT//
		$data = array(
			'type' => 'Done',
			);
		$this->db->where_not_in('id', $ignore);
		$this->db->order_by('name', 'asc'); 

		$query = $this->db->get_where('action_types',$data);
		return $query->result_object();
	}


	function get_action_types_planned()
	{	
		$this->db->order_by('name', 'asc'); 
		$query = $this->db->get_where('action_types',array('type'=>'Planned'));
		return $query->result_object();
	}
	

	// UPDATES


	function set_action_state($action_id,$user_id,$state,$outcome)

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
			'outcome' => $outcome,
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
	function create($post)
	{
		// created_at,updated_at,created_by
		$data = array(
			'company_id' 	=> $post['company_id'],
			'user_id' 		=> $post['user_id'],
			'comments'		=> (isset($post['comment'])?$post['comment']:NULL),
			'planned_at'	=> (isset($post['planned_at'])? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
			'window'		=> (isset($post['window'])?$post['window']:NULL),
			'contact_id'    => (isset($post['contact_id'])?$post['contact_id']:NULL),
			'created_by'	=> $post['user_id'],
			'action_type_id'=> $post['action_type'],
			'actioned_at'	=> (!isset($post['actioned_at']) && !isset($post['planned_at'])?date('Y-m-d H:i:s'):NULL),
			'created_at' 	=> date('Y-m-d H:i:s'),
			);
		
		$query = $this->db->insert('actions', $data);
		return $this->db->insert_id();
	}
	
	// DELETES
	function delete_campaign($id,$user_id)
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