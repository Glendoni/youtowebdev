<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Sectors_model');
		$this->load->model('Providers_model');
		$this->load->model('Companies_model');
		
	}
	
	public function index() 
	{
		// Clear search in session 
		$this->clear_search_results();
		// Getting all sectors 
		$sectors_options = $this->Sectors_model->get_all_in_array();
		// Add options
		array_unshift($sectors_options,'All');
		// Getting all providers
		$providers_options = $this->Providers_model->get_all_in_array();
		// Add options
		array_unshift($providers_options,'All');
		
		// $this->data['hide_side_nav'] = True;
		$this->data['sectors_options'] = $sectors_options;
		$this->data['sectors_default'] ='0';
		$this->data['providers_options'] = $providers_options;
		$this->data['providers_default'] ='0';
		$this->data['main_content'] = 'dashboard/search';
		$this->load->view('layouts/default_layout', $this->data);	
	}

}