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
		$this->db->select('c.name,c.id,c.user_id,u.name as searchcreatedby,u.image,c.shared');
		$this->db->from('campaigns c');
		$this->db->join('users u', 'c.user_id = u.id');
		// Apply this to find saved searches only
		$this->db->where('criteria IS NULL', null, false);
		$this->db->where('shared', 'True');
		$this->db->where_not_in('user_id', $user_id);
		$this->db->where('status', 'search');
		$this->db->order_by("c.name", "asc");
		$this->db->where("(c.eff_to IS NULL OR c.eff_to > '".date('Y-m-d')."')",null, false); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_private_campaigns($user_id)
	{
		$this->db->select('name,id,user_id,shared');
		$this->db->from('campaigns');
		// Apply this to find saved searches only
		$this->db->where('criteria IS NULL', null, false);
		$this->db->where('user_id', $user_id);
		$this->db->where('status', 'search');
		$this->db->where("(eff_to IS NULL OR eff_to > '".date('Y-m-d')."')",null, false);
		$this->db->order_by("name", "asc"); 
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
		// filter by name
		if (isset($post['agency_name']) && strlen($post['agency_name'])) 
		{
			$company_name_sql = "select id from companies  where name ilike '%".$post['agency_name']."%'"; 
			
		}

		// COMPANY AGE
		
		if($post['company_age_from'] >= 0  )
		{
			$company_age_from = date("m-d-Y", strtotime("-".$post['company_age_from']." year"));
			
		}
		if(!empty($post['company_age_to'])  )
		{
			$company_age_to = date("m-d-Y", strtotime("-".$post['company_age_to']." year"));
			
		}
		if(isset($company_age_from) && isset($company_age_to)) 
		{
			$company_age_sql = 'select id from companies  where companies.eff_from between \''.$company_age_to.'\'  and  \''.$company_age_from.'\' ';
		}
		

		
		// TURNOVER

		//REMOVE COMMA ETC FROM TURNOVER

		$turnover_from = preg_replace('/[^0-9]/','',$post['turnover_from']);
		$turnover_to = preg_replace('/[^0-9]/','',$post['turnover_to']);


		if(empty($turnover_to) && !empty($turnover_from))
		{
			$turnover_to = '100000000';
		}
	

		
		if( (isset($turnover_from) && strlen($turnover_from) > 0) && (strlen($turnover_to) > 0 && isset($turnover_to)) ) 
		{	
				if($post['turnover_from'] == 0)
				{
					$turnover_sql = 'select T.company_id "company_id",
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
									and T.turnover = NULL or  T.turnover < '.$turnover_to.'
			  
			  						';
				}
				else
				{
					$turnover_sql = 'select T.company_id "company_id",
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
									and  T.turnover between '.$turnover_from.'  and '.$turnover_to.'  ';
				}
				
		}
		
		
		
		// EMP COUNT
		// if((isset($post['employees_to']) and !empty($post['employees_to'])) and (isset($post['employees_from']) and !empty($post['employees_from'])) ) 
		// {
		// 	$emp_count_sql = 'select company_id  from emp_counts where count > '.$post['employees_from'].'  and turnover < '.$post['employees_to'].'  ';
		// }

		// MORTGAGE
		// if (!empty($post['mortgage_to']) && !empty($post['mortgage_from']))
		// {
		// 	$mortgage_sql = 'select company_id  from mortgages where mortgages.stage = \''.MORTGAGES_OUTSTANDING.'\' and EXTRACT (doy from mortgages.eff_from) - EXTRACT (doy from now()) BETWEEN '.$post['mortgage_from'].' AND '.$post['mortgage_to'].'  ';
		// }

		// SECTORS

		if( isset($post['sectors']) && !empty($post['sectors']) && $post['sectors'] !== '0' )
		{	
			if ($post['sectors'] < 0)
			{
				$sectors_sql = 'select operates.company_id from operates where operates.active = True and operates.sector_id = NULL ';
			}
			else
			{	$sectors = $post['sectors'];
				if(is_array($sectors))
				{
					$sectors_sql = 'select operates.company_id from operates where operates.active = True and operates.sector_id in ('.implode(', ', $post['sectors']).')';
				}
				else
				{
					$sectors_sql = 'select operates.company_id from operates where operates.active = True and operates.sector_id = '.$post['sectors'].' ';
				}
				
			}
			
		}

		// Providers
		if(isset($post['providers']) && (!empty($post['providers'])) )
		{
			if($post['providers'] < 0)
			{
				$no_providers_sql = 'select distinct(companies.id )from companies left join (select company_id from mortgages where mortgages.stage = \''.MORTGAGES_OUTSTANDING.'\') t on t.company_id = companies.id where t.company_id  is NULL';
			}
			else
			{
				$providers_sql = 'select mortgages.company_id "company_id" from providers join mortgages on  providers.id = mortgages.provider_id	where mortgages.stage = \''.MORTGAGES_OUTSTANDING.'\' and providers.id = '.$post['providers'];
			}
			
		}

		// assigned
		if(isset($post['assigned']) && (!empty($post['assigned'])) && ($post['assigned'] > 0 ))
		{	
			$assigned_sql = 'select id from companies where user_id = '.$post['assigned'].'';
		}
		else if (isset($post['assigned']) && (!empty($post['assigned'])) && ($post['assigned'] =='-1'))
		{
			$assigned_sql = 'select id from companies where user_id is Null';
		}
		
		// segment
		if(isset($post['class']) && (!empty($post['class'])) && ($post['class'] !== ''))
		{	
			$class_sql = "select id from companies where class = '".$post['class']."'";

		}

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
			   U.id "owner_id",
		       row_to_json((
		       C.id, -- f1
		       C.name, -- f2
		       C.url, -- f3
			   to_char(C.eff_from, \'dd/mm/yyyy\'), -- f4
			   C.ddlink, -- f5
			   C.linkedin_id, -- f6
			   U.name, -- f7
			   U.id , -- f8
			   A.address, --f9
			   C.contract, --f10
			   C.perm, -- f11
			   C.active, -- f12
			   C.created_at, -- f13
			   C.updated_at, -- f14
			   C.created_by,-- f15
			   C.updated_by,-- f16
			   C.registration, -- f17
		       TT1."turnover", -- f18
			   TT1."turnover_method",  -- f19
			   EMP.count,--f20
			   U.image , -- f21
			   C.class, -- f22
			   A.lat, -- f23
			   A.lng, -- f24
			   json_agg( 
			   row_to_json ((
			   TT2."sector_id", TT2."sector"))),-- f25
			   C.phone, 
			   C.pipeline,
			   CONT.contacts_count)) "JSON output" 
			   


		from (select * from COMPANIES where eff_to IS NULL) C ';
		
		$sql = $sql.' JOIN ( select company_id from targets where campaign_id = '.$campaign_id.' ) company ON C.id = company.company_id';
		// if(isset($company_name_sql)) $sql = $sql. ' JOIN ( '.$company_name_sql.' ) name ON C.id = name.id ';
		// if(isset($no_providers_sql)) $sql = $sql. ' JOIN ( '.$no_providers_sql.' ) companies on C.id = companies.id ';
		// if(isset($company_age_sql)) $sql =  $sql.' JOIN ( '.$company_age_sql.' ) company_age ON C.id = company_age.id ';
		// if(isset($turnover_sql)) $sql = $sql.' JOIN ( '.$turnover_sql.' ) turnovers ON C.id = turnovers.company_id';
		// if(isset($mortgage_sql)) $sql = $sql.' JOIN ( '.$mortgage_sql.' ) mortgages ON C.id = mortgages.company_id';
		// if(isset($sectors_sql)) $sql = $sql.' JOIN ( '.$sectors_sql.' ) sectors ON C.id = sectors.company_id';
		// if(isset($providers_sql)) $sql = $sql.' JOIN ( '.$providers_sql.' ) providers ON C.id = providers.company_id';
		// if(isset($assigned_sql)) $sql = $sql.' JOIN ( '.$assigned_sql.' ) assigned ON C.id = assigned.id';
		// if(isset($class_sql)) $sql = $sql.' JOIN ( '.$class_sql.' ) segment ON C.id = segment.id';
		// if(isset($company_id) && $company_id !== False) $sql = $sql.' JOIN ( select id from companies where id = '.$company_id.' ) company ON C.id = company.id';
		
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

		LEFT JOIN 
		(
			SELECT count,company_id FROM "emp_counts"  ORDER BY "emp_counts"."id" DESC limit 1
		) EMP ON EMP.company_id = C.id

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
			     C.ddlink,
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
			     U.id,
			     U.name,
			     A.address,
			     A.lat,
			     A.lng,
		         TT1."turnover",
			     TT1."turnover_method",
			     EMP.count,
			     CONT.contacts_count

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
		order by T1.owner_id,lower(T1.name) 
		 
		) results';
		// print_r($sql);
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function get_saved_searched_by_id($id)
	{
		$this->db->select('name,id,criteria,shared,user_id');
		$this->db->from('campaigns');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result();
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

}