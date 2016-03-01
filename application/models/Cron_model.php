<?php
class Cron_model extends CI_Model {


function connect_to_wordpress_database()  {
    
}

function update_marketing_clicks()
{
	$con = mysqli_connect("137.117.165.135","baselist","OzzyElmo$1","sonovate_finance");
	//$con = mysqli_connect("localhost","root","root","sonovate");
	// Check connection
	if (mysqli_connect_errno()){
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	//GET NEW CAMPAIGNS
	$add_new_campaigns_sql = '	select distinct
									a.campaign_id as "Campaign ID",
									p.post_title as "Campaign Name",
									pm2.meta_value as "Sent By",
									from_unixtime(pm.meta_value) as "Sent At"
								from sf_mymail_subscribers s
								inner join sf_mymail_actions a on
									a.subscriber_id = s.id
								inner join sf_posts p on
									a.campaign_id = p.id
								inner join sf_postmeta pm on
									p.id = pm.post_id
								inner join sf_postmeta pm2 on
									p.id = pm2.post_id
								left join sf_mymail_links l on
									a.link_id = l.id
								where pm.meta_key = "_mymail_finished" and pm2.meta_key = "_mymail_from_email" and p.post_title <> "" order by pm.meta_value desc';
	$add_new_campaigns_query = mysqli_query($con, $add_new_campaigns_sql);
	while($row = mysqli_fetch_array($add_new_campaigns_query)){
        $campaign_id = pg_escape_string ($row['Campaign ID']);
        $campaign_name = pg_escape_string ( $row['Campaign Name']);
        $campaign_sent = pg_escape_string ( $row['Sent At']);
        $campaign_sent_by = pg_escape_string ( $row['Sent By']);
        $check_dupe_sql = "select sent_id from email_campaigns where sent_id = '$campaign_id'";
        $check_dupe_campaign = $this->db->query($check_dupe_sql);
        if ($check_dupe_campaign->num_rows() == 0){
            //GET EMAIL ADDRESS OF SENDER OR DEFAULT TO NICK(1)
            $sql_user =  "select id from users where email ilike '$campaign_sent_by'";
            $query = $this->db->query($sql_user);
            if ($query->num_rows() > 0){
                foreach ($query->result() as $row)
                {
                    $user_id = $row->id;
                }
            }else{
                $user_id ='1';
            }
            $add_campaign_to_postgres = "insert into email_campaigns (sent_id,name, date_sent, created_by) values ('$campaign_id','$campaign_name', '$campaign_sent','$user_id')";
            $add_sql = $this->db->query($add_campaign_to_postgres);
             $campaign_name." Updated\r\n";
        }else{ //END DUPE CHECK
            "No Campaigns to Update\r\n";
        }
  };
	?>

	<?php
//ADD ACTIONS
     $unix_date = time() - 345600; //CHECK FOR LAST FOUR DAYS
	  $add_new_actions_sql = 'select CONCAT(a.campaign_id,a.timestamp,LPAD(s.id, 4, "0"),a.type) as "Unique ID", s.email as "Subscriber Email", a.campaign_id as "Campaign ID", a.type as "Action Type", l.link as "Clicked Link", from_unixtime(a.timestamp) as "Actioned At" from sf_mymail_subscribers s inner join sf_mymail_actions a on a.subscriber_id = s.id inner join sf_posts p on a.campaign_id = p.id inner join sf_postmeta pm on p.id = pm.post_id left join sf_mymail_links l on a.link_id = l.id where a.campaign_id is not null and pm.meta_key = "_mymail_finished" and p.post_title <> "" AND a.timestamp > '.$unix_date.' order by pm.meta_value asc ';
	$add_new_actions_query = mysqli_query($con, $add_new_actions_sql);
	while($row1 = mysqli_fetch_array($add_new_actions_query)){    
        $campaign_id = pg_escape_string ($row1['Campaign ID']);
        $check_campaign_loaded_sql = "select sent_id from email_campaigns where sent_id = '$campaign_id';";
        $check_campaign_loaded = $this->db->query($check_campaign_loaded_sql);
        if ($check_campaign_loaded->num_rows() > 0) {
        $action_id 		= pg_escape_string ($row1['Unique ID']);
        $action_email 	= pg_escape_string ($row1['Subscriber Email']);
        $action_type 	= pg_escape_string ($row1['Action Type']);
        $action_link 	= pg_escape_string ($row1['Clicked Link']);
        $action_date 	= pg_escape_string ($row1['Actioned At']);

        $check_dupe_action_sql = "select sent_action_id from email_actions where sent_action_id = '$action_id';";
        $check_dupe_action = $this->db->query($check_dupe_action_sql);
        if ($check_dupe_action->num_rows() == 0){
            $check_contact_sql = "select id from contacts where email ilike '$action_email';";
            $query_actions = $this->db->query($check_contact_sql);
            if ($query_actions->num_rows() > 0){
                foreach ($query_actions->result() as $row){
                    $contact_id = $row->id;
                }
                $add_action_to_postgres = "insert INTO email_actions (email_campaign_id,sent_action_id,contact_id,email_action_type,link,action_time) VALUES ((select id from email_campaigns where sent_id = '$campaign_id'),'$action_id', '$contact_id','$action_type','$action_link','$action_date')";
                $this->db->query($add_action_to_postgres);
            }
        }//END DUPE CHECK
        }
	}
	echo "Campaigns & Actions Updated";
	//UPDATE LINKS REMOVE EMPTY ROWS
	$this->db->query("update email_actions set link = NULL where link = ''");
	//MYSQL CLOSE
	mysqli_close($con);
}

function prospects_not_in_sector() {
    //REMOVE PROSPECT FROM COMPANIES NOT IN TARGET SECTOR
    $update_prospects = "update companies set pipeline = null where pipeline ilike 'Prospect' and id not in (select company_id from operates where active = 't' and sector_id in (select id from sectors where target = 't')); update companies set pipeline = 'Prospect' where pipeline is null and id in (select company_id from operates where active = 't' and sector_id in (select id from sectors where target = 't'))";
    $this->db->query($update_prospects);

}

function remove_contacts_from_marketing() 
{
    $this->db->select('email');
    $query = $this->db->get('contacts where email_opt_out_date is not null and email is not null and email_opt_out_date > current_date  - interval \'3\' day;');

    foreach ($query->result() as $row) {
        $email = $row->email;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api2.autopilothq.com/v1/contact/".$email."");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "autopilotapikey:ed278f3d19a5453fb807125aa945a81a"
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        $contact = json_decode($response);
        $contactactemail = $contact->Email;
        $unsubscribestatus = $contact->unsubscribed;

        if ((!empty($contactactemail)) && (empty($unsubscribestatus))) {

            //UNSUBSCRIBE//
            $ch2 = curl_init();
            curl_setopt($ch2, CURLOPT_URL, "https://api2.autopilothq.com/v1/contact");
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch2, CURLOPT_HEADER, FALSE);

            curl_setopt($ch2, CURLOPT_POST, TRUE);

            curl_setopt($ch2, CURLOPT_POSTFIELDS, "{
            \"contact\": {
            \"unsubscribed\": \"Yes\",
            \"Email\": \"".$email."\"
            }
            }");

            curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
            "autopilotapikey: ed278f3d19a5453fb807125aa945a81a",
            "Content-Type: application/json"
            ));
            $response2 = curl_exec($ch2);
            curl_close($ch2);
            echo $email."updated";
        }
    }
    
}

