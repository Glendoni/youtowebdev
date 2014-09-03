<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaigns extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('Campaigns_model');

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
			redirect('/companies');
		}

		if($this->input->post('private'))
		{
			$shared = 'False'; //have to be string to match psql boolean type
		}
		else
		{
			$shared = 'True';
		}
		
		$user_id = $this->get_current_user_id();
		$current_search = $this->get_current_search();

		$save_current_search = $this->Campaigns_model->create_from_post($name,$shared,$user_id,$current_search);
		
		if($save_current_search)
		{
			$this->set_message_success('Campaign '.$name.' saved ');
		}
		redirect('/companies');
		// $this->data['main_content'] = 'campaigns/list';
		// $this->load->view('layouts/default_layout', $this->data);
	}

	public function get_all_shared_campaigns($user_id=False){
		return $this->Campaigns_model->get_all_shared_campaigns($user_id);
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
			$this->session->set_userdata('current_search',$post);
			redirect('/companies');
		}
		else
		{
			// id missing 
		}
	}
	

}
