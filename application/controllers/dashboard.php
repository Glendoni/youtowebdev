<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
		$this->load->model('Companies_model');
	}
	
	public function index() 
	{	
		// Clear search in session 
		$this->clear_search_results();
		// Getting all sectors 

		// Add options
		// array_unshift($providers_options,'All');

		$this->data['last_imported_companies'] = $this->Companies_model->get_last_imported();
		$this->data['last_updated_companies'] = $this->Companies_model->last_updated_companies();
		// $this->data['hide_side_nav'] = True;
		
		$this->data['main_content'] = 'dashboard/home';
		$this->load->view('layouts/default_layout', $this->data);	
	}

}