<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companies extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	public function index($ajax_refresh = False) 
	{	
		$session_result = $this->session->userdata('companies');
		$search_results_in_session = unserialize($session_result);
		$refresh_search_results = $this->session->flashdata('refresh');
		$campaign = $this->session->userdata('campaign_id');

		if($this->input->post('submit') and !$refresh_search_results and !$ajax_refresh and !$campaign )
		{ 
			
			$this->clear_campaign_from_session();
			// $this->clear_search_results();

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
			$this->form_validation->set_rules('class', 'class', 'xss_clean');


			if($this->form_validation->run())
			{	
				// Result set to session and current search 
				$this->seve_current_search($this->input->post());

				$raw_search_results = $this->Companies_model->search_companies_sql($this->input->post());
				
				$result = $this->process_search_result($raw_search_results);
				// var_dump($result);
				if(empty($result))
				{
					$this->session->unset_userdata('companies');
					unset($search_results_in_session);
				}
				else
				{
					$session_result = serialize($result);
					$this->session->set_userdata('companies',$session_result);
				}
			}else{
				$this->set_message_error(validation_errors());
			}
		}
		elseif ($refresh_search_results or $ajax_refresh) 
		{
			$post = $this->session->userdata('current_search');
			foreach ($post as $key => $value) {
				$_POST[$key] = $value;
			}
			$raw_search_results = $this->Companies_model->search_companies_sql($post);
			$result = $this->process_search_result($raw_search_results);
			if(empty($result))
			{
				$this->session->unset_userdata('companies');
				unset($search_results_in_session);
			}
			else
			{
				$session_result = serialize($result);
				$this->session->set_userdata('companies',$session_result);
			}
		}
		elseif (!$this->input->post('submit') and !$search_results_in_session and !$refresh_search_results) {
			$this->session->unset_userdata('companies');
			unset($search_results_in_session);
		}
		
		$companies_array = isset($result) ? $result : $search_results_in_session;

		// if campaign exist set this variables
		$this->data['current_campaign_name'] = ($this->session->userdata('campaign_name') ?: FALSE );
		$this->data['current_campaign_owner_id'] = ($this->session->userdata('campaign_owner') ?: FALSE );
		$this->data['current_campaign_id'] = ($this->session->userdata('campaign_id') ?: FALSE );
		$this->data['current_campaign_editable'] = ($this->data['current_campaign_owner_id'] == $this->get_current_user_id() ? TRUE : FALSE );
		
		$this->data['current_campaign_is_shared'] = $this->session->userdata('campaign_shared') == 'f'? FALSE : TRUE; 

		if(empty($companies_array))
		{
			$this->session->unset_userdata('companies');
			$this->data['companies_count'] = 0;
			$this->data['page_total'] = 0;
			$this->data['current_page_number'] = 0;
			$this->data['next_page_number'] = FALSE;
			$this->data['previous_page_number'] =  FALSE;
			$this->data['companies'] = array();

			$this->data['main_content'] = 'companies/search_results';
			$this->load->view('layouts/default_layout', $this->data);
		}else{
			// get companies from recent result or get it from session
			$companies_array_chunk = array_chunk($companies_array, RESULTS_PER_PAGE);
			$current_page_number = $this->input->get('page_num') ? $this->input->get('page_num') : 1;
			$this->data['companies_count'] = count($companies_array);
			$pages_count = ceil(count($companies_array)/RESULTS_PER_PAGE);
			$this->data['page_total'] = ($pages_count < 1)? 1 : $pages_count;
			$this->data['current_page_number'] = $current_page_number;
			$this->data['next_page_number'] = ($current_page_number+1) <= $this->data['page_total'] ? ($current_page_number+1) : FALSE;
			$this->data['previous_page_number'] = ($current_page_number-1) >= 0 ? ($current_page_number-1) : FALSE;
			$this->data['companies'] = $companies_array_chunk[($current_page_number-1)];


			$this->data['main_content'] = 'companies/search_results';
			$this->load->view('layouts/default_layout', $this->data);
		}
		
	}

	public function _valid_name(){
		$result_name = $this->Companies_model->get_company_by_name($this->input->post('name'));
	
		if(empty($result_name)){
			return TRUE;
		}else{
			$this->form_validation->set_message('_valid_name', 'Company already in database with that name');
			return FALSE;
		}
	}

	public function _valid_registration(){
		if($this->input->post('registration')){
			$result_registration = $this->Companies_model->get_company_by_registration($this->input->post('registration'));
			if(!empty($result_registration)){
				$this->form_validation->set_message('_valid_registration', 'Company already in database with that registration');
				return FALSE;
			}
		}
		return TRUE;
	}


	public function create_company(){
		if($this->input->post('create_company_form')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('linkedin_id', 'linkedin id', 'xss_clean');
			$this->form_validation->set_rules('registration', 'registration', 'xss_clean|callback__valid_registration');
			$this->form_validation->set_rules('name', 'name', 'xss_clean|required|callback__valid_name');
			$this->form_validation->set_rules('url', 'url', 'xss_clean');
			$this->form_validation->set_rules('ddlink', 'ddlink', 'xss_clean');
			$this->form_validation->set_rules('contract', 'contract', 'xss_clean');
			$this->form_validation->set_rules('perm', 'perm', 'xss_clean');
			$this->form_validation->set_rules('phone', 'phone', 'xss_clean');
			$this->form_validation->set_rules('company_class', 'company_class', 'xss_clean');
			$this->form_validation->set_rules('eff_from','eff_from','xss_clean');

			// address
			$this->form_validation->set_rules('country_id', 'country_id', 'xss_clean|required');
			$this->form_validation->set_rules('address', 'address', 'xss_clean|required');
			$this->form_validation->set_rules('lat', 'latitude', 'xss_clean');
			$this->form_validation->set_rules('lng', 'longitude', 'xss_clean');
			$this->form_validation->set_rules('type', 'type', 'xss_clean');

			if($this->form_validation->run())
			{
				$result = $this->Companies_model->create_company($this->input->post());
				if($result == TRUE) {
					$this->set_message_success('New company successfully created');
					redirect('/companies/create_company','location');
				}else{
					$this->set_message_error('Error in the database while creating company');
					redirect('/companies/create_company','location');
				}
			}else{
				$this->set_message_error(validation_errors());
				redirect('/companies/create_company','location');
			}
		}
		
		$this->data['country_options'] = $this->Companies_model->get_countries_options();
		$this->data['hide_side_nav'] = True;
		$this->data['main_content'] = 'companies/create_company';
		$this->load->view('layouts/single_page_layout', $this->data);
		

	}

	public function assignto()
	{
		if($this->input->post('company_id') && $this->input->post('user_id'))
		{
			$rows_affected = $this->Companies_model->assign_company($this->input->post('company_id'),$this->input->post('user_id'));
			if($rows_affected > 0)
			{
				// Clear search in session 
				$this->refresh_search_results();
				// redirect('/companies?page_num='.$this->input->post('page_number'),'refresh');
			}
			else
			{
				$this->set_message_error('Error while inserting to database');
				$this->refresh_search_results();
				// redirect('/companies?page_num='.$this->input->post('page_number'),'refresh');
			}
		}
		return True;
	}

	public function unassign()
	{
		if($this->input->post('company_id') && $this->input->post('user_id'))
		{
			$rows_affected = $this->Companies_model->unassign_company($this->input->post('company_id'));
			if($rows_affected > 0)
			{
				// Clear search in session 
				$this->refresh_search_results();
				// redirect('/companies?page_num='.$this->input->post('page_number'),'refresh');
			}
			else
			{
				$this->set_message_error('Error while inserting to database');
				$this->refresh_search_results();
				// redirect('/companies?page_num='.$this->input->post('page_number'),'refresh');
			}
		}
		return True;
	}

	
	public function company()
	{
		if($this->input->get('id'))
		{	
			$this->load->model('Email_templates_model');
			$this->data['email_templates'] = $this->Email_templates_model->get_all();
			$raw_search_results = $this->Companies_model->search_companies_sql(FALSE,$this->input->get('id'));
			$company = $this->process_search_result($raw_search_results);
			$this->data['contacts'] = $this->Contacts_model->get_contacts($this->input->get('id'));
			$option_contacts =  array();
			foreach ($this->data['contacts'] as $contact) {
				$option_contacts[$contact->id] = $contact->first_name.' '.$contact->last_name;
			}
			$this->data['option_contacts'] = $option_contacts;
			$this->data['action_types_done'] = $this->Actions_model->get_action_types_done();
			$this->data['action_types_planned'] = $this->Actions_model->get_action_types_planned();
			$this->data['action_types_array'] = $this->Actions_model->get_action_types_array();
			$this->data['actions_outstanding'] = $this->Actions_model->get_actions_outstanding($this->input->get('id'));
			$this->data['actions_completed'] = $this->Actions_model->get_actions_completed($this->input->get('id'));
			$this->data['actions_cancelled'] = $this->Actions_model->get_actions_cancelled($this->input->get('id'));
			$this->data['actions_marketing'] = $this->Actions_model->get_actions_marketing($this->input->get('id'));
			$this->data['comments'] = $this->Actions_model->get_comments($this->input->get('id'));
			$this->data['page_title'] = $company[0]['name'];
			$this->data['companies'] = $company;
			$this->data['hide_side_nav'] = True;
			$this->data['main_content'] = 'companies/company';
			$this->load->view('layouts/single_page_layout', $this->data);
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
			// We need to clean the post and validate the post fields *pending*
			$result = $this->Companies_model->update_details($this->input->post());
			$this->refresh_search_results();
			redirect('/companies','refresh');
			return True;
		}
	}

	private function process_search_result($raw_search_results){
		 // print_r($raw_search_results[0]['json_agg']);
		
		$companies_json = json_decode($raw_search_results[0]['json_agg']);

		if(empty($companies_json )) return false;

		$companies_array = array();
		foreach ($companies_json as $company) {
			$mapped_companies_array = array();
			if($company->company->f1->f1)$mapped_companies_array['id'] = $company->company->f1->f1;
			if($company->company->f1->f2)$mapped_companies_array['name'] = $company->company->f1->f2;
			if($company->company->f1->f3)$mapped_companies_array['url'] = $company->company->f1->f3;
			if($company->company->f1->f4)$mapped_companies_array['eff_from'] = $company->company->f1->f4;
			if($company->company->f1->f5)$mapped_companies_array['ddlink'] = $company->company->f1->f5;
			if($company->company->f1->f6)$mapped_companies_array['linkedin_id'] = $company->company->f1->f6;
			if($company->company->f1->f7)$mapped_companies_array['assigned_to_name'] = $company->company->f1->f7;
			if($company->company->f1->f21)$mapped_companies_array['assigned_to_image'] = $company->company->f1->f21;
			if($company->company->f1->f22)$mapped_companies_array['class'] = $company->company->f1->f22;
			if($company->company->f1->f23)$mapped_companies_array['address_lat'] = $company->company->f1->f23;
			if($company->company->f1->f24)$mapped_companies_array['address_lng'] = $company->company->f1->f24;
			if($company->company->f1->f26)$mapped_companies_array['phone'] = $company->company->f1->f26;


			if($company->company->f1->f8)$mapped_companies_array['assigned_to_id'] = $company->company->f1->f8;
			if($company->company->f1->f9)$mapped_companies_array['address'] = $company->company->f1->f9;
			if($company->company->f1->f10)$mapped_companies_array['contract'] = $company->company->f1->f10;
			if($company->company->f1->f11)$mapped_companies_array['perm'] = $company->company->f1->f11;
			if($company->company->f1->f12)$mapped_companies_array['active'] = (bool)$company->company->f1->f12;
			if($company->company->f1->f13)$mapped_companies_array['created_at'] = (bool)$company->company->f1->f13;
			if($company->company->f1->f14)$mapped_companies_array['updated_at'] = (bool)$company->company->f1->f14;
			if($company->company->f1->f15)$mapped_companies_array['created_by'] = $company->company->f1->f15;
			if($company->company->f1->f16)$mapped_companies_array['updated_by'] = $company->company->f1->f16;
			if($company->company->f1->f17)$mapped_companies_array['registration'] = $company->company->f1->f17;
			if($company->company->f1->f18)$mapped_companies_array['turnover'] = $company->company->f1->f18;
			if($company->company->f1->f19)$mapped_companies_array['turnover_method'] = $company->company->f1->f19;
			if($company->company->f1->f20)$mapped_companies_array['emp_count'] = $company->company->f1->f20;
			if($company->company->f1->f27)$mapped_companies_array['pipeline'] = $company->company->f1->f27;
			if($company->company->f1->f28)$mapped_companies_array['contacts_count'] = $company->company->f1->f28;

			
			// sectors

			if(!empty($company->company->f1->f25)){
				$sectors = array();
				foreach ($company->company->f1->f25 as $sector) {
					if(isset($sector->f1) && !empty($sector->f1)) 
						$sectors[$sector->f1] = $sector->f2;
				}
				if(!empty($sectors)) $mapped_companies_array['sectors'] = $sectors;
			}
			
			// mortgages 
			if(isset($company->company->f2) && (empty($company->company->f2) == False)){
				$mortgages_array = array();
				foreach ($company->company->f2 as $mortgage) {
					$mortgages = array();
					$mortgages['id'] = $mortgage->f1;
					$mortgages['name'] = $mortgage->f2;
					$mortgages['stage'] = $mortgage->f3;
					$mortgages['eff_from'] = $mortgage->f4;
					$mortgages['eff_to'] = $mortgage->f5;
					$mortgages['type'] = $mortgage->f6;

					$mortgages_array[] = $mortgages;
				}
				$mapped_companies_array['mortgages'] = $mortgages_array;
			}
			$companies_array[]= $mapped_companies_array;
		}
		return $companies_array;
	}

	public function autocomplete() {
        $search_data = $this->input->post("search_data");
		$response = "<ul class='autocomplete-holder'>";
        $query = $this->Companies_model->get_autocomplete($search_data);
        $rowcount = $query->num_rows();
		if ($rowcount> 0) {
			$response= $response."<li class='autocomplete-item split-heading'><i class='fa fa-caret-square-o-down'></i> Companies</li>";
		}
		else
		{
			$response= $response."<li class='autocomplete-item split-heading autocomplete-no-results'><i class='fa fa-times'></i> No Companies Found</li>";
		}
        $words = array( 'Limited', 'LIMITED', 'LTD','ltd','Ltd' );
        foreach ($query->result() as $row):
        	if(!empty($row->user)) { 
        		$user_icon = explode(",", $row->image);

        		$assigned_label = "| <span class='label label-primary' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$row->user."</div>";};
        	 
		$response= $response."<a target='_blank' href='". base_url() . "companies/company?id=" . $row->id . "'><li class='autocomplete-item'><strong>" . str_replace($words, ' ',$row->name). "</strong><br><small>".$row->pipeline." ".$assigned_label."</small></li></a>";
        endforeach;
		$query = $this->Companies_model->get_autocomplete_contact($search_data);
		$rowcount = $query->num_rows();
		if ($rowcount> 0) {
			$response= $response."<li class='autocomplete-item split-heading'><i class='fa fa-caret-square-o-down'></i> Contacts</li>";
		} else{
			$response= $response."<li class='autocomplete-item split-heading autocomplete-no-results'><i class='fa fa-times'></i> No Contacts Found</li>";
		}
 		foreach ($query->result() as $row):
            $response= $response."<a target='_blank' href='". base_url() . "companies/company?id=" . $row->id . "#contacts'><li class='autocomplete-item'>" . str_replace($words, ' ',$row->name). "</strong><br><small>".$row->company_name."</small></li></a>";
        endforeach;
        $response= $response."</ul>";
        $this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('html'=> $response)));
    }
}