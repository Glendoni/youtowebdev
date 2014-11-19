<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {


	public function profile(){
		 
		$companies_array_chunk = array_chunk($companies_array, RESULTS_PER_PAGE);
		$current_page_number = $this->input->get('page_num') ? $this->input->get('page_num') : 1;
		$this->data['companies_count'] = count($companies_array);
		$pages_count = ceil(count($companies_array)/RESULTS_PER_PAGE);
		$this->data['page_total'] = ($pages_count < 1)? 1 : $pages_count;
		$this->data['current_page_number'] = $current_page_number;
		$this->data['next_page_number'] = ($current_page_number+1) <= $this->data['page_total'] ? ($current_page_number+1) : FALSE;
		$this->data['previous_page_number'] = ($current_page_number-1) >= 0 ? ($current_page_number-1) : FALSE;
		$this->data['companies'] = $companies_array_chunk[($current_page_number-1)];


		$this->data['main_content'] = 'companies/search_results';
		$this->load->view('layouts/default_layout', $this->data);
		
	} 

	public function settings(){
		 
		$companies_array_chunk = array_chunk($companies_array, RESULTS_PER_PAGE);
		$current_page_number = $this->input->get('page_num') ? $this->input->get('page_num') : 1;
		$this->data['companies_count'] = count($companies_array);
		$pages_count = ceil(count($companies_array)/RESULTS_PER_PAGE);
		$this->data['page_total'] = ($pages_count < 1)? 1 : $pages_count;
		$this->data['current_page_number'] = $current_page_number;
		$this->data['next_page_number'] = ($current_page_number+1) <= $this->data['page_total'] ? ($current_page_number+1) : FALSE;
		$this->data['previous_page_number'] = ($current_page_number-1) >= 0 ? ($current_page_number-1) : FALSE;
		$this->data['companies'] = $companies_array_chunk[($current_page_number-1)];


		$this->data['main_content'] = 'companies/search_results';
		$this->load->view('layouts/default_layout', $this->data);
		
	} 
}