<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		// load database
        $this->load->database();
        // load form validation library
        $this->load->library('form_validation');
	}

 public function email_check()
    {
        // allow only Ajax request    
        if($this->input->is_ajax_request()) {
        // grab the email value from the post variable.
        $email = $this->input->post('email');
        if(!$this->form_validation->is_unique($email,'contacts.email')) {
        // set the json object as output                 
         $this->output->set_content_type('application/json')->set_output(json_encode(array('message' => '<b>Note:</b> There is already a contact with this email.')));

            }
   
        }
    }

	public function create_contact(){
		if($this->input->post('create_contact'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('first_name', 'first_name', 'xss_clean|required');
			$this->form_validation->set_rules('last_name', 'last_name', 'xss_clean|required');
			$this->form_validation->set_rules('email', 'email', 'xss_clean');
			$this->form_validation->set_rules('phone', 'phone', 'xss_clean');
			$this->form_validation->set_rules('linkedin_id', 'linkedin_id', 'xss_clean');
			$this->form_validation->set_rules('company_id', 'company_id', 'xss_clean|required');
			$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
			$this->form_validation->set_rules('email', 'email', 'valid_email');
			$this->form_validation->set_rules('report_extensions', 'report_extensions', 'xss_clean');
			$this->form_validation->set_rules('report_timesheets_storage', 'report_timesheets_storage', 'xss_clean');
			$this->form_validation->set_rules('report_timesheets_processed', 'report_timesheets_processed', 'xss_clean');
			$this->form_validation->set_rules('report_sales_ledger', 'report_sales_ledger', 'xss_clean');
			$this->form_validation->set_rules('report_commision', 'report_commision', 'xss_clean');
			$this->form_validation->set_rules('report_age_debtor', 'report_age_debtor', 'xss_clean');
            $this->form_validation->set_rules('report_owner', 'report_owner', 'xss_clean');
			$this->form_validation->set_rules('report_system', 'report_system', 'xss_clean');
			$this->form_validation->set_rules('report_administrator', 'report_administrator', 'xss_clean');
			$this->form_validation->set_rules('role', 'role', 'xss_clean|required');

			if($this->form_validation->run())
			{
				echo $rows_affected = $this->Contacts_model->create_contact(
					$this->input->post('first_name'),
					$this->input->post('last_name'),
					$this->input->post('email'),
					$this->input->post('role'),
					$this->input->post('company_id'),
					$this->input->post('user_id'),
					$this->input->post('phone'),
					$this->input->post('linkedin_id'),
					$this->input->post('title'),
					$this->input->post('report_extensions'),
					$this->input->post('report_timesheets_storage'),
					$this->input->post('report_timesheets_processed'),
					$this->input->post('report_sales_ledger'),
					$this->input->post('report_commision'),
					$this->input->post('report_age_debtor'),
                    $this->input->post('report_owner'),
                    $this->input->post('report_system'),
                    $this->input->post('report_administrator')
					//$this->input->post('role_dropdown')
				);
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
			$this->form_validation->set_rules('first_name', 'first_name', 'xss_clean|required');
			$this->form_validation->set_rules('last_name', 'last_name', 'xss_clean|required');
			$this->form_validation->set_rules('email', 'email', 'xss_clean');
			$this->form_validation->set_rules('phone', 'phone', 'xss_clean');
			$this->form_validation->set_rules('linkedin_id', 'linkedin_id', 'xss_clean');
			$this->form_validation->set_rules('company_id', 'company_id', 'xss_clean|required');
			$this->form_validation->set_rules('contact_id', 'contact_id', 'xss_clean|required');
			$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
			$this->form_validation->set_rules('email', 'email', 'valid_email');
			$this->form_validation->set_rules('report_extensions', 'report_extensions', 'xss_clean');
			$this->form_validation->set_rules('report_timesheets_storage', 'report_timesheets_storage', 'xss_clean');
			$this->form_validation->set_rules('report_timesheets_processed', 'report_timesheets_processed', 'xss_clean');
			$this->form_validation->set_rules('report_sales_ledger', 'report_sales_ledger', 'xss_clean');
			$this->form_validation->set_rules('report_commision', 'report_commision', 'xss_clean');
			$this->form_validation->set_rules('report_age_debtor', 'report_age_debtor', 'xss_clean');
            $this->form_validation->set_rules('report_owner', 'report_owner', 'xss_clean');
			$this->form_validation->set_rules('report_system', 'report_system', 'xss_clean');
			$this->form_validation->set_rules('report_administrator', 'report_administrator', 'xss_clean');
			$this->form_validation->set_rules('role_dropdown', 'role', 'xss_clean|required');

			if($this->form_validation->run())
			{
                
				$rows_affected = $this->Contacts_model->update($this->input->post());
				if($rows_affected)
				{
					$this->set_message_success('Contact has been updated.');
					redirect('/companies/company?id='.$this->input->post('company_id').'#contacts');
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
				redirect('/companies/company?id='.$this->input->post('company_id').'#contacts');
			}
		}
	}

}