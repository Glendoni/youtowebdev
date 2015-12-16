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
		$saved_search = $this->session->userdata('saved_search_id');

		// print_r($this->input->post());
		if($this->input->post('submit') and !$refresh_search_results and !$ajax_refresh and !$saved_search )
		{ 
			
			$this->clear_saved_search_from_session();
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
		$this->data['current_campaign_name'] = ($this->session->userdata('saved_search_name') ?: FALSE );
		$this->data['current_campaign_owner_id'] = ($this->session->userdata('saved_search_owner') ?: FALSE );
		$this->data['current_campaign_id'] = ($this->session->userdata('saved_search_id') ?: FALSE );
		$this->data['current_campaign_editable'] = ($this->data['current_campaign_owner_id'] == $this->get_current_user_id() ? TRUE : FALSE );
		
		$this->data['current_campaign_is_shared'] = $this->session->userdata('saved_search_shared') == 'f'? FALSE : TRUE; 
		if(empty($companies_array))
		{
			$this->session->unset_userdata('companies');
			$this->data['companies_count'] = 0;
			$this->data['page_total'] = 0;
			$this->data['current_page_number'] = 0;
			$this->data['next_page_number'] = FALSE;
			$this->data['previous_page_number'] =  FALSE;
			$this->data['companies'] = array();
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
		}
		$this->data['results_type'] = 'Saved Search';
		$this->data['edit_page'] = 'edit_saved_search';
		$this->data['main_content'] = 'companies/search_results';
		$this->data['full_container'] = True;
		$this->load->view('layouts/default_layout', $this->data);

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
			$this->form_validation->set_rules('employees', 'employees', 'xss_clean');
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
		$this->data['full_container'] = True;
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
        //    $this->data['companieshack'] = $this->Companies_model->hackmorgages($this->input->get('id'));
			$company = $this->process_search_result($raw_search_results);
           // $this->data['companieshack'] = $this->Companies_model->hackmorgages($this->input->get('id'));
			$this->data['contacts'] = $this->Contacts_model->get_contacts($this->input->get('id'));
            $address = $this->Companies_model->get_addresses($this->input->get('id'));
            foreach ($address as $row)
            {
                if($row->created_by){
                    $user_id =  $row->created_by; 
                break; 
                }
            }
			$this->data['addresses'] = $address;
			$this->data['campaigns'] = $this->Campaigns_model->get_campaigns($this->input->get('id'));
            $this->data['created_by_name'] = $this->Users_model->get_user($user_id);
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
			$this->data['get_actions'] = $this->Actions_model->get_actions($this->input->get('id'));
			$this->data['comments'] = $this->Actions_model->get_comments($this->input->get('id'));
			$this->data['page_title'] = $company[0]['name'];
			$this->data['companies'] = $company;
           
			$this->data['hide_side_nav'] = True;
			$this->data['main_content'] = 'companies/company';
			$this->data['full_container'] = True;
			$this->load->view('layouts/single_page_layout', $this->data);
		}
		else
		{
			$this->set_message_error('No company id passed.');
			redirect('/dashboard','refresh');
		}
	}
    
    
    public function hackmorgages(){
        // this is a redunudent function
        $compohack =  $this->Companies_model->hackmorgages(346339);
        
        //echo $compohack->name;
        
    }
    
    
    
    
	public function edit()
	{
		if($this->input->post('edit_company'))
		{

			$post = $this->input->post();
			
			// We need to clean the post and validate the post fields *pending*
			$result = $this->Companies_model->update_details($this->input->post());
			$this->refresh_search_results();
			$this->set_message_success('Company Updated');
			redirect('/companies','refresh');
			return True;
		
		}
	}

    public function create_address(){
		if($this->input->post('create_address')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('phone', 'phone', 'xss_clean');
			$this->form_validation->set_rules('country_id', 'country_id', 'xss_clean|required');
			$this->form_validation->set_rules('address', 'address', 'xss_clean|required');
			$this->form_validation->set_rules('address_types', 'address_types', 'xss_clean');
			if($this->form_validation->run())
			{
				$rows_affected = $this->Companies_model->create_address($this->input->post());


				if($rows_affected  > 0)
				{
				$this->set_message_success('Address has been added.');
					redirect('/companies/company?id='.$this->input->post('company_id'));
					// $this->refresh_search_results();
				}
				else
				{
					$array = array('error'=>'<p>Error while creating address</p>');
					$this->output->set_status_header('400');
					$this->output->set_output(json_encode($array));
				}
			}
			else
			{
				
				$array = array('error'=>validation_errors());
				$this->output->set_status_header('400');
				$this->output->set_output(json_encode($array));
			}
		}else{
			
			$array = array('error'=>'<p>Missing information on form</p>');
			$this->output->set_status_header('400');
			$this->output->set_output(json_encode($array));
		}

	}

		public function update_address()
        {
		if($this->input->post('update_address'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('address', 'address', 'xss_clean|required');
			$this->form_validation->set_rules('address_types', 'address_types', 'xss_clean|required');
			$this->form_validation->set_rules('country_id', 'country_id', 'xss_clean');
			$this->form_validation->set_rules('phone', 'phone', 'xss_clean');
			$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
			
			if($this->form_validation->run())
			{
				$rows_affected = $this->Companies_model->update_address($this->input->post());
				if($rows_affected)
				{
					$this->set_message_success('Address has been updated.');
					redirect('/companies/company?id='.$this->input->post('company_id'));
					// $this->refresh_search_results();
				}
				else
				{
					$this->set_message_error('Error while updating contact.');
					redirect('/companies/company?id='.$this->input->post('company_id'));
				}
			}
			else
			{
				
				$this->set_message_error(validation_errors());
				redirect('/companies/company?id='.$this->input->post('company_id'));
			}
		}
	}


	public function autocomplete() 
    {
        
        $callCH = true;
        $search_data = trim($this->input->post("search_data"));
		$response = "<div class='autocomplete-full-holder'><div class='col-md-6 clearfix no-padding'><ul class='autocomplete-holder'>";
        
        
        $query = $this->Companies_model->get_autocomplete($search_data);
        
        
        $rowcount = $query->num_rows();
		if ($rowcount> 0) {
			$response= $response."<li class='autocomplete-item split-heading'><i class='fa fa-caret-square-o-down'></i> Companies</li>";
 
		}
		else
		{
            
            $response= $response."<li class='autocomplete-item split-heading autocomplete-no-results'><i class='fa fa-times'></i> No Companies Found</li>";
           // $callCH = false;
           // $responsed=  $response.$this->getCompanyHouseDetails(08245800);
            
		}
        $words = array( 'Limited', 'LIMITED', 'LTD','ltd','Ltd' );
        foreach ($query->result() as $row):
        	if(!empty($row->user)) { 
        		$user_icon = explode(",", $row->image);
        		$assigned_label = "| <span class='label label-primary' style='background-color:".$user_icon[1]."; color:".$user_icon[2].";'>".$row->user."</span>";};
        	 
		$response= $response."<a href='". base_url() . "companies/company?id=" . $row->id . "'><li class='autocomplete-item autocomplete-company'><strong>" . str_replace($words, ' ',$row->name). "</strong><br><small>".$row->pipeline." ".$assigned_label."</small></li></a>";
         //$callCH = false;
        endforeach;
        $response= $response."</ul></div>";
        $response= $response."<div class='col-md-6 no-padding'><ul class='autocomplete-holder'>";

		$query = $this->Companies_model->get_autocomplete_contact($search_data);

		$rowcount = $query->num_rows();
		if ($rowcount> 0) {
			$response= $response."<li class='autocomplete-item split-heading'><i class='fa fa-caret-square-o-down'></i> Contacts</li>";
           $callCH = true;
		} else{
			$response= $response."<li class='autocomplete-item split-heading autocomplete-no-results'><i class='fa fa-times'></i> No Contacts Found</li>";
           $callCH = false;
		}
        
     
 		foreach ($query->result() as $row):
            $response= $response."<a href='". base_url() . "companies/company?id=" . $row->id . "#contacts'><li class='autocomplete-item autocomplete-contact'><strong>" . str_replace($words, ' ',$row->name). "</strong><br><small>".$row->company_name."</small></li></a>";
           //
     
        
        endforeach;
        
    
        
        $response= $response."</ul></div>";
        $this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('html'=> $response, 'callCH'=> $callCH))); //callCH = return true or false (default) call company house function
        
        
       // $responsed=  $this->getCompanyHouseDetails(08245800);
    }
    	public function getCompany() 
        {
            header('Content-Type : application/json');
            $obj = json_decode($_POST);
            $output = array(
            'registration' => $_POST['registration'],
                'user_id' => $_POST['user_id'],
             'company_type' => $_POST['company_type']   
                
            );
            
            if($this->input->post('postal_code')){  

                // file_put_contents('glen.txt', 'this has ran');

                $this->load->library('form_validation');
                $this->form_validation->set_rules('registration', 'registration', 'xss_clean');
                $this->form_validation->set_rules('name', 'name', 'xss_clean|required');
                $this->form_validation->set_rules('address', 'address', 'xss_clean|required');
                $this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
                $this->form_validation->set_rules('company_type', 'company_type', 'xss_clean|required'); 
                $this->form_validation->set_rules('date_of_creation', 'date_of_creation', 'xss_clean|required');
                $rows_affected = $this->Companies_model->create_company_from_CH($this->input->post(),$this->data['current_user']['id']);

                if($rows_affected)
                {
                    if(is_array($rows_affected)){
                        
                        echo  json_encode(array('status' => 200, 'message' => $rows_affected['row_id']));
                        
                     exit();
                    }
                   
                    
                    
                        file_put_contents('apitext.txt', 'Initial stage two'.PHP_EOL, FILE_APPEND);            
                        $chargesResponse = $this->getCompanyHouseCharges($this->input->post('registration'));

                        //file_put_contents('apitext.txt', 'This has ran retured a $chargesResponse condition bbb:'.$rows_affected, FILE_APPEND); 

                        if($chargesResponse){      
                            file_put_contents('apitext.txt', 'Initial stage three'.PHP_EOL, FILE_APPEND); 
                            $this->Companies_model->insert_charges_CH($chargesResponse,$rows_affected,$this->data['current_user']['id']);      
                        }
                            echo json_encode(array('status' => 200, 'message' => $rows_affected));
                    }else{
                              echo json_encode(array('status' =>202, 'message' => 'Something went wrong'));
                   
                }
            }
             
        }
    
    public function getCompanyHouseCharges($id)
    { 
       $response =  $this->getCompanyHouseChargesApi($id);
      
       if($response['items'][0]['status'] == 'outstanding'){
            return $response;
       } 
 
    }
    
    public function getCompanyHouseDetails($id = 0) 
	{
          
           //$id = str_replace(' ', '', $id);
             $server_output = array();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.companieshouse.gov.uk/search/companies?q=".$id);
            curl_setopt($ch, CURLOPT_GET, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $headers = array();
            $headers[] = 'Authorization: Basic RWFpN0V2N0JOSk1wcDlkcThUTWxkdHZzOXBDSzRTdmt0UGpzVjduWDo=';
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
             $server_output = curl_exec ($ch);
               
             return   json_encode($server_output);
            curl_close ($ch);  
    }
    
    public function getCompanyHouseChargesApi($id = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.companieshouse.gov.uk/company/".$id."/charges");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json;',
            'Authorization: Basic RWFpN0V2N0JOSk1wcDlkcThUTWxkdHZzOXBDSzRTdmt0UGpzVjduWDo=' 

          ]
        );

        $result = curl_exec($ch);
        // Check for errors
        if($result === FALSE){

          die(curl_errno($ch).': '.curl_error($ch));
        }

        return json_decode($result,TRUE);
        
    }
}