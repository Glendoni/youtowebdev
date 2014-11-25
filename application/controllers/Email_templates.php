<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_templates extends MY_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->model('Email_templates_model');
	}

	public function index()
	{
		$this->data['hide_side_nav'] = True;
		$this->data['email_templates'] = $this->Email_templates_model->get_all();
		$this->data['main_content'] = 'email_templates/dashboard';
		$this->load->view('layouts/single_page_layout', $this->data);
	}

	public function edit()
	{	
		if($this->input->get('id'))
		{
			 $template= $this->Email_templates_model->get_by_id($this->input->get('id'));
			 $this->data['template'] = $template;
			 $this->data['template_attachments'] = json_decode($template->attachments);
		}
		
		$this->data['hide_side_nav'] = True;
		$this->data['main_content'] = 'email_templates/edit';
		$this->load->view('layouts/single_page_layout', $this->data);
	}

	public function delete(){
		if($this->input->get('id'))
		{
			$result = $this->Email_templates_model->delete($this->input->get('id'));
			redirect('/email_templates/');
		}
	}
	private function process_upload(){
		if (!empty($_FILES['files']['name'][0])) {
			$config['upload_path'] = realpath(APPPATH.'../assets/email_attachments/');
			$config["overwrite"] = TRUE;
			$config["remove_spaces"] = TRUE;
			$config["allowed_types"] = "txt|pdf|doc|docx|jpg|zip|png";
			$config["max_size"] = 2000;
			$count = 0;
			$attachments = array();
			foreach ($_FILES as $key => $value)   //fieldname is the form field name
			{	
			    if (!empty($value['name'])) 
			    {	
			    	$this->load->library('upload', $config);
					$this->upload->initialize($config); 
			        if (!$this->upload->do_multi_upload($key))
			        {
			            $this->set_message_error($this->upload->display_errors());
			            if($this->input->post('template_id')){
			            	redirect('/email_templates/edit/?id='.$this->input->post('template_id'));
			            }else{
			            	redirect('/email_templates/');
			            }							
			        }
			        else
			        {
			            $data = $this->upload->get_multi_upload_data();
			            foreach ($data as $key => $value) {
			             	array_push($attachments, $value['full_path']);
			            }			             
			        }
			    }
			}
			return $attachments;
		}
		return array();
	}

	public function send_email(){
		
		if($this->input->post('send_email')){
			$attachments = $this->process_upload();	
				
			$contact = $this->Contacts_model->get_contact_by_id($this->input->post('contact_id'));

			$message = str_replace('{{contact_name}}', $contact->name, $this->input->post('message_'.$this->input->post('template_selector'))); 
			$template = $this->Email_templates_model->get_by_id($this->input->post('template_selector'));
		
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
			    $this->email->to($contact->email);
			    $this->email->subject($template->subject);
			    $data = array( 
			    	'sender_message' => nl2br($message),
			    	'sender_name'=> $this->data['current_user']['name'],
			    	'sender_direct_line' => $this->data['current_user']['phone'],
			    	'sender_mobile' => $this->data['current_user']['mobile'],
			    	'sender_linkedin' => $this->data['current_user']['linkedin'],
			    	'sender_role' => $this->data['current_user']['role'],
			    	);
			    $email = $this->load->view('email_templates/base', $data, TRUE);

			 	// template attachment
			 	if(!empty($template->attachments)){
				 	foreach (json_decode($template->attachments) as $attachment) {
				 		$this->email->attach($attachment);
				 	}
				 }
			 	// form attachments
			 	if(!empty($attachments)){
				 	foreach ($attachments as $attachment) {
				 		$this->email->attach($attachment);
				 	}
				}
			    $this->email->message($email);
			    if (!$this->email->send()){
				    $this->set_message_error($this->email->print_debugger());
				    
			    }
				else {
				    $this->set_message_success('Your e-mail has been sent!');
				    $data = array(
							'company_id' 	=> $this->input->post('company_id'),
							'user_id' 		=> $this->data['current_user']['id'],
							'comment'		=> nl2br($message),
							'contact_id'    => $contact->id,
							'created_by'	=> $this->data['current_user']['id'],
							'action_type'=> '13',//email
							'created_at' 	=> date('Y-m-d H:i:s'),
							);
				    $this->Actions_model->create($data); 
				}
			    redirect('/companies/company?id='.$this->input->post('company_id'));
			}else{
				$this->set_message_error('Gmail account missing: Please add your Gmail account in the settings section.');
				// redirect('/companies/company?id='.$this->input->post('company_id'));
			}
		}
	}

	public function update()
	{	
		if($this->input->post('email_template')){
			
			$attachments = $this->process_upload();
			if(!empty($attachments)){
				$attachments = json_encode($attachments);
			}

			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'name', 'xss_clean|required');
			$this->form_validation->set_rules('subject', 'subject', 'xss_clean|required');
			$this->form_validation->set_rules('message', 'message', 'xss_clean|required');
			$this->form_validation->set_rules('template_id', 'template_id', 'xss_clean');
			if($this->form_validation->run())
			{	
				$result = $this->Email_templates_model->update($this->input->post(),$this->data['current_user']['id'],$attachments);
				if(!$result)
				{
					if($this->input->post('template_id')){
		            	redirect('/email_templates/edit/?id='.$this->input->post('template_id'));
		            }else{
		            	redirect('/email_templates/');
		            }
				}
				else
				{
					$this->set_message_success('Email successfully updated.');
					if($this->input->post('template_id')){
		            	redirect('/email_templates/edit/?id='.$this->input->post('template_id'));
		            }else{
		            	redirect('/email_templates/');
		            }
				}
			}else{
				$this->set_message_error(validation_errors());
				if($this->input->post('template_id')){
	            	redirect('/email_templates/edit/?id='.$this->input->post('template_id'));
	            }else{
	            	redirect('/email_templates/');
	            }
			}
			
			
		}elseif($this->input->post('clear_attachments')){
			$result = $this->Email_templates_model->clear_attachments($this->input->post('template_id'),$this->data['current_user']['id']);
			if(!$result)
			{
				if($this->input->post('template_id')){
	            	redirect('/email_templates/edit/?id='.$this->input->post('template_id'));
	            }else{
	            	redirect('/email_templates/');
	            }
			}
			else
			{
				$this->set_message_success('Email successfully updated.');
				redirect('/email_templates/edit/?id='.$this->input->post('template_id'));
			}
		}
	}

	
}