<?php
class Actions_model extends MY_Model {
	

	// GETS

	function get_actions($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			);
		$this->db->where_not_in('action_type_id', $category_exclude);
		$this->db->order_by('actioned_at desc, cancelled_at desc,planned_at desc');
		$query = $this->db->get_where('actions', $data);
		return $query->result_object();
	}

	function get_actions_outstanding($company_id)
	{
		$category_exclude = array('7', '20');
		$data = array(
			'company_id' => $company_id,
			);
		$this->db->where('planned_at IS NOT NULL', null);
		$this->db->where('actioned_at IS NULL', null);
		$this->db->where('cancelled_at IS NULL', null);
		$this->db->where_not_in('action_type_id',$category_exclude);
		$this->db->order_by('actioned_at desc, cancelled_at desc,planned_at desc');
		$query = $this->db->get_where('actions', $data);
		return $query->result_object();
	}

	function get_actions_completed($company_id)
	{
		$category_exclude = array('7', '20');
		$data = array(
			'company_id' => $company_id,
			);
		$this->db->where('actioned_at IS NOT NULL', null);
		$this->db->where_not_in('action_type_id', $category_exclude);
		$this->db->order_by('actioned_at desc,planned_at desc');
		$query = $this->db->get_where('actions', $data);
		return $query->result_object();
	}

	function get_actions_cancelled($company_id)
	{
		$category_exclude = array('7', '20');
		$data = array(
			'company_id' => $company_id,
			);
		$this->db->where('cancelled_at IS NOT NULL', null);
		$this->db->where_not_in('action_type_id', 7);
		$this->db->order_by('cancelled_at, planned_at desc');
		$query = $this->db->get_where('actions', $data);
		return $query->result_object();
	}

	function get_actions_marketing($company_id)
	{
 	$sql = "select ec.name as campaign_name, con.first_name, con.last_name,
c.name, u.email,u.id as user_id,ec.date_sent,
sum(case when email_action_type = '2' then 1 else 0 end) opened,
sum(case when email_action_type = '3' then 1 else 0 end) clicked,
sum(case when email_action_type = '3' and link ilike '%unsubscribe%' then 1 else 0 end) unsubscribed
from email_campaigns ec
left join email_actions ea on ec.id = ea.email_campaign_id
inner join contacts con on ea.contact_id = con.id
left join companies c on con.company_id = c.id
left join users u on ec.created_by = u.id
where c.id = '$company_id'
group by 1,2,3,4,5,6,7 order by date_sent desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}
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
		$start_date_week = date('Y-m-d 00:00:00',strtotime('monday this week'));
		$end_date_week = date('Y-m-d 23:59:59',strtotime('sunday this week'));
		$sql = "select U.name, U.id as user,
				sum(case when action_type_id = '4' AND actioned_at > '$start_date_week' AND actioned_at < '$end_date_week' then 1 else 0 end) introcall,
				sum(case when (action_type_id = '4' or action_type_id = '5')  AND actioned_at > '$start_date_week' AND actioned_at < '$end_date_week' then 1 else 0 end) salescall,
		    	sum(case when (action_type_id = '5' OR action_type_id = '11') AND actioned_at > '$start_date_week' AND actioned_at < '$end_date_week' then 1 else 0 end) callcount,
		   		sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND actioned_at > '$start_date_week' AND actioned_at < '$end_date_week' then 1 else 0 end) meetingcount,
		    	sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND a.created_at > '$start_date_week' AND a.created_at < '$end_date_week' then 1 else 0 end) meetingbooked,
		    	sum(case when (action_type_id = '16') AND a.created_at > '$start_date_week' AND a.created_at < '$end_date_week' then 1 else 0 end) deals,
		    	sum(case when (action_type_id = '8') AND a.created_at > '$start_date_week' AND a.created_at < '$end_date_week' then 1 else 0 end) proposals,
				Sum(CASE WHEN action_type_id = '19' and a.id = 	(SELECT MAX(id) FROM actions z WHERE z.company_id = a.company_id and z.action_type_id = '19' order by a.actioned_at desc) AND (a.comments ilike '%intent%' or a.comments ilike '%qualified%') AND a.created_at > '$start_date_week' AND a.created_at < '$end_date_week' THEN 1 ELSE 0 END) AS pipelinecount
				from actions A LEFT JOIN companies C on A.company_id = C.id INNER JOIN users U on A.user_id = U.id where cancelled_at is null and u.department = 'sales' group by U.id,U.name order by deals desc,proposals desc,meetingbooked desc, introcall desc, name desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}

	}

	function get_last_week_stats(){
		$start_date_week = date('Y-m-d 00:00:00',strtotime('monday last week'));
		$end_date_week = date('Y-m-d 23:59:59',strtotime('sunday last week'));
		$sql = "select U.name, U.id as user,
				sum(case when action_type_id = '4' AND actioned_at > '$start_date_week' AND actioned_at < '$end_date_week' then 1 else 0 end) introcall,
				sum(case when (action_type_id = '4' or action_type_id = '5')  AND actioned_at > '$start_date_week' AND actioned_at < '$end_date_week' then 1 else 0 end) salescall,
		    	sum(case when (action_type_id = '5' OR action_type_id = '11') AND actioned_at > '$start_date_week' AND actioned_at < '$end_date_week' then 1 else 0 end) callcount,
		   		sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND actioned_at > '$start_date_week' AND actioned_at < '$end_date_week' then 1 else 0 end) meetingcount,
		    	sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND a.created_at > '$start_date_week' AND a.created_at < '$end_date_week' then 1 else 0 end) meetingbooked,
		    	sum(case when (action_type_id = '16') AND a.created_at > '$start_date_week' AND a.created_at < '$end_date_week' then 1 else 0 end) deals,
		    	sum(case when (action_type_id = '8') AND a.created_at > '$start_date_week' AND a.created_at < '$end_date_week' then 1 else 0 end) proposals,
				Sum(CASE WHEN action_type_id = '19' and a.id = 	(SELECT MAX(id) FROM actions z WHERE z.company_id = a.company_id and z.action_type_id = '19' order by a.actioned_at desc) AND (a.comments ilike '%intent%' or a.comments ilike '%qualified%') AND a.created_at > '$start_date_week' AND a.created_at < '$end_date_week' THEN 1 ELSE 0 END) AS pipelinecount
				from actions A LEFT JOIN companies C on A.company_id = C.id INNER JOIN users U on A.user_id = U.id where cancelled_at is null and u.department = 'sales' group by U.id,U.name order by deals desc,proposals desc,meetingbooked desc, introcall desc, name desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}

	}


	function get_this_month_stats(){
		$start_date_month = date('Y-m-d 00:00:00',strtotime('first day of this month'));
		$end_date_month = date('Y-m-d 23:59:59',strtotime('last day of this month'));
		$sql = "select U.name, U.id as user,
				sum(case when action_type_id = '4' AND actioned_at > '$start_date_month' AND actioned_at < '$end_date_month' then 1 else 0 end) introcall,
				sum(case when (action_type_id = '4' or action_type_id = '5')  AND actioned_at > '$start_date_month' AND actioned_at < '$end_date_month' then 1 else 0 end) salescall,
		    	sum(case when (action_type_id = '5' OR action_type_id = '11') AND actioned_at > '$start_date_month' AND actioned_at < '$end_date_month' then 1 else 0 end) callcount,
		   		sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND actioned_at > '$start_date_month' AND actioned_at < '$end_date_month' then 1 else 0 end) meetingcount,
		    	sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) meetingbooked,
		    	sum(case when (action_type_id = '16') AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) deals,
		    	sum(case when (action_type_id = '8') AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) proposals,
		    	Sum(CASE WHEN action_type_id = '19' and a.id = 	(SELECT MAX(id) FROM actions z WHERE z.company_id = a.company_id and z.action_type_id = '19' order by a.actioned_at desc) AND (a.comments ilike '%intent%' or a.comments ilike '%qualified%') AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' THEN 1 ELSE 0 END) AS pipelinecount 
				from actions A
				INNER JOIN users U
				on A.user_id = U.id
				LEFT JOIN companies C
				on A.company_id = C.id
				where cancelled_at is null and u.department = 'sales' group by U.name, U.id order by deals desc, meetingbooked desc, introcall desc,  name desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}
	}

	function get_stats_search(){
		$dates = $this->dates();
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		$sql = "select U.name, U.id as user,
				sum(case when action_type_id = '4' AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) introcall,
				sum(case when (action_type_id = '4' or action_type_id = '5')  AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) salescall,
		    	sum(case when (action_type_id = '5' OR action_type_id = '11') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) callcount,
		   		sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) meetingcount,
		    	sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) meetingbooked,
		    	sum(case when (action_type_id = '16') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) deals,
		    	sum(case when (action_type_id = '8') AND a.created_at > '$start_date' AND a.created_at < '$end_date' then 1 else 0 end) proposals,
		    	Sum(CASE WHEN action_type_id = '19' and a.id = 	(SELECT MAX(id) FROM actions z WHERE z.company_id = a.company_id and z.action_type_id = '19' order by a.actioned_at desc) AND (a.comments ilike '%intent%' or a.comments ilike '%qualified%') AND a.created_at > '$start_date' AND a.created_at < '$end_date' THEN 1 ELSE 0 END) AS pipelinecount 
				from actions A
				INNER JOIN users U
				on A.user_id = U.id
				LEFT JOIN companies C
				on A.company_id = C.id
				where cancelled_at is null and u.department = 'sales' group by U.name, U.id order by deals desc, meetingbooked desc, introcall desc,  name desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}
	}

	function get_pipeline_contacted(){
		$dates = $this->dates();
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		if (isset($_GET['start_date'])) {
		$start_date_sql = "AND a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."' ";
		}
		else {
		$start_date = "";}
		$sql = "select
		c.id as company_id,
		a.comments,
		c.name as company_name,
		a.id,
		a.created_at,
		c.pipeline,
		u.name as username
		from companies c
		inner join actions a on
		c.id = a.company_id
		and a.id = 	(
		SELECT MAX(id) 
		FROM actions z 
		WHERE z.company_id = a.company_id and z.action_type_id = '19' 
		order by a.actioned_at desc
		) left join users u on a.created_by = u.id where a.action_type_id = '19' and (a.comments ilike '%intent%' or a.comments ilike '%qualified%') and a.created_at > NOW() - INTERVAL '60 days' $start_date_sql order by a.created_at desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}
	}

	function get_pipeline_contacted_individual($user_id){
		$dates = $this->dates();
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		if (isset($start_date)) {
		$start_date_sql = "AND a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."'";
		}
		$sql = "select
		c.id as company_id,
		a.comments,
		c.name as company_name,
		a.id,
		a.created_at,
		c.pipeline,
		u.name as username
		from companies c
		inner join actions a on
		c.id = a.company_id
		and a.id = 	(
		SELECT MAX(id) 
		FROM actions z 
		WHERE z.company_id = a.company_id and z.action_type_id = '19' 
		order by a.actioned_at desc
		) left join users u on a.created_by = u.id where a.created_by = '$user_id' and a.action_type_id = '19' and (a.comments ilike '%intent%' or a.comments ilike '%qualified%') and a.created_at > NOW() - INTERVAL '60 days' $start_date_sql order by a.created_at desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}
	}

	function get_pipeline_proposal(){
		$dates = $this->dates();
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		if (isset($_GET['start_date'])) {
		$start_date_sql = "AND a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."'";
		}
		$sql = "select
		c.id as company_id,a.comments,c.name as company_name,a.id,a.created_at,c.pipeline,u.name as username from companies c inner join actions a on c.id = a.company_id and a.id = 	(
		SELECT MAX(id) 
		FROM actions z 
		WHERE z.company_id = a.company_id and z.action_type_id = '19' 
		order by a.actioned_at desc
		) left join users u on a.created_by = u.id where a.action_type_id = '19' and (c.pipeline ilike '%proposal%') and a.created_at > NOW() - INTERVAL '60 days' $start_date_sql order by a.created_at desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}
	}

	function get_pipeline_proposal_individual($user_id){
		$dates = $this->dates();
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		if (isset($_GET['start_date'])) {
		$start_date_sql = "AND a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."'";
		}
		$sql = "select
		c.id as company_id,a.comments,c.name as company_name,a.id,a.created_at,c.pipeline,u.name as username from companies c inner join actions a on c.id = a.company_id and a.id = 	(
		SELECT MAX(id) 
		FROM actions z 
		WHERE z.company_id = a.company_id and z.action_type_id = '19' 
		order by a.actioned_at desc
		) left join users u on a.created_by = u.id where a.created_by = '$user_id' and a.action_type_id = '19' and (c.pipeline ilike '%proposal%') and a.created_at > NOW() - INTERVAL '60 days' $start_date_sql order by a.created_at desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}
	}

	function get_pipeline_customer(){
		$dates = $this->dates();
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		if (isset($start_date)) {
		$start_date_sql = "AND a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."'";
		}
		$sql = "select c.id as company_id, a.comments, c.name as company_name, a.id, a.created_at, c.pipeline, u.name as username
		from companies c
		inner join actions a on
		c.id = a.company_id
		and a.id = 	(
		SELECT MAX(id) 
		FROM actions z 
		WHERE z.company_id = a.company_id and z.action_type_id = '16' 
		order by a.actioned_at desc
		) left join users u on a.created_by = u.id where a.action_type_id = '16'   $start_date_sql order by a.created_at desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}
	}

	function get_pipeline_customer_individual($user_id){
		$dates = $this->dates();
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		if (isset($start_date)) {
		$start_date_sql = "AND a.created_at > '".date('Y-m-d 00:00:00',strtotime($start_date))."'  AND a.created_at < '".date('Y-m-d 23:59:59',strtotime($end_date))."'";
		}
		$sql = "select
		c.id as company_id,
		a.comments,
		c.name as company_name,
		a.id,
		a.created_at,
		c.pipeline,
		u.name as username
		from companies c
		inner join actions a on
		c.id = a.company_id
		and a.id = 	(
		SELECT MAX(id) 
		FROM actions z 
		WHERE z.company_id = a.company_id and z.action_type_id = '16' 
		order by a.actioned_at desc
		) left join users u on a.created_by = u.id where a.created_by = '$user_id' and a.action_type_id = '16' and (c.pipeline ilike '%customer%') $start_date_sql order by a.created_at desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}
	}

	function get_pipeline_lost(){

		$dates = $this->dates();
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		$sql = "select
		c.id as company_id,
		a.comments,
		c.name as company_name,
		a.id,
		a.created_at,
		c.pipeline,
		u.name as username
		from companies c
		inner join actions a on
		c.id = a.company_id
		and a.id = 	(
		SELECT MAX(id) 
		FROM actions z 
		WHERE z.company_id = a.company_id and z.action_type_id = '19' 
		order by a.actioned_at desc
		) left join users u on a.created_by = u.id where a.action_type_id = '19' and (c.pipeline ilike '%lost%') AND a.created_at > '$start_date' AND a.created_at < '$end_date' and a.created_at > NOW() - INTERVAL '60 days' order by a.created_at desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}
	}

	function get_pipeline_lost_individual($user_id){
		$dates = $this->dates();
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		$sql = "select
		c.id as company_id,
		a.comments,
		c.name as company_name,
		a.id,
		a.created_at,
		c.pipeline,
		u.name as username
		from companies c
		inner join actions a on
		c.id = a.company_id
		and a.id = 	(
		SELECT MAX(id) 
		FROM actions z 
		WHERE z.company_id = a.company_id and z.action_type_id = '19' 
		order by a.actioned_at desc
		) left join users u on a.created_by = u.id where a.created_by = '$user_id' and a.action_type_id = '19' and (c.pipeline ilike '%lost%') AND a.created_at > '$start_date' AND a.created_at < '$end_date'order by a.created_at desc";
		$query = $this->db->query($sql);

		if($query){
			return $query->result_array();
		}else{
			return [];
		}
	}

	function get_user_placements(){
		$dates = $this->dates();
		$search_user_id = $dates['search_user_id'];
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		if (!empty($search_user_id)) {
			 $sql = "select distinct c.name, a.actioned_at, c.id, u.name as username from companies c 
			 inner join actions a on c.id = a.company_id
			 left join users u on a.created_by = u.id where a.action_type_id = '16' and a.created_by = '$search_user_id' AND a.created_at > '$start_date' AND a.created_at < '$end_date' order by a.actioned_at asc";
			$query = $this->db->query($sql);
			if($query){
				return $query->result_array();
			}else{
				return [];
			}
		}
	}
		function get_user_proposals(){
		$dates = $this->dates();
		$search_user_id = $dates['search_user_id'];
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		if (!empty($search_user_id)) {
		  	$sql = "select distinct c.name, a.created_at, c.id from companies c inner join actions a on c.id = a.company_id where a.action_type_id = '8' and a.created_by = '$search_user_id' AND a.created_at > '$start_date' AND a.created_at < '$end_date' order by a.created_at asc";
			$query = $this->db->query($sql);
			if($query){
				return $query->result_array();
			}else{
				return [];
			}
		}
	}

	function dates(){
		$period = $_GET['period'];
		if (!empty($_GET['start_date'])) {
		$start_date = date('Y-m-d 00:00:00',strtotime($_GET['start_date']));
			
			if (!empty($_GET['end_date'])) {
		$end_date = date('Y-m-d 00:00:00',strtotime($_GET['end_date']));
		

		} else {

					$end_date = date('Y-m-d 23:59:59',strtotime('last day of this month'));

		}

		}
		else if ($period==='week') {
		$start_date = date('Y-m-d 00:00:00',strtotime('monday this week'));
		$end_date = date('Y-m-d 23:59:59',strtotime('sunday this week'));
		}
		else
		{
		$start_date = date('Y-m-d 00:00:00',strtotime('first day of this month'));
		$end_date = date('Y-m-d 23:59:59',strtotime('last day of this month'));
		}
				return array('search_user_id' => $_GET['user'], 'start_date' => $start_date, 'end_date' => $end_date);

	}

		function get_user_meetings(){
		$dates = $this->dates();
		$search_user_id = $dates['search_user_id'];
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		if (!empty($search_user_id)) {
		$sql = "select distinct c.name, a.created_at,c.id, sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND actioned_at > '$start_date' AND actioned_at < '$end_date' then 1 else 0 end) meeting_actioned from companies c inner join actions a on c.id = a.company_id where (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') and a.created_by = '$search_user_id' AND (a.created_at > '$start_date' or a.actioned_at > '$start_date') AND (a.created_at < '$end_date' or a.actioned_at < '$end_date') group by c.name, a.created_at, c.id order by a.created_at asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	}

		function get_user_pitches(){
		$dates = $this->dates();
		$search_user_id = $dates['search_user_id'];
		$start_date = $dates['start_date'];
		$end_date = $dates['end_date'];
		if (!empty($search_user_id)) {
		$sql = "select distinct c.name, a.actioned_at, c.id from companies c inner join actions a on c.id = a.company_id where a.action_type_id = '4' and a.created_by = '$search_user_id' AND a.actioned_at > '$start_date' AND a.actioned_at < '$end_date' order by a.actioned_at asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
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
		$ignore = array('19','7','20'); //EXCLUDE PIPELINE TRACKING, COMMENT AND MARKETING//
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
		//TEST - COMPLETED ACTION ONLY
			$completeddata = array(
			'company_id' 	=> $post['company_id'],
			'user_id' 		=> $post['user_id'],
			'comments'		=> (isset($post['comment'])?$post['comment']:NULL),
			'planned_at'	=> NULL,
			'window'		=> (isset($post['window'])?$post['window']:NULL),
			'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
			'created_by'	=> $post['user_id'],
			'action_type_id'=> (isset($post['action_type_completed'])?$post['action_type_completed']:$post['action_type']),
			'actioned_at'	=> date('Y-m-d H:i:s'),
			'created_at' 	=> date('Y-m-d H:i:s'),
			);
		$query = $this->db->insert('actions', $completeddata);
		//END TEST

		if ($post['action_type_planned']>0) {

			$planneddata = array(
			'company_id' 	=> $post['company_id'],
			'user_id' 		=> $post['user_id'],
			'comments'		=> (isset($post['comment'])?$post['comment']:NULL),
			'planned_at'	=> $post['planned_at'],
			'window'		=> (isset($post['window'])?$post['window']:NULL),

			'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
			'created_by'	=> $post['user_id'],
			'action_type_id'=> $post['action_type_planned'],
			'actioned_at'	=> NULL,
			'created_at' 	=> date('Y-m-d H:i:s'),
			);
		$query = $this->db->insert('actions', $planneddata);


		}




		$data = array(
			'company_id' 	=> $post['company_id'],
			'user_id' 		=> $post['user_id'],
			'comments'		=> (isset($post['comment'])?$post['comment']:NULL),
			'planned_at'	=> (isset($post['planned_at'])? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
			'window'		=> (isset($post['window'])?$post['window']:NULL),
			'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
			'created_by'	=> $post['user_id'],
			'action_type_id'=> $post['action_type'],
			'actioned_at'	=> (!isset($post['actioned_at']) && !isset($post['planned_at'])?date('Y-m-d H:i:s'):NULL),
			'created_at' 	=> date('Y-m-d H:i:s')
			);

		if ($post['action_type']=='16') {
			$id = $post['company_id'];
			$pipelinedata = array('pipeline' => "Customer");

		$this->db->where('id', $id);
		$this->db->update('companies', $pipelinedata); 

		$actiondata = array(
			'company_id' 	=> $post['company_id'],
			'user_id' 		=> $post['user_id'],
			'comments'		=> 'Pipeline changed to Customer',
			'planned_at'	=> (isset($post['planned_at'])? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
			'window'		=> (isset($post['window'])?$post['window']:NULL),
			'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
			'created_by'	=> $post['user_id'],
			'action_type_id'=> '19',
			'actioned_at'	=> (!isset($post['actioned_at']) && !isset($post['planned_at'])?date('Y-m-d H:i:s'):NULL),
			'created_at' 	=> date('Y-m-d H:i:s'),
			);
		$query = $this->db->insert('actions', $actiondata);


	}
			else if ($post['action_type']=='8') {
			$id = $post['company_id'];
			$pipelinedata = array(
               'pipeline' => "Proposal"
            );

		$this->db->where('id', $id);
		$this->db->update('companies', $pipelinedata); 

			$actiondata = array(
			'company_id' 	=> $post['company_id'],
			'user_id' 		=> $post['user_id'],
			'comments'		=> 'Pipeline changed to Proposal',
			'planned_at'	=> (isset($post['planned_at'])? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
			'window'		=> (isset($post['window'])?$post['window']:NULL),
			'contact_id'    => (!empty($post['contact_id'])?$post['contact_id']:NULL),
			'created_by'	=> $post['user_id'],
			'action_type_id'=> '19',
			'actioned_at'	=> (!isset($post['actioned_at']) && !isset($post['planned_at'])?date('Y-m-d H:i:s'):NULL),
			'created_at' 	=> date('Y-m-d H:i:s'),
			);
		//$query = $this->db->insert('actions', $actiondata);
	}

	//	$query = $this->db->insert('actions', $completeddata);
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