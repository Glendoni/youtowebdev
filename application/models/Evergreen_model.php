<?php
class Evergreen_model extends MY_Model {
	
public function campaigncountChecker(){

$sql = 'select U.name "owner",
       CA.created_at::date "created",
       CA.name "campaign",
       count(*) "companies in campaign",
	   count(CASE when T1.company_id is not null then 1 END) "DQ Tag",
	   count(CASE when T2.company_id is not null then 1 END) "Sector Allocated",
	   count(*) - count(CASE when T1.company_id is not null or T2.company_id is not null  then 1 END) "remaining"

from CAMPAIGNS CA
JOIN TARGETS T
ON CA.id = T.campaign_id
  
JOIN COMPANIES C
ON T.company_id = C.id

JOIN USERS U
ON CA.user_id = U.id

LEFT JOIN
(-- T1
select distinct CT.company_id

from COMPANY_TAGS CT
  
JOIN TAGS T
ON CT.tag_id = T.id

where T.category_id = 18
-- AND CT.eff_to is null
)   T1
ON C.id = T1.company_id

LEFT JOIN
(-- T2
select distinct company_id
from OPERATES 
where active = \'t\'
)   T2
ON C.id = T2.company_id

where CA.id = 4

group by 1,2,3
';
    
    
    
     	$query = $this->db->query($sql);

		//return $query->result_array();
 $sql  =  $query->result_array();
  
        
           echo '<pre>'; print_r($sql); echo '</pre>';



}
	 
public function updateTagCampaign($campaign_id,$user_id,$evergreenID){

   
        $preCheckAllocation  = $this->evergreenHeaderInfo(1,$campaign_id);
 if (!$preCheckAllocation [0]['remaining']){
    $query = $this->db->query("SELECT * FROM evergreens WHERE id=".$evergreenID);
     $row  =     $query->result_array();
         
     $sql =   $row[0]['sql']; 
     
		//return $query->result_array();
 //$sql  =  $query->result_array();
  
    $query = $this->db->query($sql);
            
            foreach ($query->result_array() as $row => $value)
            {
                //echo $value['companyid'];
                $this->campaignAllocator($value['companyid'],$user_id,$campaign_id,$evergreenID);
    
            }
    
 }
    return array('success' => 'ok');
               // echo '<pre>'; print_r($query); echo '</pre>';
             
}
    
    
    private function campaignAllocator($company_id,$user_id,$campaign_id,$evergreenID){


$data = array(
   'campaign_id' => $campaign_id ,
   'company_id' => $company_id,
    'created_by' => $user_id ,
    'updated_by' => null,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
    'eff_to' => null,
    'evergreen_id' => $evergreenID
);

$this->db->insert('targets', $data);

}
    
    
 function evergreendataAllocator(){
     
     
     
     
     
 }   
    
    public function  getMyEvergreenCampaign($user_id)
    {

            $sql =  'select cam.*, to_char(cam.created_at, \'dd-mm-yyyy\') as datecreated, U.image  
            FROM campaigns cam 
            LEFT JOIN users  U
            ON cam.user_id = U.id
            WHERE cam.user_id='.$user_id;
        
            $query = $this->db->query($sql);
            //return $query->result_array();
        
       // $array2[0] =  array( 'percentage' => 23);
   
         $sql  =  $query->result_array();
  
             $output = $sql;
        
        
          return $output ? $output : array('success' => 'not ok');
          // echo '<pre>'; print_r($result); echo '</pre>';

    }
    
    
    function evergreenHeaderInfo($user_id, $campaign_id){
        
               $sql_ = 'select U.name "owner",
       CA.created_at::date "created",
       CA.name "campaign",
       CA.evergreen_id "evergreen",
       count(*) "companies_in_campaign",
	   count(CASE when T1.company_id is not null then 1 END) "DQ_Tag",
	   count(CASE when T2.company_id is not null then 1 END) "Sector_Allocated",
	   count(*) - count(CASE when T1.company_id is not null or T2.company_id is not null  then 1 END) "remaining"

from CAMPAIGNS CA
JOIN TARGETS T
ON CA.id = T.campaign_id
  
JOIN COMPANIES C
ON T.company_id = C.id

JOIN USERS U
ON CA.user_id = U.id

LEFT JOIN
(-- T1
select distinct CT.company_id

from COMPANY_TAGS CT
  
JOIN TAGS T
ON CT.tag_id = T.id

where T.category_id = 18
AND CT.eff_to is null
)   T1
ON C.id = T1.company_id

LEFT JOIN
(-- T2
select distinct company_id
from OPERATES 
where active = \'t\'
)   T2
ON C.id = T2.company_id

where CA.id = '.$campaign_id.'

group by 1,2,3,4'; 
        
        $sql = 'select U.name "owner",
       CA.created_at::date "created",
       CA.name "campaign",
       count(*) "companies_in_campaign",
	   count(CASE when T1.company_id is not null then 1 END) "DQ_Tag",
	   count(CASE when T2.company_id is not null then 1 END) "Sector_Allocated",
	   count(*) - count(CASE when T1.company_id is not null or T2.company_id is not null then 1 END) "remaining"

from CAMPAIGNS CA
JOIN TARGETS T
ON CA.id = T.campaign_id
  
JOIN COMPANIES C
ON T.company_id = C.id

JOIN USERS U
ON CA.user_id = U.id

LEFT JOIN
(-- T1
select company_id,
       max(CT.created_at) "most recent DQ set"
  
from COMPANY_TAGS CT

JOIN TAGS 
ON TAGS.id = CT.tag_id

where TAGS.category_id = 18
and CT.eff_TO is null

group by 1
)   T1
ON C.id = T1.company_id
AND "most recent DQ set" > T.created_at 

LEFT JOIN
(-- T2
select distinct company_id
from OPERATES 
where active = \'t\'
)   T2
ON C.id = T2.company_id

where CA.id = '.$campaign_id.'

group by 1,2,3';
        
         $query = $this->db->query($sql);
            //return $query->result_array();
        
       // $array2[0] =  array( 'percentage' => 23);
   
        return $query->result_array();
    }
    
    
}