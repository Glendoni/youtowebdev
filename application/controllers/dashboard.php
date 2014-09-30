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
		$this->data['lastweekstats'] = $this->Actions_model->get_last_week_stats();

		
		$this->data['main_content'] = 'dashboard/home';
		$this->load->view('layouts/default_layout', $this->data);	
	}

}