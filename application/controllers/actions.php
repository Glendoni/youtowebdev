<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actions extends MY_Controller {

	public function create(){
		
		if($this->input->post('company_id'))
		{
			
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
				$result = $this->Actions_model->create($this->input->post('company_id'),$this->input->post('user_id'),False,$this->input->post('comment'),$this->input->post('planned_at'),$this->input->post('window'),$this->input->post('action_type'),$this->input->post('actioned_at'));
				
				if(empty($result))
				{
					$this->set_message_warning('Error');
					die('Error in form');
				}
				else
				{
					die('created');
				}
			}
			die('missing');
		}
	} 
}