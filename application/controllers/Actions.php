<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actions extends MY_Controller {

	function __construct() 
	{
		parent::__construct();
		
	}

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
			if (!empty($post['campaign_id'])) {
			$campaign_redirect ='&campaign_id='.$post['campaign_id'];
			}
		 // print_r('<pre>');print_r($this->input->post());print_r('</pre>');
		$post = $this->input->post();
		if ((empty($post['action_type_completed'])) && (empty($post['action_type_planned']))) {
		$this->set_message_action_error('Please select either a new or follow up action.');
		$message = $post['comment'];
		redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'&message='.urlencode($message).'#action-error','location');
		}
else
{
			if (!empty($post['campaign_id'])) {
			$campaign_redirect ='&campaign_id='.$post['campaign_id'];
			}


		if($this->input->post('done'))
		{	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('actioned_at', 'actioned_at', 'xss_clean');
			$this->form_validation->set_rules('company_id', 'company_id', 'xss_clean|required');
			$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
			$this->form_validation->set_rules('contact_id', 'contact_id', 'xss_clean');
			if($this->form_validation->run())
			{	$post = $this->input->post();

				if (($post['action_type_completed']=='16') && (empty($post['class_check'] ))){
					$this->set_message_error('Please set a company class before adding a deal.');
					redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#add_action','location');
					}

				else if (($post['action_type_completed']=='16') && ($post['source_check'] < 1 )){
					$this->set_message_error('<strong>Deal Not Added</strong></br> Please add a source.');
					redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#add_action','location');
					}
				else if (($post['action_type_completed']=='8') && ($post['source_check'] < 1 )){
					$this->set_message_error('<strong>Proposal Not Added</strong></br> Please add a source.');
					redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#add_action','location');
					}

				else if (($post['action_type_completed']=='16') && ($post['sector_check'] < 1 )){
					$this->set_message_error('<strong>Deal Not Added</strong></br> Please add at least one sector to this company.');
					redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#add_action','location');
					}

					else 
					{
				$result = $this->Actions_model->create($this->input->post());
					}
				if(empty($result))
					{
					$this->set_message_warning('Error while inserting details to database');
					}
				else
					{
					// after the initial action has been successfully created we can continue with the following login
					// *** TRY TO KEEP LOGIC IN THE CONTROLLER AND DATABASE COMMITS IN THE MODELS***
					$post = $this->input->post();
					$company_id = $post['company_id'];
					if ($post['action_type_completed']=='16') {

						// if action type completed is a deal then company is a now a customer
						// companies model update the company to customer
						$result = $this->Companies_model->update_company_to_customer($company_id);
						if(empty($result)){
							$this->set_message_warning('Error while updating company.');	
						}
						else{
							// actions models, register the update of a company to customer status 
							$result = $this->Actions_model->company_updated_to_customer($post);
							$result1 = $this->Actions_model->add_to_zendesk($post);
							if(empty($result)) $this->set_message_warning('Error while updating action for the company.');
						}
						
					}else if($post['action_type_completed']=='8'){
						// proposal sent to company 
						$result = $this->Companies_model->update_company_to_proposal($company_id);
						if(empty($result)){
							$this->set_message_warning('Error while updating company.');
						}else{
							// action model, update register an action for the proposal
							$result = $this->Actions_model->company_updated_to_proposal($post); 
							$result1 = $this->Actions_model->add_to_zendesk($post); 
							if(empty($result)) $this->set_message_warning('Error while updating action for the company.');
						}
					}
					$this->set_message_success('Action successfully inserted');
					redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#actions','location');
				}
			}else{
				$this->set_message_error(validation_errors());
				redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect,'location');
			}

		}
		elseif($this->input->post('follow_up')){
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('action_type_completed', 'action_type_completed', 'xss_clean|required');
			$this->form_validation->set_rules('comment', 'comment', 'xss_clean|required');
			$this->form_validation->set_rules('planned_at', 'planned_at', 'required|callback__valid_date');
			$this->form_validation->set_rules('company_id', 'company_id', 'xss_clean|required');
			$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean|required');
			$this->form_validation->set_rules('contact_id', 'contact_id', 'xss_clean');

			if($this->form_validation->run())
			{
							if (!empty($post['campaign_id'])) {
			$campaign_redirect ='&campaign_id='.$post['campaign_id'];
			}

				$result = $this->Actions_model->create($this->input->post());
				if(empty($result))
				{
					$this->set_message_warning('Error while inserting details to database');
				}
				else
				{
					$this->set_message_success('Action successfully inserted');
					redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect,'location');
				}
			}else{
				$this->set_message_error(validation_errors());
				redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect,'location');
			}
		}
	}
	} 

	public function edit(){
		if($this->input->post('action_id'))
		{
			if($this->input->post('action_do') == 'completed')
			{   
				$this->load->library('form_validation');
				$this->form_validation->set_rules('action_type', 'action_type', 'xss_clean');
				$this->form_validation->set_rules('comment', 'comment', 'xss_clean');
				$this->form_validation->set_rules('planned_at', 'planned_at', 'xss_clean');
				$this->form_validation->set_rules('actioned_at', 'actioned_at', 'xss_clean');
				$this->form_validation->set_rules('company_id', 'company_id', 'xss_clean');
				$this->form_validation->set_rules('user_id', 'user_id', 'xss_clean');

				if($this->form_validation->run())
				{
					if (!empty($post['campaign_id'])) {
					$campaign_redirect ='&campaign_id='.$post['campaign_id'];
					}


					$outcome = $this->input->post('outcome');
					$result = $this->Actions_model->set_action_state($this->input->post('action_id'),$this->input->post('user_id'),'completed',$outcome);
					if($result)
					{
						$this->set_message_success('Action updated successfully.');
					}
					else
					{
						$this->set_message_warning('Error while updating action');
					}
				}else{
					$this->set_message_error(validation_errors());
				}

				redirect('companies/company?id='.$this->input->post('company_id').$campaign_redirect.'#actions','location');
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
			if (empty($this->input->post('page'))) {
				redirect('companies/company?id='.$this->input->post('company_id'),'location');
			}
			else
			{redirect('/dashboard#calls','location');}
			}
		}
	}
    
    
    public function addActionsComment(){
        $rqst = $this->input->post();
        
    $output =     array('call'=>$rqst, 'pattern'=>'Wake up');
        
        $this->Actions_model->create($this->input->post());
        echo   json_encode($rqst);
        
         
    }
    
     public function addActionsCallback(){
        $rqst = $this->input->post();
        
    $output =     array('call'=>$rqst, 'pattern'=>'Wake up');
        
        $this->Actions_model->create($this->input->post());
        echo   json_encode($output);
        
         
    }
    
    
    
    public function addOutcome(){
        
       $inputpost = $this->input->post();
                    //set_action_state($action_id,$user_id,$state,$outcome);
         //$rap = json_decode($rap);
        $user_id = $this->data['current_user']['id'];
       $action_id = $inputpost['outcomeActionId'];
        $outcome = $inputpost['outcome'];
        $state = $inputpost['status'];
        $result  =  $this->Actions_model->set_action_state($action_id,$user_id,$state,$outcome,$inputpost);
        $output = array(
     'action' => $action_id,
            'user_id' =>$user_id ,
            'state' => $state,
            'result' => $result,
            'outcome' => $outcome
        
        );
            echo json_encode($output);
    }
    
  
    
    
    
    
    function removeOutsandingaction(){
        
       // $this->Actions_model->create();
        $rap = $this->input->post('big');
                     
                      echo json_encode(array('glen' =>$rap ));
    }
    
}