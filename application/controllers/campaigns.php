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
		$current_search = $this->get_current_search();

		$new_campaign_id = $this->Campaigns_model->create_from_post($name,$shared,$user_id,$current_search);
		
		if($new_campaign_id)
		{
			$new_campaign = $this->Campaigns_model->get_campaign_by_id($new_campaign_id);
			$this->session->set_userdata('campaign_id',$new_campaign[0]->id);
			$this->session->set_userdata('campaign_name',$new_campaign[0]->name);
			$this->session->set_userdata('campaign_owner',$new_campaign[0]->user_id);
			$this->session->set_userdata('campaign_shared',(bool)$new_campaign[0]->shared);
			$this->set_message_success('Campaign saved!');
		}
		redirect('/companies','refresh');
	}

	public function get_all_shared_campaigns(){
		return $this->Campaigns_model->get_all_shared_campaigns();
	}

	public function get_all_private_campaigns($user_id){
		return $this->Campaigns_model->get_all_private_campaigns($user_id);
	}
	
	public function get_campaigns_for_user($user_id)
	{
		return $this->Campaigns_model->get_campaigns_for_user($user_id);
	}

	public function display()
	{
		if($this->input->get('id'))
		{
			$campaign = $this->Campaigns_model->get_campaign_by_id($this->input->get('id'));
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

		if($this->input->post('make_private')!== FALSE)
		{
			$result = $this->Campaigns_model->update_campaign_make_private($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{
				$this->session->set_userdata('campaign_shared',False);
			}
		}elseif ( ($this->input->post('make_public') !== FALSE ) ) {
			
			$result = $this->Campaigns_model->update_campaign_make_public($this->input->post('campaign_id'),$this->get_current_user_id());

			if($result == True)
			{	
				$this->session->set_userdata('campaign_shared',True);
			}
		}elseif ($this->input->post('delete')!== FALSE) {
			$result = $this->Campaigns_model->delete_campaign($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{
				$this->clear_campaign_from_session();
			}
		}

		redirect('/companies');
	}
	

}
