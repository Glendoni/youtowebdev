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
   
     
     
          $sqlCheck = 'SELECT evg.max_allowed as maxallowed, sql ,count(ta.id) as targetCounter
                        FROM targets ta
                        LEFT JOIN evergreens evg
                        ON ta.evergreen_id = evg.id
                        WHERE ta.campaign_id='.$campaign_id.'
                        AND ta.evergreen_id is not null
                        GROUP BY 1,2';
        $query = $this->db->query($sqlCheck);
        $row  =     $query->result_array(); 
        
       if($row[0]['targetcounter'] > $row[0]['maxallowed']){
                    return array('success' => 202);
                 
              }else{
     
            $numrow = $query->num_rows();
     
        if($numrow < 1){ 
         $query = $this->db->query("SELECT evg.max_allowed as emax, sql, count(ta.id) FROM evergreens evg 
                                    LEFT JOIN targets ta
                                    ON evg.id = ta.evergreen_id
                                    WHERE evg.id=".$evergreenID."
                                    GROUP BY 1,2");
         $row = $query->result_array();
        }
     
         $sql =   $row[0]['sql']; 
  
                            //return $query->result_array();
                     //$sql  =  $query->result_array();
  
         $query = $this->db->query($sql);
           
            foreach ($query->result_array() as $row => $value)
            {
                //echo $value['companyid'];
                //$this->campaignAllocator($value['companyid'],$user_id,$campaign_id,$evergreenID);
    
            }
    
 
    return array('success' => 'ok');
   }  
 }
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
            WHERE cam.user_id='.$user_id.' AND cam.evergreen_id is not null';
        
            $query = $this->db->query($sql);
            //return $query->result_array();
        
       // $array2[0] =  array( 'percentage' => 23);
   
         $sql  =  $query->result_array();
  
             $output = $sql;
        
        
          return $output ? $output : array('success' => 'not ok');
          // echo '<pre>'; print_r($result); echo '</pre>';

    }
    
    
    function evergreenHeaderInfo($campaign_id){
 
        
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
    
    
       function evergreenHeaderInfoSales($campaign_id){
           
           
        $sql= "select campaign_id,
       campaignname,
	   description,
	   image,
	   datecreated,
       campaign_total,
	   campaign_suspect,
       campaign_prospect,
       campaign_intent,
       campaign_proposal,
       campaign_customer,
       campaign_unsuitable,
	   unprocessed
	   
from
(-- TT1
select CA.id,
 	   CA.id campaign_id,
	   CA.created_at::date \"created\",
	   U.image image,
	   CA.name \"campaign name\" ,
	   CA.name \"campaignname\" ,
       CA.created_at::date \"datecreated\",
       CA.description description ,
       count(distinct T.id) campaign_total,
       count(distinct CASE when CO.pipeline = 'Suspect' then CO.id END) campaign_suspect,
       count(distinct CASE when CO.pipeline = 'Prospect' then CO.id END) campaign_prospect,
       count(distinct CASE when CO.pipeline = 'Intent' then CO.id END) campaign_intent,
       count(distinct CASE when CO.pipeline = 'Proposal' then CO.id END) campaign_proposal,
       count(distinct CASE when CO.pipeline = 'Customer' then CO.id END) campaign_customer,
       count(distinct CASE when CO.pipeline in ('Unsuitable','Lost') then CO.id END) campaign_unsuitable,
       count(distinct T.id) - count(T1.company_id) unprocessed
  
FROM CAMPAIGNS CA
  
JOIN USERS U
ON CA.user_id = U.id
  
JOIN TARGETS T
ON CA.id = T.campaign_id
  
JOIN COMPANIES CO
ON T.company_id = CO.id
  
LEFT JOIN 
(
select company_id,
       max(created_at) \"most recent action\"
  
from ACTIONS 
group by 1
)   T1
ON CO.id = T1.company_id
AND T1.\"most recent action\" > T.created_at
  
where CA.id = ".$campaign_id."
and CO.active = 't'
  
group by 1,2,3,4,5,6,7,8
  
order by 2, 1 desc
)   TT1"
;   
           
           
$sql = "select campaign_id,
       campaignname,
	   description,
	   image,
	   datecreated,
       campaign_total,
	   campaign_suspect,
       campaign_prospect,
       campaign_intent,
       campaign_proposal,
       campaign_customer,
       campaign_unsuitable,
	   unprocessed
	   
from
(-- TT1
select CA.id,
 	   CA.id campaign_id,
	   CA.created_at::date \"created\",
	   U.image image,
	   CA.name \"campaign name\" ,
	   CA.name \"campaignname\" ,
       CA.created_at::date \"datecreated\",
       CA.description description ,
       count(distinct T.id) campaign_total,
       count(distinct CASE when CO.pipeline = 'Suspect' then CO.id END) campaign_suspect,
       count(distinct CASE when CO.pipeline = 'Prospect' then CO.id END) campaign_prospect,
       count(distinct CASE when CO.pipeline = 'Intent' then CO.id END) campaign_intent,
       count(distinct CASE when CO.pipeline = 'Proposal' then CO.id END) campaign_proposal,
       count(distinct CASE when CO.pipeline = 'Customer' then CO.id END) campaign_customer,
       count(distinct CASE when CO.pipeline in ('Unsuitable','Lost') then CO.id END) campaign_unsuitable,
       count(distinct T.id) - count(T1.company_id) unprocessed
  
FROM CAMPAIGNS CA
  
JOIN USERS U
ON CA.user_id = U.id
  
JOIN TARGETS T
ON CA.id = T.campaign_id
  
JOIN COMPANIES CO
ON T.company_id = CO.id
  
LEFT JOIN 
(
select company_id,
       max(created_at) \"most recent action\"
  
from ACTIONS 
group by 1
)   T1
ON CO.id = T1.company_id
AND T1.\"most recent action\" > T.created_at
  
where CA.id =  ".$campaign_id."
and CO.active = 't'
  
group by 1,2,3,4,5,6,7,8
  
order by 2, 1 desc
)   TT1
";  
           
           
           $sql = "select campaign_id,
       campaignname,
	   description,
	   image,
	   datecreated,
       campaign_total,
	   campaign_suspect,
       campaign_prospect,
       campaign_intent,
       campaign_proposal,
       campaign_customer,
       campaign_unsuitable,
       evergreenmax,
	   unprocessed
	   
from
(-- TT1
select CA.id,
 	   CA.id campaign_id,
	   CA.created_at::date \"created\",
	   U.image image,
	   CA.name \"campaign name\" ,
	   CA.name \"campaignname\" ,
       evg.max_allowed  \"evergreenmax\",
       CA.created_at::date \"datecreated\",
       CA.description description ,
       count(distinct T.id) campaign_total,
       count(distinct CASE when CO.pipeline = 'Suspect' then CO.id END) campaign_suspect,
       count(distinct CASE when CO.pipeline = 'Prospect' then CO.id END) campaign_prospect,
       count(distinct CASE when CO.pipeline = 'Intent' then CO.id END) campaign_intent,
       count(distinct CASE when CO.pipeline = 'Proposal' then CO.id END) campaign_proposal,
       count(distinct CASE when CO.pipeline = 'Customer' then CO.id END) campaign_customer,
       count(distinct CASE when CO.pipeline in ('Unsuitable','Lost') then CO.id END) campaign_unsuitable,
       count(distinct T.id) - count(T1.company_id) unprocessed
  
FROM CAMPAIGNS CA
  
JOIN USERS U
ON CA.user_id = U.id
  
JOIN TARGETS T
ON CA.id = T.campaign_id
  
JOIN COMPANIES CO
ON T.company_id = CO.id
  
LEFT JOIN 
(
select company_id,
       max(created_at) \"most recent action\"
  
from ACTIONS 
group by 1
)   T1
ON CO.id = T1.company_id
 LEFT JOIN evergreens evg
ON CA.evergreen_id = evg.id 
AND T1.\"most recent action\" > T.created_at
  
where CA.id = ".$campaign_id." 
and CO.active = 't'
  
group by 1,2,3,4,5,6,7,8
  
order by 2, 1 desc
)   TT1 ";
           
           
           
     $query = $this->db->query($sql);
            //return $query->result_array();
        
       // $array2[0] =  array( 'percentage' => 23);
   
        return $query->result_array();       
           
       }
    
    
    
}