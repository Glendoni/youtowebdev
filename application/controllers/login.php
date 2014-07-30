<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('Users_model');
	}
	
	public function index() 
	{
		if($this->input->post('email')){

			$this->load->library('form_validation');

			$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
			$this->form_validation->run();
		}

		if($this->session->userdata('logged_in')){
			redirect('/dashboard');
		}else{
			// Not user found, show login page
			$this->data['hide_side_nav'] = True;
			$this->data['main_content'] = 'login/login_view';
		}

		$this->load->view('layouts/default_layout', $this->data);	
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/', 'refresh');
	}

	public function check_database($password)
	{
		//Field validation succeeded.  Validate against database
		//query the database
		$email = $this->input->post('email');
		$result = $this->Users_model->getUserLogin($email, $password);
		if($result)
		{
			$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array(
				 'user_id' => $row->id,
				 'user_name' => $row->name
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid email or password');
			return FALSE;
		}
	}

}