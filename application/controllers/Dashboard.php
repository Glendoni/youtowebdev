<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
   
    protected $userPermission;
    
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
        
       
          $this->userPermission = $this->data['current_user']['permission']? $this->data['current_user']['permission'] :   $this->userMarket = $this->data['current_user']['market'];
		
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
		//$this->data['assigned_companies'] = $this->Actions_model->get_assigned_companies($this->get_current_user_id());
		$this->data['action_types_array'] = $this->Actions_model->get_action_types_array();
        
        
        
		$this->data['stats'] = $this->Actions_model->get_recent_stats('week', 'np');
        $this->data['ustats'] = $this->Actions_model->get_recent_stats('week', $this->userPermission);
		//$this->data['lastweekstats'] = $this->Actions_model->get_recent_stats('lastweek');
		//$this->data['thismonthstats'] = $this->Actions_model->get_recent_stats('thismonth');
		//$this->data['lastmonthstats'] = $this->Actions_model->get_recent_stats('lastmonth');
		if($_GET['search']) $this->data['getstatssearch'] = $this->Actions_model->get_recent_stats('search','np');
        if($_GET['search']) $this->data['ugetstatssearch'] = $this->Actions_model->get_recent_stats('search', 'uf');
        
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
    $this->data['tagssummary'] = $this->Tagging_model->get_tagging_stats();
		$this->data['teamcampaignsummary'] = $this->Campaigns_model->get_team_campaigns();
    $this->data['private_campaigns_new'] = $this->Campaigns_model->private_campaigns_new($this->get_current_user_id());
		$this->data['userimage'] = $this->Users_model->get_user_image();
		//$this->data['marketing_actions'] = $this->Actions_model->get_marketing_actions($this->get_current_user_id());
		$this->data['main_content'] = 'dashboard/home';
		$this->load->view('layouts/default_layout', $this->data);	
	}
    
   
     function getTeamStats($userGroup = 'np'){ //json request
        	//$userGroup =  $this->userPermission;
       $output =  array(
        'lastweek' => $this->lastweek($userGroup),
        'currentmonth' => $this->currentmonth($userGroup),
        'lastmonth'=> $this->lastmonths($userGroup)
           );
         
         header('Content-Type: application/json');
         echo json_encode($output); 
         
    }
    
    
    
    function lastweek($userGroup){
        $this->data['lastweekstats'] = $this->Actions_model->get_recent_stats('lastweek',$userGroup);
        $this->data['prefix'] = $userGroup;
        return  $this->load->view('dashboard/lastweek', $this->data, true);	
        //echo json_encode(array('stats' => $lastweek));  
    }
    
    
       function currentmonth($userGroup){
       $this->data['thismonthstats'] = $this->Actions_model->get_recent_stats('thismonth', $userGroup);
        $this->data['prefix'] = $userGroup;
       return  $this->load->view('dashboard/thismonth', $this->data, true);	
        //echo json_encode(array('stats' => $thismonth)); 
        //return   array('stats' => $thismonth));  
    }
    
    
    
       function lastmonths($userGroup){
           //$this->data['lastmonthstats'] = array();
       $this->data['lastmonthstats'] = $this->Actions_model->get_recent_stats('lastmonth', $userGroup);
        $this->data['prefix'] = $userGroup;
        return $this->load->view('dashboard/lastmonth', $this->data, true);	
        //echo json_encode(array('stats' => $lastmonth));  
    }
    
    
    
function refactorFavourites($order =false){
    
    
    
    $output = (array)$this->Actions_model->get_assigned_companies_ajax($this->get_current_user_id(),$order);
    
  //echo '<pre>'; print_r($output); echo '</pre>';
    
    
    echo json_encode($output);
}    
    
    
    
        
    function testpear(){

echo $this->userPermission;



}
    
    

/*
By: Glen 20/04/2016

ONE OFF FUNCTION TO REFORMAT LEGACY INITIAL RATES

The two function below are to be used to reformat legacy inital_fee
values into the new decimal point format.

Pre Check using the url dashboard/setupdateintialrate

This will return a list containing the current values that do not conform to
the new format distinctly grouped 

On the left is the new format on the right the original


If happy with the result set hit append the word true after the url: dashboard/setupdateintialrate/true

This will run through the values and change them programatically


function setupdateintialrate($debug = false){

        $query = $this->db->query("SELECT DISTINCT initial_rate FROM companies");
        
        foreach ($query->result_array() as $row)
        {
           if(strlen($row['initial_rate']) <= 9 && $row['initial_rate'] == true)
            echo  $this->updateInitialValues($row['initial_rate'],$debug);
            
        }
}
    
    function updateInitialValues($initialRates,$debug){
        
        if(!$debug){
        return  $initialRates. ' - original '. str_replace(0,'',$initialRates).'<br>' ;
        }else{
              $initialRatesMinusZeros =  str_replace(0,'',$initialRates);
        $newvalue = '0.0'.str_replace('.','',$initialRatesMinusZeros);
        $data = array(
                       'initial_rate' => $newvalue
                    );

        $this->db->where('initial_rate', $initialRates);
        $this->db->update('companies', $data);
        }
    }
*/

}