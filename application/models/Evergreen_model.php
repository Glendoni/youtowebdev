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
	 
public function updateTagCampaign($campaign_id,$user_id){

$sql_ = 'select U.name "owner",
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

where CA.id = 604

group by 1,2,3';

    
    $sql = 'select C.id as companyID, concat(\'<a href="http://localhost:8888/baselist/companies/company?id=\',"company id",\'" target="_blank">\',C.name,\'</a>\') "Company / Baselist URL",
       CASE when A.address ilike \'%london%\' then \'London\' 
             else \'Reg.\'
       END "Address",
	   C.eff_from "founded",
       to_char(C.turnover,\'999,999,999\') "turnover",
       sum("score") "score"

-- select count(distinct C.id)

from
(-- T2
select distinct "company id",
       "score",
       "method"

from
(-- T1
-- -----------  TURNOVER & FOUNDED DATE  --------------------------------------

select C.id "company id",
       CASE 
            when current_date - eff_from < 182 then 100
            when current_date - eff_from between 183 and (365 * 2 + 300) then 50
            when current_date - eff_from > (365 * 2 + 300) and turnover > 150000 then 25
            else 0
	   END "score",
       \'Turnover & Founded Date\' "method"
	   
from COMPANIES C

where class  = \'FF\'
and C.active = \'t\'

UNION ALL -- ----  FOUNDED DATE    --------------------------------------

select C.id "company id",
       CASE when current_date - eff_from < (365 * 0.5) then 100
            when to_char(eff_from,\'yyyy\') = \'2008\' then 2.2 
            else 0.6
        END  "score",
       \'founded date\' "method"
	   
from COMPANIES C

where class  = \'FF\'
and C.active = \'t\'
  
UNION ALL  -- ------------  LOCATION   ------------------------------------

select C.id "company id",
       CASE when A.address ilike \'%london%\' then 1.2 
             else 0.9 
       END "score",
       \'location\' "method"
	   
from COMPANIES C

JOIN ADDRESSES A
ON C.id = A.company_id
AND A.type = \'Registered Address\'

where class  = \'FF\'
and C.active = \'t\'
  
UNION ALL -- ----  SIC CODE   --------------------------------------

select C.id "company id",
       CASE when T.name = \'78200 - Temporary employment agency activities\' then 1.23
            when T.name = \'82990 - Other business support service activities n.e.c.\' then 1.23
            when T.name = \'78300 - Human resources provision and management of human resources functions\' then 0.22
            when T.name = \'78109 - Other activities of employment placement agencies\' then 0.86
            else 1
        END  "score",
       \'SIC code\' "method"
	   
from COMPANIES C
JOIN COMPANY_TAGS CT
ON C.id = CT.company_id

JOIN TAGS T
ON CT.tag_id = T.id
AND T.category_id = 52
AND T.id in (314,315,316,320,326,615) 

where class  = \'FF\'
and C.active = \'t\'
  
UNION ALL -- ----  LTD vs LIMITED vs OTHER  --------------------------------------

select C.id "company id",
       CASE when name ilike \'% ltd%\' then 1.23
	        when name ilike \'% limited%\' then 0.9  
			else 0
	   END "score",
       \'Ltd vs Limited\' "method"
	   
from COMPANIES C

where class  = \'FF\'
and C.active = \'t\'   
  
UNION ALL -- ----  COMPANY NAME  --------------------------------------

select C.id "company id",
	   CASE when name ilike \'%search%\' then 2
	        when name ilike \'%group%\' then 2
			else 1	 
	   END "score",
       \'Company name\' "method"
	   
from COMPANIES C

where class  = \'FF\'
and C.active = \'t\'

)   T1 -- ---------------------------------------------------------------
  
  
LEFT JOIN OPERATES O
ON T1."company id" = O.company_id
AND O.active = \'t\'

LEFT JOIN SECTORS S
ON O.sector_id = S.id
-- AND S.target = \'t\'

LEFT JOIN ACTIONS A
ON T1."company id" = A.company_id

where A.company_id is null
and S.id is null

order by 1 desc nulls last
)   T2

JOIN COMPANIES C
ON T2."company id" = C.id

JOIN ADDRESSES A
ON C.id = A.company_id
AND A.type = \'Registered Address\'

LEFT JOIN
(-- T3
select distinct company_id
  
from COMPANY_TAGS CT

JOIN TAGS 
ON TAGS.id = CT.tag_id

where TAGS.category_id = 18
and CT.eff_TO is null
)   T3
ON C.id = T3.company_id 

where class = \'FF\'
and T3.company_id is null
and C.parent_registration is null
and C.id not in (select company_id from targets)

and current_date - C.eff_from < 365 * 8

AND 
(
turnover between 50000 and 1000000
or 
(turnover is null and current_date - C.eff_from < 365 * 1.5)
)

group by 1,2,3,4

order by sum("score") desc, 1

limit 5';


   
        $preCheckAllocation  = $this->evergreenHeaderInfo(1,$campaign_id);
 if (!$preCheckAllocation [0]['remaining']){
    $query = $this->db->query("SELECT * FROM evergreen WHERE id=".$campaign_id);
     $row  =     $query->result_array();
         
     $sql =   $row[0]['sql']; 
     
		//return $query->result_array();
 //$sql  =  $query->result_array();
  
    $query = $this->db->query($sql);
            
            foreach ($query->result_array() as $row => $value)
            {
                //echo $value['companyid'];
                $this->campaignAllocator($value['companyid'],$user_id,$campaign_id);
    
            }
    
 }
    return array('success' => 'ok');
               // echo '<pre>'; print_r($query); echo '</pre>';
             
}
    
    
    private function campaignAllocator($company_id,$user_id,$campaign_id){


$data = array(
   'campaign_id' => $campaign_id ,
   'company_id' => $company_id,
    'created_by' => $user_id ,
    'updated_by' => null,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
    'eff_to' => null,
    'evergreen_id' => $campaign_id
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
        
        
        
        $sql = 'select U.name "owner",
       CA.created_at::date "created",
       CA.name "campaign",
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

group by 1,2,3';
        
    
    
         $query = $this->db->query($sql);
            //return $query->result_array();
        
       // $array2[0] =  array( 'percentage' => 23);
   
        return $query->result_array();
    }
    
    
}