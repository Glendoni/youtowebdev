<?php
class Companies_model extends CI_Model {
	
	function get_all()
	{
		$query = $this->db->get('companies');	
		return $query->result();
	}

	function get_company_by_name($name)
	{
		$query = $this->db->get_where('companies',array('name'=>$name));	
		return $query->result();
	}

	function get_company_by_registration($registration)
	{
		$query = $this->db->get_where('companies',array('registration'=>$registration));	
		return $query->result();
	}

	function get_companies_classes()
	{
		$arrayNames = array(
			'PreStartUp' => 'Pre-Start Up',
			'StartUp' => 'Start Up',
			'UsingFinance' => 'Using Finance',
			'PermOnly' => 'Perm Only',
			'OccasionalContract' => 'Perm - Occasional Placements',
			'LookingToPlaceContractors' => 'Perm - Looking to Build Contract Business',
			'SelfFunding' => 'Self-Funding'
			);
		return 	$arrayNames;
	}

	function get_companies_pipeline()
	{
		$arrayNamesPipeline = array(
			'Prospect' => 'Prospect',
			'Intent' => 'Intent',
			'Qualified' => 'Qualified',
			'Proposal' => 'Proposal',
			'Unsuitable' => 'Unsuitable',
			'Lost' => 'Lost'
			);
		return 	$arrayNamesPipeline;
	}

		function get_address_types()
	{
		$arrayAddressTypes = array(
			'Registered Address' => 'Registered Address',
			'Trading Address' => 'Trading Address'
			);
		return 	$arrayAddressTypes;
	}

		function get_companies_pipeline_search()
	{
		$arrayNamesPipelineSearch = array(
			'Prospect' => 'Prospect',
			'Intent' => 'Intent',
			'Qualified' => 'Qualified',
			'Proposal' => 'Proposal',
			'Customer' => 'Customer',
			'Unsuitable' => 'Unsuitable',
			'Lost' => 'Lost'
			);
		return 	$arrayNamesPipelineSearch;
	}

	// not in use
	// function get_company_by_id($id)
	// {

	// 	$this->db->select('companies.*,addresses.address');
	// 	$this->db->from('companies');
	// 	$this->db->join('addresses','addresses.company_id = companies.id','left');
	// 	$this->db->join('operates','operates.company_id = companies.id AND operates.active = True','left');
	// 	$this->db->join('sectors','sectors.id = operates.sector_id','left');
		
	// 	$this->db->where('companies.id', $id);
	// 	$this->db->where('companies.active', 'True');
	// 	$this->db->group_by('companies.id,addresses.address');
	// 	$this->db->order_by("companies.name", "asc");


	// 	// Employee count
	// 	$this->db->select('(SELECT "count" FROM "emp_counts" WHERE "emp_counts"."company_id" = "companies"."id" ORDER BY "emp_counts"."created_at" DESC LIMIT 1) as emp_count', FALSE, FALSE);

	// 	// Sectors the company is in 
	// 	$this->db->select("(SELECT string_agg(S.name, ',') FROM sectors S,operates O WHERE O.company_id = companies.id AND S.id = O.sector_id  AND O.active = 'True') as company_sectors", FALSE, FALSE);
	// 	$this->db->select("(SELECT array_to_string(array_agg(S.id), ',')  FROM sectors S,operates O WHERE O.company_id = companies.id AND S.id = O.sector_id  AND O.active = 'True'  ) as company_sectors_ids", FALSE, FALSE);
	// 	// Linkedin connectioins ( need improvement , can be done once a month to another table)
	// 	$this->db->select("(SELECT count(*) FROM connections C,employees E WHERE E.company_id = companies.id AND C.employee_id = E.id ) as company_connections", FALSE, FALSE);

	// 	// Assign to
	// 	$this->db->select("(SELECT Ad.name FROM users Ad WHERE Ad.id = companies.user_id ) as company_assigned_to", FALSE, FALSE);
	// 	$this->db->select("(SELECT Ad.image FROM users Ad WHERE Ad.id = companies.user_id ) as company_assigned_to_image", FALSE, FALSE);
	// 	$this->db->select("(SELECT Ad.id FROM users Ad WHERE Ad.id = companies.user_id ) as company_assigned_to_id", FALSE, FALSE);


