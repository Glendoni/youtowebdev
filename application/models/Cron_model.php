<?php ini_set('max_execution_time', 300);
class Cron_model extends CI_Model {

    
    
function __construct() {
		parent::__construct();
           $this->load->helper('date');
    $this->load->database('staging');
    
	}

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
    WHERE identifies.sent_at >= '2016-02-01' 
    AND  _open.campaign IS NOT null
    AND  identifies.company IS NOT null
    LIMIT  3000000
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
    
    
    public function csvreader() 
	{
    
        // path where your CSV file is located
            define('CSV_PATH','');
        // Name of your CSV file
           $file_exists_check = file_exists("companies.csv");
           if($file_exists_check){
                $csv_file = CSV_PATH . "companies.csv"; 
                if (($handle = fopen($csv_file, "r")) !== FALSE) {
                    fgetcsv($handle);   
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $num = count($data);
                        for ($c=0; $c < $num; $c++) {
                            $col[$c] = $data[$c];
                        }

                        $col1 = $col[0]; //name =  company name
                        $col2 = $col[1]; //registration  =  company id
                        $col3 =  str_replace(',', '',$col[2].' '.$col[3].' '.$col[5].' '.$col[6]); //address = full address
                        $col4 = $col[7];
                        $reformated_time = explode('/', $col[8]);
                        $time = $reformated_time[1].'/'.$reformated_time[0].'/'.$reformated_time[2];       
                        $eff_from = date("Y-m-d", strtotime($time)) ? date("Y-m-d", strtotime($time)) : NULL;
                        $post = array(
                            'name' => $col1,
                            'registration' =>  $col2,
                            'address' => $col3,
                            'date_of_creation' =>$eff_from  
                        );
                        if($col[7] == 'Active'){
                            $compID = $this->create_company_from_CH($post,1); 
                       
                            //echo '<hr />';

                        //echo $col[8] . '' . $col[1].' '.$col3.' <br>';
                        }
                    }
                  
                    fclose($handle);
                }
               // unlink('companies.csv');
                echo "File data successfully imported to database!!";
           }else{
            echo "Cannot find companies.csv file!!";   
           }
    }
    


    
    public function ipp($lmt = 100 ,$oft= 0, $debug = false)
    {
        
        $sql = "SELECT registration,id FROM companies WHERE  created_at >= '".date('Y-m-d')."' ORDER BY id LIMIT ".$lmt."  OFFSET ".$oft."   ";
    $query = $this->db->query($sql);
         if($debug) echo $sql.'<br>';
            if($debug) 'Number of rows being checked - '.  $query->num_rows();
          foreach ($query->result_array() as $row)
          {          
             if($debug) echo $row['registration'].' ' .$row['id'] .'  - <br> ';
           $this->getCompanyHouseChargesApi($row['registration'],$row['id'],$debug)  ;
          } 
         if($debug) echo 'Query has finished<br>';
          echo "<h2>Update to table completed!!</h2>";
        //unlink('companies.csv');
    }
    
       private function getCompanyHouseChargesApi($id,$compID,$debug)
    {
        
       // return  $id;
       //echo  substr("abcdef", 1, 6);
      //  echo ltrim($id, '0');
        $url = "https://api.companieshouse.gov.uk/company/".$id."/charges";
       // echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json;',
            'Authorization: Basic RWFpN0V2N0JOSk1wcDlkcThUTWxkdHZzOXBDSzRTdmt0UGpzVjduWDo='
          ]
        );
         
            $result = curl_exec($ch);
        // Check for errors
        if($result === FALSE){

          die(curl_errno($ch).': '.curl_error($ch));
        }

       $output =  json_decode($result,TRUE);
        $rtnOutput =$output;
        if(is_array($output)){
           
                    $i = $output['items'] ;
            foreach($i as $item => $value){
            //    echo  'I am will now check run morgages<br>' ;
                $runMorgageCheck = $this->runMorgageCheck($value['etag']);
                          echo $value['persons_entitled'][0]['name'];
                       if($runMorgageCheck){
                          
                              $output = array(
                                'company_id' => $compID,
                                'provider_str' =>   $value['persons_entitled'][0]['name'],
                                'etag' => $value['etag'],  
                                'stage' => $value['status'],    
                                'eff_from' => $value['transactions'][0]['delivered_on'], 
                                'created_by' => 1 
                              );
                           //send querry to model for futhur checking
                          //echo $output['ref'];
                           
                           
                 
                           $this->insert_charges_CSV($output);
                   
               // echo  $output['company_id'];
                // $this->Companies_model->insert_charges_CSV($output);
                // echo $id .'<br>';
               //echo   $value['persons_entitled'][0]['name']. '<br>'. $value['etag'].'<br>';  //prividers_id
               //echo $value['etag'].'<br>'; //ref
               //echo $value['status'].'<br>'; //stage
               //echo $value['transactions'][0]['delivered_on'].'<br>'; //eff_from
               //echo  '<br><br>';//
                           if($debug){
                        print_r($rtnOutput); 
                               echo '<br>';
                           }
                             //return true;
                       } 
           }
        }
        //return false; 
    }
 private function runMorgageCheck($ref)
 {
     $sql = "SELECT ref FROM mortgages WHERE ref='".$ref."' ";
     //echo $sql;
     $query = $this->db->query($sql);
         $rownum  =     $query->num_rows();
     if($rownum){
         return  false;
     }else{
         
         return true ;
     }
 }
    
     private function insert_charges_CH($response, $company_id,$user_id)
    {
           
        $this->load->helper('inflector');
        $provider  = '';
        $provider = $response['items'][0]['persons_entitled'][0]['name'];
         $provider_id = $this->providerCheck($provider);
    
        if($provider_id){
            $mortgages = array(
                    'company_id' => $company_id,
                    'provider_id' => $provider_id,
                    'ref' => $response['items'][0]['etag'],
                    'stage' =>  $response['items'][0]['status'],
                    'eff_from' => $response['items'][0]['transactions'][0]['delivered_on'],
                    'created_at' =>   date('Y-m-d'),	
                    'created_by' => $user_id

                    );
                $this->db->insert('mortgages', $mortgages);
        }        
             
    }
    
       private function providerCheck($name)
    {
        
        //$name = 'ABN AMRO COMMERCIAL FINANCE PLC';
        
        $q = '
         SELECT id,name,provider_id
         FROM provider_checks
         WHERE name ilike \''.$name.'\'
         LIMIT 1
        ';
        $result = $this->db->query($q);
            $last = $this->db->last_query();
         //file_put_contents('pop.txt', $last.PHP_EOL, FILE_APPEND);
        
        
              if( $result->num_rows()){
                   foreach ($result->result() as $row)
                    {
                        return $row->provider_id;
                    } 
             }else{
                  return false;
            }
    }
    
    
    private function insert_charges_CSV($response)
    {
           
        
        $provider  = '';
        $provider = $response['provider_str'];
        
        file_put_contents('pop.txt', $provider.PHP_EOL, FILE_APPEND);
        
        
         $provider_id = $this->providerCheck($provider);
    
        if($provider_id){
            $mortgages = array(
                    'company_id' => $response['company_id'],
                    'provider_id' => $provider_id,
                    'ref' => $response['etag'],
                    'stage' =>  $response['status'],
                    'eff_from' => $response['eff_from'],
                    'created_at' =>   date('Y-m-d'),	
                    'created_by' => $response['created_by']

                    );
                $this->db->insert('mortgages', $mortgages);
        }        
             
    }
    
    
    
        /*
    @ Insert Company details from Company House API Record
    @ Author: Glen Small
    */
    private function create_company_from_CH($post,$user_id){
        
        
     
                   $q = '
     SELECT id
     FROM companies
     WHERE registration=\''.$post['registration'].'\'
     LIMIT 1
    ';
    $result = $this->db->query($q);
              if(!$result->num_rows()){
        
     
		  $this->load->helper('inflector');
        
        $postName = str_replace('"', '&quot;', $post['name']);
          $postName = str_replace('\'', '&#39;', $postName);
        
    $company = array(
        'name' => humanize($postName),
        'contract' => null,
        'perm' => null,
        'created_by'=> $user_id,
        'eff_from'=> $post['date_of_creation'],
        'registration' => !empty($post['registration'])?$post['registration']:NULL,		 
		);
		$this->db->insert('companies', $company);
		$new_company_id = $this->db->insert_id(); 
		if($new_company_id){
			// address
			$address = array(
				'company_id' => $new_company_id,
				'address' => $post['address'],
                'type' => 'Registered Address',
                'country_id' => 1,
				'created_by'=> $user_id,
				);
			$this->db->insert('addresses', $address);
			$new_company_address_id = $this->db->insert_id();
		}
    if($new_company_id and $new_company_address_id) return $new_company_id;
		return FALSE;
        
 
              }else{
                  
             foreach ($result->result() as $row)
                {
                    return array('row_id' => $row->id);
                } 
                  
              }    
                  
	}
    
