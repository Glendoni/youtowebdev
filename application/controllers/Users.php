<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

	function __construct() 
	{
		parent::__construct();
		
	}


	public function profile(){
		$this->data['hide_side_nav'] = TRUE;
		$this->data['main_content'] = 'users/profile';
		$image_updated = FALSE;
		if($this->input->post('name'))
		{	
			if (isset($_FILES['userfile']) && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
				
				$config['upload_path'] = realpath(APPPATH . '../assets/images/profiles/');
				$config['allowed_types'] = 'gif|jpg|png';
				$config['file_name'] = $this->data['current_user']['id'].'.jpg';
				$config['overwrite'] = TRUE;
				$config['max_size']	= '100';
				// $config['max_width']  = '1024';
				// $config['max_height']  = '768';

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload())
				{
					$this->set_message_error($this->upload->display_errors());
					redirect('/users/profile');
				}else{
					$image = $this->upload->data(); 
					$image_updated = $image['file_name'];
				}
			}

			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'name', 'xss_clean|required');
			$this->form_validation->set_rules('email', 'email', 'xss_clean|valid_email|required');
			$this->form_validation->set_rules('phone', 'phone', 'xss_clean|integer|required');
			$this->form_validation->set_rules('role', 'role', 'xss_clean|required');
			$this->form_validation->set_rules('mobile', 'mobile', 'integer|xss_clean');
			$this->form_validation->set_rules('linkedin', 'linkedin', 'xss_clean');
			if($this->form_validation->run())
			{	
				$result = $this->Users_model->update($this->input->post(),$this->data['current_user']['id'],$image_updated);
				if(!$result)
				{
					redirect('/users/profile');
				}
				else
				{
					$this->set_message_success('Profile successfully updated.');
					redirect('/users/profile');
				}
			}else{
				$this->set_message_error(validation_errors());
				redirect('/users/profile');
			}			
		}
		
		$this->load->view('layouts/single_page_layout', $this->data);
		
	} 

	public function settings(){
		if($this->input->post('gmail_account'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('gmail_account', 'gmail_account', 'xss_clean|required');
			$this->form_validation->set_rules('gmail_password', 'gmail_password', 'xss_clean|required');
			if($this->form_validation->run())
			{	
				$result = $this->Users_model->update_settings($this->input->post(),$this->data['current_user']['id']);
				if(!$result)
				{
					redirect('/users/settings');
				}
				else
				{
					$this->set_message_success('Settings successfully updated');
					redirect('/users/settings');
				}
			}else{
				$this->set_message_error(validation_errors());
				redirect('/users/settings');
			}
		}

		$this->data['hide_side_nav'] = TRUE;
		$this->data['main_content'] = 'users/settings';
		$this->load->view('layouts/single_page_layout', $this->data);
		
	}

}