	// 	// Build query 
	// 	$query = $this->db->get();
	// 	print $query;
	// 	die;
	// 	// Run query  
	// 	$query->result();

	// 	// Place query result into variable
	// 	$companies = $query;

	// 	foreach ($companies->result_object as $key => $company) {
	// 		// Select fields 
	// 		$this->db->select("to_char(mortgages.eff_from, 'DD/Mon/YYYY') AS eff_from , providers.name, mortgages.stage ",FALSE);
	// 		$this->db->from('mortgages');
	// 		$this->db->where('mortgages.company_id',$company->id);
	// 		$this->db->join('providers','providers.id = mortgages.provider_id','left');
	// 		$this->db->group_by(array('providers.name', 'mortgages.stage' , 'mortgages.eff_from'));
	// 		$this->db->order_by('mortgages.eff_from');
	// 		$mortgages = $this->db->get(); 


	// 		// Get result as array 
	// 		$mortgages2 = $mortgages->result_array();

	// 		// Place the result array on the current object
	// 		$companies->result_object[$key]->mortgages = $mortgages2;

	// 		$this->db->select('turnovers.turnover');
	// 		$this->db->from('turnovers');
	// 		$this->db->where('turnovers.company_id',$company->id);
	// 		$this->db->order_by('turnovers.eff_from','desc');
	// 		$this->db->limit(1);
	// 		$turnovers = $this->db->get(); 
	// 		$turnovers_array = $turnovers->result_array();

	// 		$companies->result_object[$key]->turnover = $turnovers_array[0]['turnover'];

	// 	}

	// 	return $companies;
	// }

	function get_last_imported(){
		$this->db->select('companies.name,companies.id');
		$this->db->from('companies');
		$this->db->where('created_at >'," (CURRENT_DATE - INTERVAL '30 days') ", FALSE);
		$this->db->limit(10);
		$query = $this->db->get();
		return $query->result();
	}

	function last_updated_companies(){
		$this->db->select('companies.name,companies.id');
		$this->db->from('companies');
		$this->db->where('updated_at >'," (CURRENT_DATE - INTERVAL '30 days') ", FALSE);
		$this->db->limit(10);
		$query = $this->db->get();
		return $query->result();
	}

	function update_company_to_customer($id){
		$this->db->where('id', $id);
		$this->db->update('companies', array('customer_from'=>date('Y-m-d H:i:s'),'pipeline' => "Customer"));
		return $this->db->affected_rows();
	}

	function update_company_to_proposal($id){
		$pipelinedata = array('pipeline' => "Proposal");
		$this->db->where('id', $id);
		$this->db->update('companies', $pipelinedata);
		return $this->db->affected_rows(); 
	}

     // $query = $this->db->query("YOUR QUERY");

