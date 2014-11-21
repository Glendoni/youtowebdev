<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		
	}

	public function create_contact(){
		if($this->input->post('create_contact'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'name', 'xss_clean|required');
			$this->form_validation->set_rules('email', 'email', 'xss_clean');
			$this->form_validation->set_rules('phone', 'phone', 'xss_clean');
			$this->form_validation->set_rules('role', 'role', 'xss_clean|required');
			$this->form_validation->set_rules('company_id', 'company_id', 'xss_clean|required');
			$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
			if($this->form_validation->run())
			{
				$rows_affected = $this->Contacts_model->create_contact($this->input->post('name'),$this->input->post('email'),$this->input->post('role'),$this->input->post('company_id'),$this->input->post('user_id'),$this->input->post('phone'));
				if($rows_affected  > 0)
				{
					$this->output->set_status_header('200');
					$this->refresh_search_results();
				}
				else
				{
					$array = array('error'=>'<p>Error while creating contact</p>');
					$this->output->set_status_header('400');
					$this->output->set_output(json_encode($array));
				}
			}
			else
			{
				
				$array = array('error'=>validation_errors());
				$this->output->set_status_header('400');
				$this->output->set_output(json_encode($array));
			}
		}else{
			
			$array = array('error'=>'<p>Missing information on form</p>');
			$this->output->set_status_header('400');
			$this->output->set_output(json_encode($array));
		}

	}

	public function update(){
		if($this->input->post('update_contact'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'name', 'xss_clean|required');
			$this->form_validation->set_rules('email', 'email', 'xss_clean');
			$this->form_validation->set_rules('phone', 'phone', 'xss_clean');
			$this->form_validation->set_rules('role', 'role', 'xss_clean|required');
			$this->form_validation->set_rules('company_id', 'company_id', 'xss_clean|required');
			$this->form_validation->set_rules('contact_id', 'contact_id', 'xss_clean|required');
			$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
			if($this->form_validation->run())
			{
				$rows_affected = $this->Contacts_model->update($this->input->post());
				if($rows_affected)
				{
					$this->set_message_success('Contact has been updated.');
					redirect('/companies/company?id='.$this->input->post('company_id'));
					// $this->refresh_search_results();
				}
				else
				{
					$this->set_message_error('Error while updating contact.');
					redirect('/companies/company?id='.$this->input->post('company_id'));
				}
			}
			else
			{
				
				$this->set_message_error(validation_errors());
				redirect('/companies/company?id='.$this->input->post('company_id'));
			}
		}
	}

	public function sendEmail(){

		if(!empty($this->data['current_user']['gmail_account']) and !empty($this->data['current_user']['gmail_password']))
		{
			$this->load->library('encrypt');
			$email_config = Array(
		        'protocol'  => 'smtp',
		        'smtp_host' => 'ssl://smtp.googlemail.com',
		        'smtp_port' => '465',
		        'smtp_user' => $this->data['current_user']['gmail_account'],
		        'smtp_pass' => $this->encrypt->decode($this->data['current_user']['gmail_password']),
		        'mailtype'  => 'html',
		        'starttls'  => true,
		        'newline'   => "\r\n"
		    );
	    	$this->load->library('email', $email_config);
	    	$this->email->from($this->data['current_user']['gmail_account'], $this->data['current_user']['name']);
		    $this->email->to('antonio@creinntech.com');
		 
		    $this->email->subject('Sire Subject');
		    $data = array( 'message' => "Hello Sir, you've got mail!");
		    $email = $this->load->view('emails/intro_email', null, TRUE);
		 
		    $this->email->message($email);
		    if (!$this->email->send())
			    show_error($this->email->print_debugger());
			else
			    $this->set_message_success('Your e-mail has been sent!');  
		    die;
		}else{
			$this->set_message_error('Gmail account missing: Please add your Gmail account in the settings section.');
		}
		
	}

}