public function generate_segment_events()
{
    $this->load->model('Marketing_model');
    //connection to external heroku database
    $dbconn = pg_connect("host=ec2-79-125-118-138.eu-west-1.compute.amazonaws.com port=5522 dbname=d7fvbgmrpjg4ba user=ucvie36u7gtubf password=p6lgogrt7mg89411qujnepsgfkf")or die('Could not connect: ' . pg_last_error());
    // Performing SQL query on multiple heroku tables created by Autopilot
    $query = "select DISTINCT  identifies.company, identifies.id as un_ids,CONCAT(identifies.first_name,' ',identifies.last_name) as username, send.sent_by as owneremail,
    to_char(identifies.sent_at, 'YYYY-MM-DD') as Date ,send.event_text as sent, identifies.received_at as event_time,
    _open.event_text as opened, click.event_text as click, unsubscribe.event_text as unsubscribed, send.campaign as campaign_name, identifies.email as sent_email
    From autopilot_baselist.identifies 
    LEFT JOIN  autopilot_baselist.tracks
    ON tracks.user_id  = identifies.user_id 
    LEFT JOIN  autopilot_baselist.send
    ON tracks.anonymous_id  = send.anonymous_id 
    LEFT JOIN  autopilot_baselist._open
    ON send.user_id = _open.user_id 
    LEFT JOIN  autopilot_baselist.click
    ON _open.user_id = click.user_id 
    LEFT JOIN  autopilot_baselist.unsubscribe
    ON _open.user_id = unsubscribe.user_id 
    WHERE identifies.sent_at >= '2015-01-22' 
    AND  _open.campaign IS NOT null
    AND  identifies.company IS NOT null
    LIMIT  300000
    ";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    $words = array( 'Limited', 'LIMITED', 'LTD','ltd','Ltd','\'' ); // no harm in checking
    while ($row = pg_fetch_array($result)) 
    {

        $companyrow  =  str_replace($words, '',ltrim($row[0])) ;
        if($companyrow){
            $get_companyID  = $this->getuserdetails(ltrim($companyrow));
        if($get_companyID) $resultArray[]['companyID'] =   $get_companyID; 
            $resultArray[] = $row; 
        }
    } 
    $marketing_events = $resultArray;
    //$theOutcomeArr = array('click'=>2, 'unsubscribe'=>3);
    $query = '';
    foreach($marketing_events as $marketing){
       
        //Marketing events change to accomodate original procedure   // tested ok.
        if($marketing['unsubscribed']){
            $theoutcome = 4;
            $createdBy = $marketing['created_by'];
        }elseif($marketing['click']){
            $theoutcome = 2;
        }else{
            $theoutcome = 1;
        }
        //Check if the contact exist on the system in the contacts table.
        $contactidd =  $this->Marketing_model->getemailuserid($marketing['sent_email']); // tested ok.
        if($contactidd){ //if contact = true proceed
        
            $created_by = $this->Marketing_model->getcampaignowner($marketing['owneremail']); 
          
            //Unfortunately we need to re-run the query to limit the record set and return the relevant entry basised on the un_ids            
            $queryone = $this->db->query("SELECT sent_id FROM email_campaigns WHERE name='".$marketing['campaign_name']."' ");  
            //if the un_ids has been found then skip this event as the entry already exist
            if (!$queryone->num_rows()){//tested ok   
                $queryr = $this->db->query("SELECT sent_id FROM email_campaigns");        
                $get_next_num =  $queryr->num_rows(); // tested ok.
                $email_campaign =   array(
                'id' =>  $get_next_num,
                'sent_id' => $marketing['un_ids'],
                'name' => $marketing['campaign_name'],
                'date_sent' => $marketing['date'],
                'created_by' => $created_by 
                );
                $this->db->insert('email_campaigns', $email_campaign);
            }
            //find the company id baised on the campaign name and insert FK into  the emails action table
            $campaignID   = $this->get_campaign_name($marketing['campaign_name']); //tested ok
            $sql =  "SELECT email_campaign_id FROM email_actions WHERE contact_id='".$contactidd."' AND email_campaign_id=".$campaignID." AND email_action_type=".$theoutcome."  ";
           
            $querye = $this->db->query($sql);
            $get_next_num_two =  $querye->num_rows();  //tested ok 
            
            //echo $get_next_num_two;
            
            if ($campaignID){
            //if $get_next_num_two does not exist then add the entry event and details into the email_actions table
                if($get_next_num_two != true){
                    $email_actions = array(
                    'email_campaign_id'=> $campaignID,
                    'sent_action_id' => $marketing['un_ids'], // 
                    'contact_id' => $contactidd,
                    'email_action_type' => $theoutcome,
                    'action_time' => $marketing['event_time'],
                    'created_at' => $marketing['date'],
                    'created_by' => $created_by 
                    );
                    $this->db->insert('email_actions', $email_actions);   
                }
            } 
            
            
            
        } //contactdd end
    } 
 }
public function getuserdetails($string)
{ //gets comapny id based on company name 
 $this->load->model('Companies_model');
 $query   =  $this->Companies_model->get_autocomplete($string);
 if($query->num_rows()){
    foreach ($query->result() as $row):
    return  $row->id ;
     endforeach;
     }else{
      return false;     
 }
} 
public function get_campaign_name($campaign)
{ //checks campaign name and if exist returns the ID 
    $query = $this->db->query("SELECT id FROM email_campaigns WHERE name='".$campaign."'  ");
     foreach ($query->result_array() as $row)
     {
         return $row['id'];
     }
    return false;          
}
    
       /*public function trigger_autopilot_unsubscribe($email, $status = "true"){
         
            if(is_array($email){
                if(count($email)){
                    foreach($array as $item){

                        $json_post_fields = '{ 
                        "contact": {
                        "Email": "'.$item.'",
                        "unsubscribed": "'.$status.'"
                        }
                        }';

                    $seglist =  $this->Autopilotapi_model->connect_post('v1/contact',$json_post_fields);

                }
            	}
				}
   				}
   				*/
}