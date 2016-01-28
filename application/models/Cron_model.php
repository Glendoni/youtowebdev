<?php
class Cron_model extends CI_Model {
	function connect_to_wordpress_database()  {
	}
	function update_marketing_clicks()
	{
	$con = mysqli_connect("137.117.165.135","baselist","OzzyElmo$1","sonovate_finance");
	//$con = mysqli_connect("localhost","root","root","sonovate");
	// Check connection
	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}


	//GET NEW CAMPAIGNS
	$add_new_campaigns_sql = 'select distinct a.campaign_id as "Campaign ID",
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
	while($row = mysqli_fetch_array($add_new_campaigns_query))
	{
	$campaign_id = pg_escape_string ($row['Campaign ID']);
	$campaign_name = pg_escape_string ( $row['Campaign Name']);
	$campaign_sent = pg_escape_string ( $row['Sent At']);
	$campaign_sent_by = pg_escape_string ( $row['Sent By']);
	$check_dupe_sql = "select sent_id from email_campaigns where sent_id = '$campaign_id'";
	$check_dupe_campaign = $this->db->query($check_dupe_sql);
		if ($check_dupe_campaign->num_rows() == 0)
 	{
	//GET EMAIL ADDRESS OF SENDER OR DEFAULT TO NICK(1)
	$sql_user =  "select id from users where email ilike '$campaign_sent_by'";
	$query = $this->db->query($sql_user);
	if ($query->num_rows() > 0)
	{
   	foreach ($query->result() as $row)
   	{
		$user_id = $row->id;
   	}
	}
	else
	{
		$user_id ='1';
	}
	$add_campaign_to_postgres = "insert into email_campaigns (sent_id,name, date_sent, created_by) values ('$campaign_id','$campaign_name', '$campaign_sent','$user_id')";
	$add_sql = $this->db->query($add_campaign_to_postgres);
	 $campaign_name." Updated\r\n";
	}//END DUPE CHECK
	else 
	{
	 "No Campaigns to Update\r\n";
	}
	};
	?>

