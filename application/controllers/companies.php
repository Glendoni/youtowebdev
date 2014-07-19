<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companies extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('Companies_model');
	}
	
	public function index() {
		if ($query = $this->Companies_model->get_all()){
			$data['companies']=$query;
			print_r($query);
			
		}
		
		$this->load->view('companies_list', $data);
	}

	public function search() {

		if ($query = $this->Companies_model->get_all()){
			$data['companies']=$query;
		}
		
		$this->load->view('companies_list', $data);
	}
}
