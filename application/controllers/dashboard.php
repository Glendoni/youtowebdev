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
		// Getting all sectors 

		// Add options
		// array_unshift($providers_options,'All');

		$this->data['pending_actions'] = $this->Actions_model->get_pending_actions($this->get_current_user_id());
		$this->data['action_types_array'] = $this->Actions_model->get_action_types_array();
		// $this->data['companies_per_sector'] = $this->Companies_model->get_companies_per_sector();
		// $this->data['compl'] = $this->Companies_model->last_updated_companies();
		// $this->data['hide_side_nav'] = True;
		
		$this->data['main_content'] = 'dashboard/home';
		$this->load->view('layouts/default_layout', $this->data);	
	}

}