	<?php
//ADD ACTIONS
$unix_date = time() - 345600; //CHECK FOR LAST FOUR DAYS
	  $add_new_actions_sql = 'select CONCAT(a.campaign_id,a.timestamp,LPAD(s.id, 4, "0"),a.type) as "Unique ID", s.email as "Subscriber Email", a.campaign_id as "Campaign ID", a.type as "Action Type", l.link as "Clicked Link", from_unixtime(a.timestamp) as "Actioned At" from sf_mymail_subscribers s inner join sf_mymail_actions a on a.subscriber_id = s.id inner join sf_posts p on a.campaign_id = p.id inner join sf_postmeta pm on p.id = pm.post_id left join sf_mymail_links l on a.link_id = l.id where a.campaign_id is not null and pm.meta_key = "_mymail_finished" and p.post_title <> "" AND a.timestamp > '.$unix_date.' order by pm.meta_value asc ';
	$add_new_actions_query = mysqli_query($con, $add_new_actions_sql);
	while($row1 = mysqli_fetch_array($add_new_actions_query))
	{
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
		if ($check_dupe_action->num_rows() == 0)
 	{
		$check_contact_sql = "select id from contacts where email ilike '$action_email';";
		$query_actions = $this->db->query($check_contact_sql);
	if ($query_actions->num_rows() > 0)
	{
   	foreach ($query_actions->result() as $row)
   	{
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
	$update_prospects = "update companies set pipeline = null where pipeline ilike 'Prospect' and id not in (select company_id from operates where active = 't' and sector_id in (select id from sectors where target = 't'))";
	$this->db->query($update_prospects);
	}


function remove_contacts_from_marketing() {
	
	$con = mysqli_connect("137.117.165.135","baselist","OzzyElmo$1","sonovate_finance");
	//$con = mysqli_connect("localhost","root","root","sonovate");

	// Check connection
	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	 $select_contacts_sql = "select con.email, con.email_opt_out_date, u.name from contacts con left join users u on con.email_opt_out_user = u.id where con.email_opt_out_date is not null and con.email is not null and con.eff_to is NULL";
	$select_contacts = $this->db->query($select_contacts_sql);
	if ($select_contacts->num_rows() > 0)
	{
	//REMOVE ALL BEFORE RE-ADDING THOSE STILL UNSUBSCRIBED//
	$delete_all = "delete from sf_mymail_subscriber_fields where meta_key = 'unsubscribed-via-baselist'";
	mysqli_query($con, $delete_all);
		$delete_101 =  "delete from sf_mymail_lists_subscribers where list_id = '101'";		
	mysqli_query($con, $delete_101);

   	foreach ($select_contacts->result() as $row)
   	{
	$contact_email = $row->email;
	$contact_date = $row->email_opt_out_date;
	$opt_out_name = $row->name;
	$sql = "select s.id, s.email from sf_mymail_subscribers s where email = '$contact_email'";
	$result = mysqli_query($con, $sql);
	if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
	echo $delete =  "delete from sf_mymail_lists_subscribers where subscriber_id = '". $row["id"]."' ";		
	mysqli_query($con, $delete);
 	$update = "insert into sf_mymail_subscriber_fields (subscriber_id, meta_key, meta_value) values ('". $row["id"]."','unsubscribed-via-baselist','".$contact_date." by ".$opt_out_name."');";
 	mysqli_query($con, $update);
	$add = "insert into sf_mymail_lists_subscribers (list_id, subscriber_id, added) values ('101','". $row["id"]."','".time()."');";
 	mysqli_query($con, $add);
    }
	} 
	else {}
   	} //END FOR EACH
   	}
   	//MYSQL CLOSE
	mysqli_close($con);
	echo "Complete";
   }

   function remove_customer_contacts_from_marketing() {
	
	$con = mysqli_connect("137.117.165.135","baselist","OzzyElmo$1","sonovate_finance");
	//$con = mysqli_connect("localhost","root","root","sonovate");
	// Check connection
	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	 $select_contacts_sql = "select con.email, c.customer_from from contacts con left join companies c on con.company_id = c.id where c.pipeline ilike 'Customer' and c.customer_from is not null and con.email is not null";
	$select_contacts = $this->db->query($select_contacts_sql);
	if ($select_contacts->num_rows() > 0)
	{
	//REMOVE ALL BEFORE RE-ADDING THOSE STILL CUSTOMERS//
	$delete_all = "delete from sf_mymail_subscriber_fields where meta_key = 'customer-on-baselist'";
	mysqli_query($con, $delete_all);
	$delete_121 = "delete from sf_mymail_lists_subscribers where list_id = '121';";		
	mysqli_query($con, $delete_121);
	$update_timestamp = "update sf_mymail_lists set updated = UNIX_TIMESTAMP () where id = '121';";	
	mysqli_query($con, $update_timestamp);
	 
   	foreach ($select_contacts->result() as $row)
   	{
        $contact_email = $row->email;
        $autopilotUnsubscribe[] = $row->email;
        $contact_date = $row->customer_from;
        $sql = "select s.id, s.email from sf_mymail_subscribers s where email = '$contact_email'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
            $delete =  "delete from sf_mymail_lists_subscribers where subscriber_id = '". $row["id"]."' and list_id not in (select id from sf_mymail_lists where parent_id ='121')";		
            mysqli_query($con, $delete);
            $add = "insert into sf_mymail_lists_subscribers (list_id, subscriber_id, added) values ('121','". $row["id"]."','".time()."');";
            mysqli_query($con, $add);
        }
    } 
    else {}
   	} //END FOR EACH
        
        $this->trigger_autopilot_unsubscribe($autopilotUnsubscribe);
   	}

	$select_contacts_sql = "select con.email, a.actioned_at from contacts con left join companies c on con.company_id = c.id inner join actions a on a.company_id = c.id where a.action_type_id = '8' and c.pipeline ilike 'Proposal' and con.email is not null";
	$select_contacts = $this->db->query($select_contacts_sql);
	if ($select_contacts->num_rows() > 0)
	{
        //REMOVE ALL BEFORE RE-ADDING THOSE STILL PROSPECTS//
        $delete_all = "delete from sf_mymail_subscriber_fields where meta_key = 'proposal-on-baselist'";
        mysqli_query($con, $delete_all);
        $delete_122 = "delete from sf_mymail_lists_subscribers where list_id = '122'; update sf_mymail_lists set updated = UNIX_TIMESTAMP () where id = '122';";		
        mysqli_query($con, $delete_122);
        $update_timestamp = "update sf_mymail_lists set updated = UNIX_TIMESTAMP () where id = '122';";	
        mysqli_query($con, $update_timestamp);
        foreach ($select_contacts->result() as $row)
        {
            $contact_email = $row->email;
            $contact_date = $row->customer_from;
            $sql = "select s.id, s.email from sf_mymail_subscribers s where email = '$contact_email'";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    $delete =  "delete from sf_mymail_lists_subscribers where subscriber_id = '". $row["id"]."'";	mysqli_query($con, $delete);
                    $add = "insert into sf_mymail_lists_subscribers (list_id, subscriber_id, added) values ('122','". $row["id"]."','".time()."');";
                    mysqli_query($con, $add);
                }
            } 
            else {}
        } //END FOR EACH
   	}
   	//MYSQL CLOSE
	mysqli_close($con);
	echo "Complete";
   }
    
    
       public function trigger_autopilot_unsubscribe($email, $status = "true"){
         
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
    

}