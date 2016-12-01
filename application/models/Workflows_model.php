<?php
class Workflows_model extends MY_Model {
    
    
    function allUserCustomers($userID){
        
        
$sql = "select customer_from,
       customer_to,
	  C.id  \"company_id\",C.name \"name_\",
	   round(100* initial_rate,2) \"initial_rate\", 
	   LS.name \"lead_source\",
	   round((customer_from::date - C.eff_from::date)/30) \"age_at_joining_months\",
	   -- to_char(C.eff_from,'yyyy-Mon') \"founded\",
	   to_char(round(C.turnover,-3),'999,999,999')  \"turnover\",
	   -- CASE when T1.company_id is not null then 'Target' else 'Non-TS' END \"sector\",
	   class,
	   TT2.planned_at::date \"planned\",
       AT.name \"action\",
       TT2.\"by\"
	   
from COMPANIES C

LEFT JOIN LEAD_SOURCES LS
ON C.lead_source_id = LS.id

JOIN
(-- T0
select distinct A.company_id
	   
from ACTIONS A

where A.action_type_id = 19
and comments = 'Pipeline changed to Customer'
and created_by = 21 -- CURRENT USER HERE ! ! ! 
)   T0
ON C.id = T0.company_id

LEFT JOIN
(-- T1
select distinct company_id
from SECTORS S
JOIN OPERATES O
ON S.id = O.sector_id
where O.active = 't'
and S.target = 't'
)   T1
ON C.id = T1.company_id

LEFT JOIN
(-- TT2
select company_id,
       planned_at,
       comments,
       action_type_id,
       \"by\"

from 
(-- T1
select A.company_id,
       A.planned_at,
       A.comments,
       A.action_type_id,
       U.name \"by\",
       row_number() OVER (PARTITION BY company_id order by A.created_at desc) \"rownum\"

from ACTIONS A
JOIN USERS U
ON A.created_by = U.id  

where A.actioned_at is null
)   T1
where \"rownum\" = 1
)   TT2
ON C.id = TT2.company_id

LEFT JOIN ACTION_TYPES AT
ON TT2.action_type_id = AT.id

where C.customer_from is not null

order by 1 desc
";

$sql = "select customer_from,
       customer_to,
	  C.id  \"company_id\",C.name \"name_\",
	   round(100* initial_rate,2) \"initial_rate\", 
	   LS.name \"lead_source\",
	   round((customer_from::date - C.eff_from::date)/30) \"age_at_joining_months\",
	   -- to_char(C.eff_from,'yyyy-Mon') \"founded\",
	   to_char(round(C.turnover,-3),'999,999,999') \"turnover\",
	   -- CASE when T1.company_id is not null then 'Target' else 'Non-TS' END \"sector\",
	   class,
	   CASE when TT2.actioned_at is null then TT2.planned_at::date END \"planned\",
	   TT2.actioned_at::date \"actioned\",
       AT.name \"action\",
       TT2.\"by\"
	   
from COMPANIES C

LEFT JOIN LEAD_SOURCES LS
ON C.lead_source_id = LS.id

JOIN
(-- T0
select distinct A.company_id
	   
from ACTIONS A

where A.action_type_id = 19
and comments = 'Pipeline changed to Customer'
and created_by = 21 -- CURRENT USER HERE ! ! ! 
)   T0
ON C.id = T0.company_id

LEFT JOIN
(-- T1
select distinct company_id
from SECTORS S
JOIN OPERATES O
ON S.id = O.sector_id
where O.active = 't'
and S.target = 't'
)   T1
ON C.id = T1.company_id

LEFT JOIN
(-- TT2
select company_id,
       planned_at,
       actioned_at,
       comments,
       action_type_id,
       \"by\"

from 
(-- T1
select A.company_id,
       A.planned_at,
       A.actioned_at,
       A.comments,
       A.action_type_id,
       U.name \"by\",
       row_number() OVER (PARTITION BY company_id order by CASE when 
          actioned_at is null then planned_at else actioned_at END desc) \"rownum\"

from ACTIONS A
JOIN USERS U
ON A.user_id = U.id
where A.action_type_id not in (7,30) -- ie ignore Comments
and A.cancelled_at is null
)   T1
where \"rownum\" = 1
)   TT2
ON C.id = TT2.company_id

LEFT JOIN ACTION_TYPES AT
ON TT2.action_type_id = AT.id

where C.customer_from is not null

order by 1 desc
LIMIT 100
";        
        
        
//print($sql);
$query = $this->db->query($sql);
	 
	return $query->result_array();
       // nl2br($sql);
     }
  
    
    
    function companiesCreatedUser($userID){

$sql = "select created_at::date created,
       id  company_id,
       name  company_name,
	   pipeline   pipeline        
	   
from COMPANIES

where created_by =  ".$userID." -- ie CURRENT USER

order by created_at desc

limit 100
";
        
        $query = $this->db->query($sql);
	 
		return $query->result_array();
        
        
}
    
  
    
    
function recentViewedCompanies($userID){
    
            $sql = "select T.created_at::date visit_date,
            T.company_id       company_id,
            C.name             company_name,
            C.pipeline         pipeline

            from
            (
            select V.company_id,
            row_number() OVER (PARTITION BY company_id order by V.created_at desc) \"rownum\",
            V.created_at

            from VIEWS V

            where V.user_id = ".$userID." -- ie CURRENT USER

            order by V.created_at desc
            limit 175
            ) T

            JOIN COMPANIES C
            ON T.company_id = C.id

            where \"rownum\" = 1

            order by T.created_at desc

            limit 100";


                
                $query = $this->db->query($sql);
	 
		return $query->result_array();
                
    
    
}
    
    
}