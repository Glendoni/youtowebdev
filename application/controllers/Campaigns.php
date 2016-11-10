<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaigns extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
         $this->load->model('Evergreen_model');
		
	}
	
	public function index() 
	{	
		$session_result = $this->session->userdata('companies');
		$search_results_in_session = unserialize($session_result);
		$refresh_search_results = $this->session->flashdata('refresh');
		$campaign = $this->session->userdata('campaign_id');
	
		$companies_array = $search_results_in_session;
        
         //echo '<pre>'; print_r($companies_array); echo '</pre>';
           //     exit();

		// if campaign exist set this variables
		$this->data['current_campaign_name'] = ($this->session->userdata('campaign_name') ?: FALSE );
		$this->data['current_campaign_owner_id'] = ($this->session->userdata('campaign_owner') ?: FALSE );
		$this->data['current_campaign_id'] = ($this->session->userdata('campaign_id') ?: FALSE );
		$this->data['current_campaign_editable'] = ($this->data['current_campaign_owner_id'] == $this->get_current_user_id() ? TRUE : FALSE );
		$this->data['current_campaign_is_shared'] = $this->session->userdata('campaign_shared') == 'f'? FALSE : TRUE; 
		$this->data['current_campaign_owners'] = $this->Campaigns_model->get_campaign_owner($campaign);
		$this->data['current_campaign_stats'] = $this->Campaigns_model->get_campaign_pipeline($campaign);

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
            
$this->data['department'] =   $this->data['current_user']['department'] ;
            
$this->data['evergreen'] =  $this->Evergreen_model->evergreenHeaderInfo($this->get_current_user_id(),($this->session->userdata('campaign_id') ?: FALSE ));
           
		}
		$this->data['results_type'] = 'Campaign';
		$this->data['edit_page'] = 'edit_campaign';

		$this->data['main_content'] = 'companies/search_results';
		
         
        
        
        $this->load->view('layouts/default_layout', $this->data);
        
        
        
	}

	public function create() 
	{	

		if($this->input->post('name'))
		{
			$name = $this->input->post('name');
		}
		else
		{
			$this->set_message_warning('Missing name for the campaign');
			redirect('/companies','refresh');
		}

		if($this->input->post('public'))
		{
			$shared = 'True'; //have to be string to match psql boolean type
		}
		else
		{
			$shared = 'False';
		}
		
		$user_id = $this->get_current_user_id();
		// var_dump($this->input->post());
		
		if ($this->input->post('save_search')){
			$current_search = $this->get_current_search();
			$new_saved_search_id = $this->Campaigns_model->save_search($name,$shared,$user_id,$current_search);
		}elseif ($this->input->post('save_campaign')){
			$new_campaign_id = $this->Campaigns_model->create_campaign($name,$shared,$user_id);
			$session_result = $this->session->userdata('companies');
			$companies_array = unserialize($session_result);
			foreach ($companies_array as $company) {
				// create target
				$this->Campaigns_model->add_company_to_campaign($new_campaign_id,$company['id'],$user_id);
			}
		}
		
		if($new_campaign_id)
		{
			$new_campaign = $this->Campaigns_model->get_campaign_by_id($new_campaign_id);
			$this->session->set_userdata('campaign_id',$new_campaign[0]->id);
			$this->session->set_userdata('campaign_name',$new_campaign[0]->name);
			$this->session->set_userdata('campaign_owner',$new_campaign[0]->user_id);
			$this->session->set_userdata('campaign_shared',(bool)$new_campaign[0]->shared);
			$raw_search_results = $this->Campaigns_model->get_companies_for_campaign_id($new_campaign_id);
			$this->refresh_search_results();
			$companies = $this->process_search_result($raw_search_results);
			$session_companies = serialize($companies);
			$this->session->set_userdata('companies',$session_companies);
			$this->set_message_success('Campaign saved!');
			redirect('/campaigns');
			
		}elseif($new_saved_search_id){
			$this->set_message_success('Search saved!');
			$new_saved_search_id = $this->Campaigns_model->get_saved_searched_by_id($new_saved_search_id);
			$this->session->set_userdata('saved_search_id',$new_saved_search_id[0]->id);
			$this->session->set_userdata('saved_search_name',$new_saved_search_id[0]->name);
			$this->session->set_userdata('saved_search_owner',$new_saved_search_id[0]->user_id);
			$this->session->set_userdata('saved_search_shared',(bool)$new_saved_search_id[0]->shared);
			$this->refresh_search_results();
			redirect('/companies');
		}
	}

	public function get_all_shared_searches(){
		return $this->Campaigns_model->get_all_shared_searches();
	}

	public function get_all_private_searches($user_id){
		return $this->Campaigns_model->get_all_private_searches($user_id);
	}
	
	public function get_campaigns_for_user($user_id)
	{
		return $this->Campaigns_model->get_campaigns_for_user($user_id);
	}

	public function display_campaign(){
        
		if($this->input->get('id'))
		{	
            //$this->session->unset_userdata('pipedate');
			$campaign = $this->Campaigns_model->get_campaign_by_id($this->input->get('id'));
			if ($campaign[0]->id == False) {
				print_r('No campaign');
				return False;
			}
			$pipeline = $this->input->get('pipeline');

if($this->data['current_user']['department'] == 'data'){
    
    $companies = $this->Campaigns_model->get_companies_for_campaign_id_data_entry($campaign[0]->id,$pipeline);
}else{
            
        
			$companies = $this->Campaigns_model->get_companies_for_campaign_id($campaign[0]->id,$pipeline);
    
}
			// print '<pre>';
			// print_r($companies);
			// die;	
			$this->refresh_search_results();
			$this->session->set_userdata('campaign_id',$campaign[0]->id);
			$this->session->set_userdata('campaign_name',$campaign[0]->name);
			$this->session->set_userdata('campaign_owner',$campaign[0]->user_id);
			$this->session->set_userdata('campaign_shared',$campaign[0]->shared);
			$this->session->unset_userdata('current_search');

			$result = $this->process_search_result($companies);

			if(empty($result))
			{
                
               $this->session->unset_userdata('companies');
				unset($search_results_in_session);
			}
			else
			{
                
                
                           foreach($result as $item => $value){
                              // echo $value['id'];
                        $dt =     $this->data['last_pipeline_created_at'] = $this->Actions_model->actiondata($value['id']);
                        $dta[] = array('id' => $value['id'], 'last_pipeline_date' =>  $dt );      
                
                }
            
                $this->session->set_userdata('pipedate',$dta);
				$session_result = serialize($result);
				$this->session->set_userdata('pipeline',$pipeline);
				$this->session->set_userdata('companies',$session_result);
			}
			redirect('/campaigns');
		}
		else
		{
			print 'missing id';
			// id missing 
		}

	}

	public function display_saved_search()
	{
		if($this->input->get('id'))
		{ 
			$campaign = $this->Campaigns_model->get_saved_searched_by_id($this->input->get('id'));
			$post = unserialize($campaign[0]->criteria);			
			$this->refresh_search_results();
			$this->session->set_userdata('saved_search_id',$campaign[0]->id);
			$this->session->set_userdata('saved_search_name',$campaign[0]->name);
			$this->session->set_userdata('saved_search_owner',$campaign[0]->user_id);
			
			$this->session->set_userdata('saved_search_shared',$campaign[0]->shared);
			$this->session->set_userdata('current_search',$post);
			
			redirect('/companies');
		}
		else
		{
			// id missing 
		}
	}
	// edit saved search
	public function edit_saved_search()
	{	
		if($this->input->post('campaign_id') == FALSE) return False;
		
		if(null !== $this->input->post('make_private'))
		{
			$result = $this->Campaigns_model->update_campaign_make_private($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{
				$this->session->set_userdata('saved_search_shared','f');
			}
		}
		elseif(null !== $this->input->post('make_public')) 
		{
			$result = $this->Campaigns_model->update_campaign_make_public($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{	
				$this->session->set_userdata('saved_search_shared','t');
			}
		}
		elseif (null !== $this->input->post('delete')) 
		{
			$result = $this->Campaigns_model->delete_campaign($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{
				$this->clear_saved_search_from_session();
			}
		}
		
		redirect('/companies');
	}
	
	public function edit_campaign()
	{	
		if($this->input->post('campaign_id') == FALSE) return False;
		
		if(null !== $this->input->post('make_private'))
		{
			$result = $this->Campaigns_model->update_campaign_make_private($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{
				$this->session->set_userdata('campaign_shared','f');
			}
		}
		elseif(null !== $this->input->post('make_public')) 
		{
			$result = $this->Campaigns_model->update_campaign_make_public($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{	
				$this->session->set_userdata('campaign_shared','t');
			}
		}
		elseif (null !== $this->input->post('delete')) 
		{
			$result = $this->Campaigns_model->delete_campaign($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{
				$this->clear_campaign_from_session();
			}
		}
		
		redirect('/campaigns');
	}
    
    
      function updateTagCampaignRun()
    { //updates the campaign with 5 more 
        echo json_encode(array('success' => 'ok'));
        //echo json_encode($this->Evergreen_model->updateTagCampaign());
        
    }
    

}