// NEW AUTOPILOT START
    public function get_contact_list($bookmark = false, $iteration = 0) //inserts email campaign listing
    {
        
     $bookmark = $bookmark ? $bookmark : file_get_contents('autopilotBook.txt');
        $objv =   $this->getCompanyHouseDetails("https://api2.autopilothq.com/v1/contacts/".$bookmark);
        
        echo $bookmark;
        
        $i = $iteration;
        $actionsLastNumId = $camp_id  = $this->get_last_row_id_email_campaign();  
        $bookmark = $objv;
            // THIS IS WHERE THE SHIT HAPPENS
            foreach($objv as $itemv  => $valuev){
                   foreach($valuev as $objr =>$item ){
                          $mail =  array('mail_received' => 0,'mail_opened'=> 1,'mail_clicked' => 2,'mail_unsubscribed' => 4);
                       foreach($mail as $mailItem => $value){
                           $objMailR = $item[$mailItem];
                           foreach($objMailR as $itemr => $valuedr  ){
                               
                             if($itemr){
                                   $entDate = date("Y-m-d", (substr($valuedr, 0, 10)));
                                //echo  $this->check_campaign_ref($itemr) ? 'No ' : 'YEs';
                                 //$bookmark = $itemr; 
                                 //echo '<h1>'.$value.'</h1>'.$itemr.' ---- '.$valuedr.' ---- '.$entDate.'<br>'.$item['Email'].'<br>'; //ok
                                 
                                // echo $this->check_campaign_ref($itemr) ? 'Insert Record' : ' Skip' . '<br>';
                                 if($entDate > '2016-01-01' && $value==0){
                                    $eval_sent_id = $this->check_campaign_ref($itemr); 
                                    if($eval_sent_id){
                                        //insert
                                        $actionsLastNum = $actionsLastNumId++;
                                        $now = time(); 
                                        $human = unix_to_human($now, TRUE, eu);
                                        $contactList = array(
                                            'id' => $actionsLastNum,
                                            'sent_id' => $itemr,
                                            'date_sent' => $entDate,
                                            'updated_at' => $human,
                                            'name' => 'pending',
                                            'created_by' => 1
                                        );
                                        
                                       // echo $entDate;
                                       $this->db->insert('email_campaigns', $contactList);
                                        
                                       //echo $actionsLastNum .' -- '.$itemr. ' -- '.$entDate;
                                        //    echo '<br>';
                                        //print_r($contactList) ;
                                    }
                                 }
                          }
                               
                               
                        }   
                         
                       }
                     
                   }
                
                    $i++; 
                
      
                //echo $objv['bookmark'];
             break;
            }
         
    echo $i;
    //REMOVE BOTH FOLLOWING LINES TO TEST ONE 100
        
        if($i == 6){
            
            file_put_contents('autopilotBook.txt',$objv['bookmark']);
        }
        
        if(!$objv['bookmark'])
             file_put_contents('autopilotBook.txt','');
        
        if($i <6)
       if($objv['bookmark']) 
            $this->get_contact_list($objv['bookmark'],$i); //RECURSION GET NEXT LIST UNTIL BOOKMARK RETURNS EMPTY
        
       
        
    } //end of get_contact_list
    
 
       // print_r($itemv);
    public function insert_email_contact_list($bookmark = false, $iteration = 0)
    {
              
        $query = $this->db->query("SELECT id from email_actions ORDER BY id DESC LIMIT 1");

        $row = $query->row(); 
        $last_row_id =  $row->id;
        
         $bookmark = $bookmark ? $bookmark : file_get_contents('autopilotBook.txt');
        $objv =   $this->getCompanyHouseDetails("https://api2.autopilothq.com/v1/contacts/".$bookmark);
        
        
        
        $i = $iteration;
        $actionsLastNumId = $camp_id  = $this->get_last_row_id_email_campaign();  
        $bookmark = $objv;
            // THIS IS WHERE THE SHIT HAPPENS
            foreach($objv as $itemv  => $valuev){
               
                   foreach($valuev as $objr =>$item ){

                     $mail =  array('mail_received' => 0,'mail_opened'=> 1,'mail_clicked' => 2,'mail_unsubscribed' => 4);
                       foreach($mail as $mailItem => $value){
                           $objMailR = $item[$mailItem];
                           foreach($objMailR as $itemr => $valuedr  ){
                          
                             if($itemr){
                                   $entDate = date("Y-m-d", (substr($valuedr, 0, 10)));
                                //echo  $this->check_campaign_ref($itemr) ? 'No ' : 'YEs';
                                 //$bookmark = $itemr; 
                                  $email_campaign_id = $this->get_campaign_id($itemr);
                                $check_if_email_exist  = $this->getemailuserid($item['Email']);
                                    
                                 if($check_if_email_exist && $campaign_title  != 'Removed Via Baselist' &&   $value != 3 &&   $value != 0 && $entDate > '2016-01-01'){
                                 
                                     $check_if_email_exist  = $this->getemailuserid($item['Email']);  
    
                             $campaignID = $check_if_email_exist.'-'.$value.'-'.$itemr.'-'.$valuedr;                       //email id,event id, batch number, unix date          
                             
                                if(!$this->compaignFinder($check_if_email_exist,$campaignID,$value) && $email_campaign_id != false){    
                                 //email id,event id, batch number, unix date   
                                       // echo '<h1>'.$email_campaign_id.'</h1>'.$itemr.'-'.$valuedr.' ---- '.$entDate.'<br>'.$item['Email'].' <br> contact ID'. $check_if_email_exist. ' <br> Last inserted ID ' .$last_row_id++ . '<br> envent ID - '.$value ;                         
                                        $contactList = array(
                                            'id' => $last_row_id++,
                                            'email_campaign_id' =>  $email_campaign_id,
                                            'sent_action_id' => $campaignID,
                                            'contact_id' => $check_if_email_exist , 
                                            'email_action_type' => $value,
                                            'action_time' => $entDate,
                                            'created_by' => 1
                                        );
                                        $this->db->insert('email_actions',   $contactList);   
                                    }                                     
                                }   
                            }
                        }   
                           
                     }
                
                   /*
                        DO NOT REMOVE
                       $output[] =  '<h2>Page Visits</h2>';
                         $pageVitits = $item['anywhere_page_visits'];
                         foreach($pageVitits as $itempv => $valuepv  ){

                        };
                       
                       */
                     // echo $bookmark. '<br>';
            }
                
                   $i++; 
                //echo $objv['bookmark'];
             break;
        }
       // echo $i;
         if($i == 4){
            
            file_put_contents('autopilotBook.txt',$objv['bookmark']);
        }
        if(!$objv['bookmark'])
             file_put_contents('autopilotBook.txt','');
        
        if($i <4)
       if($objv['bookmark']) 
    if($objv['bookmark'])
          $this->insert_email_contact_list($objv['bookmark'],$i); //RECURSION GET NEXT LIST UNTIL BOOKMARK RETURNS EMPTY
    
    }
    
    public function get_last_row_id_email_campaign()
    {
        
        $query = $this->db->query("SELECT id from email_campaigns ORDER BY id DESC LIMIT 1");
        
         if ($query->num_rows() > 0){
        $row = $query->row(); 
        
        return $row->id+1;
         }
    }
    
    
    //find the company id baised on the campaign name and insert FK into  the emails action table
    //contact id, campaign identifier, email event
    public function compaignFinder($contactid,$campaignID,$event)
    {
        
        $sql =  "SELECT email_campaign_id FROM email_actions WHERE contact_id=".$contactid." AND sent_action_id='".$campaignID."' AND email_action_type=".$event."  ";
        $querye = $this->db->query($sql);
       
        if ($querye->num_rows() > 0){
        return  true;  //tested ok 
            
        }
        
        return false;
        
    }
    
    public function get_campaign_id($campaign)
    { //checks campaign name and if exist returns the ID 

        //$sql = "SELECT id FROM email_campaigns WHERE sent_id='".$campaign."'  ";
        $sql = "SELECT id FROM email_campaigns   ";
       // $query = $this->db->query($sql);  
        //$row = $query->row(); 
            //if ($query->num_rows() > 0){
                   
              //     return $row->id;
                //}
               $this->db->select('id');
         $this->db->from('email_campaigns');
    $this->db->where('sent_id', $campaign );
        $this->db->limit(1);
        $query = $this->db->get();

    if ( $query->num_rows() > 0 )
    {
        $row = $query->row_array();
        return  $row['id'];
    }
        
        
        
        
        
        
        return false;
        
    
        
        
                   
    }
    
    public function check_campaign_ref($campaign_name)
    {
        $query = $this->db->query("SELECT sent_id FROM email_campaigns WHERE sent_id='".$campaign_name."' LIMIT 1 "); 
                   $row = $query->row(); 
            if ($query->num_rows() > 0){
              
                   return false;
        
                }
                return true;
    }
    
    public function getemailuserid($email)
    {
    $sql =  "SELECT id FROM contacts WHERE email='".$email."' LIMIT 1 ";
    $query = $this->db->query($sql); 
         $row = $query->row(); 
            if ($query->num_rows() > 0){
                  
                   return $row->id;
        
                }else{
                return false;
            }
        
            
}
 
    

// NEW AUTOPILOT END
    
    
    
    
     public function getCompanyHouseDetails($url = 0) 
	{
         $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "autopilotapikey: ed278f3d19a5453fb807125aa945a81a",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 57861545-5cf1-95d1-c82d-035b6fc32a51"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result  = json_decode($response, true);
        return  $result; 
        }
    }
         public function _getCompanyHouseDetails($url = 0) 
	{
 
        $server_output = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_GET, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
         curl_setopt($ch, CURLOPT_TIMEOUT, 464);
        $headers = array();
        $headers[] = 'autopilotapikey: ed278f3d19a5453fb807125aa945a81a';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $server_output = curl_exec ($ch);
        $result  = json_decode($server_output, true);
         return  $result; 
        curl_close ($ch); 
         
     }   
}
