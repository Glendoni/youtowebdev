<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {
	
	function __construct() {
		parent::__construct();
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
			if($this->session->userdata('last_page') and (!in_array($this->session->userdata('last_page'),array("http://staging-baselist.herokuapp.com/", "http://baselist.herokuapp.com/", "http://baselist/")))){
				redirect($this->session->userdata('last_page'));
			}else{
				redirect('/dashboard');	
			}
			
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
		//Field validation succeeded.Validate against database
		//query the database
		$email = $this->input->post('email');
		

		$result = $this->Users_model->get_user_login($email, $password);
		if($result)
		{
			$sess_array = array();
			foreach($result as $row)
			{
				$logged_in_user_id = $row->id;
				$this->Users_model->update_last_login($logged_in_user_id);
				$sess_array = array(
				 'user_id' => $row->id,
				 'user_name' => $row->name
				);
				$this->session->set_userdata('logged_in', $sess_array);
				//UPDATE LAST LOGIN
			}
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid email or password');
			$result = $this->Users_model->update_last_unsuccessful_login($email);
			foreach($result as $row)
			{
			if ($row->unsuccessful_login_attempts >9){
			$this->Users_model->disable_user($email);
			$this->form_validation->set_message('check_database', 'Your account is now locked.');
			}
			}

			return FALSE;
		}
	}

}