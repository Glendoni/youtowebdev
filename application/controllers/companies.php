<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companies extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('Companies_model');

	}
	
	public function index($ajax_refresh = False) 
	{
		$search_results_in_session = $this->session->userdata('companies');
		$refresh_search_results = $this->session->flashdata('refresh');

		if($this->input->post('submit') and !$refresh_search_results and !$ajax_refresh )
		{

			var_dump($this->input->post());

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

			if($this->form_validation->run())
			{	
				// Result set to session and current search 
				$this->seve_current_search($this->input->post());

				$result = $this->Companies_model->search_companies($this->input->post());

				if(empty($result))
				{
					$this->set_message_info('No result found for query');
					redirect('/dashboard');
				}
				else
				{
					$this->session->set_userdata('companies',$result);
				}
			}
		}
		elseif ($refresh_search_results or $ajax_refresh) 
		{
			$post = $this->session->userdata('current_search');
			$result = $this->Companies_model->search_companies($post);
			if(empty($result))
			{
				$this->set_message_warning('No result found for query. :( ');
				redirect('/dashboard');
			}
			else
			{
				$this->session->set_userdata('companies',$result);
			}
		}
		elseif (!$this->input->post('submit') and !$search_results_in_session and !$refresh_search_results) {
			redirect('/dashboard');
		}

		
		$companies_array = $result ? $result->result_object : $search_results_in_session->result_object;

		if(empty($companies_array))
		{
			$this->set_message_error('No results return for query.');
			// redirect('/dashboard','refresh');
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
		$this->data['companies_chunk'] = $companies_array_chunk[($current_page_number-1)];
		$this->data['main_content'] = 'companies/list';
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
			$this->data['company'] = $company->result_object[0];
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
