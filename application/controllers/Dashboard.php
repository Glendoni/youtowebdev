<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
		
	}
	
	public function index() 
	{	
		// Clear search in session 
		$this->clear_search_results();
		$this->clear_campaign_from_session();
		
		// Getting all sectors 

		// Add options
		// array_unshift($providers_options,'All');

		$this->data['pending_actions'] = $this->Actions_model->get_pending_actions($this->get_current_user_id());
		$this->data['action_types_array'] = $this->Actions_model->get_action_types_array();
		$this->data['stats'] = $this->Actions_model->get_recent_stats();
		$this->data['thismonthstats'] = $this->Actions_model->get_this_month_stats();
		$this->data['getstatssearch'] = $this->Actions_model->get_stats_search();
		$this->data['pipelinecontacted'] = $this->Actions_model->get_pipeline_contacted();
		$this->data['pipelinecontactedindividual'] = $this->Actions_model->get_pipeline_contacted_individual($this->get_current_user_id());
		$this->data['pipelineproposal'] = $this->Actions_model->get_pipeline_proposal();
		$this->data['pipelineproposalindividual'] = $this->Actions_model->get_pipeline_proposal_individual($this->get_current_user_id());
		$this->data['pipelinecustomer'] = $this->Actions_model->get_pipeline_customer();
		$this->data['pipelinecustomerindividual'] = $this->Actions_model->get_pipeline_customer_individual($this->get_current_user_id());
		$this->data['pipelinelost'] = $this->Actions_model->get_pipeline_lost();
		$this->data['pipelinelostindividual'] = $this->Actions_model->get_pipeline_lost_individual($this->get_current_user_id());

		$this->data['main_content'] = 'dashboard/home';
		$this->load->view('layouts/default_layout', $this->data);	
	}

}