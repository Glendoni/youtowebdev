<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_templates extends MY_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->model('Email_templates_model');
	}

	public function index()
	{
		$this->data['email_templates'] = $this->Email_templates_model->get_all();
		$this->data['main_content'] = 'email_templates/dashboard';
		$this->load->view('layouts/single_page_layout', $this->data);
	}

	public function edit()
	{
		if($this->input->get('id'))
		{
			$this->data['email_template'] = $this->Email_templates_model->get_by_id($this->input->get('id'));
		}
		$this->data['email_templates'] = $this->Email_templates_model->get_all();
		$this->data['main_content'] = 'email_templates/dashboard';
		$this->load->view('layouts/single_page_layout', $this->data);
	}

	
}