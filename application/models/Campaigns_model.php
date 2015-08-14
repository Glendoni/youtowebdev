<?php
class Campaigns_model extends MY_Model {
	

	// GETS
	function get_all_shared_searches($user_id)
	{
		$this->db->select('c.name,c.id,c.user_id,u.name as searchcreatedby,u.image,c.shared');
		$this->db->from('campaigns c');
		$this->db->join('users u', 'c.user_id = u.id');
		// Apply this to find saved searches only
		$this->db->where('criteria IS NOT NULL', null, false);
		$this->db->where('shared', 'True');
		$this->db->where_not_in('user_id', $user_id);
		$this->db->where('status', 'search');
		$this->db->order_by("c.name", "asc");
		$this->db->where("(c.eff_to IS NULL OR c.eff_to > '".date('Y-m-d')."')",null, false); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_private_searches($user_id)
	{
		$this->db->select('name,id,user_id,shared');
		$this->db->from('campaigns');
		// Apply this to find saved searches only
		$this->db->where('criteria IS NOT NULL', null, false);
		$this->db->where('user_id', $user_id);
		$this->db->where('status', 'search');
		$this->db->where("(eff_to IS NULL OR eff_to > '".date('Y-m-d')."')",null, false);
		$this->db->order_by("name", "asc"); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_shared_campaigns($user_id)
	{
		$this->db->select('c.name,c.id,c.user_id,u.name as searchcreatedby,u.image,c.shared,count(t.*) as campaigncount');
		$this->db->from('campaigns c');
		$this->db->join('users u', 'c.user_id = u.id');
		$this->db->join('targets t', 'c.id = t.campaign_id');

		// Apply this to find saved searches only
		$this->db->where('criteria IS NULL', null, false);
		$this->db->where('shared', 'True');
		$this->db->where_not_in('user_id', $user_id);
		$this->db->order_by("c.created_at", "desc");
		$this->db->where("(c.eff_to IS NULL OR c.eff_to > '".date('Y-m-d')."')",null, false); 
				$this->db->group_by("1,2,3,4,5"); 

		$query = $this->db->get();
		return $query->result();
	}

		function get_all_private_campaigns($user_id)
	{
		$this->db->select('c.name,c.id,c.user_id,c.shared,count(t.*) as campaigncount');
		$this->db->from('campaigns c');
		$this->db->join('targets t', 'c.id = t.campaign_id');
		// Apply this to find saved searches only
		$this->db->where('c.criteria IS NULL', null, false);
		$this->db->where('c.user_id', $user_id);
		$this->db->where("(c.eff_to IS NULL OR c.eff_to > '".date('Y-m-d')."')",null, false);
		$this->db->group_by("1,2,3"); 
		$this->db->order_by("c.created_at", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_campaigns_for_user($user_id)
	{
		$this->db->select('name,id,user_id');
		$this->db->from('campaigns');
		// Apply this to find campaigns
		$this->db->where('criteria IS NULL', null, false);
		$this->db->where('user_id', $user_id);
		$this->db->order_by("name", "asc"); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_campaign_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('campaigns');
		$this->db->where('campaigns.criteria IS NULL', null, false);
		$this->db->where('campaigns.id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_companies_for_campaign_id($campaign_id)
	{	

		// -- Data to Display a Company's details
		// IMPORTANT if you change/add colums on the following query then change the mapping array on the companies controller
		$sql = 'select json_agg(results)
		from (

		select row_to_json((
		       T1."JSON output",
		       T2."JSON output"
		       )) "company"
		from 
		(-- T1
		select C.id,
			   C.name,
			   C.pipeline,
			   U.id "owner_id",
		       row_to_json((
		       C.id, -- f1
		       C.name, -- f2
		       C.url, -- f3
			   to_char(C.eff_from, \'dd/mm/yyyy\'), -- f4
			   C.linkedin_id, -- f5
			   U.name, -- f6
			   U.id , -- f7
			   A.address, --f8
			   C.contract, --f9
			   C.perm, -- f10
			   C.active, -- f11
			   C.created_at, -- f12
			   C.updated_at, -- f13
			   C.created_by,-- f14
			   C.updated_by,-- f15
			   C.registration, -- f16
		       TT1."turnover", -- f17
			   TT1."turnover_method",  -- f18
			   EMP.count,--f19
			   U.image , -- f20
			   C.class, -- f21
			   A.lat, -- f22
			   A.lng, -- f23
			   json_agg( 
			   row_to_json ((
			   TT2."sector_id", TT2."sector"))),-- f24
			   C.phone, -- f25 
			   C.pipeline, -- f26
			   CONT.contacts_count, -- f27
			   C.parent_registration, --f28
			   C.zendesk_id, -- f29
			   C.customer_from -- f30

			   )) "JSON output" 
			   


		from (select * from COMPANIES where eff_to IS NULL) C ';
		
		$sql = $sql.' JOIN ( select company_id from targets where campaign_id = '.$campaign_id.' ) company ON C.id = company.company_id';
		$sql = $sql.' LEFT JOIN 
		(-- TT1 
		select T.company_id "company id",
		       T.turnover "turnover",
		       T.method "turnover_method"       
		from 
		(-- T1
		select id "id",
		       company_id,
		       max(eff_from) OVER (PARTITION BY company_id) "max eff date"
		from TURNOVERS
		)   T1
		  
		JOIN TURNOVERS T
		ON T1.id = T.id
		  
		where T1."max eff date" = T.eff_from
		  
		  
		)   TT1
		ON TT1."company id" = C.id 

		LEFT JOIN
		(
			SELECT count(*) as "contacts_count",company_id FROM "contacts" group by contacts.company_id
		) CONT ON CONT.company_id = C.id

		LEFT JOIN
		(-- TT2
		select O.company_id "company id",
		       S.id "sector_id",
		       S.name "sector"       
		from OPERATES O

		JOIN SECTORS S
		ON O.sector_id = S.id
		where O.active = \'TRUE\'
		)   TT2
		ON TT2."company id" = C.id




        left join 
        (select count, company_id from emp_counts ORDER BY "emp_counts"."created_at" DESC limit 1)
        EMP ON EMP.company_id = C.id



		LEFT JOIN 
		ADDRESSES A
		ON A.company_id = C.id

		LEFT JOIN
		USERS U
		ON U.id = C.user_id
				 
		group by C.id,
		         C.name,
		         C.url,
			     C.eff_from,
			     C.linkedin_id,
			     C.contract,
			     C.perm,
			     C.active,
			     C.created_at,
			     C.updated_at,
			     C.created_by,
			     C.updated_by,
			     C.registration,
			     C.class,
			     C.phone,
			     C.pipeline,
			     C.parent_registration,	
			     U.id,
			     U.name,
			     A.address,
			     A.lat,
			     A.lng,
		         TT1."turnover",
			     TT1."turnover_method",
			     EMP.count,
			     CONT.contacts_count,
			     C.zendesk_id,
			     C.customer_from

		order by C.id 


		)   T1

		LEFT JOIN

		(-- T2
		select T."company id",
		       json_agg(
			   row_to_json(
			   row (T."mortgage id", T."mortgage provider", T."mortgage stage", T."mortgage start", T."mortgage end", T."mortgage type"))) "JSON output"  -- f11
				 
		from 
		(-- T
		select M.company_id "company id",
		       M.id "mortgage id",
		       P.name "mortgage provider",
		       M.stage "mortgage stage",
		       to_char(M.eff_from, \'dd/mm/yyyy\')  "mortgage start",
		       to_char(M.eff_to, \'dd/mm/yyyy\')  "mortgage end",
		       M.type "mortgage type"

		from MORTGAGES M
		  
		JOIN PROVIDERS P
		ON M.provider_id = P.id 

		order by 1, 4, M.eff_from desc

		)   T

		group by T."company id"	

		order by T."company id"

		)   T2
		ON T1.id = T2."company id"
		-- insert this for sort order  
		order by case when pipeline = \'Customer\' then 1
		when pipeline = \'Proposal\' then 2
		when pipeline = \'Intent\' then 3
		when pipeline = \'Qualified\' then 4
		when pipeline = \'Lost\' then 8
		else 5
		end, name asc
		 
		) results';
		// print_r($sql);
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_saved_searched_by_id($id)
	{
	$sql = "select U.name, U.id as user, U.image,
				sum(case when action_type_id = '4' AND actioned_at > '$start_date_month' AND actioned_at < '$end_date_month' then 1 else 0 end) introcall,
				sum(case when (action_type_id = '4' or action_type_id = '5' or action_type_id = '11' or action_type_id = '17')  AND actioned_at > '$start_date_month' AND actioned_at < '$end_date_month' then 1 else 0 end) salescall,
		    	sum(case when (action_type_id = '5' OR action_type_id = '11') AND actioned_at > '$start_date_month' AND actioned_at < '$end_date_month' then 1 else 0 end) callcount,
		   		sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND actioned_at > '$start_date_month' AND actioned_at < '$end_date_month' then 1 else 0 end) meetingcount,
		    	sum(case when (action_type_id = '12' or action_type_id = '10' or action_type_id = '9' or action_type_id = '15') AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) meetingbooked,
		    	sum(case when (action_type_id = '16') AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) deals,
		    	sum(case when (action_type_id = '8') AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) proposals,
		    	sum(case when action_type_id = '25' AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) duediligence,
		    	sum(case when action_type_id = '22' AND a.created_at > '$start_date_month' AND a.created_at < '$end_date_month' then 1 else 0 end) key_review_added,
		    	sum(case when action_type_id = '22' AND a.planned_at > '$start_date_month' AND a.planned_at < '$end_date_month' then 1 else 0 end) key_review_occuring,
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
	// UPDATES

	function update_campaign_make_public($id,$user_id)
	{
		$this->db->where('id', $id);
		$this->db->update('campaigns', array('shared'=>'True','updated_by'=>$user_id));
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
		} 
	}

	function update_campaign_make_private($id,$user_id)
	{
		$data = array(
			'shared' => 'False',
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $user_id,
			);

		$this->db->where('id', $id);
		$this->db->update('campaigns',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
		} 
	}

	// INSERTS
	function save_search($name,$shared,$user_id,$post) 
	{	
		$data['name'] = $name;	
		$data['user_id'] = $user_id;
		$data['campaign_user_id'] = $user_id;
		$data['criteria'] =  serialize($post);
		$data['shared'] = $shared;
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['eff_from'] = date('Y-m-d');
		$data['created_by'] = $user_id;

		$this->db->insert('campaigns',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			//return user if insert was successful 
			$compaign_id = $this->db->insert_id();
			return $compaign_id;
		}
	}

	function add_company_to_campaign($new_campaign_id,$company_id,$user_id)
	{
		$data['campaign_id'] = $new_campaign_id;
		$data['company_id'] = $company_id;
		$data['created_by'] = $user_id;
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert('targets',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			//return user if insert was successful 
			$target_id = $this->db->insert_id();
			return $target_id;
		}
	}

	function create_campaign($name,$shared,$user_id) 
	{	
		$data['name'] = $name;	
		$data['user_id'] = $user_id;
		$data['campaign_user_id'] = $user_id;
		$data['shared'] = $shared;
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['eff_from'] = date('Y-m-d');
		$data['created_by'] = $user_id;

		$this->db->insert('campaigns',$data);
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

		function get_campaigns($company_id)
	{
		$this->db->select('campaigns.id,campaigns.name as "campaign_name", users.name, campaigns.created_at');
		$this->db->join('campaigns', 'campaigns.id = targets.campaign_id', 'left');
		$this->db->join('users', 'users.id = targets.created_by', 'left');
		$this->db->where('eff_to', NULL);
		$this->db->order_by('campaigns.created_at', 'desc'); 
		$query = $this->db->get_where('targets',array('company_id'=>$company_id));	
		return $query->result();
	}

function get_campaign_pipeline($id)
	{
	$sql = "select 
				sum(case when company_id in (select id from companies where pipeline = 'Prospect') then 1 else 0 end) campaign_prospects,
				sum(case when company_id in (select id from companies where pipeline = 'Intent') then 1 else 0 end) campaign_intent,
				sum(case when company_id in (select id from companies where pipeline = 'Customer') then 1 else 0 end) campaign_customers,
				sum(case when company_id in (select id from companies where pipeline = 'Lost') then 1 else 0 end) campaign_lost,
				sum(case when company_id in (select id from companies where pipeline = 'Proposal') then 1 else 0 end) campaign_proposals
				from targets T
				INNER JOIN campaigns CP
				on T.campaign_id = CP.id
				where CP.id = $id limit 1";
		$query = $this->db->query($sql);
		    return $query->result(); /* returns an object */
}

}