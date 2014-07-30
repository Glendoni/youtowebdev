<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companies extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('Companies_model');
	}
	
	public function index() {
		
		if($this->input->post('submit'))
		{
			var_dump($this->input->post());
			$this->load->library('form_validation');
			$this->form_validation->set_rules('agency_name', 'agency_name', 'xss_clean');
			$this->form_validation->set_rules('turnover_from', 'turnover_from', 'xss_clean');
			$this->form_validation->set_rules('turnover_to', 'turnover_to', 'xss_clean');
			$this->form_validation->set_rules('employees_from', 'employees_from', 'xss_clean');
			$this->form_validation->set_rules('employees_to', 'employees_to', 'xss_clean');
			$this->form_validation->set_rules('company_age_from', 'company_age_from', 'xss_clean');
			$this->form_validation->set_rules('company_age_to', 'company_age_to', 'xss_clean');
			$this->form_validation->set_rules('sectors', 'sectors', 'xss_clean');
			$this->form_validation->set_rules('providers', 'providers', 'xss_clean');
			$this->form_validation->set_rules('mortgage_from', 'anniversary_from', 'xss_clean');
			$this->form_validation->set_rules('mortgage_to', 'anniversary_to', 'xss_clean');

			if($this->form_validation->run())
			{	
				$result = $this->Companies_model->search_companies($this->input->post(),$page_num);
				var_dump($result);// $this->data['companies']=$result;
			}
		}

		if (!isset($this->data['companies']) && ! $this->session->userdata('companies')) redirect('/dashboard');
		
		var_dump($this->session->userdata('companies')->result_object);
		$companies_array_chunk = array_chunk($this->session->userdata('companies')->result_object, 30);
		$page_num = $this->input->get('page_num') ? $this->input->get('page_num') -1 : 0;

		$this->data['hide_side_nav'] = True;
		$this->data['companies_chunk'] = $companies_array_chunk[$page_num];
		$this->data['main_content'] = 'companies/list';
		$this->load->view('layouts/default_layout', $this->data);
	}

	public function search() {

		if ($query = $this->Companies_model->get_all()){
			$data['companies']=$query;
		}
		$this->load->view('companies_list', $data);
	}
}
