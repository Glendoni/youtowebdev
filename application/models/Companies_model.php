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

	    function get_company_sources(){
    	$this->db->select('id,name');
    	$this->db->where('eff_to >', 'now()');
    	$this->db->or_where('eff_to', NULL); 
    	//$this->db->order_by('display_seq','asc'); 
    	$this->db->order_by('name','asc'); 

    	$query = $this->db->get('lead_sources');	
		foreach($query->result() as $row)
		{
		  $array[$row->id] = $row->name;
		} 	
		return $array;

    }

	function get_companies_classes()
	{
		$arrayNames = array(
	       'Using Finance' => 'Using Finance',
			'FF' => 'First to Finance'

			);
		return 	$arrayNames;
	}

	function get_pipeline_show_source()
	{
		$arrayNamesSources = array('Proposal','Intent','Customer','Proposal','Qualified','Suspect');
		return 	$arrayNamesSources;
	}

	function get_companies_pipeline()
	{
		$arrayNamesPipeline = array(
			'Prospect' => 'Prospect',
			'Intent' => 'Intent',
			//'Qualified' => 'Qualified',
			'Unsuitable' => 'Unsuitable',
             'Suspect' => 'Suspect',
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
			//'Qualified' => 'Qualified',
			'Intent' => 'Intent',
			'Proposal' => 'Proposal',
			'Customer' => 'Customer',
			'Unsuitable' => 'Unsuitable',
            'Suspect' => 'Suspect',
			'Lost' => 'Lost'
			);
		return 	$arrayNamesPipelineSearch;
	}


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
    
    
    
    
    	function update_company_to_action($id, $actionName){ //new function to aid the refactor of pipeline from edit box
		$pipelinedata = array('pipeline' => $actionName, 'updated_at' => date('Y-m-d H:i:s'));
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
			$company_name_Search = trim(pg_escape_string($post['agency_name']));
			$company_name_sql = "select id from companies  where (name ilike '%".$company_name_Search."%' or trading_name ilike '%".$company_name_Search."%' or registration = '".str_replace(' ', '', $company_name_Search)."')"; 
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
                    
                    
                    		$turnover_sql = 'select T.company_id "company_id",
									       T.turnover "turnover",
									       T.method "turnover_method"       
									from TURNOVERS T
								
									  
									where  T.turnover between '.$turnover_from.'  and '.$turnover_to.'  ';
                    
                    
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
		if (isset($post['contacted']) && !empty($post['contacted'])){
			
			$int_val = intval($post['contacted_days']);  //extract as interger
            
            
                        if(!$int_val){
                $datetime1 = date_create('1970-01-01');
                $datetime2 = date_create(date('Y-m-d'));
                $interval = date_diff($datetime1, $datetime2);
                $int_val =  intval($interval->format('%a'));
            }

            
              
            //echo  $int_val;
			// is valid int 
			// select companies that have had an action in that period and the exclude them from the results
			if($post['contacted'] == 'include'){
				if (is_int($int_val)){
					$contacted_in = "select companies.id 
										 from companies 
										LEFT JOIN 
(
select distinct company_id
from ACTIONS
where action_type_id in (11,5,4,16,8) 
and created_at < current_date - interval '".$int_val." day' 
) ACTIONS_SUB
ON companies.id = ACTIONS_SUB.company_id

where active = 'TRUE' 
and ACTIONS_SUB.company_id is null
  
-- )
										 ";
                    
                    // echo $sql = $this->db->last_query();
				}
			}elseif ($post['contacted'] == 'exclude') {
				if (is_int($int_val)){
					$contacted_in = "select companies.id 
										 from companies 
										LEFT JOIN 
(
select distinct company_id
from ACTIONS
where action_type_id in (11,5,4,16,8) 
and created_at > current_date - interval '".$int_val." day' 
) ACTIONS_SUB
ON companies.id = ACTIONS_SUB.company_id

where active = 'TRUE' 
and ACTIONS_SUB.company_id is null

-- )";
 

					if(isset($post['exlude_no_contact'])){
						$contacted_in = $contacted_in.'  or actions.id is null';
					}
				}
			}	
		}

		// SECTORS
		if( isset($post['sectors']) && !empty($post['sectors']) && $post['sectors'] !== '0' )
		{	
			if ($post['sectors'] == 0)
			{
				$sectors_sql = 'select operates.company_id from operates where operates.active = \'t\' and operates.sector_id = NULL ';
			}
			elseif ($post['sectors'] == -1)
			{
				$sectors_sql = 'select o.company_id from operates o where o.active = True and o.sector_id in (select id from sectors where target = \'t\')';
			}
			else
			{	
				$sectors = $post['sectors'];
				if(is_array($sectors))
				{
					 $sectors_sql = 'select operates.company_id from operates where operates.active = \'t\' and operates.sector_id in ('.implode(', ', $post['sectors']).')';
				}
				else
				{
					 $sectors_sql = "select operates.company_id from operates where operates.active = 't' and operates.sector_id = '".$post['sectors']."'";
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
		if(isset($_POST['pipeline']) && (!empty($_POST['pipeline'])) /*&& ($_POST['pipeline'] !== 'none')*/ && $result !== '0')
		{
		if (in_array('none', $_POST['pipeline'])) {
		$pipelines = "pipeline = '".implode("' \n   OR pipeline = '",$_POST['pipeline'])."'";
		$pipeline_sql = "select id from companies where pipeline is null or  ".$pipelines;
		}
		else {
		$pipelines = "pipeline = '".implode("' \n   OR pipeline = '",$_POST['pipeline'])."'";
		$pipeline_sql = "select id from companies where ".$pipelines;
		}
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
			   C.pipeline,
			   U.id "owner_id",
			   TT5.actioned_at, -- f32
			   TT6.planned_at, -- f35
			   AU1.name "aname1",
			   AU2.name "aname2",
		       row_to_json((
		       C.id, -- f1
		       C.name, -- f2
		       C.url, -- f3
			   to_char(C.eff_from, \'dd/mm/yyyy\'), -- f4
			   C.linkedin_id, -- f5
			   U.name, -- f6
			   U.id , -- f7
			   A.address, --f8
			  
			   C.active, -- f9
			   C.created_at, -- f10
			   C.updated_at, -- f11
			   C.created_by,-- f12
			   C.updated_by,-- f13
			   C.registration, -- f14
		       TT1."turnover", -- f15
			   TT1."turnover_method",  -- f16
			   TT4.count,--f17
			   U.image , -- f18
			   C.class, -- f19
			   A.lat, -- f20
			   A.lng, -- f21
			   json_agg( 
			   row_to_json ((
			   TT2."sector_id", TT2."sector", TT2."target"))),-- f22
			   C.phone, -- f23 
			   C.pipeline, -- f24
			   CONT.contacts_count, -- f25
			   C.parent_registration, --f26
			   C.zendesk_id, -- f27
			   C.customer_from, -- f28
			   C.sonovate_id, -- f29
			   TT5.actioned_at, -- f30
			   ACT1.name, -- f31
			   AU1.name, -- f32
			   TT6.planned_at, -- f33
			   ACT2.name , -- f34
			   AU2.name, -- f35
			   C.trading_name, --f36
			   C.lead_source_id, --f37
			   C.source_date, --f38
			   pr.name, --f39
			   pr.id, --f40
			   C.source_explanation, --f41
			   UC.name, --f42
			   UU.name, --f43
               C.initial_rate, --f44
                C.customer_to --f45
			   )) "JSON output" 
			   
from (select * from COMPANIES where active = \'TRUE\' ' ;

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
		(-- TT4 
		select distinct E.company_id,
		E.count
		from 
		(-- T4
		select distinct id,
		company_id,
		max(created_at) OVER (PARTITION BY company_id) "max created_at date"
		from emp_counts
		)   T4
		JOIN EMP_COUNTS E
		ON T4.id = E.id 
		where T4."max created_at date" = E.created_at
		)   TT4
		ON TT4.company_id = C.id 

		LEFT JOIN
		(
		SELECT count(*) as "contacts_count",company_id FROM "contacts" group by contacts.company_id
		) CONT ON CONT.company_id = C.id
	
		LEFT JOIN 
		(-- TT5 LAST ACTION
		select distinct ac1.*
		from 
		(-- T5
		select distinct id,
		       company_id,
		       max(id) OVER (PARTITION BY company_id) "max id"
		from actions
		where action_type_id in (\'4\',\'5\',\'6\',\'8\',\'9\',\'10\',\'11\',\'12\',\'13\',\'17\',\'18\')
		and actioned_at is not null
		)   T5
		JOIN ACTIONS AC1
		ON T5.id = AC1.id 
		where T5."max id" = AC1.id
		)   TT5
		ON TT5.company_id = C.id

		LEFT JOIN 
 		action_types ACT1 on
 		TT5.action_type_id = ACT1.id

 		LEFT JOIN
 		companies pr
		ON C.parent_registration = pr.registration

		LEFT JOIN 
 		users UC on
 		uc.id = C.created_by

		LEFT JOIN 
 		users UU on
 		uu.id = C.updated_by

		LEFT JOIN 
 		users AU1 on
 		TT5.user_id = AU1.id

 		LEFT JOIN 
		(-- TT6 NEXT ACTION
		select distinct ac2.*
		from 
		(-- T6
		select distinct id,
		       company_id,
		       planned_at
		from actions
		where actioned_at is null and cancelled_at is null
		order by planned_at asc
		)   T6
		JOIN ACTIONS AC2
		ON T6.id = AC2.id 
		--where T6.id = AC2.id limit 1
		where T6.id = AC2.id

		)   TT6
		ON TT6.company_id = C.id
		
		LEFT JOIN 
 		action_types ACT2 on
 		TT6.action_type_id = ACT2.id

		LEFT JOIN 
 		users AU2 on
 		TT6.user_id = AU2.id

		LEFT JOIN
		(-- TT2
		select O.company_id "company id",
		       S.id "sector_id",
		       S.name "sector",
		       S.target "target"      
		from OPERATES O

		JOIN SECTORS S
		ON O.sector_id = S.id
		where O.active = \'TRUE\'
		)   TT2
		ON TT2."company id" = C.id


		LEFT JOIN 
		ADDRESSES A
		ON a.id = (select id from addresses where type ilike \'registered address\' and company_id = C.id limit 1)

		LEFT JOIN
		USERS U
		ON U.id = C.user_id
				 
		group by C.id,
		         C.name,
		         C.url,
			     C.eff_from,
			     C.linkedin_id,
			    
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
			     TT4.count,
			     CONT.contacts_count,
			     C.zendesk_id,
			     C.customer_from,
			     C.sonovate_id,
			     TT5.actioned_at,
			     ACT1.name,
			     AU1.name,
			     TT6.planned_at,
			     ACT2.name,
			     AU2.name,
			     C.trading_name,
				 C.lead_source_id,
			     C.source_date,
			     pr.name,
			     pr.id,
			     C.source_explanation,
			     UC.name, 
			     UU.name,
                 C.initial_rate,   
                 C.customer_to

		order by C.id 

		)   T1

		LEFT JOIN

		(-- T2
		select T."company id",
		       json_agg(
			   row_to_json(
			   row (T."mortgage id", T."mortgage provider", T."mortgage stage", T."mortgage start", T."mortgage end", T."mortgage type",  T."provider url" ,T."mortgage Inv_fin_related"))) "JSON output"  -- f11
				 
		from 
		(-- T
		select M.company_id "company id",
		       M.id "mortgage id",
		       P.name "mortgage provider",
		       P.url "provider url",
		       M.stage "mortgage stage",
		       to_char(M.eff_from, \'dd/mm/yyyy\')  "mortgage start",
		       to_char(M.eff_to, \'dd/mm/yyyy\')  "mortgage end",
		       M.type "mortgage type",
		       M.Inv_fin_related "mortgage Inv_fin_related"

		from MORTGAGES M
		  
		JOIN PROVIDERS P
		ON M.provider_id = P.id 

		order by 1, 5, M.eff_from desc

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
		//nl2br($sql);
		//print_r($sql);
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	

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
               'assign_date' => NULL
            );

		$this->db->update('companies', $data, array('id' => $company_id));

	    $rows = $this->db->affected_rows();
	    return $rows;
	}

	function clear_company_sectors($id,$user_id){
				$data = array(
				'active'=>'False',
                'updated_by' => $user_id,
                'updated_at' => date('Y-m-d H:i:s')
            );

		$this->db->where('company_id', $id);
		$this->db->where('active', 'true');

		$this->db->update('operates', $data);
		return $this->db->affected_rows();
	}

	function update_details($post, $user_id=0)
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
        
             if(isset($post['remove_pipeline']) || $post['remove_pipeline'] == true ){
                 
                 $this->delete_pipeline($post);     
             }
        
        	if(isset($post['pipeline_status']) && $post['pipeline_status'] != 0 && $post['pipeline_month'] !=0 )
		{
                $status = 1;
                $this->update_pipline($post,$user_id);         
                
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
		//CHECK IF SOURCE HAS BEEN UPDATED
		if($post['company_source'] > 0) {
			if($post['company_source'] <> $post['original_source']) {
				$source = $post['company_source'];
				$source_date = date('Y-m-d H:i:s');

			} else {
				$source = $post['original_source'];
				$source_date = $post['original_source_date'];
			} 
		}
		else 
			{$source = NULL;$source_date = NULL;}
		
		$company = array(
				'name' => !empty($post['reg_name'])?$post['reg_name']:NULL,
				'trading_name' => !empty($post['trading_name'])?$post['trading_name']:NULL,
				'phone' => !empty($post['phone'])?$post['phone']:NULL,
				'linkedin_id' => (isset($post['linkedin_id']) and !empty($post['linkedin_id']))?$post['linkedin_id']:NULL,
				'url' => !empty($post['url'])?str_replace('http://', '',$post['url']):NULL,
				//'class'=>!empty($post['company_class'])?$post['company_class']:NULL,
 
//'pipeline'=>(!empty($post['company_pipeline'])?$post['company_pipeline']:NULL),
 
				//'pipeline'=>(!empty($post['company_pipeline'])?$post['company_pipeline']:NULL),
 
				'updated_by'=>$post['user_id'],
				//'pipeline'=>!empty($post['company_pipeline'])?$post['company_pipeline']:NULL,
				'updated_at' => date('Y-m-d H:i:s'),
				'lead_source_id'=>$source,
				'source_explanation'=>!empty($post['source_explanation'])?$post['source_explanation']:NULL,
                'source_date'=>$source_date? $source_date :  null,
				);

		$this->db->select('id,pipeline');
		$this->db->where('pipeline',$post['company_pipeline']);
		$this->db->where('id',$post['company_id']);
    	$query = $this->db->get('companies');
    	if ($query->num_rows() === 0){
    		if(!empty($post['company_pipeline'])) {
   		
		$data = array(
			'company_id' 	=> $post['company_id'],
			'user_id' 		=> $post['user_id'],
			'comments'		=> 'Pipeline changed to '.$post['company_pipeline'],
			'planned_at'	=> (isset($post['planned_at'])? date('Y-m-d H:i:s',strtotime($post['planned_at'])):NULL),
			'contact_id'    => (isset($post['contact_id'])?$post['contact_id']:NULL),
			'created_by'	=> $post['user_id'],
			'action_type_id'=> '19',
			'actioned_at'	=> date('Y-m-d H:i:s'),
			'created_at' 	=> date('Y-m-d H:i:s'),
			);
		
		$query = $this->db->insert('actions', $data);
    	}
    }
		$this->db->where('id', $post['company_id']);
		$this->db->update('companies', $company);
		

		$company_status = $this->db->affected_rows();

		// clear existing sectors to no active 
		$result = $this->clear_company_sectors($post['company_id'], $post['user_id']);

		if (isset($post['add_sectors']) and !empty($post['add_sectors']))
		{
			foreach ($post['add_sectors'] as $sector_id) {
				$this->db->set('company_id', $post['company_id']);
				$this->db->set('sector_id', $sector_id);
				$this->db->set('created_by', $post['user_id']);  
 
				$this->db->insert('operates'); 
			}
			$sectors_status = $this->db->affected_rows();
		}
        
       
        
        
        
		return true;
		
	}
    

	function create_company($post){
		$postName = str_replace('\'', '&#39;', $post['name']);
        
        $company = array(
			'name' => $postName,
			'registration' => !empty($post['registration'])?$post['registration']:NULL,
			// 'ddlink' => !empty($post['ddlink'])?$post['ddlink']:NULL,
			'phone' => !empty($post['phone'])?$post['phone']:NULL,
			'linkedin_id' => (!empty($post['linkedin_id']) and !empty($post['linkedin_id']))?$post['linkedin_id']:NULL,
			'url' => !empty($post['url'])?str_replace('http://', '',$post['url']):NULL,
            'pipeline' => 'Suspect',
'class' => 'FF',
			'class'=>!empty($post['company_class'])?$post['company_class']:NULL,
			'eff_from'=> !empty($post['eff_from'])?date("Y-m-d", strtotime($post['eff_from'])):date('Y-m-d H:i:s'),
			'created_by'=>$post['user_id'],

		);
		$this->db->insert('companies', $company);
		$new_company_id = $this->db->insert_id(); 
		if($new_company_id){
			// address
			$address = array(
				'company_id' => $new_company_id,
				'country_id' => $post['country_id'],
				'address' => !empty($post['address'])?$post['address']:NULL,
				'lat' => !empty($post['lat'])?$post['lat']:NULL,
				'lng' => !empty($post['lng'])?$post['lng']:NULL,
				'type' => !empty($post['type'])?$post['type']:"Registered Address",
                'created_at' 	=> date('Y-m-d H:i:s'),
				'created_by'=> $post['user_id'],

				);
			$this->db->insert('addresses', $address);
			$new_company_address_id = $this->db->insert_id(); 
		}
        
        if(isset($post['tradingArr'])){
            
            if($post['tradingArr'] == 1) { //the same so copy
                
                	$address = array(
				'company_id' => $new_company_id,
				'country_id' => $post['country_id'],
				'address' => !empty($post['address'])?$post['address']:NULL,
				'lat' => !empty($post['lat'])?$post['lat']:NULL,
				'lng' => !empty($post['lng'])?$post['lng']:NULL,
				'type' => "Trading Address",
                'created_at' 	=> date('Y-m-d H:i:s'),
				'created_by'=> $post['user_id'],

				);
               
                $this->db->insert('addresses', $address);
            }
            
            
            if($post['tradingArr'] == 2){
                
                
                   $address = array(
				'company_id' => $new_company_id,
				'country_id' => $post['country_id'],
				'address' => !empty($post['tradingAddress'])?$post['tradingAddress']:NULL,
				'lat' => !empty($post['lat'])?$post['lat']:NULL,
				'lng' => !empty($post['lng'])?$post['lng']:NULL,
				'type' => "Trading Address",
                'created_at' 	=> date('Y-m-d H:i:s'),    
				'created_by'=> $post['user_id'],

				);
            
             $this->db->insert('addresses', $address);
        }
        
		if($new_company_id and $new_company_address_id) return TRUE;
		return FALSE;
	}

    
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
    	$this->db->order_by('id','asc'); 

    	$query = $this->db->get('countries');	
		foreach($query->result() as $row)
		{
		  $array[$row->id] = $row->name;
		} 	
		return $array;
    }

	function get_addresses($company_id)
	{
		 
		$sql = "SELECT addresses.id AS addressid, f.name as created_by_user, e.name as updated_by_user, addresses.address as address,addresses.phone, to_char(addresses.updated_at, 'DD/MM/YYYY') as addresses_updated_at, to_char(addresses.created_at, 'DD/MM/YYYY') as addresses_created_at,  addresses.type,addresses.created_by, c.id as countryid, c.name, addresses.company_id

        FROM addresses
        LEFT JOIN countries as c ON c.id = addresses.country_id
        LEFT JOIN users as f ON f.id = addresses.created_by
        LEFT JOIN users as e ON e.id = addresses.updated_by
        WHERE addresses.company_id=".$company_id."
        ORDER BY type ASC";
  
        $result = $this->db->query($sql);
        return    $result->result();
	}

	function create_address($post)
	{
       	$address->address = !empty($post['address'])?$post['address']:NULL; // please read the below note
    	$address->country_id = $post['country_id'];
		$address->type = $post['address_types'];
		$address->phone = !empty($post['phone'])?$post['phone']:NULL;
        $address->company_id = $post['company_id'];
        $address->created_by = $post['user_id'];
        $address->created_at = date('Y-m-d H:i:s');
		$this->db->insert('addresses',$address);
		return $this->db->affected_rows();

    }



	function update_address($post)
	{
    	$address->address   = !empty($post['address'])?$post['address']:NULL; // please read the below note
    	$address->country_id = $post['country_id'];
		$address->type = $post['address_types'];
		$address->phone = !empty($post['phone'])?$post['phone']:NULL;
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
        
           //$search_data = str_replace('&', '&amp;', $id);
       //$search_data = str_replace("'","&#39;", $search_data);  
        $search_data = pg_escape_string($search_data);
        //$search_data = str_replace('&#39;',"", $search_data);  
		$query1 = $this->db->query("select linkedin_id, c.name,c.id, c.pipeline, u.name as user, u.image as image, user_id, c.active from companies c left join  users u on u.id = c.user_id where c.eff_to IS NULL and (REPLACE(c.name, '''', '') ilike '".$search_data."%' or REPLACE(c.trading_name, '''', '') ilike'".$search_data."%') order by c.active desc, name asc limit 10 ");

	    if ($query1->num_rows() > 0)
			{
			return $query1; // If you want to merge both results
			}
		else 
			{
			return $this->db->query("select c.name,c.id, c.pipeline, u.name as user, u.image as image, user_id, c.active from companies c left join  users u on u.id = c.user_id where c.eff_to IS NULL and ((REPLACE(c.name, '''', '') ilike '%".$search_data."%' or REPLACE(c.trading_name, '''', '') ilike '%".$search_data."%' or c.registration ilike '".$search_data."%' or regexp_replace(c.phone, E'[^0-9]', '', '') ilike regexp_replace('".$search_data."%', E'[^0-9%]', '', ''))) order by c.active desc, name asc limit 10");
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
			return $this->db->query("select concat(c.first_name::text,' ', c.last_name::text) as name, c.company_id as id, con.name as company_name from contacts c left join companies con on con.id= c.company_id where REPLACE(concat(c.first_name::text, ' ', c.last_name::text), '''', '') ilike '%".$search_data."%' or regexp_replace(c.phone, E'[^0-9]', '', '') ilike regexp_replace('".$search_data."%', E'[^0-9%]', '', '') or regexp_replace(c.email, E'[^0-9]', '', '') ilike regexp_replace('".$search_data."%', E'[^0-9%]', '', '') order by name asc limit 7 ");
			}
	}
    /*
    @ Insert Company details from Company House API Record
    @ Author: Glen Small
    */
    public function create_company_from_CH($post,$user_id){
        
        
     
$q = '
     SELECT id
     FROM companies
     WHERE registration=\''.$post['registration'].'\'
     LIMIT 1
    ';
    $result = $this->db->query($q);
              if(!$result->num_rows()){
        
     
		  $this->load->helper('inflector');
        
        $postName = str_replace('"', '&quot;', $post['name']);
          $postName = str_replace('\'', '&#39;', $postName);
                 
        
    $company = array(
        'name' => humanize($postName),
        'pipeline' => 'Suspect',
         'class' => 'FF',
        'created_by'=> $user_id,
        'eff_from'=> $post['date_of_creation'],
        'registration' => !empty($post['registration'])?$post['registration']:NULL,		 
		);
		$this->db->insert('companies', $company);
		$new_company_id = $this->db->insert_id(); 
		if($new_company_id){
			// address
			$address = array(
				'company_id' => $new_company_id,
				'address' => $post['address'],
                'type' => 'Registered Address',
                'country_id' => 1,
				'created_by'=> $user_id,
				);
			$this->db->insert('addresses', $address);
			$new_company_address_id = $this->db->insert_id();
		}
    if($new_company_id and $new_company_address_id) return $new_company_id;
		return FALSE;
        
 
              }else{
                  
             foreach ($result->result() as $row)
                {
                    return array('row_id' => $row->id);
                } 
                  
              }    
                  
	}
        
    /*
    @ Insert Company Charges from Company House API Record
    @ Author: Glen Small
    */
    public function insert_charges_CH($response, $company_id,$user_id)
    {
           
        $this->load->helper('inflector');
        $provider  = '';
        $provider = $response['items'][0]['persons_entitled'][0]['name'];
         $provider_id = $this->providerCheck($provider);
    
        if($provider_id){
            $mortgages = array(
                    'company_id' => $company_id,
                    'provider_id' => $provider_id,
'class' => 'Using Finance',
                    'ref' => $response['items'][0]['etag'],
                    'stage' =>  $response['items'][0]['status'],
                    'eff_from' => $response['items'][0]['transactions'][0]['delivered_on'],
                    'created_at' =>   date('Y-m-d'),	
                    'created_by' => $user_id

                    );
                $this->db->insert('mortgages', $mortgages);
        }        
             
    }  
    
    
    public function insert_charges_CSV($response)
    {
           
        
        $provider  = '';
        $provider = $response['provider_str'];
        
        file_put_contents('pop.txt', $provider.PHP_EOL, FILE_APPEND);
        
        
         $provider_id = $this->providerCheck($provider);
    
        if($provider_id){
            $mortgages = array(
                    'company_id' => $response['company_id'],
                    'provider_id' => $provider_id,
                    'ref' => $response['etag'],
                    'stage' =>  $response['status'],
                    'eff_from' => $response['eff_from'],
                    'created_at' =>   date('Y-m-d'),	
                    'created_by' => $response['created_by']

                    );
                $this->db->insert('mortgages', $mortgages);
        }        
             
    }
    
    
    
    public function providerCheck($name)
    {
        
        //$name = 'ABN AMRO COMMERCIAL FINANCE PLC';
        
        
        
        
        $q = '
         SELECT id,name,provider_id
         FROM provider_checks
         WHERE name ilike \''.$name.'\'
         LIMIT 1
        ';
        $result = $this->db->query($q);
            $last = $this->db->last_query();
         //file_put_contents('pop.txt', $last.PHP_EOL, FILE_APPEND);
        
        
              if( $result->num_rows()){
                   foreach ($result->result() as $row)
                    {
                        return $row->provider_id;
                    } 
             }else{
                  return false;
            }
    }
    
    public function hackmorgages($id){
       //Redundent function used temporarily for testing purposes only!

        $this->db->select('*');
        $this->db->from('companies');
        $this->db->join('mortgages', 'mortgages.company_id= companies.id');
        $this->db->join('providers', 'providers.id=mortgages.provider_id');
        $this->db->where('companies.id',$id); 
        $this->db->limit(1);

        
    
        
        $query = $this->db->get();
        
        
    

        foreach ($query->result() as $row)
        {
            return $row;
        }

          
    }
    
    public function delete_pipeline($post){
        
        //remove_pipeline
         $this->db->where('company_id', $post['company_id']);
            $this->db->update('deals_pipeline', array('eff_to' => date('Y-m-d H:i:s')));
        
    }
    
    public function update_pipline($post, $user_id){
   
                $pipeline_month = $post['pipeline_month'];
        
                $action = $this->check_if_pipeline_exist($post['company_id'], $pipeline_month ,$post['pipeline_status']);
        
            if($action){

                        $this->db->where('company_id', $post['company_id']);
                        $this->db->update('deals_pipeline', array('eff_to' => date('Y-m-d H:i:s')));

                                $pipeline = array(
                                'company_id' => $post['company_id'],
                                'created_by' => $user_id,
                                'status' => $post['pipeline_status'],
                                    'user_id' => $user_id,
                                'eff_from' => $post['pipeline_month']
                                );
                            $this->db->insert('deals_pipeline', $pipeline);
                            $pipeline = $this->db->affected_rows();


                        return $this->db->affected_rows();

                }else{

                            $pipeline = array(
                            'company_id' => $post['company_id'],
                            'created_by' => $user_id,
                            'status' => $post['pipeline_status'],
                                'user_id' => $user_id,
                            'eff_from' => $post['pipeline_month']
                            );
                        $this->db->insert('deals_pipeline', $pipeline);
                        $pipeline = $this->db->affected_rows();

                 }
 
        
        
    }
        
    public function check_if_pipeline_exist($id =0, $pipeline_month, $pipeline_status){

        $q = "
         SELECT company_id
         FROM deals_pipeline
        WHERE company_id=".$id."
        AND status LIKE '".$pipeline_status."'
        AND eff_to IS NULL
        LIMIT 1
        ";

        $result = $this->db->query($q);

            if($result->num_rows()){ 
                return true ;
            }else{

              return  false;
            }
    }
    

    
    public function get_deals_pipeline($id =0, $user_id = 1, $mode = 2)
    {
                  
        $q = '
        SELECT deals_pipeline.*, users.name
        FROM deals_pipeline
        LEFT JOIN users
        ON deals_pipeline.user_id=users.id
        WHERE deals_pipeline.company_id='.$id.'
        AND deals_pipeline.eff_to IS NULL
        LIMIT 1
        ';
        $result = $this->db->query($q);
              if( $result->num_rows()){

               foreach ($result->result() as $row)
                {
                    return $row;
               } 
                    }else{

                  return false;
             
              }

        return array();
        
    }
 
    public function get_pipline_deals(){
        
        $q = '
        SELECT *,deals_pipeline.eff_from as efffrom, companies.name as companyname, users.name as owner, 
    to_char(deals_pipeline.updated_at, \'fmDDth Month YY\') as pipeline_date_updated, to_char(deals_pipeline.created_at, \'fmDDth Month YY\') as pipeline_date_created
        FROM deals_pipeline
        LEFT JOIN companies
        ON deals_pipeline.company_id=companies.id
        LEFT JOIN users
        ON deals_pipeline.user_id=users.id
        WHERE deals_pipeline.eff_to IS NULL 
        ORDER BY users.id ASC,deals_pipeline.updated_at DESC 
        ';
        $result = $this->db->query($q);
        return    $result->result();
    }
    
    
    public function update_pipline_from_drag_and_drop($post,$user){
        
         $companyID = $post['companyId'];
        
        if($post['monthupdate']  != 'delete'){
            $status = substr($post['monthupdate'], 0, 2);
            $newmonth =   str_replace($status, '', $post['monthupdate']); 
            if($status == 'sc'){
                $status  = 1;
            }else{
                $status  = 2;
            }
            
            $data = array(
                   'eff_from' => $newmonth,
                   'updated_by' => $user,
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => $status
                );
                 }else{
            $data = array(
                'eff_to' => date('Y-m-d') 
                );
           // return 'delete';
            
        }
            
     $this->db->where('company_id',  $companyID);
            $this->db->where('eff_to IS NULL',  null,true);       
            $this->db->update('deals_pipeline', $data); 
    return  $user;
    
    }
    public function creat_pipeline($post, $user_id){}
    
    public function get_company_from_id($id){
       //Redundent function used temporarily for testing purposes only! 

        $this->db->select('*');
        $this->db->from('companies');
        
        $this->db->where('companies.id',$id); 
        $this->db->limit(1);

        $query = $this->db->get();

        foreach ($query->result() as $row)
        {
            
              $words = array( 'Limited', 'LIMITED', 'LTD','ltd','Ltd' );
        
                    $comp_name_replace_words =  str_replace($words, '',$row->name);
                    $comp_name_trim_left =ltrim($comp_name_replace_words);
                    $comp_name = rtrim($comp_name_trim_left);
            
            return   array('trading_name' => $row->trading_name, 'name' => $comp_name);
        }

          
    }
    
    function company_select($id){
     
     $query = $this->db->query("SELECT * FROM companies WHERE id='".$id."' LIMIT 1");
     
         if ($query->num_rows() > 0)
             {
                $row = $query->row(); 
     
              if($row->pipeline == 'Customer') return false;
         return true;
             } 
      }
    
    function update_not_for_invoices($post,$userID){
        
        
    $debenturemortgage  =      $post['debenturemortgage'] ? $post['debenturemortgage'] :NULL;
        
        
        
     
       $data = array(
                      'updated_at' =>  date('Y-m-d H:i:s'),
                      'updated_by' => intval($userID),
                      'inv_fin_related' =>   $debenturemortgage
                   );
       
        
        $this->db->where('company_id', intval($post['companyid']));
        $this->db->where('id', intval($post['providerid']));
                    $this->db->update('mortgages', $data);
        
        
          //$this->classUpdater(intval($post['companyid']));
        
       
       return $debenturemortgage ? true : false;

        
    }
     /*@@@
    
        Analyses only companies with pipeline of Qualified, Suspect, Prospect or is set to null
        
        If the company is "in a Target Sector and turnover < £25 million" then set to Prospect, else set to Suspect
    @@@ */
    
    public function cronPipeline($offset =0, $comp){  

        
        if($comp) $comp = 'and C.id='.$comp; 

 
        $query = $this->db->query("select C.id,C.turnover,
       CASE when T.company_id is not null and (C.turnover < 25000000 or C.turnover is null)
            then 'Prospect'
            else 'Suspect'
	   END \"pipeline_value\"										   											      

from COMPANIES C

LEFT JOIN 
(
select distinct O.company_id
  
from OPERATES O

JOIN SECTORS S
ON S.id = O.sector_id
  
where O.active = 't'
and S.target = 't'
) T
ON C.id = T.company_id

where pipeline is null
or pipeline not in ('Customer','Proposal','Intent','Lost','Unsuitable','Blacklisted') 

and C.active = 't' 

".$comp."

LIMIT 1
	 "                              
);

                     if ($query->num_rows() > 0)
                        {
                            //echo '<table width="400">';
                            foreach($query->result() as $row)
                            {
                                $turn   = $row->turnover ? $row->turnover : '-----';
                                
                               // echo '<tr><td>'.$row->id.' </td><td align="left" class="glen">'.$row->pipeline_value.'</td><td>'.$turn.'</td></tr>'; 
                                //if($row->id == 231806){  $this->cronpipelineUpdater($row->id,$row->pipeline_value);  } 
                                $this->cronpipelineUpdater($row->id,$row->pipeline_value); 
                                //if($row->id == 343853) echo 'Got ya';
                            }
                         
                        // echo '</table>';
                     }
            }   
    
 
    
    
    
    private function cronpipelineUpdater($id,$pipeline){ 
        
        
        
        //Updates company table pipeline based on conditions in crontogo function 
                 $data = array(
                                'pipeline' => $pipeline,
                     'updated_at' => date("Y-m-d H:i:s")
                                          
                             );

                 $this->db->where('id', $id);
                 $this->db->update('companies', $data);
        
        

        }   
   
    
}
