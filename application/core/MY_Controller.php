<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	protected $current_user = ""; // Logged in user
	protected $data = array(); // Data array to be passed to views
	var $url;
		
	public function __construct() {	

		parent::__construct();
		
		// Debugging funcionality, set it only when on development 
		switch (ENVIRONMENT) {
		case 'development':
		        $this->output->enable_profiler(TRUE);
		break;
		case 'production':
				$this->output->enable_profiler(TRUE);
		break;

		default:
		        // $config['s3_bucket'] = 'mybucket_production';
		break;
		}

		// Load User model for all the controllers
		$this->load->model('Campaigns_model');
		$this->load->model('Sectors_model');
		$this->load->model('Users_model');
		$this->load->helper('mobile');

		// var_dump($this->session->all_userdata());

		// try getting logged in user from session
		if($this->session->userdata('logged_in')) 
		{
			$logged_in = $this->session->userdata('logged_in');
			$this->data['current_user'] = $this->current_user = $this->Users_model->get_user($logged_in['user_id']);
		}
		else
		{
			//user not in session and segment 1 exist then redirect to login
			if($this->uri->segment(1)) redirect('/','location');
		}


		if($this->session->userdata('sectors_array'))
		{
			
		}
		else
		{
			$sectors_array = $this->Sectors_model->get_all_in_array();
			asort($sectors_array);
			$this->session->set_userdata('sectors_array',$sectors_array);
		}
		
		// SET ALL SAVED CAMPAIGNS
		$this->data['shared_campaigns'] = $this->Campaigns_model->get_all_shared_campaigns($this->get_current_user_id());
		$this->data['own_campaigns'] = $this->Campaigns_model->get_campaigns_for_user($this->get_current_user_id());
		// var_dump($this->data['own_campaigns']);
		//var_dump($this->session->all_userdata());
		// var_dump($this->input->post());
	}

	protected function seve_current_search($post)
	{
		$this->session->set_userdata('current_search',$post);
	}

	protected function get_current_user_id()
	{
		$session = $this->session->userdata('logged_in');
		return $session['user_id'];
	}

	protected function get_current_search()
	{
		return $this->session->userdata('current_search');
	}

	protected function refresh_search_results()
	{
		$this->session->set_flashdata('refresh', TRUE);
	}

	protected function set_message_success($message)
	{
		$this->session->set_flashdata('message', $message);
		$this->session->set_flashdata('message_type', 'success');
	}

	protected function set_message_info($message)
	{
		$this->session->set_flashdata('message', $message);
		$this->session->set_flashdata('message_type', 'info');
	}

	protected function set_message_warning($message)
	{
		$this->session->set_flashdata('message', $message);
		$this->session->set_flashdata('message_type', 'warning');
	}

	protected function set_message_error($message)
	{
		$this->session->set_flashdata('message', $message);
		$this->session->set_flashdata('message_type', 'danger');
	}
	
	protected function clear_search_results()
	{
		$this->session->unset_userdata('companies');
		$this->session->unset_userdata('current_search');
	}
	// Helper function to validade is user agent is a mobile
	protected function isMobileBrowser(){
 		if(!isset($_SERVER['HTTP_USER_AGENT'])) return FALSE;
		$mobile_browser = '0';
 
		if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
		    $mobile_browser++;
		}
		 
		if((isset($_SERVER['HTTP_ACCEPT']) && strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
		    $mobile_browser++;
		}    
		 
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
		$mobile_agents = array(
		    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
		    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
		    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
		    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
		    'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
		    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
		    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
		    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
		    'wapr','webc','winw','winw','xda','xda-');
		 
		if(in_array($mobile_ua,$mobile_agents)) {
		    $mobile_browser++;
		}
		 
		if (isset($_SERVER['ALL_HTTP']) && strpos(strtolower($_SERVER['ALL_HTTP']),'operamini')>0) {
		    $mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),' ppc;')>0) {
			$mobile_browser++;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows ce')>0) {
			$mobile_browser++;
		}
		else if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) {
		    $mobile_browser=0;
		}
		 
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'iemobile')>0) {
			$mobile_browser++;
		}


		if ($mobile_browser > 0) {
		   return TRUE;
			
		} else {
		   return FALSE;
		}
	}

}