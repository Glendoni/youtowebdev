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
		$this->db->join('operates','operates.company_id = companies.id','left');
		$this->db->join('sectors','sectors.id = operates.sector_id');
		$this->db->where('operates.active', 'True');
		$this->db->where('companies.id', $id);
		$this->db->where('companies.active', 'True');
		$this->db->order_by("companies.name", "asc");

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
			$assign_to = $company->company_assign_to;
			if(!empty($assign_to))
			{
				$names = explode(" ", $assign_to); 
				$initials = $names[0][0].$names[1][0];
				$to_upper = strtoupper($initials);
				// Set to array
				$companies->result_object[$key]->company_assign_to = $to_upper;
			}

			$this->db->select('turnovers.*');
			$this->db->from('turnovers');
			$this->db->where('turnovers.id',$company->id);
			$turnovers = $this->db->get(); 
			$turnovers_array = $turnovers->result_array();

			$companies->result_object[$key]->turnovers = $turnovers_array;

		}


		return $companies;
	}

	function special_query()
	{
		$query = $this->db->query('');
		return $query->result();
	}

	function search_companies($post,$company_id = False)
	{
		// Select query
		$this->db->select('companies.*,addresses.address,turnovers.turnover,turnovers.currency,turnovers.method as turnover_method');
		$this->db->from('companies');
		$this->db->join('addresses','addresses.company_id = companies.id','left');
		$this->db->join('emp_counts','emp_counts.company_id = companies.id','left');
		$this->db->where('companies.active', 'True');
		$this->db->order_by("companies.name", "asc");
		
		// $this->db->select("( SELECT T.turnover as turnover FROM turnovers T WHERE T.company_id = companies.id ORDER BY T.eff_from DESC  LIMIT 1) as turnover ",FALSE,FALSE);
		// $this->db->select("( SELECT T.currency as currency FROM turnovers T WHERE T.company_id = companies.id ORDER BY T.eff_from DESC  LIMIT 1) as currency ",FALSE,FALSE);
		// $this->db->select("( SELECT T.method as method FROM turnovers T WHERE T.company_id = companies.id ORDER BY T.eff_from DESC  LIMIT 1) as turnover_method ",FALSE,FALSE);
		
		// Employee count
		$this->db->select('(SELECT "count" FROM "emp_counts" WHERE "emp_counts"."company_id" = "companies"."id" ORDER BY "emp_counts"."created_at" DESC LIMIT 1) as emp_count', FALSE, FALSE);

		// Sectors the company is in 
		$this->db->select("(SELECT string_agg(S.name, ',') FROM sectors S,operates O WHERE O.company_id = companies.id AND S.id = O.sector_id  AND O.active = 'True') as company_sectors", FALSE, FALSE);

		// Linkedin connectioins ( need improvement , can be done once a month to another table)
		$this->db->select("(SELECT count(*) FROM connections C,employees E WHERE E.company_id = companies.id AND C.employee_id = E.id ) as company_connections", FALSE, FALSE);

		// Campaigns
		// $this->db->select("(SELECT ARRAY['CM.id', 'CM.name'] FROM campaigns CM,targets TA WHERE TA.company_id = companies.id AND TA.campaign_id = CM.id ) as company_campaigns", FALSE, FALSE);

		// Assign to
		$this->db->select("(SELECT Ad.name FROM users Ad WHERE Ad.id = companies.user_id ) as company_assign_to", FALSE, FALSE);

	
		// Group by variable to be set during filtering 
		$group_by = array('companies.id','addresses.id');

		//FILTER QUERY 

		// Agency name 
		if (isset($post['agency_name']) && strlen($post['agency_name'])) 
		{
			$this->db->like('companies.name', $post['agency_name']); 
		}
		// Turnover
		if(isset($post['turnover_from']) || isset($post['turnover_to']))
		{
			$this->db->join('turnovers','turnovers.company_id = companies.id','inner');
			$this->db->select('turnovers.id as turnover_id');
			array_push($group_by,"turnovers.id");
			
		}
		if(isset($post['turnover_from']) && (!empty($post['turnover_from'])) ) 
		{
			$this->db->where('turnovers.turnover >', $post['turnover_from']);
		}
		else
		{
			$this->db->where('turnovers.turnover >', '0');
		}

		if(isset($post['turnover_to']) && (!empty($post['turnover_to'])) )
		{
			$this->db->where('turnovers.turnover <', $post['turnover_to']);
		}else{
			$this->db->where('turnovers.turnover <', '100000000');
		}

		// Employees count 
		if(isset($post['employees_from']) || isset($post['employees_to']))
		{
			$this->db->join('emp_counts','emp_counts.company_id = companies.id','left');
			// array_push($group_by,"emp_counts.id");			
		}
		
		if(isset($post['employees_from']) && (!empty($post['employees_from'])) )
		{
			$this->db->where('emp_counts.count >', $post['employees_from']);
		}
		else
		{
			$this->db->where('emp_counts.count >', '0');
		}

		if(isset($post['employees_to']) && (!empty($post['employees_to'])) )
		{
			$this->db->where('emp_counts.count <', $post['employees_to']);
		}
		else
		{
			$this->db->where('emp_counts.count <', '20000');
		}

		// Company age
		if(isset($post['company_age_from']) && (!empty($post['company_age_from'])) )
		{
			$company_age_from = date("m-d-Y", strtotime("-".$post['company_age_from']." year"));
			$this->db->where('companies.eff_from >=', $company_age_from);
		}
		if(isset($post['company_age_to']) && (!empty($post['company_age_to'])) )
		{
			$company_age_to = date("m-d-Y", strtotime("-".$post['company_age_to']." year"));
			$this->db->where('companies.eff_from <=', $company_age_to);
		}

		// Sectors
		if( isset($post['sectors']) && (!in_array("0", $post['sectors'])) )
		{	
			$this->db->join('operates','operates.company_id = companies.id','left');
			$this->db->join('sectors','sectors.id = operates.sector_id');
			$this->db->where_in('operates.sector_id',$post['sectors']);
			$this->db->where('operates.active', 'True');
			array_push($group_by,"operates.id"); 
		}

		// Providers
		if(isset($post['providers']) && (!empty($post['providers'])) )
		{
			$this->db->join('providers','providers.id = mortgages.provider_id','left');
			$this->db->where('providers.id', $post['providers']);
			array_push($group_by,"providers.id"); 
		}

		if (isset($post['mortgage_from']) && empty($post['mortgage_from']))
		{
			$post['mortgage_from'] = 0;
		}
		if (empty($post['mortgage_to']) && empty($post['mortgage_to']))
		{
			$post['mortgage_to'] = 365;
		}
		if (!empty($post['mortgage_to']) && (!empty($post['mortgage_from'])))
		{
			$this->db->join('mortgages','mortgages.company_id = companies.id');
			$this->db->where('mortgages.stage', MORTGAGES_OUTSTANDING);
			$mortgage_end_from = $post['mortgage_from'];
			$mortgage_end_to = $post['mortgage_to'];
			$mortgage_endsql = "EXTRACT (doy from mortgages.eff_from) - EXTRACT (doy from now()) BETWEEN $mortgage_end_from AND $mortgage_end_to ";
			$this->db->where($mortgage_endsql,'',FALSE);
			array_push($group_by,"mortgages.id");
			$this->db->order_by("(doy from mortgages.eff_from) - extract (doy from now())",'asc');
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
			$assign_to = $company->company_assign_to;
			if(!empty($assign_to))
			{
				$names = explode(" ", $assign_to); 
				$initials = $names[0][0].$names[1][0];
				$to_upper = strtoupper($initials);
				// Set to array
				$companies->result_object[$key]->company_assign_to = $to_upper;
			}
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


	function insert_entry()
	{
        $this->title   = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('entries', $this);
    }
}