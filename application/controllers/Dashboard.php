<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
		
	}
	
	public function index() 
	{	
		// Clear search in session 
		$this->clear_search_results();
		$this->clear_campaign_from_session();
		$this->data['hide_side_nav'] = True;
		$this->data['full_container'] = True;

		
		// Getting all sectors 

		// Add options
		// array_unshift($providers_options,'All');

		$this->data['pending_actions'] = $this->Actions_model->get_pending_actions($this->get_current_user_id());
		$this->data['assigned_companies'] = $this->Actions_model->get_assigned_companies($this->get_current_user_id());
		$this->data['action_types_array'] = $this->Actions_model->get_action_types_array();
        
        
        
		$this->data['stats'] = $this->Actions_model->get_recent_stats('week');
		//$this->data['lastweekstats'] = $this->Actions_model->get_recent_stats('lastweek');
		//$this->data['thismonthstats'] = $this->Actions_model->get_recent_stats('thismonth');
		//$this->data['lastmonthstats'] = $this->Actions_model->get_recent_stats('lastmonth');
		if($_GET['search']) $this->data['getstatssearch'] = $this->Actions_model->get_recent_stats('search');
        
		$this->data['pipelinecontacted'] = $this->Actions_model->get_pipeline_contacted();
		$this->data['pipelinecontactedindividual'] = $this->Actions_model->get_pipeline_contacted_individual($this->get_current_user_id());
		$this->data['pipelineproposal'] = $this->Actions_model->get_pipeline_proposal($this->get_current_user_id());
		$this->data['pipelineproposalindividual'] = $this->Actions_model->get_pipeline_proposal_individual($this->get_current_user_id());
		$this->data['pipelinecustomer'] = $this->Actions_model->get_pipeline_customer($this->get_current_user_id());
		$this->data['pipelinecustomerindividual'] = $this->Actions_model->get_pipeline_customer_individual($this->get_current_user_id());
		$this->data['pipelinelost'] = $this->Actions_model->get_pipeline_lost($this->get_current_user_id());
		$this->data['pipelinelostindividual'] = $this->Actions_model->get_pipeline_lost_individual($this->get_current_user_id());
		$this->data['getuserplacements'] = $this->Actions_model->get_user_placements($_GET['period']);
		$this->data['getuserproposals'] = $this->Actions_model->get_user_proposals($_GET['period']);
		$this->data['getusermeetings'] = $this->Actions_model->get_user_meetings($_GET['period']);
		$this->data['getuserdemos'] = $this->Actions_model->get_user_demos($_GET['period']);
		$this->data['dates'] = $this->Actions_model->dates();
		$this->data['campaignsummary'] = $this->Campaigns_model->get_user_campaigns($this->get_current_user_id());
		$this->data['teamcampaignsummary'] = $this->Campaigns_model->get_team_campaigns();
        $this->data['private_campaigns_new'] = $this->Campaigns_model->private_campaigns_new($this->get_current_user_id());

        
        
         
        
		$this->data['userimage'] = $this->Users_model->get_user_image();
        
       
		//$this->data['marketing_actions'] = $this->Actions_model->get_marketing_actions($this->get_current_user_id());
		$this->data['main_content'] = 'dashboard/home';
		$this->load->view('layouts/default_layout', $this->data);	
	}
    
   
     function getTeamStats(){ //json request
        	
       $output =  array(
          'lastweek' => $this->lastweek(),
        'currentmonth' => $this->currentmonth(),
            'lastmonth'=> $this->lastmonths()
           );
         
         //header('Content-Type: application/json');
         echo json_encode($output);  
         
         
         
         
    }
    
    
    
    function lastweek(){
        $this->data['lastweekstats'] = $this->Actions_model->get_recent_stats('lastweek');
        
        return  $this->load->view('dashboard/lastweek', $this->data, true);	
        //echo json_encode(array('stats' => $lastweek));  
    }
    
    
       function currentmonth(){
       $this->data['thismonthstats'] = $this->Actions_model->get_recent_stats('thismonth');
        
       return  $this->load->view('dashboard/thismonth', $this->data, true);	
        //echo json_encode(array('stats' => $thismonth)); 
        //return   array('stats' => $thismonth));  
    }
    
    
    
       function lastmonths(){
           //$this->data['lastmonthstats'] = array();
       $this->data['lastmonthstats'] = $this->Actions_model->get_recent_stats('lastmonth');
        
        return $this->load->view('dashboard/lastmonth', $this->data, true);	
        //echo json_encode(array('stats' => $lastmonth));  
    }

}