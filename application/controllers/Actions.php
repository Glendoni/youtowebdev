<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actions extends MY_Controller {

	public function _valid_date(){
		$now = date('Y-m-d H:i:s',time());
		$date = date('Y-m-d H:i:s',strtotime($this->input->post('planned_at')));
		if($date > $now){
			return TRUE;
		}else{
			$this->form_validation->set_message('_valid_date', 'Planned date for action must be in the future');
			return FALSE;
		}

	}
	public function create(){
		 // print_r('<pre>');print_r($this->input->post());print_r('</pre>');
		if($this->input->post('done'))
		{	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('action_type', 'action_type', 'xss_clean|required');
			$this->form_validation->set_rules('comment', 'comment', 'xss_clean|required');
			$this->form_validation->set_rules('actioned_at', 'actioned_at', 'xss_clean');
			$this->form_validation->set_rules('company_id', 'company_id', 'xss_clean|required');
			$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
			$this->form_validation->set_rules('contact_id', 'contact_id', 'xss_clean');
			if($this->form_validation->run())
			{	
				$result = $this->Actions_model->create($this->input->post());
				if(empty($result))
				{
					$this->set_message_warning('Error while inserting details to database');
					
				}
				else
				{
					redirect('companies/company?id='.$this->input->post('company_id'),'location');
				}
			}
		}elseif($this->input->post('follow_up')){
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('action_type', 'action_type', 'xss_clean|required');
			$this->form_validation->set_rules('comment', 'comment', 'xss_clean|required');
			$this->form_validation->set_rules('planned_at', 'planned_at', 'required|callback__valid_date');
			$this->form_validation->set_rules('company_id', 'company_id', 'xss_clean|required');
			$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
			$this->form_validation->set_rules('contact_id', 'contact_id', 'xss_clean');

			if($this->form_validation->run())
			{
				$result = $this->Actions_model->create($this->input->post());
				if(empty($result))
				{
					$this->set_message_warning('Error while inserting details to database');
				}
				else
				{
					redirect('companies/company?id='.$this->input->post('company_id'),'location');
				}
			}else{
				$this->set_message_error(validation_errors());
				redirect('companies/company?id='.$this->input->post('company_id'),'location');
			}
		}
	} 

	public function edit(){
		if($this->input->post('action_id'))
		{
			if($this->input->post('action_do') == 'completed')
			{   
				var_dump($this->input->post());die;
				$this->load->library('form_validation');
				$this->form_validation->set_rules('action_type', 'action_type', 'xss_clean');
				$this->form_validation->set_rules('comment', 'comment', 'xss_clean');
				$this->form_validation->set_rules('planned_at', 'planned_at', 'xss_clean');
				$this->form_validation->set_rules('actioned_at', 'actioned_at', 'xss_clean');
				$this->form_validation->set_rules('window', 'window', 'xss_clean');
				$this->form_validation->set_rules('company_id', 'company_id', 'xss_clean');
				$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean');
		

				if($this->form_validation->run())
				{

				}
				$outcome = $this->input->post('outcome');
				$result = $this->Actions_model->set_action_state($this->input->post('action_id'),$this->input->post('user_id'),'completed',$outcome);
				if($result)
				{
					$this->set_message_success('Action set to completed.');
				}
				else
				{
					$this->set_message_warning('Error while completing action');
				}
				redirect('companies/company?id='.$this->input->post('company_id'),'location');
			}
			else if($this->input->post('action_do') == 'cancelled')
			{	
				$outcome = $this->input->post('outcome');
				$result = $this->Actions_model->set_action_state($this->input->post('action_id'),$this->input->post('user_id'),'cancelled',$outcome);				
				if($result)
				{
					$this->set_message_success('Action set to cancelled.');
				}
				else
				{
					$this->set_message_warning('Error while canceling action');
				}
				redirect('companies/company?id='.$this->input->post('company_id'),'location');
			}
		}
	}
}