	function search_companies_sql($post,$company_id = False)
	{	
		// filter by name
		if (isset($post['agency_name']) && strlen($post['agency_name'])) 
		{
			$company_name_sql = "select id from companies  where name ilike '%".$post['agency_name']."%'"; 
			
		}

		// COMPANY AGE
		
		if($post['company_age_from'] >= 0  )
		{
			$company_age_from = date("m-d-Y", strtotime("-".$post['company_age_from']." month"));
			
		}
		if(!empty($post['company_age_to'])  )
		{
			$company_age_to = date("m-d-Y", strtotime("-".$post['company_age_to']." month"));
			
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
									and  T.turnover < '.$turnover_to.'
			  						';
			  						// removed this line "T.turnover = NULL or " as is was givin isues when searching for turnover from "0" Ex. 0-60000
			  						// probably neeed to add something to show companies with no turnover details
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
		
		// exclude_contacted_in
		if (isset($post['contacted']) && !empty($post['contacted']) && !empty($post['contacted_days'])){
			
			$int_val = intval($post['contacted_days']);  //extract as interger
			// is valid int 
			// select companies that have had an action in that period and the exclude them from the results
			if($post['contacted'] == 'include'){
				if (is_int($int_val)){
					$contacted_in = "select companies.id 
										 from companies 
										 left join actions on actions.company_id = companies.id 
										 where actions.action_type_id in (11,5,4,16,8) 
										 and actions.actioned_at > current_timestamp - interval '".$int_val." day' 
										 ";
				}
			}elseif ($post['contacted'] == 'exclude') {
				if (is_int($int_val)){
					$contacted_in = "select companies.id 
										 from companies 
										 left join actions on actions.company_id = companies.id 
										 where actions.action_type_id in (11,5,4,16,8) 
										 and actions.actioned_at < current_timestamp - interval '".$int_val." day' 
										 ";
					if(isset($post['exlude_no_contact'])){
						$contacted_in = $contacted_in.'  or actions.id is null';
					}
				}
			}	
		}

		
		// EMP COUNT
		// if((isset($post['employees_to']) and !empty($post['employees_to'])) and (isset($post['employees_from']) and !empty($post['employees_from'])) ) 
		// {
		// 	$emp_count_sql = 'select company_id  from emp_counts where count > '.$post['employees_from'].'  and count < '.$post['employees_to'].'  ';
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
			if($post['providers'] == -1)
			{
				// no curresnt provider 
				$no_providers_sql = 'select distinct(companies.id ) from companies left join (select company_id from mortgages where mortgages.stage = \''.MORTGAGES_OUTSTANDING.'\') t on t.company_id = companies.id where t.company_id  is NULL';
			}
			elseif ($post['providers'] == -2) {
				// has provider
				$providers_sql = 'select mortgages.company_id "company_id" from providers join mortgages on  providers.id = mortgages.provider_id	where mortgages.stage = \''.MORTGAGES_OUTSTANDING.'\'';
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

		// pipeline
		//CHECK IF NOT 0
		foreach($_POST['pipeline'] as $result) {
		}
		if(isset($_POST['pipeline']) && (!empty($_POST['pipeline'])) && ($_POST['pipeline'] !== 'none') && $result !== '0')
		{		
		$pipelines = "pipeline = '".implode("' \n   OR pipeline = '",$_POST['pipeline'])."'";
		$pipeline_sql = "select id from companies where ".$pipelines;
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
			   C.parent_registration --f 28

			   )) "JSON output" 
			   


		from (select * from COMPANIES where eff_to IS NULL and active = \'TRUE\' ';
		if(isset($contacted_in)) $sql = $sql.' AND id in ('.$contacted_in.')';
		$sql = $sql.') C ';

		if(isset($company_name_sql)) $sql = $sql. ' JOIN ( '.$company_name_sql.' ) name ON C.id = name.id ';
		if(isset($no_providers_sql)) $sql = $sql. ' JOIN ( '.$no_providers_sql.' ) companies on C.id = companies.id ';
		if(isset($company_age_sql)) $sql =  $sql.' JOIN ( '.$company_age_sql.' ) company_age ON C.id = company_age.id ';
		if(isset($turnover_sql)) $sql = $sql.' JOIN ( '.$turnover_sql.' ) turnovers ON C.id = turnovers.company_id';
		if(isset($mortgage_sql)) $sql = $sql.' JOIN ( '.$mortgage_sql.' ) mortgages ON C.id = mortgages.company_id';
		if(isset($sectors_sql)) $sql = $sql.' JOIN ( '.$sectors_sql.' ) sectors ON C.id = sectors.company_id';
		if(isset($providers_sql)) $sql = $sql.' JOIN ( '.$providers_sql.' ) providers ON C.id = providers.company_id';
		if(isset($assigned_sql)) $sql = $sql.' JOIN ( '.$assigned_sql.' ) assigned ON C.id = assigned.id';
		if(isset($class_sql)) $sql = $sql.' JOIN ( '.$class_sql.' ) segment ON C.id = segment.id';
		if(isset($pipeline_sql)) $sql = $sql.' JOIN ( '.$pipeline_sql.' ) pipeline ON C.id = pipeline.id';
		if(isset($company_id) && $company_id !== False) $sql = $sql.' JOIN ( select id from companies where id = '.$company_id.' ) company ON C.id = company.id';
		if(isset($emp_count_sql)) $sql = $sql.' JOIN ( '.$emp_count_sql.' ) company ON C.id = company.company_id';

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
		 
		)
		 results';
		//print_r($sql);
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	// NOT IN USE
	// function search_companies($post)
	// {
	// 	// Select query
	// 	$this->db->select('companies.*,addresses.address,turnovers.turnover,turnovers.currency,turnovers.method as turnover_method');
	// 	$this->db->from('companies');
	// 	$this->db->join('addresses','addresses.company_id = companies.id','left');
	// 	$this->db->join('emp_counts','emp_counts.company_id = companies.id','left');
	// 	$this->db->join('mortgages','mortgages.company_id = companies.id','left');
	// 	$this->db->where('companies.active', 'True');
	// 	$this->db->order_by("companies.name", "asc");
		
	// 	$this->db->join('turnovers','turnovers.company_id = companies.id','left');
		
		
		
	// 	// $this->db->select("( SELECT T.turnover as turnover FROM turnovers T WHERE T.company_id = companies.id ORDER BY T.eff_from DESC  LIMIT 1) as turnover ",FALSE,FALSE);
	// 	// $this->db->select("( SELECT T.currency as currency FROM turnovers T WHERE T.company_id = companies.id ORDER BY T.eff_from DESC  LIMIT 1) as currency ",FALSE,FALSE);
	// 	// $this->db->select("( SELECT T.method as method FROM turnovers T WHERE T.company_id = companies.id ORDER BY T.eff_from DESC  LIMIT 1) as turnover_method ",FALSE,FALSE);
		
	// 	// Employee count
	// 	$this->db->select('(SELECT "count" FROM "emp_counts" WHERE "emp_counts"."company_id" = "companies"."id" ORDER BY "emp_counts"."created_at" DESC LIMIT 1) as emp_count', FALSE, FALSE);

	// 	// Sectors the company is in 
	// 	$this->db->select("(SELECT string_agg(S.name, ',') FROM sectors S,operates O WHERE O.company_id = companies.id AND S.id = O.sector_id  AND O.active = 'True' ) as company_sectors", FALSE, FALSE);
	// 	$this->db->select("(SELECT array_to_string(array_agg(S.id), ',')  FROM sectors S,operates O WHERE O.company_id = companies.id AND S.id = O.sector_id  AND O.active = 'True'  ) as company_sectors_ids", FALSE, FALSE);

	// 	// Linkedin connectioins ( need improvement , can be done once a month to another table)
	// 	$this->db->select("(SELECT count(*) FROM connections C,employees E WHERE E.company_id = companies.id AND C.employee_id = E.id ) as company_connections", FALSE, FALSE);

	// 	// Campaigns
	// 	// $this->db->select("(SELECT ARRAY['CM.id', 'CM.name'] FROM campaigns CM,targets TA WHERE TA.company_id = companies.id AND TA.campaign_id = CM.id ) as company_campaigns", FALSE, FALSE);

	// 	// Assign to
	// 	$this->db->select("(SELECT Ad.name FROM users Ad WHERE Ad.id = companies.user_id ) as company_assigned_to", FALSE, FALSE);
	// 	$this->db->select("(SELECT Ad.id FROM users Ad WHERE Ad.id = companies.user_id ) as company_assigned_to_id", FALSE, FALSE);
	
	// 	// Group by variable to be set during filtering 
	// 	$group_by = array('companies.id',
	// 						'companies.user_id',	
	// 						'companies.linkedin_id',
	// 						'companies.registration',
	// 						'companies.name',
	// 						'companies.url',
	// 						'companies.ddlink',	
	// 						'companies.contract',	
	// 						'companies.perm',	
	// 						'companies.active',
	// 						'companies.on_base',
	// 						'companies.eff_from',	
	// 						'companies.eff_to',	
	// 						'customer_from',
	// 						'companies.created_at',	
	// 						'companies.updated_at',	
	// 						'address',
	// 						'turnover',	
	// 						'currency',
	// 						'turnover_method',
	// 						'emp_count',
	// 						'company_sectors',
	// 						'company_connections',
	// 						'company_assigned_to'
	// 						);
		
	// 	//FILTER QUERY 

	// 	// AGENCY NAME
	// 	if (isset($post['agency_name']) && strlen($post['agency_name'])) 
	// 	{
	// 		$this->db->like('companies.name', $post['agency_name']); 
	// 		$this->db->order_by("companies.name", "asc");
	// 	}

	// 	// TURNOVER
	// 		// Defautl values
	// 		if(empty($turnover_from) && !empty($turnover_to))
	// 		{
	// 			$turnover_from = '0';
	// 		}

	// 		if(empty($turnover_to) && !empty($turnover_from))
	// 		{
	// 			$turnover_to = '100000000';
	// 		}
	// 		// set from in query
	// 	if(isset($turnover_from) && (!empty($turnover_from)) ) 
	// 	{
	// 		$this->db->where('turnovers.turnover >', $turnover_from);
	// 	}
	// 		// set to in query
	// 	if(isset($turnover_to) && (!empty($turnover_to)) )
	// 	{
	// 		$this->db->where('turnovers.turnover <', $turnover_to);
	// 	}
	// 		// order by turnover
	// 	if(isset($turnover_from) || isset($turnover_to)) 
	// 	{
	// 		array_push($group_by,"turnovers.turnover");
	// 		$this->db->order_by("turnovers.turnover", "asc");
	// 	}


	// 	// EMPLOYEES COUNT
	// 		// Defautl values
	// 		if(empty($post['employees_from']) && !empty($post['employees_to']))
	// 		{
	// 			$post['employees_from'] = '0';
	// 		}

	// 		if(empty($post['employees_to']) && !empty($post['employees_from']))
	// 		{
	// 			$post['employees_to'] = '1000';
	// 		}
	// 	if(isset($post['employees_from']) && (!empty($post['employees_from'])) )
	// 	{
	// 		$this->db->where('emp_counts.count >', $post['employees_from']);
	// 	}	

	// 	if(isset($post['employees_to']) && (!empty($post['employees_to'])) )
	// 	{
	// 		$this->db->where('emp_counts.count <', $post['employees_to']);
	// 	}

	// 	if(isset($post['employees_to']) || isset($post['employees_from'])) 
	// 	{
	// 		array_push($group_by,"emp_counts.count");
	// 		$this->db->order_by("emp_counts.count", "asc");
	// 	}
		

	// 	// COMPANY AGE
	// 		// Defautl values
	// 		if(empty($post['company_age_from']) && !empty($post['company_age_to']))
	// 		{
	// 			$post['company_age_from'] = 1;
	// 		}

	// 		if(empty($post['company_age_to']) && !empty($post['company_age_from']))
	// 		{
	// 			$post['company_age_to'] = 4;
	// 		}
		
	// 	if(isset($post['company_age_from']) && (!empty($post['company_age_from'])) )
	// 	{
	// 		$company_age_from = date("m-d-Y", strtotime("-".$post['company_age_from']." year"));
	// 		$this->db->where('companies.eff_from <=', $company_age_from);
	// 	}
	// 	if(isset($post['company_age_to']) && (!empty($post['company_age_to'])) )
	// 	{
	// 		$company_age_to = date("m-d-Y", strtotime("-".$post['company_age_to']." year"));
	// 		$this->db->where('companies.eff_from >=', $company_age_to);
	// 	}
	// 	if(isset($post['company_age_to']) || isset($post['company_age_from'])) 
	// 	{
	// 		// array_push($group_by,"companies.eff_from");
	// 		$this->db->order_by("companies.eff_from", "desc");
	// 	}

	// 	// SECTORS

	// 	if( isset($post['sectors']) && (!in_array("0", $post['sectors'])) )
	// 	{	
	// 		$this->db->join('operates','operates.company_id = companies.id AND operates.active = True','left');
	// 		$this->db->join('sectors','sectors.id = operates.sector_id','left');
	// 		$this->db->where_in('operates.sector_id',$post['sectors']);
	// 		array_push($group_by,"operates.id"); 
	// 	}

	// 	// MORTGAGES
	// 	// Defautl values
	// 		if(empty($post['mortgage_from']) && !empty($post['mortgage_to']))
	// 		{
	// 			$post['mortgage_from'] = 0;
	// 		}

	// 		if(empty($post['mortgage_to']) && !empty($post['mortgage_from']))
	// 		{
	// 			$post['mortgage_to'] = 365;
	// 		}

	// 	if (!empty($post['mortgage_to']) && !empty($post['mortgage_from']))
	// 	{
	// 		$this->db->where('mortgages.stage', MORTGAGES_OUTSTANDING);
	// 		$mortgage_end_from = $post['mortgage_from'];
	// 		$mortgage_end_to = $post['mortgage_to'];
	// 		$mortgage_endsql = "EXTRACT (doy from mortgages.eff_from) - EXTRACT (doy from now()) BETWEEN $mortgage_end_from AND $mortgage_end_to ";
	// 		$this->db->where($mortgage_endsql,'',FALSE);
	// 		array_push($group_by,"mortgages.id");
	// 		$this->db->order_by('(EXTRACT (doy from mortgages.eff_from) - EXTRACT (doy from now()))','asc');
	// 	}


	// 	// Providers
	// 	if(isset($post['providers']) && (!empty($post['providers'])) )
	// 	{
	// 		$this->db->join('providers','providers.id = mortgages.provider_id','left');
	// 		$this->db->where('providers.id', $post['providers']);
	// 		array_push($group_by,"providers.id"); 
	// 	}

	// 	// Set order by from variable
	// 	$this->db->group_by($group_by); 
		
	// 	// Build query 
	// 	$query = $this->db->get();

	// 	// Run query  
	// 	$query->result();


	// 	// Place query result into variable
	// 	$companies = $query;
		
	// 	// Flush memory cache: as we won't be repeating this query we should not keep it in memory :) 
	// 	$this->db->flush_cache();
		
	// 	// Populate mortgages for each company as array and make the assign to initials.
	// 	foreach ($companies->result_object as $key => $company) {
	// 		// Select fields 
	// 		$this->db->select("to_char(mortgages.eff_from, 'dd/mm/yy') AS eff_from , providers.name, mortgages.stage ",FALSE);
	// 		$this->db->from('mortgages');
	// 		$this->db->where('mortgages.company_id',$company->id);
	// 		$this->db->join('providers','providers.id = mortgages.provider_id','left');
	// 		$this->db->group_by(array('providers.name', 'mortgages.stage' , 'mortgages.eff_from'));
	// 		$this->db->order_by('mortgages.eff_from','desc');
	// 		$this->db->order_by('mortgages.stage','asc');
			
	// 		$mortgages = $this->db->get(); 


	// 		// Get result as array 
	// 		$mortgages2 = $mortgages->result_array();

	// 		// Place the result array on the current object
	// 		$companies->result_object[$key]->mortgages = $mortgages2;

			
	// 	}
		
	// 	return  $companies;
	// }

	function assign_company($company_id,$user_id)
	{
		$data = array(
               'user_id' => $user_id,
               'assign_date' => date('Y-m-d H:i:s')
            );

		$this->db->update('companies', $data, array('id' => $company_id));
	    $rows = $this->db->affected_rows();
	    return $rows;
	}

	function unassign_company($company_id)
	{
		$data = array(
               'user_id' => NULL,
               'assign_date' => date('Y-m-d H:i:s')
            );

		$this->db->update('companies', $data, array('id' => $company_id));

	    $rows = $this->db->affected_rows();
	    return $rows;
	}

	function clear_company_sectors($id){
		$this->db->where('company_id', $id);
		$this->db->update('operates', array('active'=>'False'));
		return $this->db->affected_rows();
	}

	function update_details($post)
	{
		if(isset($post['turnover']) and !empty($post['turnover']))
		{	
			// this should only happen when no turnonver exist
			$turnover = array(
				'company_id' => $post['company_id'],
				'turnover' => $post['turnover'],
				'method'=> isset($post['method'])?$post['method']:NULL,
				'eff_from'=> date('Y-m-d H:i:s'),
				'created_by' => $post['user_id'],
				'created_at' => date('Y-m-d H:i:s')
				); 
			$this->db->insert('turnovers', $turnover);
			$turnover_status = $this->db->affected_rows();
		}
		
		if(isset($post['emp_count']) and !empty($post['emp_count']))
		{
			$emp_count = array(
				'company_id' => $post['company_id'],
				'count' => $post['emp_count'],
				'created_by' => $post['user_id'],
				'created_at' => date('Y-m-d H:i:s')
				);
			$this->db->insert('emp_counts', $emp_count);
			$emp_counts = $this->db->affected_rows();
		}
		
		
		$company = array(
				'phone' => !empty($post['phone'])?$post['phone']:NULL,
				'linkedin_id' => (isset($post['linkedin_id']) and !empty($post['linkedin_id']))?$post['linkedin_id']:NULL,
				'url' => !empty($post['url'])?$post['url']:NULL,
				'contract'=>!empty($post['contract'])?$post['contract']:NULL,
				'perm'=>!empty($post['perm'])?$post['perm']:NULL,
				'class'=>!empty($post['company_class'])?$post['company_class']:NULL,
				'pipeline'=>!empty($post['company_pipeline'])?$post['company_pipeline']:NULL,
				'updated_at' => date('Y-m-d H:i:s')
			);

		$this->db->select('id,pipeline');
		$this->db->where('pipeline',$post['company_pipeline']);
		$this->db->where('id',$post['company_id']);
    	$query = $this->db->get('companies');
    	if ($query->num_rows() === 0){
   		
		$data = array(
			'company_id' 	=> $post['company_id'],
			'user_id' 		=> $post['user_id'],
			'comments'		=> 'Pipeline changed to '.$post['company_pipeline'],
			'planned_at'	=> (isset($post['planned_at'])? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
			'window'		=> (isset($post['window'])?$post['window']:NULL),
			'contact_id'    => (isset($post['contact_id'])?$post['contact_id']:NULL),
			'created_by'	=> $post['user_id'],
			'action_type_id'=> '19',
			'actioned_at'	=> (!isset($post['actioned_at']) && !isset($post['planned_at'])?date('Y-m-d H:i:s'):NULL),
			'created_at' 	=> date('Y-m-d H:i:s'),
			);
		
		$query = $this->db->insert('actions', $data);
    	}
		$this->db->where('id', $post['company_id']);
		$this->db->update('companies', $company);
		

		$company_status = $this->db->affected_rows();

		// clear existing sectors to no active 
		$result = $this->clear_company_sectors($post['company_id']);

		if (isset($post['add_sectors']) and !empty($post['add_sectors']))
		{
			foreach ($post['add_sectors'] as $sector_id) {
				$this->db->set('company_id', $post['company_id']);
				$this->db->set('sector_id', $sector_id);  
				$this->db->insert('operates'); 
			}
			$sectors_status = $this->db->affected_rows();
		}
		return true;
		
	}



	function create_company($post){
		$company = array(
			'name' => $post['name'],
			'registration' => !empty($post['registration'])?$post['registration']:NULL,
			// 'ddlink' => !empty($post['ddlink'])?$post['ddlink']:NULL,
			'phone' => !empty($post['phone'])?$post['phone']:NULL,
			'linkedin_id' => (!empty($post['linkedin_id']) and !empty($post['linkedin_id']))?$post['linkedin_id']:NULL,
			'url' => !empty($post['url'])?$post['url']:NULL,
			'contract'=>!empty($post['contract'])?$post['contract']:NULL,
			'perm'=>!empty($post['perm'])?$post['perm']:NULL,
			'class'=>!empty($post['company_class'])?$post['company_class']:NULL,
			'pipeline'=>"Prospect",
			'eff_from'=> !empty($post['eff_from'])?date("Y-m-d", strtotime($post['eff_from'])):date('Y-m-d H:i:s'),
		);
		$this->db->insert('companies', $company);
		$new_company_id = $this->db->insert_id(); 
		if($new_company_id){
			// address
			$address = array(
				'company_id' => $new_company_id,
				'country_id' => $post['country_id'],
				'address' => $post['address'],
				'lat' => !empty($post['lat'])?$post['lat']:NULL,
				'lng' => !empty($post['lng'])?$post['lng']:NULL,
				'type' => !empty($post['type'])?$post['type']:"Registered",
				);
			$this->db->insert('addresses', $address);
			$new_company_address_id = $this->db->insert_id(); 
		}
		if($new_company_id and $new_company_address_id) return TRUE;
		return FALSE;
	}

	// This is an example of inserting 
	function insert_entry()
	{
        $this->title   = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();
        $this->db->insert('entries', $this);
    }

    // should be here but let's just use this model for the countries bit
    function get_countries_options(){
    	$this->db->select('id,name');
    	$query = $this->db->get('countries');	
		foreach($query->result() as $row)
		{
		  $array[$row->id] = $row->name;
		} 	
		return $array;
    }

	function get_addresses($company_id)
	{
		$data = array(
			'company_id' => $company_id,
			);
		$this->db->select('addresses.id AS addressid, addresses.address as address,addresses.phone, addresses.type, c.id as countryid, c.name, addresses.company_id', FALSE);

		$this->db->join('countries c', 'c.id = addresses.country_id');
		$this->db->order_by('type asc');

		echo $query = $this->db->get_where('addresses', $data);
		return $query->result_object();
	}

		function create_address($post,$user_id)
	{
       	$address->address = $post['address']; // please read the below note
    	$address->country_id = $post['country_id'];
		$address->type = $post['address_types'];
		$address->phone = $post['phone'];
        $address->company_id = $post['company_id'];
        $address->created_by = $post['user_id'];
        $address->created_at = date('Y-m-d H:i:s');
		echo $this->db->insert('addresses',$address);
	    return $rows;
    }



		 function update_address($post)
	 {
    	$address->address   = $post['address']; // please read the below note
    	$address->country_id = $post['country_id'];
		$address->type = $post['address_types'];
		$address->phone = $post['phone'];
        $address->updated_by = $post['user_id'];
        $address->updated_at = date('Y-m-d H:i:s');
        $this->db->where('id', $post['address_id']);
		$this->db->update('addresses',$address);
        if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
		} 
    }


    function get_autocomplete($search_data) {
		$query1 = $this->db->query("select c.name,c.id, c.pipeline, u.name as user, u.image as image, user_id from companies c left join  users u on u.id = c.user_id where c.eff_to IS NULL and c.active = 'true' and c.name ilike'".$search_data."%' order by name asc limit 7 ");

	    if ($query1->num_rows() > 0)
			{
			return $query1; // If you want to merge both results
			}
		else 
			{
			return $this->db->query("select c.name,c.id, c.pipeline, u.name as user, u.image as image, user_id from companies c left join  users u on u.id = c.user_id where c.eff_to IS NULL and c.active = 'true' and c.name ilike '%".$search_data."%' or c.registration ilike '".$search_data."%' order by c.name asc limit 5 ");
			}
	}
	    function get_autocomplete_contact($search_data) {
		 $query2 = $this->db->query("select concat(c.first_name::text,' ', c.last_name::text) as name, c.company_id as id, con.name as company_name from contacts c left join companies con on con.id= c.company_id where concat(c.first_name::text, ' ', c.last_name::text) ilike '".$search_data."%' order by name asc limit 7 ");

	    if ($query2->num_rows() > 0)
			{
			return $query2; // If you want to merge both results
			}
		else 
			{
			return $this->db->query("select concat(c.first_name::text,' ', c.last_name::text) as name, c.company_id as id, con.name as company_name from contacts c left join companies con on con.id= c.company_id where concat(c.first_name::text, ' ', c.last_name::text) ilike '%".$search_data."%' or regexp_replace(c.phone, E'[^0-9]', '', '') ilike regexp_replace('".$search_data."%', E'[^0-9%]', '', '') order by name asc limit 5 ");
			}
	}
}

