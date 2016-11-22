<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaigns extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
         $this->load->model('Evergreen_model');
				
	}
	
	public function index() 
	{	
		$session_result = $this->session->userdata('companies');
		$search_results_in_session = unserialize($session_result);
		$refresh_search_results = $this->session->flashdata('refresh');
		$campaign = $this->session->userdata('campaign_id');
	
		$companies_array = $search_results_in_session;
        
         //echo '<pre>'; print_r($companies_array); echo '</pre>';
           //     exit();

		// if campaign exist set this variables
		$this->data['current_campaign_name'] = ($this->session->userdata('campaign_name') ?: FALSE );
		$this->data['current_campaign_owner_id'] = ($this->session->userdata('campaign_owner') ?: FALSE );
		$this->data['current_campaign_id'] = ($this->session->userdata('campaign_id') ?: FALSE );
		$this->data['current_campaign_editable'] = ($this->data['current_campaign_owner_id'] == $this->get_current_user_id() ? TRUE : FALSE );
		$this->data['current_campaign_is_shared'] = $this->session->userdata('campaign_shared') == 'f'? FALSE : TRUE; 
		$this->data['current_campaign_owners'] = $this->Campaigns_model->get_campaign_owner($campaign);
		$this->data['current_campaign_stats'] = $this->Campaigns_model->get_campaign_pipeline($campaign);

		if(empty($companies_array))
		{
			$this->session->unset_userdata('companies');
			$this->data['companies_count'] = 0;
			$this->data['page_total'] = 0;
			$this->data['current_page_number'] = 0;
			$this->data['next_page_number'] = FALSE;
			$this->data['previous_page_number'] =  FALSE;
			$this->data['companies'] = array();
		}else{
			// get companies from recent result or get it from session
			$companies_array_chunk = array_chunk($companies_array, RESULTS_PER_PAGE);
			$current_page_number = $this->input->get('page_num') ? $this->input->get('page_num') : 1;
			$this->data['companies_count'] = count($companies_array);
			$pages_count = ceil(count($companies_array)/RESULTS_PER_PAGE);
			$this->data['page_total'] = ($pages_count < 1)? 1 : $pages_count;
			$this->data['current_page_number'] = $current_page_number;
			$this->data['next_page_number'] = ($current_page_number+1) <= $this->data['page_total'] ? ($current_page_number+1) : FALSE;
			$this->data['previous_page_number'] = ($current_page_number-1) >= 0 ? ($current_page_number-1) : FALSE;
$this->data['companies'] = $companies_array_chunk[($current_page_number-1)];
            
$this->data['department'] =   $this->data['current_user']['department'] ;
            if($this->data['current_user']['department'] == 'sales' || $this->data['current_user']['permission'] == 'admin')
$this->data['evergreen'] =  $this->Evergreen_model->evergreenHeaderInfoSales($this->session->userdata('campaign_id'));
            
            if($this->data['current_user']['department'] == 'data')
            $this->data['evergreen'] =  $this->Evergreen_model->evergreenHeaderInfo($this->session->userdata('campaign_id'));
           
		}
		$this->data['results_type'] = 'Campaign';
		$this->data['edit_page'] = 'edit_campaign';

		$this->data['main_content'] = 'companies/search_results';
		
         
         $this->data['curent_user_permission'] = $this->data['current_user']['permission'];
    
        $this->load->view('layouts/default_layout', $this->data);
        
        
        
	}

	public function create() 
	{	

		if($this->input->post('name'))
		{
			$name = $this->input->post('name');
		}
		else
		{
			$this->set_message_warning('Missing name for the campaign');
			redirect('/companies','refresh');
		}

		if($this->input->post('public'))
		{
			$shared = 'True'; //have to be string to match psql boolean type
		}
		else
		{
			$shared = 'False';
		}
		
		$user_id = $this->get_current_user_id();
		// var_dump($this->input->post());
		
		if ($this->input->post('save_search')){
			$current_search = $this->get_current_search();
			$new_saved_search_id = $this->Campaigns_model->save_search($name,$shared,$user_id,$current_search);
		}elseif ($this->input->post('save_campaign')){
			$new_campaign_id = $this->Campaigns_model->create_campaign($name,$shared,$user_id);
			$session_result = $this->session->userdata('companies');
			$companies_array = unserialize($session_result);
			foreach ($companies_array as $company) {
				// create target
				$this->Campaigns_model->add_company_to_campaign($new_campaign_id,$company['id'],$user_id);
			}
		}
		
		if($new_campaign_id)
		{
			$new_campaign = $this->Campaigns_model->get_campaign_by_id($new_campaign_id);
			$this->session->set_userdata('campaign_id',$new_campaign[0]->id);
			$this->session->set_userdata('campaign_name',$new_campaign[0]->name);
			$this->session->set_userdata('campaign_owner',$new_campaign[0]->user_id);
			$this->session->set_userdata('campaign_shared',(bool)$new_campaign[0]->shared);
			$raw_search_results = $this->Campaigns_model->get_companies_for_campaign_id($new_campaign_id);
			$this->refresh_search_results();
			$companies = $this->process_search_result($raw_search_results);
			$session_companies = serialize($companies);
			$this->session->set_userdata('companies',$session_companies);
			$this->set_message_success('Campaign saved!');
			redirect('/campaigns');
			
		}elseif($new_saved_search_id){
			$this->set_message_success('Search saved!');
			$new_saved_search_id = $this->Campaigns_model->get_saved_searched_by_id($new_saved_search_id);
			$this->session->set_userdata('saved_search_id',$new_saved_search_id[0]->id);
			$this->session->set_userdata('saved_search_name',$new_saved_search_id[0]->name);
			$this->session->set_userdata('saved_search_owner',$new_saved_search_id[0]->user_id);
			$this->session->set_userdata('saved_search_shared',(bool)$new_saved_search_id[0]->shared);
			$this->refresh_search_results();
			redirect('/companies');
		}
	}

	public function get_all_shared_searches(){
$this->session->unset_userdata('evergreen');
		return $this->Campaigns_model->get_all_shared_searches();
	}

	public function get_all_private_searches($user_id){
        $this->session->unset_userdata('evergreen');
		return $this->Campaigns_model->get_all_private_searches($user_id);
	}
	
	public function get_campaigns_for_user($user_id)
	{
        $this->session->unset_userdata('evergreen');
		return $this->Campaigns_model->get_campaigns_for_user($user_id);
	}

	public function display_campaign(){

        
        if(($this->input->get('evergreen')) || ($this->session->userdata("evergreen"))  ){

//echo 'fsdgsdfgsd';
//exit();
            
        $this->session->set_userdata('evergreen',$this->input->get('evergreen'));
            
            
}else{
            
           
		 $this->session->unset_userdata('evergreen');
            
        }
        
        
          if($this->input->get('private')){
              
               $this->session->unset_userdata('evergreen');  
              
          }
        
        
		if($this->input->get('id'))
		{	
            //$this->session->unset_userdata('pipedate');
			$campaign = $this->Campaigns_model->get_campaign_by_id($this->input->get('id'));
			if ($campaign[0]->id == False) {
				print_r('No campaign');
				return False;
			}
			$pipeline = $this->input->get('pipeline');

$dept = array('data','sales');
 
if(in_array($this->data['current_user']['department'],$dept) && ($this->input->get('evergreen'))){
    
    $companies = $this->Campaigns_model->get_companies_for_campaign_id_data_entry($campaign[0]->id,$pipeline);

}else{
           $companies = $this->Campaigns_model->get_companies_for_campaign_id($campaign[0]->id,$pipeline);
    
}
			// print '<pre>';
			// print_r($companies);
			// die;	
			$this->refresh_search_results();
			$this->session->set_userdata('campaign_id',$campaign[0]->id);
			$this->session->set_userdata('campaign_name',$campaign[0]->name);
			$this->session->set_userdata('campaign_owner',$campaign[0]->user_id);
			$this->session->set_userdata('campaign_shared',$campaign[0]->shared);
			$this->session->unset_userdata('current_search');

			$result = $this->process_search_result($companies);

			if(empty($result))
			{
                
               $this->session->unset_userdata('companies');
				unset($search_results_in_session);
			}
			else
			{
                
                
                           foreach($result as $item => $value){
                              // echo $value['id'];
                        $dt =     $this->data['last_pipeline_created_at'] = $this->Actions_model->actiondata($value['id']);
                        $dta[] = array('id' => $value['id'], 'last_pipeline_date' =>  $dt );      
                
                }
            
                $this->session->set_userdata('pipedate',$dta);
				$session_result = serialize($result);
				$this->session->set_userdata('pipeline',$pipeline);
				$this->session->set_userdata('companies',$session_result);
			}
			redirect('/campaigns');
		}
		else
		{
			print 'missing id';
			// id missing 
		}

	}

	public function display_saved_search()
	{
		if($this->input->get('id'))
		{ 
			$campaign = $this->Campaigns_model->get_saved_searched_by_id($this->input->get('id'));
			$post = unserialize($campaign[0]->criteria);			
			$this->refresh_search_results();
			$this->session->set_userdata('saved_search_id',$campaign[0]->id);
			$this->session->set_userdata('saved_search_name',$campaign[0]->name);
			$this->session->set_userdata('saved_search_owner',$campaign[0]->user_id);
			
			$this->session->set_userdata('saved_search_shared',$campaign[0]->shared);
			$this->session->set_userdata('current_search',$post);
			
			redirect('/companies');
		}
		else
		{
			// id missing 
		}
	}
	// edit saved search
	public function edit_saved_search()
	{	
		if($this->input->post('campaign_id') == FALSE) return False;
		
		if(null !== $this->input->post('make_private'))
		{
			$result = $this->Campaigns_model->update_campaign_make_private($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{
				$this->session->set_userdata('saved_search_shared','f');
			}
		}
		elseif(null !== $this->input->post('make_public')) 
		{
			$result = $this->Campaigns_model->update_campaign_make_public($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{	
				$this->session->set_userdata('saved_search_shared','t');
			}
		}
		elseif (null !== $this->input->post('delete')) 
		{
			$result = $this->Campaigns_model->delete_campaign($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{
				$this->clear_saved_search_from_session();
			}
		}
		
		redirect('/companies');
	}
	
	public function edit_campaign()
	{	
		if($this->input->post('campaign_id') == FALSE) return False;
		
		if(null !== $this->input->post('make_private'))
		{
			$result = $this->Campaigns_model->update_campaign_make_private($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{
				$this->session->set_userdata('campaign_shared','f');
			}
		}
		elseif(null !== $this->input->post('make_public')) 
		{
			$result = $this->Campaigns_model->update_campaign_make_public($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{	
				$this->session->set_userdata('campaign_shared','t');
			}
		}
		elseif (null !== $this->input->post('delete')) 
		{
			$result = $this->Campaigns_model->delete_campaign($this->input->post('campaign_id'),$this->get_current_user_id());
			if($result == True)
			{
				$this->clear_campaign_from_session();
			}
		}
		
		redirect('/campaigns');
	}
    
    
      function updateTagCampaignRun()
    { //updates the campaign with 5 more 
        echo json_encode(array('success' => 'ok'));
        //echo json_encode($this->Evergreen_model->updateTagCampaign());
        
    }
    
    
    function test(){
        
        
     $output =    $this->data['evergreen'] =  $this->Evergreen_model->evergreenHeaderInfoSales($this->session->userdata('campaign_id'));
        
    print_r($output);
        
        
        
    }
    
    
    function evergreenHeaderInfoSales($campaign_id){
           
     $campaign_id  = 657;      
                    
$sql = 'select json_agg(results)
		from (

		select row_to_json((
		       T1."JSON output",
		       T2."JSON output"
		       )) "company"
		from 
		(-- T1 -----------------------------------------------------------------------------------------------------------------------------------------------------------------------
		select C.id,
			   C.name,
			   C.pipeline,
               TARGETS.created_at "target created",
			   U.id "owner_id",
			   TT5.actioned_at, -- f32
			   TT6.planned_at, -- f35
			   AU1.name "aname1",
			   AU2.name "aname2",
		       row_to_json((
		       C.id, -- f1
		       C.name, -- f2
		       C.url, -- f3
			   to_char(C.eff_from, \'dd/mm/yyyy\'), -- f4
			   C.linkedin_id, -- f5
			   U.name, -- f6
			   U.id , -- f7
			   A.address, --f8
			   C.active, -- f9
			   C.created_at, -- f10
			   C.updated_at, -- f11
			   C.created_by,-- f12
			   C.updated_by,-- f13
			   C.registration, -- f14
		       TT1."turnover", -- f15
			   TT1."turnover_method",  -- f16
			   TT4.count,--f17
			   U.image , -- f18
			   C.class, -- f19
			   A.lat, -- f20
			   A.lng, -- f21
			   json_agg( 
			   row_to_json ((
			   TT2."sector_id", TT2."sector"))),-- f22
			   C.phone, -- f23 
			   C.pipeline, -- f24
			   CONT.contacts_count, -- f25
			   C.parent_registration, --f26
			   C.zendesk_id, -- f27
			   C.customer_from, -- f28
			   C.sonovate_id, -- f29
			   TT5.actioned_at, -- f30
			   ACT1.name, -- f31
			   AU1.name, -- f32
			   TT6.planned_at, -- f33
			   ACT2.name , -- f34
			   AU2.name, -- f35
			   C.trading_name, --f36
			   C.lead_source_id, --f37
			   C.source_date, --f38
			   pr.name, --f39
			   pr.id, --f40
			   C.source_explanation, --f41
			   UC.name, --f42
			   UU.name, --f43
               C.initial_rate, --f44
                C.customer_to --f45
			   )) "JSON output" 
			  
		from (select * from companies where active = \'t\') C  
		  
		JOIN 
		(select company_id,
		        created_at
		from TARGETS 
		where campaign_id = '.$campaign_id.' ) TARGETS  -- Hack to list companies for a campaign - remove in Baselist Code
		ON C.id = TARGETS.company_id                                            -- 
	  
		LEFT JOIN 
		(-- TT1 
		select T.company_id "company id",
		       T.turnover "turnover",
		       T.method "turnover_method"       
		from 
		(-- T1
		select id "id",
		       company_id,
		       max(eff_from) OVER (PARTITION BY company_id) "max eff date"
		from TURNOVERS
		)   T1
		  
		JOIN TURNOVERS T
		ON T1.id = T.id
		  
		where T1."max eff date" = T.eff_from	  
		)   TT1
		ON TT1."company id" = C.id 

		LEFT JOIN 
		(-- TT4 
		select distinct E.company_id,
		                E.count
		from 
		(-- T4
		select distinct id,
		company_id,
		max(created_at) OVER (PARTITION BY company_id) "max created_at date"
		from emp_counts
		)   T4
		JOIN EMP_COUNTS E
		ON T4.id = E.id 
		where T4."max created_at date" = E.created_at
		)   TT4
		ON TT4.company_id = C.id 

		LEFT JOIN
		(
		SELECT count(*) "contacts_count",
		       company_id FROM "contacts" 
		group by contacts.company_id
		) CONT 
		ON CONT.company_id = C.id
	
		LEFT JOIN 
		(-- TT5 LAST ACTION
		select distinct ac1.*
		from 
		(-- T5
		select distinct id,
		       company_id,
		       max(id) OVER (PARTITION BY company_id) "max id"
		from actions
		where action_type_id in (\'4\',\'5\',\'6\',\'8\',\'9\',\'10\',\'11\',\'12\',\'13\',\'17\',\'18\')
		and actioned_at is not null
		)   T5
		JOIN ACTIONS AC1
		ON T5.id = AC1.id 
		where T5."max id" = AC1.id
		)   TT5
		ON TT5.company_id = C.id

		LEFT JOIN 
 		ACTION_TYPES ACT1
 		ON TT5.action_type_id = ACT1.id

 		LEFT JOIN
 		COMPANIES PR
		ON C.parent_registration = PR.registration

		LEFT JOIN 
 		USERS UC
 		ON UC.id = C.created_by

		LEFT JOIN 
 		USERS UU
 		ON uu.id = C.updated_by

		LEFT JOIN 
 		USERS AU1
 		ON TT5.user_id = AU1.id

 		LEFT JOIN 
		(-- TT6 NEXT ACTION
		select distinct AC2.*
		from 
		(-- T6
		select distinct id,
		       company_id,
		       planned_at
		from ACTIONS
		where actioned_at is null 
		and cancelled_at is null
		)   T6
		JOIN ACTIONS AC2
		ON T6.id = AC2.id 
		where T6.id = AC2.id
		)   TT6
		ON TT6.company_id = C.id
		
		LEFT JOIN 
 		ACTION_TYPES ACT2 on
 		TT6.action_type_id = ACT2.id

		LEFT JOIN 
 		USERS AU2 on
 		TT6.user_id = AU2.id

		LEFT JOIN
		(-- TT2
		select O.company_id "company id",
		       S.id "sector_id",
		       S.name "sector"       
		from OPERATES O

		JOIN SECTORS S
		ON O.sector_id = S.id
		where O.active = \'TRUE\'
		)   TT2
		ON TT2."company id" = C.id

		LEFT JOIN 
		ADDRESSES A
		ON a.id = (select id from addresses where type ilike \'registered address\' and company_id = C.id limit 1)

		LEFT JOIN
		USERS U
		ON U.id = C.user_id
				 
		group by C.id,
		         C.name,
		         C.url,
			     C.eff_from,
			     C.linkedin_id,
                 TARGETS.created_at,
			     C.active,
			     C.created_at,
			     C.updated_at,
			     C.created_by,
			     C.updated_by,
			     C.registration,
			     C.class,
			     C.phone,
			     C.pipeline,
			     C.parent_registration,	
			     U.id,
			     U.name,
		  		 U.image,
			     A.address,
			     A.lat,
			     A.lng,
		         TT1."turnover",
			     TT1."turnover_method",
			     TT4.count,
			     CONT.contacts_count,
			     C.zendesk_id,
			     C.customer_from,
			     C.sonovate_id,
			     TT5.actioned_at,
			     ACT1.name,
			     AU1.name,
			     TT6.planned_at,
			     ACT2.name,
			     AU2.name,
			     C.trading_name,
				 C.lead_source_id,
			     C.source_date,
			     pr.name,
			     pr.id,
			     C.source_explanation,
			     UC.name, 
			     UU.name,
                  C.initial_rate,   
                 C.customer_to

		order by C.id 

		)   T1 -----------------------------------------------------------------------------------------------------------------------------------------------------------------------

		LEFT JOIN

		(-- T2 -----------------------------------------------------------------------------------------------------------------------------------------------------------------------
		select T."company id",
		       json_agg(
			   row_to_json(
			   row (T."mortgage id", T."mortgage provider", T."mortgage stage", T."mortgage start", T."mortgage end", T."mortgage type",  T."provider url", T."mortgage Inv_fin_related"))) "JSON output"  -- f11
				 
		from 
		(-- T
		select M.company_id "company id",
		       M.id "mortgage id",
		       P.name "mortgage provider",
		       P.url "provider url",
		       M.stage "mortgage stage",
		       to_char(M.eff_from, \'dd/mm/yyyy\')  "mortgage start",
		       to_char(M.eff_to, \'dd/mm/yyyy\')  "mortgage end",
		       M.type "mortgage type",
                M.Inv_fin_related "mortgage Inv_fin_related"

		from MORTGAGES M
		  
		JOIN PROVIDERS P
		ON M.provider_id = P.id 

		order by 1, 5, M.eff_from desc

		)   T

		group by T."company id"	

		order by T."company id"

		)   T2 -----------------------------------------------------------------------------------------------------------------------------------------------------------------------
		ON T1.id = T2."company id"
 
		order by "target created"desc
		 
		) results';
            
            
            
		$query = $this->db->query($sql);
            //return $query->result_array();
        
       // $array2[0] =  array( 'percentage' => 23);
   
        //return $query->result_array();  
        
        
      print '<pre>';
     print_r($this->process_search_result($query->result_array()));
      print '</pre>';
           
       }
    

}
