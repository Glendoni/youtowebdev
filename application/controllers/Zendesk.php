<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zendesk extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url','zendeskv3'));
	}

  function get_tickets()
  {
    $zd_id = $this->input->get('zd_id'); 
     echo $response  = sonovate_zendesk($zd_id, false, false,'get_all_tickets_regarding_a_specific_user');
  }
  
}
