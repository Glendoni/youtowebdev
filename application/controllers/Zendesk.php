<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zendesk extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Zendesk_model');
        $this->load->helper(array('form', 'url','zendeskv3'));
	}
    function add_user_to_campaign_test()
    {
        echo $response  = sonovate_zendesk(false, false,'get_all_tickets_regarding_a_specific_user');  
    }
    
    function get_tickets()
    {
        $zd_id = $this->input->post('zd_id'); 
        echo $response  = sonovate_zendesk($zd_id, false, false,'get_all_tickets_regarding_a_specific_user');  
    }
    function get_company_placements()
    {
        $department = array('support', 'development');
        
        if($this->input->post('zd_id')) {
          $comp_reg_num = $this->input->post('comp_reg_num');
        }
        echo $response =  $this->Zendesk_model->get_placement_data($comp_reg_num); 
    }    
}