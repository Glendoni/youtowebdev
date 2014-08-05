<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
		// $this->load->model('Users_model');
		// $this->load->model('Sectors_model');
		$this->load->model('Providers_model');
		$this->load->model('Companies_model');
	}
	
	public function index() 
	{	
		// Clear search in session 
		$this->clear_search_results();
		// Getting all sectors 
		$sectors_options = $this->session->userdata('sectors_array');
		$sectors_options[0]='All';
		asort($sectors_options);
		// Add options
		// var_dump($sectors_options);
		// array_unshift($sectors_options,'All');
		// var_dump($sectors_options);
		// die;
		// Getting all providers
		$providers_options = $this->Providers_model->get_all_in_array();
		$providers_options[0]='All';
		asort($providers_options);
		// Add options
		// array_unshift($providers_options,'All');

		$this->data['last_imported_companies'] = $this->Companies_model->get_last_imported();
		$this->data['last_updated_companies'] = $this->Companies_model->last_updated_companies();
		// $this->data['hide_side_nav'] = True;
		$this->data['sectors_options'] = $sectors_options;
		$this->data['sectors_default'] ='0';
		$this->data['providers_options'] = $providers_options;
		$this->data['providers_default'] ='0';
		$this->data['main_content'] = 'dashboard/home';
		$this->load->view('layouts/default_layout', $this->data);	
	}

}