<?php
class Companies_model extends CI_Model {
	
	function get_all()
	{
		$query = $this->db->get('companies',10);	
		return $query->result();
	}

	function special_query($dfds)
	{
		$query = $this->db->query('');
		return $query->result();
	}

	function search_companies($post,$page_num,$page_rows = 30)
	{
		$this->db->select('companies.*,addresses.address,turnovers.turnover,turnovers.currency,turnovers.method as turnover_method');
		$this->db->from('companies');
		// $this->db->join('employees ','employees.company_id = companies.id','left');
		$this->db->join('addresses','addresses.company_id = companies.id','left');
		$this->db->where('companies.active', 'True');
		$this->db->order_by("companies.name", "asc");
		
		// Employee count
		$this->db->select('(SELECT "count" FROM "emp_counts" WHERE "emp_counts"."company_id" = "companies"."id" ORDER BY "emp_counts"."created_at" DESC LIMIT 1) as emp_count', FALSE, FALSE);

		// Sectors the company is in 
		$this->db->select("(SELECT string_agg(S.name, ',') FROM sectors S,operates O WHERE O.company_id = companies.id AND S.id = O.sector_id  AND O.active = 'True') as company_sectors", FALSE, FALSE);

		//Linkedin connectioins ( need improvement , can be done once a month to another table)
		$this->db->select("(SELECT count(*) FROM connections C,employees E WHERE E.company_id = companies.id AND C.employee_id = E.id ) as company_connections", FALSE, FALSE);

		// Campaigns
		// $this->db->select("(SELECT ARRAY['CM.id', 'CM.name'] FROM campaigns CM,targets TA WHERE TA.company_id = companies.id AND TA.campaign_id = CM.id ) as company_campaigns", FALSE, FALSE);

		// Assign to
		$this->db->select("(SELECT Ad.name FROM users Ad WHERE Ad.id = companies.user_id ) as company_assignto", FALSE, FALSE);

		// Mortgage info
		// $this->db->select("(SELECT Pr.name, Mr.stage , Mr.eff_from FROM mortgages Mr,providers Pr WHERE Mr.company_id = companies.id AND Mr.provider_id = Pr.id AND Mr.search = 'True' ORDER BY Mr.stage ASC, Mr.eff_from desc) as company_mortgage", FALSE, FALSE);

		//Variables 
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
			$this->db->join('turnovers','turnovers.company_id = companies.id','left');
			$this->db->select('turnovers.id as turnover_id');
			array_push($group_by,"turnovers.id");
			
		}
		if(isset($post['turnover_from'])) 
		{
			$this->db->where('turnovers.turnover >', $post['turnover_from']);
		}
		else
		{
			$this->db->where('turnovers.turnover >', '0');
		}
		if(isset($post['turnover_to']) && $post['turnover_to'] !== '0' )
		{
			$this->db->where('turnovers.turnover <', $post['turnover_to']);
		}else{
			$this->db->where('turnovers.turnover <', '100000000');
		}

		// Employess
		if(isset($post['employees_from']) || isset($post['employees_to']))
		{
			$this->db->join('emp_counts','emp_counts.company_id = companies.id','left');
			// array_push($group_by,"emp_counts.id");			
		}
		
		if(isset($post['employees_from']))
		{
			$this->db->where('emp_counts.count >', $post['employees_from']);
		}
		else
		{
			$this->db->where('emp_counts.count >', '0');
		}

		if(isset($post['employees_to']) && $post['employees_to'] !== '0' )
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
		if(isset($post['providers']) && $post['providers'] !== '0' )
		{
			$this->db->join('providers','providers.id = mortgages.provider_id','left');
			$this->db->where('providers.id', $post['providers']);
			array_push($group_by,"providers.id"); 
		}

		if (isset($post['mortgage_from']) && (!empty($post['mortgage_to'])))
		{
			$post['mortgage_from'] = 0;
		}
		if (empty($post['mortgage_to']) && (!empty($post['mortgage_from'])))
		{
			$post['mortgage_to'] = 365;
		}
		if (!empty($post['mortgage_to']) || (!empty($post['mortgage_from'])))
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

		
		// set order by 
		$this->db->group_by($group_by); 
		

		$query = $this->db->get();
		// seved query resutl to data base 
		$query->result();
		$companies = $query;
	
		$this->db->flush_cache();
		
		// populate mortgages for companys as array
		foreach ($companies->result_object as $key => $company) {

			$this->db->select("to_char(mortgages.eff_from, 'DD/Mon/YYYY') AS eff_from , providers.name, mortgages.stage ",FALSE);
			$this->db->from('mortgages');
			$this->db->where('mortgages.company_id',$company->id);
			$this->db->join('providers','providers.id = mortgages.provider_id','left');
			$this->db->group_by(array('providers.name', 'mortgages.stage' , 'mortgages.eff_from'));
			$this->db->order_by('mortgages.eff_from', $order_by);
			$mortgages = $this->db->get(); 
			$mortgages2 = $mortgages->result_array();
			$companies->result_object[$key]->mortgages = $mortgages2;
			// $company['mortgages'] = $mortgages2;
		}
		
		return  $companies;
	}

	function insert_entry()
	{
        $this->title   = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('entries', $this);
    }
}