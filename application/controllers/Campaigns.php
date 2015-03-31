<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaigns extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		
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
			$new_campaign_id = $this->Campaigns_model->save_search($name,$shared,$user_id,$current_search);
		}elseif ($this->input->post('save_campaign')){
			$current_search = '';
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
			if ($this->input->post('save_search')){
				$this->set_message_success('Search saved!');
			}else{
				$raw_search_results = $this->Companies_model->search_companies_sql(FALSE,FALSE,$new_campaign_id);
				$companies = $this->process_search_result($raw_search_results);
				$session_companies = serialize($companies);
				$this->session->set_userdata('companies',$session_companies);
				$this->set_message_success('Campaign saved!');
			}
		}

		redirect('/companies');
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
			$campaign = $this->Campaigns_model->get_campaign_by_id($this->input->get('id'));
			var_dump($campaign);die;			
			$this->refresh_search_results();
			$this->session->set_userdata('campaign_id',$campaign[0]->id);
			$this->session->set_userdata('campaign_name',$campaign[0]->name);
			$this->session->set_userdata('campaign_owner',$campaign[0]->user_id);
			
			$this->session->set_userdata('campaign_shared',$campaign[0]->shared);
			$this->session->set_userdata('current_search',$post);
			
			redirect('/companies');
		}
		else
		{
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
			$this->session->set_userdata('campaign_id',$campaign[0]->id);
			$this->session->set_userdata('campaign_name',$campaign[0]->name);
			$this->session->set_userdata('campaign_owner',$campaign[0]->user_id);
			
			$this->session->set_userdata('campaign_shared',$campaign[0]->shared);
			$this->session->set_userdata('current_search',$post);
			
			redirect('/companies');
		}
		else
		{
			// id missing 
		}
	}

	public function edit()
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
		
		redirect('/companies');
	}
	

}
