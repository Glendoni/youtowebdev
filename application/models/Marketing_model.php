      <?php
//for model.php
class Marketing_model extends MY_Model {
    
    
public function autopilot_segment()
{
    $dbconn = pg_connect("host=ec2-79-125-118-138.eu-west-1.compute.amazonaws.com port=5522 dbname=d7fvbgmrpjg4ba user=ucvie36u7gtubf password=p6lgogrt7mg89411qujnepsgfkf")
    or die('Could not connect: ' . pg_last_error());

    // Performing SQL query
    $query = "select DISTINCT  identifies.company, identifies.id as un_ids,CONCAT(identifies.first_name,' ',identifies.last_name) as username, 
    to_char(identifies.sent_at, 'YYYY-MM-DD') as Date ,send.event_text as sent,
    _open.event_text as opened, click.event_text as click, unsubscribe.event_text as unsubscribed, send.campaign as campaign_name, identifies.email as sent_email
    From autopilot_baselist.identifies 
    LEFT JOIN  autopilot_baselist.tracks
    ON tracks.user_id  = identifies.user_id 
    LEFT JOIN  autopilot_baselist.send
    ON tracks.id  = send.id 
    LEFT JOIN  autopilot_baselist._open
    ON send.user_id = _open.user_id 
    LEFT JOIN  autopilot_baselist.click
    ON _open.user_id = click.user_id 
    LEFT JOIN  autopilot_baselist.unsubscribe
    ON _open.user_id = unsubscribe.user_id 
    WHERE identifies.sent_at >= '2016-01-20' 
    AND  _open.campaign IS NOT null
    AND  identifies.company IS NOT null
    LIMIT 3000
    ";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    $words = array( 'Limited', 'LIMITED', 'LTD','ltd','Ltd','\'' );
    while ($row = pg_fetch_array($result)){
        $companyrow  =  str_replace($words, '',ltrim($row[0]));
        //echo  $comapnyrow ." - ".$row[1]." - ".$row[2]." - ".$row[3]." - ".$row[4]." - ". $row[5]."\n"; 
        if($companyrow){
            $get_companyID  = $this->getuserdetails(ltrim($companyrow));
            if($get_companyID) $resultArray[]['companyID'] =   $get_companyID; 
            $resultArray[] = $row; 
        //array_push($resultArray , array('emailsent = > '$row['sent_email'] )
        }
    } 
    return $resultArray;
}
     
public function getuserdetails($string)
{
    $query   =  $this->Companies_model->get_autocomplete($string);
    if($query->num_rows()){
        foreach ($query->result() as $row):
            return  $row->id ;
        endforeach;
    }else{
        return false;     
    }
} 

public function getemailusercompanyid($email)
{
    $this->db->select('*');
    $this->db->where('email',$email);
    $this->db->limit(1);
    $query = $this->db->get('contacts');
    foreach ($query->result() as $row):
        return  $row->company_id ;
    endforeach;
    return false;     
}
    
public function getemailuserid($email)
{
    $query = $this->db->query("SELECT * FROM contacts WHERE email='".$email."' LIMIT 1 ");
    foreach ($query->result_array() as $row){
        return $row['id'];
    }
}
    
public function getcampaignowner($email)
{
    
   $sql = "SELECT id FROM users WHERE email='".$email."' LIMIT 1 ";
$query = $this->db->query($sql);
    foreach ($query->result_array() as $row){
        return  $row['id'];
    }
    echo $sql;
     return 1; // Return Nick 3 returns RL 31 returns GS
}

public function getuserdetailss($email = 0)
{
$query =  $this->Users_model->get_user_by_email($email);
    if(count($query)):
        foreach ($query as $row):
            return  $row->id ;
        endforeach;
    endif;
    return  false;
}
    
public function _actions_performed_new($compID)
{        
    $sql = "select  ec.name as campaign, c.id as company_id, ec.ap_sent_id, c.name as company, c.pipeline, con.first_name, con.last_name, CONCAT(con.last_name, ' ', con.first_name)  as username,to_char(ea.created_at, 'DD-MM-YYYY') as Date, ea.created_at, ea.email_action_type, ea.link as url from companies c
    left join contacts con on
    c.id = con.company_id
    left join email_actions ea on 
    ea.contact_id = con.id
    left join email_campaigns ec on 
    ec.id = ea.email_campaign_id
    where (ea.email_action_type = '2' or ea.email_action_type = '3' or ea.email_action_type = '4' or ea.email_action_type = '1' ) and c.pipeline not in ('proposal','customer')  
    AND ea.created_at >= '2016-01-01 09:10:50.36656' 
    AND ec.name IS NOT null
    AND ea.contact_id=154537
    limit 100 ";

    $query = $this->db->query($sql);
    return $query->result_object();  
}
    
public function _actions_performed($comp_name)
{

    $trading_name =  $comp_name['trading_name'];
    $comp_name =  $comp_name['name'];

    $dbconn = pg_connect("host=ec2-79-125-118-138.eu-west-1.compute.amazonaws.com port=5522 dbname=d7fvbgmrpjg4ba user=ucvie36u7gtubf password=p6lgogrt7mg89411qujnepsgfkf")or die('Could not connect: ' . pg_last_error());

    $query =  "select DISTINCT  identifies.company,CONCAT(identifies.first_name,' ',identifies.last_name) as username, to_char(identifies.sent_at, 'DAY DDth MONTH') as Date ,send.event_text as sent,_open.event_text as opened, click.event_text as click, unsubscribe.event_text as opened, send.campaign
    From autopilot_baselist.identifies 
    LEFT JOIN  autopilot_baselist.tracks
    ON tracks.user_id  = identifies.user_id 
    LEFT JOIN  autopilot_baselist.send
    ON tracks.id  = send.id 
    LEFT JOIN  autopilot_baselist._open
    ON send.user_id = _open.user_id 
    LEFT JOIN  autopilot_baselist.click
    ON _open.user_id = click.user_id 
    LEFT JOIN  autopilot_baselist.unsubscribe
    ON _open.user_id = unsubscribe.user_id 
    WHERE identifies.sent_at >= '2016-01-20' 
    AND  _open.campaign IS NOT null
    AND  identifies.company IS NOT null
    AND identifies.company LIKE '$comp_name%' OR identifies.company='$trading_name%'
    ORDER BY identifies.company
    ";

    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    while ($row = pg_fetch_array($result)){
        //echo  $row[0]." - ".$row[1]." - ".$row[2]." - ".$row[3]." - ".$row[4]." - ". $row[5]."<br>"; 
        if($get_companyID) $resultArray[]['companyID'] =   $get_companyID; 
        $resultArray[] = $row; 
    } 
        return $resultArray;
    }

}