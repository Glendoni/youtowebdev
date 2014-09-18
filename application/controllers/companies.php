<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companies extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('Companies_model');
	}
	
	public function index($ajax_refresh = False) 
	{
		$session_result = $this->session->userdata('companies');
		$search_results_in_session = unserialize($session_result);
		$refresh_search_results = $this->session->flashdata('refresh');

		if($this->input->post('submit') and !$refresh_search_results and !$ajax_refresh )
		{ 
			
			$this->clear_campaign_from_session();

			$this->load->library('form_validation');
			$this->form_validation->set_rules('agency_name', 'agency_name', 'xss_clean');
			$this->form_validation->set_rules('turnover_from', 'turnover_from', 'xss_clean');
			$this->form_validation->set_rules('turnover_to', 'turnover_to', 'xss_clean');
			$this->form_validation->set_rules('employees_from', 'employees_from', 'xss_clean');
			$this->form_validation->set_rules('employees_to', 'employees_to', 'xss_clean');
			$this->form_validation->set_rules('company_age_from', 'company_age_from', 'xss_clean');
			$this->form_validation->set_rules('company_age_to', 'company_age_to', 'xss_clean');
			$this->form_validation->set_rules('sectors', 'sectors', 'xss_clean');
			$this->form_validation->set_rules('providers', 'providers', 'xss_clean');
			$this->form_validation->set_rules('mortgage_from', 'anniversary_from', 'xss_clean');
			$this->form_validation->set_rules('mortgage_to', 'anniversary_to', 'xss_clean');
			$this->form_validation->set_rules('assigned', 'assigned', 'xss_clean');

			if($this->form_validation->run())
			{	
				// Result set to session and current search 
				$this->seve_current_search($this->input->post());

				$result = $this->Companies_model->search_companies_sql($this->input->post());
				
				$companies_json = json_decode($result[0]['json_agg']);
				// print "<pre>";
				// print_r($companies_json);
				// print "</pre>";
				// die;

				$companies_array = array();
				foreach ($companies_json as $company) {
					$mapped_companies_array = array();
					if($company->company->f1->f1)$mapped_companies_array['id'] = $company->company->f1->f1;
					if($company->company->f1->f2)$mapped_companies_array['name'] = $company->company->f1->f2;
					if($company->company->f1->f3)$mapped_companies_array['url'] = $company->company->f1->f3;
					if($company->company->f1->f4)$mapped_companies_array['eff_from'] = $company->company->f1->f4;
					if($company->company->f1->f5)$mapped_companies_array['ddlink'] = $company->company->f1->f5;
					if($company->company->f1->f6)$mapped_companies_array['linkedin_id'] = $company->company->f1->f6;
					if($company->company->f1->f7)$mapped_companies_array['assignedto'] = $company->company->f1->f7;
					if($company->company->f1->f8)$mapped_companies_array['turnover'] = $company->company->f1->f8;
					if($company->company->f1->f9)$mapped_companies_array['turnover_method'] = $company->company->f1->f9;
					if($company->company->f1->f11)$mapped_companies_array['contract'] = (bool)$company->company->f1->f11;
					if($company->company->f1->f12)$mapped_companies_array['perm'] = (bool)$company->company->f1->f12;
					if($company->company->f1->f13)$mapped_companies_array['active'] = (bool)$company->company->f1->f13;
					if($company->company->f1->f14)$mapped_companies_array['created_at'] = $company->company->f1->f14;
					if($company->company->f1->f15)$mapped_companies_array['updated_at'] = $company->company->f1->f15;
					if($company->company->f1->f16)$mapped_companies_array['created_by'] = $company->company->f1->f16;
					if($company->company->f1->f17)$mapped_companies_array['updated_by'] = $company->company->f1->f17;
					if($company->company->f1->f18)$mapped_companies_array['registration'] = $company->company->f1->f18;
					
					// mortgages
					if($company->company->f1->f10){
						$sectors_array = array();
						foreach ($company->company->f1->f10 as $sector) {
							if(isset($sector->f1) && !empty($sector->f1)) $sectors_array[$sector->f1] = $sector->f2;
						}
						
						if(empty($sectors_array) == False) $mapped_companies_array['sectors'] = $sectors_array;
					}
					

					// sectors 
					if(isset($company->company->f2) && (empty($company->company->f2) == False)){
						$mortgages_array = array();
						foreach ($company->company->f2 as $mortgage) {
							$mortgages = array();
							$mortgages['id'] = $mortgage->f1;
							$mortgages['name'] = $mortgage->f2;
							$mortgages['stage'] = $mortgage->f3;
							$mortgages['eff_from'] = $mortgage->f4;
							$mortgages_array[] = $mortgages;
						}
						$mapped_companies_array['mortgages'] = $mortgages_array;
					}
					$companies_array[]= $mapped_companies_array;
				}
				// print "<pre>";
				// print_r($companies_array);
				// print "</pre>";
				$result =  $companies_array;
				// if new search clear old data and campaigns from session
				$this->clear_campaign_from_session();

				if(empty($result))
				{
					$this->set_message_warning('No result found for query.');
					$this->data['main_content'] = 'dashboard/home';
					$this->load->view('layouts/default_layout', $this->data);
					return False;
				}
				else
				{
					$session_result = serialize($result);
					$this->session->set_userdata('companies',$session_result);
				}
			}
		}
		elseif ($refresh_search_results or $ajax_refresh) 
		{
			$post = $this->session->userdata('current_search');
			foreach ($post as $key => $value) {
				$_POST[$key] = $value;
			}
			$result = $this->Companies_model->search_companies_sql($post);
			if(empty($result))
			{
				$this->set_message_warning('No result found for query.');
				$this->data['main_content'] = 'dashboard/home';
				$this->load->view('layouts/default_layout', $this->data);
				return False;
			}
			else
			{
				$session_result = serialize($result);
				$this->session->set_userdata('companies',$session_result);
				
			}
		}
		elseif (!$this->input->post('submit') and !$search_results_in_session and !$refresh_search_results) {
			$this->set_message_warning('No result found for query.');
			$this->data['main_content'] = 'dashboard/home';
			$this->load->view('layouts/default_layout', $this->data);
			return False;
		}

		
		$companies_array = $result ? $result : $search_results_in_session;
		
		if(empty($companies_array))
		{
			$this->set_message_warning('No result found for query.');
			$this->data['main_content'] = 'dashboard/home';
			$this->load->view('layouts/default_layout', $this->data);
			return False;
		}
		// get companies from recent result or get it from session
		$companies_array_chunk = array_chunk($companies_array, RESULTS_PER_PAGE);
		$current_page_number = $this->input->get('page_num') ? $this->input->get('page_num') : 1;
		$this->data['companies_count'] = count($companies_array);
		$this->data['page_total'] = round($this->data['companies_count']/RESULTS_PER_PAGE);
		$this->data['current_page_number'] = $current_page_number;
		$this->data['next_page_number'] = ($current_page_number+1) <= $this->data['page_total'] ? ($current_page_number+1) : FALSE;
		$this->data['previous_page_number'] = ($current_page_number-1) >= 0 ? ($current_page_number-1) : FALSE;
		$this->data['sectors_array'] = $this->session->userdata('sectors_array');
		$this->data['companies'] = $companies_array_chunk[($current_page_number-1)];

		$this->data['main_content'] = 'companies/search_results';
		$this->load->view('layouts/default_layout', $this->data);
	}


	public function assignto()
	{
		if($this->input->post('company_id') && $this->input->post('user_id'))
		{
			$result = $this->Companies_model->assign_company($this->input->post('company_id'),$this->input->post('user_id'));
			if(!$result['error'])
			{
				// Clear search in session 
				$this->index($ajax_refresh=True);
				// redirect('/companies?page_num='.$this->input->post('page_number'),'refresh');
			}
			else
			{
				$this->set_message_error($result['message']);
				$this->index();
				// redirect('/companies?page_num='.$this->input->post('page_number'),'refresh');
			}
		}
		return True;
	}

	public function unassign()
	{
		if($this->input->post('company_id') && $this->input->post('user_id'))
		{
			$result = $this->Companies_model->unassign_company($this->input->post('company_id'));
			if(!$result['error'])
			{
				// Clear search in session 
				$this->index($ajax_refresh=True);
				// redirect('/companies?page_num='.$this->input->post('page_number'),'refresh');
			}
			else
			{
				$this->set_message_error($result['message']);
				$this->index();
				// redirect('/companies?page_num='.$this->input->post('page_number'),'refresh');
			}
		}
		return True;
	}

	public function refreshsearch()
	{
		$this->refresh_search_results();
		redirect('/companies','refresh');	
	}

	public function company()
	{
		if($this->input->get('id'))
		{
			$company = $this->Companies_model->get_company_by_id($this->input->get('id'));
			$this->data['action_types'] = $this->Actions_model->get_action_types();
			$this->data['actions'] = $this->Actions_model->get_actions($this->input->get('id'));
			$this->data['companies'] = $company->result_object;
			$this->data['main_content'] = 'companies/company';
			$this->load->view('layouts/default_layout', $this->data);
		}
		else
		{
			$this->set_message_error('No company id passed.');
			redirect('/dashboard','refresh');
		}
	}

	public function edit()
	{
		if($this->input->post('edit_company'))
		{
			$result = $this->Companies_model->update_details($this->input->post());
			$this->refreshsearch();
		}
	}

}
