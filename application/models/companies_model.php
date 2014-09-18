<?php
class Companies_model extends CI_Model {
	
	function get_all()
	{
		$query = $this->db->get('companies');	
		return $query->result();
	}


	function get_company_by_id($id)
	{

		$this->db->select('companies.*,addresses.address');
		$this->db->from('companies');
		$this->db->join('addresses','addresses.company_id = companies.id','left');
		$this->db->join('operates','operates.company_id = companies.id AND operates.active = True','left');
		$this->db->join('sectors','sectors.id = operates.sector_id','left');
		
		$this->db->where('companies.id', $id);
		$this->db->where('companies.active', 'True');
		$this->db->group_by('companies.id,addresses.address');
		$this->db->order_by("companies.name", "asc");


		// Employee count
		$this->db->select('(SELECT "count" FROM "emp_counts" WHERE "emp_counts"."company_id" = "companies"."id" ORDER BY "emp_counts"."created_at" DESC LIMIT 1) as emp_count', FALSE, FALSE);

		// Sectors the company is in 
		$this->db->select("(SELECT string_agg(S.name, ',') FROM sectors S,operates O WHERE O.company_id = companies.id AND S.id = O.sector_id  AND O.active = 'True') as company_sectors", FALSE, FALSE);

		// Linkedin connectioins ( need improvement , can be done once a month to another table)
		$this->db->select("(SELECT count(*) FROM connections C,employees E WHERE E.company_id = companies.id AND C.employee_id = E.id ) as company_connections", FALSE, FALSE);

		// Assign to
		$this->db->select("(SELECT Ad.name FROM users Ad WHERE Ad.id = companies.user_id ) as company_assigned_to", FALSE, FALSE);
		$this->db->select("(SELECT Ad.id FROM users Ad WHERE Ad.id = companies.user_id ) as company_assigned_to_id", FALSE, FALSE);

		// Build query 
		$query = $this->db->get();

		// Run query  
		$query->result();

		// Place query result into variable
		$companies = $query;

		foreach ($companies->result_object as $key => $company) {
			// Select fields 
			$this->db->select("to_char(mortgages.eff_from, 'DD/Mon/YYYY') AS eff_from , providers.name, mortgages.stage ",FALSE);
			$this->db->from('mortgages');
			$this->db->where('mortgages.company_id',$company->id);
			$this->db->join('providers','providers.id = mortgages.provider_id','left');
			$this->db->group_by(array('providers.name', 'mortgages.stage' , 'mortgages.eff_from'));
			$this->db->order_by('mortgages.eff_from');
			$mortgages = $this->db->get(); 


			// Get result as array 
			$mortgages2 = $mortgages->result_array();

			// Place the result array on the current object
			$companies->result_object[$key]->mortgages = $mortgages2;

			// Check for assign to
			// $assign_to = $company->company_assigned_to;
			// if(!empty($assign_to))
			// {
			// 	$names = explode(" ", $assign_to); 
			// 	$initials = $names[0][0].$names[1][0];
			// 	$to_upper = strtoupper($initials);
			// 	// Set to array
			// 	$companies->result_object[$key]->company_assign_to = $to_upper;
			// }

			$this->db->select('turnovers.turnover');
			$this->db->from('turnovers');
			$this->db->where('turnovers.company_id',$company->id);
			$this->db->order_by('turnovers.eff_from','desc');
			$this->db->limit(1);
			$turnovers = $this->db->get(); 
			$turnovers_array = $turnovers->result_array();

			$companies->result_object[$key]->turnover = $turnovers_array[0]['turnover'];

		}

		return $companies;
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




     // $query = $this->db->query("YOUR QUERY");

	function search_companies_sql($post)
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
		if( (isset($post['turnover_from']) && !empty($post['turnover_from'])) && (isset($post['turnover_to']) && !empty($post['turnover_to'])) ) 
		{
			$turnover_sql = 'select company_id  from turnovers where turnover > '.$post['turnover_from'].'  and turnover < '.$post['turnover_to'].'  ';
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

		if( isset($post['sectors']) && (!in_array("0", $post['sectors'])) )
		{	
			if ($post['sectors'] < 0)
			{
				$sectors_sql = 'select operates.company_id from operates where operates.active = True and operates.sector_id = NULL ';
			}
			else
			{
				$sectors_sql = 'select operates.company_id from operates where operates.active = True and operates.sector_id in ('.implode(', ', $post['sectors']).')';
			}
			
		}

		// Providers
		if(isset($post['providers']) && (!empty($post['providers'])) )
		{
			if($post['providers'] < 0)
			{
				$providers_sql = 'select mortgages.company_id "company_id" from providers join mortgages on  providers.id = mortgages.provider_id	where  providers.id = NULL';
			}
			else
			{
				$providers_sql = 'select mortgages.company_id "company_id" from providers join mortgages on  providers.id = mortgages.provider_id	where providers.id = '.$post['providers'];
			}
			
		}

		// assigned
		if(isset($post['assigned']) && (!empty($post['assigned'])) && ($post['assigned'] !== '0'))
		{	
			$assigned_sql = 'select id from companies where user_id = '.$post['assigned'].'';
		}

		// -- Data to Display a Company's details
		

		$sql = 'select json_agg(results)
from (

select row_to_json((
       T1."JSON output",
       T2."JSON output"
       )) "company"
from 
(-- T1
select C.id,
       row_to_json((
       C.id, -- f1
       C.name, -- f2
       C.url, -- f3
	   to_char(C.eff_from, \'DD\Mon\YYYY\'), -- f4
	   C.ddlink, -- f5
	   C.linkedin_id, -- f6
	   U.name, -- f7
       TT1."turnover", -- f8
	   TT1."turnover_method",  -- f9
	   json_agg( 
	   row_to_json ((
	   TT2."sector_id", TT2."sector"))))) "JSON output", -- f10
	   C.contract, -- f11
	   C.perm, -- f12
	   C.active, -- f13
	   C.created_at, -- f14
	   C.updated_at, -- f15
	   C.created_by,-- f16
	   C.updated_by,-- f17
	   C.registration -- f18
   

from COMPANIES C';

if(isset($company_name_sql)) $sql = $sql. ' JOIN ( '.$company_name_sql.' ) name ON C.id = name.id ';
if(isset($company_age_sql)) $sql =  $sql.' JOIN ( '.$company_age_sql.' ) company_age ON C.id = company_age.id ';
if(isset($turnover_sql)) $sql = $sql.' JOIN ( '.$turnover_sql.' ) turnovers ON C.id = turnovers.company_id';
if(isset($mortgage_sql)) $sql = $sql.' JOIN ( '.$mortgage_sql.' ) mortgages ON C.id = mortgages.company_id';
if(isset($sectors_sql)) $sql = $sql.' JOIN ( '.$sectors_sql.' ) sectors ON C.id = sectors.company_id';
if(isset($providers_sql)) $sql = $sql.' JOIN ( '.$providers_sql.' ) sectors ON C.id = sectors.company_id';
if(isset($assigned_sql)) $sql = $sql.' JOIN ( '.$assigned_sql.' ) assigned ON C.id = assigned.id';

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
(-- TT2
select O.company_id "company id",
       S.id "sector_id",
       S.name "sector"       
from OPERATES O
  
JOIN SECTORS S
ON O.sector_id = S.id 
)   TT2
ON TT2."company id" = C.id

LEFT JOIN
USERS U
ON U.id = C.user_id
		 
group by C.id,
         C.name,
         C.url,
	     C.eff_from,
	     C.ddlink,
	     C.linkedin_id,
	     U.name,
         TT1."turnover",
	     TT1."turnover_method"

order by C.id 


)   T1

LEFT JOIN

(-- T2
select T."company id",
       json_agg(
	   row_to_json(
	   row (T."mortgage id", T."mortgage provider", T."mortgage stage", T."mortgage start"))) "JSON output"  -- f11
		 
from 
(-- T
select M.company_id "company id",
       M.id "mortgage id",
       P.name "mortgage provider",
       M.stage "mortgage stage",
       to_char(M.eff_from, \'DD\Mon\YYYY\')  "mortgage start"
from MORTGAGES M
  
JOIN PROVIDERS P
ON M.provider_id = P.id 

order by 1, 4, 5 desc

)   T

group by T."company id"

order by T."company id"


)   T2
ON T1.id = T2."company id"
 
) results';
		// print_r($sql);
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function search_companies($post)
	{
		// Select query
		$this->db->select('companies.*,addresses.address,turnovers.turnover,turnovers.currency,turnovers.method as turnover_method');
		$this->db->from('companies');
		$this->db->join('addresses','addresses.company_id = companies.id','left');
		$this->db->join('emp_counts','emp_counts.company_id = companies.id','left');
		$this->db->join('mortgages','mortgages.company_id = companies.id','left');
		$this->db->where('companies.active', 'True');
		$this->db->order_by("companies.name", "asc");
		
		$this->db->join('turnovers','turnovers.company_id = companies.id','left');
		
		
		
		// $this->db->select("( SELECT T.turnover as turnover FROM turnovers T WHERE T.company_id = companies.id ORDER BY T.eff_from DESC  LIMIT 1) as turnover ",FALSE,FALSE);
		// $this->db->select("( SELECT T.currency as currency FROM turnovers T WHERE T.company_id = companies.id ORDER BY T.eff_from DESC  LIMIT 1) as currency ",FALSE,FALSE);
		// $this->db->select("( SELECT T.method as method FROM turnovers T WHERE T.company_id = companies.id ORDER BY T.eff_from DESC  LIMIT 1) as turnover_method ",FALSE,FALSE);
		
		// Employee count
		$this->db->select('(SELECT "count" FROM "emp_counts" WHERE "emp_counts"."company_id" = "companies"."id" ORDER BY "emp_counts"."created_at" DESC LIMIT 1) as emp_count', FALSE, FALSE);

		// Sectors the company is in 
		$this->db->select("(SELECT string_agg(S.name, ',') FROM sectors S,operates O WHERE O.company_id = companies.id AND S.id = O.sector_id  AND O.active = 'True' ) as company_sectors", FALSE, FALSE);
		$this->db->select("(SELECT array_to_string(array_agg(S.id), ',')  FROM sectors S,operates O WHERE O.company_id = companies.id AND S.id = O.sector_id  AND O.active = 'True'  ) as company_sectors_ids", FALSE, FALSE);

		// Linkedin connectioins ( need improvement , can be done once a month to another table)
		$this->db->select("(SELECT count(*) FROM connections C,employees E WHERE E.company_id = companies.id AND C.employee_id = E.id ) as company_connections", FALSE, FALSE);

		// Campaigns
		// $this->db->select("(SELECT ARRAY['CM.id', 'CM.name'] FROM campaigns CM,targets TA WHERE TA.company_id = companies.id AND TA.campaign_id = CM.id ) as company_campaigns", FALSE, FALSE);

		// Assign to
		$this->db->select("(SELECT Ad.name FROM users Ad WHERE Ad.id = companies.user_id ) as company_assigned_to", FALSE, FALSE);
		$this->db->select("(SELECT Ad.id FROM users Ad WHERE Ad.id = companies.user_id ) as company_assigned_to_id", FALSE, FALSE);
	
		// Group by variable to be set during filtering 
		$group_by = array('companies.id',
							'companies.user_id',	
							'companies.linkedin_id',
							'companies.registration',
							'companies.name',
							'companies.url',
							'companies.ddlink',	
							'companies.contract',	
							'companies.perm',	
							'companies.active',
							'companies.on_base',
							'companies.eff_from',	
							'companies.eff_to',	
							'customer_from',
							'companies.created_at',	
							'companies.updated_at',	
							'address',
							'turnover',	
							'currency',
							'turnover_method',
							'emp_count',
							'company_sectors',
							'company_connections',
							'company_assigned_to'
							);
		
		//FILTER QUERY 

		// AGENCY NAME
		if (isset($post['agency_name']) && strlen($post['agency_name'])) 
		{
			$this->db->like('companies.name', $post['agency_name']); 
			$this->db->order_by("companies.name", "asc");
		}

		// TURNOVER
			// Defautl values
			if(empty($post['turnover_from']) && !empty($post['turnover_to']))
			{
				$post['turnover_from'] = '0';
			}

			if(empty($post['turnover_to']) && !empty($post['turnover_from']))
			{
				$post['turnover_to'] = '100000000';
			}
			// set from in query
		if(isset($post['turnover_from']) && (!empty($post['turnover_from'])) ) 
		{
			$this->db->where('turnovers.turnover >', $post['turnover_from']);
		}
			// set to in query
		if(isset($post['turnover_to']) && (!empty($post['turnover_to'])) )
		{
			$this->db->where('turnovers.turnover <', $post['turnover_to']);
		}
			// order by turnover
		if(isset($post['turnover_from']) || isset($post['turnover_to'])) 
		{
			array_push($group_by,"turnovers.turnover");
			$this->db->order_by("turnovers.turnover", "asc");
		}


		// EMPLOYEES COUNT
			// Defautl values
			if(empty($post['employees_from']) && !empty($post['employees_to']))
			{
				$post['employees_from'] = '0';
			}

			if(empty($post['employees_to']) && !empty($post['employees_from']))
			{
				$post['employees_to'] = '1000';
			}
		if(isset($post['employees_from']) && (!empty($post['employees_from'])) )
		{
			$this->db->where('emp_counts.count >', $post['employees_from']);
		}	

		if(isset($post['employees_to']) && (!empty($post['employees_to'])) )
		{
			$this->db->where('emp_counts.count <', $post['employees_to']);
		}

		if(isset($post['employees_to']) || isset($post['employees_from'])) 
		{
			array_push($group_by,"emp_counts.count");
			$this->db->order_by("emp_counts.count", "asc");
		}
		

		// COMPANY AGE
			// Defautl values
			if(empty($post['company_age_from']) && !empty($post['company_age_to']))
			{
				$post['company_age_from'] = 1;
			}

			if(empty($post['company_age_to']) && !empty($post['company_age_from']))
			{
				$post['company_age_to'] = 4;
			}
		
		if(isset($post['company_age_from']) && (!empty($post['company_age_from'])) )
		{
			$company_age_from = date("m-d-Y", strtotime("-".$post['company_age_from']." year"));
			$this->db->where('companies.eff_from <=', $company_age_from);
		}
		if(isset($post['company_age_to']) && (!empty($post['company_age_to'])) )
		{
			$company_age_to = date("m-d-Y", strtotime("-".$post['company_age_to']." year"));
			$this->db->where('companies.eff_from >=', $company_age_to);
		}
		if(isset($post['company_age_to']) || isset($post['company_age_from'])) 
		{
			// array_push($group_by,"companies.eff_from");
			$this->db->order_by("companies.eff_from", "desc");
		}

		// SECTORS

		if( isset($post['sectors']) && (!in_array("0", $post['sectors'])) )
		{	
			$this->db->join('operates','operates.company_id = companies.id AND operates.active = True','left');
			$this->db->join('sectors','sectors.id = operates.sector_id','left');
			$this->db->where_in('operates.sector_id',$post['sectors']);
			array_push($group_by,"operates.id"); 
		}

		// MORTGAGES
		// Defautl values
			if(empty($post['mortgage_from']) && !empty($post['mortgage_to']))
			{
				$post['mortgage_from'] = 0;
			}

			if(empty($post['mortgage_to']) && !empty($post['mortgage_from']))
			{
				$post['mortgage_to'] = 365;
			}

		if (!empty($post['mortgage_to']) && !empty($post['mortgage_from']))
		{
			
			$this->db->where('mortgages.stage', MORTGAGES_OUTSTANDING);
			$mortgage_end_from = $post['mortgage_from'];
			$mortgage_end_to = $post['mortgage_to'];
			$mortgage_endsql = "EXTRACT (doy from mortgages.eff_from) - EXTRACT (doy from now()) BETWEEN $mortgage_end_from AND $mortgage_end_to ";
			$this->db->where($mortgage_endsql,'',FALSE);
			array_push($group_by,"mortgages.id");
			$this->db->order_by('(EXTRACT (doy from mortgages.eff_from) - EXTRACT (doy from now()))','asc');
		}


		// Providers
		if(isset($post['providers']) && (!empty($post['providers'])) )
		{
			$this->db->join('providers','providers.id = mortgages.provider_id','left');
			$this->db->where('providers.id', $post['providers']);
			array_push($group_by,"providers.id"); 
		}

		// Set order by from variable
		$this->db->group_by($group_by); 
		
		// Build query 
		$query = $this->db->get();

		// Run query  
		$query->result();


		// Place query result into variable
		$companies = $query;
		
		// Flush memory cache: as we won't be repeating this query we should not keep it in memory :) 
		$this->db->flush_cache();
		
		// Populate mortgages for each company as array and make the assign to initials.
		foreach ($companies->result_object as $key => $company) {
			// Select fields 
			$this->db->select("to_char(mortgages.eff_from, 'dd/mm/yy') AS eff_from , providers.name, mortgages.stage ",FALSE);
			$this->db->from('mortgages');
			$this->db->where('mortgages.company_id',$company->id);
			$this->db->join('providers','providers.id = mortgages.provider_id','left');
			$this->db->group_by(array('providers.name', 'mortgages.stage' , 'mortgages.eff_from'));
			$this->db->order_by('mortgages.stage');
			$this->db->order_by('mortgages.eff_from');
			$mortgages = $this->db->get(); 


			// Get result as array 
			$mortgages2 = $mortgages->result_array();

			// Place the result array on the current object
			$companies->result_object[$key]->mortgages = $mortgages2;

			// Check for assign to
			// $assign_to = $company->company_assign_to;
			// if(!empty($assign_to))
			// {
			// 	$names = explode(" ", $assign_to); 
			// 	$initials = $names[0][0].$names[1][0];
			// 	$to_upper = strtoupper($initials);
			// 	// Set to array
			// 	$companies->result_object[$key]->company_assign_to = $to_upper;
			// }
		}
		
		return  $companies;
	}

	function assign_company($company_id,$user_id)
	{
		$data = array(
               'user_id' => $user_id
            );

		$this->db->update('companies', $data, array('id' => $company_id));

	    $report = array();
	    $report['error'] = $this->db->_error_number();
	    $report['message'] = $this->db->_error_message();
	    return $report;
	}

	function unassign_company($company_id)
	{
		$data = array(
               'user_id' => NULL
            );

		$this->db->update('companies', $data, array('id' => $company_id));

	    $report = array();
	    $report['error'] = $this->db->_error_number();
	    $report['message'] = $this->db->_error_message();
	    return $report;
	}

	function clear_company_sectors($id){
		$this->db->where('company_id', $id);
		$this->db->update('operates', array('active'=>'False'));
		return $this->db->affected_rows();
	}

	function update_details($post)
	{
		
		if($post['turnover'])
		{
			$this->db->set('company_id', $post['company_id']);
			$this->db->set('turnover', $post['turnover']);
			$this->db->insert('turnovers', $turnover);
			$turnover_status = $this->db->affected_rows();
		}
		else
		{
			$turnover_status = 0;
		}
		

			
		$company = array(
				'linkedin_id' => $post['linkedin_id']?$post['linkedin_id']:NULL,
				'url' => $post['url']?$post['url']:NULL,
				'contract'=>$post['contract']?$post['contract']:NULL,
				'perm'=>$post['perm']?$post['perm']:NULL,
				'updated_at' => date('Y-m-d H:i:s')
			);
		$this->db->where('id', $post['company_id']);
		$this->db->update('companies', $company);

		$company_status = $this->db->affected_rows();
		// clear existing sectors to no active 
		$result = $this->clear_company_sectors($post['company_id']);
		
		foreach ($post['sectors'] as $sector_id) {
			$this->db->set('company_id', $post['company_id']);
			$this->db->set('sector_id', $sector_id);  
			$this->db->insert('operates'); 
		}
		return $this->db->affected_rows();
	}

	function insert_entry()
	{
        $this->title   = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('entries', $this);
    }
}