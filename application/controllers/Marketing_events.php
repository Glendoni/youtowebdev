<?php 
echo  '';

if ( ! defined('BASEPATH')) ;

class Marketing_events extends MY_Controller {
	
    //public $DB1;
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
		// $DB1 = $this->load->database('autopilot',true);
           $this->load->helper('date');
	}
	
	
    
    public function import_bookmark(){
        
        
        
        
        
        
        
        
    }
    
    public function update_email_events() 
	{
       
            $query = $this->db->query("SELECT id,name, updated_at, sent_id FROM email_campaigns WHERE  date_sent >= '2016-03-01' AND id > 479 ORDER BY updated_at ASC LIMIT 1  ");
                    
                        foreach ($query->result_array() as $row)
                        {
                            echo $row['name'].'<br>'; 
                            if($row['id']){

                                $now = time(); 
                                $human = unix_to_human($now, TRUE, eu);
                                $data = array(
                                    'updated_at' => $human
                                );
                                
                                $this->db->where('id', $row['id']);
                                $this->db->update('email_campaigns', $data);  

                                 $this->getContactListDetails($row['id'],$row['sent_id'],$row['name']);
                            }
            
                    }
                  
    }
    
    
    
    function get_contact_list($bookmark = true){
            
         $objv =   $this->getCompanyHouseDetails("https://api2.autopilothq.com/v1/contacts/".$bookmark);

        $i = 0;
        $bookmark = $objv;
            // THIS IS WHERE THE SHIT HAPPENS
           
   
            foreach($objv as $itemv  => $valuev){
             
              { 
                   foreach($valuev as $objr =>$item ){

                          $mail =  array('mail_received' => 0,'mail_opened'=> 1,'mail_clicked' => 2,'mail_unsubscribed' => 4);
                       foreach($mail as $mailItem => $value){
                           $objMailR = $item[$mailItem];
                           foreach($objMailR as $itemr => $valuedr  ){
                          
                             if($itemr){
                                   $entDate = date("Y-m-d H:i:s", (substr($valuedr, 0, 10)));
                                //echo  $this->check_campaign_ref($itemr) ? 'No ' : 'YEs';
                                 $bookmark = $itemr; 
                                 echo '<h1>'.$value.'</h1>'.$itemr.' ---- '.$valuedr.' ---- '.$entDate.'<br>'.$item['Email'].'<br>';
                             }
                        }   
                           
                       }
                       
                       
                   /*
DO NOt REMOVE

                       $output[] =  '<h2>Page Visits</h2>';
                         $pageVitits = $item['anywhere_page_visits'];
                         foreach($pageVitits as $itempv => $valuepv  ){

                        };
                       
                       */
                     // echo $bookmark. '<br>';
                       

                   }
                 
           
            }
          
            
         }
    
    
      if($objv['bookmark'])
             $this->get_contact_list($objv['bookmark']); //RECURSION GET NEXT LIST
    
    }
    
       // print_r($itemv);
        
   
    
    
    
    
    //This should run every hour or more -  Checks and adds email campaign list to database from AP
    function create_email_campaign_listing1()
    {
            
          $objv =   $this->getCompanyHouseDetails("https://api2.autopilothq.com/v1/lists");
                 $i = 0;
        $words = array('\'');
        
            foreach($objv as $itemv  => $valuev){

                   foreach($valuev as $itemvr  => $valuevr){
                       
                       //$title = str_replace($words, '',$valuevr['title']);
                       $title =  htmlspecialchars($valuevr['title'], ENT_QUOTES);  
                       $sql = "SELECT id,name,contact_list  from email_campaigns where name='".$title."'  LIMIT 1";
                               $query = $this->db->query($sql);
                              $row = $query->row(); 
                       
                                $numrows = $query->num_rows();
                           if (!$numrows) {
                               // insert new entry anme and contact list id
                               // echo 'insert '. $valuevr['title'] . ' list id' .$valuevr['list_id'];
                                $camp_id  = $this->get_last_row_id_email_campaign();        
                                $now = time(); 
                                $human = unix_to_human($now, TRUE, eu);
                                $contactList = array(
                                'id' => $camp_id,
                                'name' => $title,
                                      'date_sent' => date('Y-m-d'),
                                    'updated_at' => $human , 
                                'sent_id' => $valuevr['list_id']
                                );
                                $this->db->insert('email_campaigns',   $contactList);

                             }elseif(!$row->sent_id){
                                
                                $contactList = array(
                                             'sent_id' => $valuevr['list_id']
                                        );
                               
                                $this->db->where('name',$row->name);
                                $this->db->update('email_campaigns',   $contactList);
                     
                            }else{
                               //do do nthing
                               
                            }
                     }
            }
        
    }
    
    function get_last_row_id_email_campaign(){
        
        $query = $this->db->query("SELECT id from email_campaigns ORDER BY id DESC LIMIT 1");
                   $row = $query->row(); 
                   return $row->id+1;
            }
    
    public function getContactListDetails($campaign_id = 480,$contact_list = "contactlist_07D36C5F-DFF1-4606-B34E-7137BECC8870",$campaign_title = "MCU: Mar 2016"){
        
        $query = $this->db->query("SELECT id from email_actions ORDER BY id DESC LIMIT 1");


           $row = $query->row(); 

          $last_row_id =  $row->id;


            $obj = $this->test('https://api2.autopilothq.com/v1/list/'.$contact_list.'/contacts/');

            $objCont = $obj['contacts'] ;
         foreach($objCont as $objr =>$item ){

            $event = 3;

                 $objMailR = $item['mail_received'];
                 foreach($objMailR as $itemr => $valuedr  ){
                    $entDate = date("Y-m-d H:i:s", (substr($valuedr, 0, 10)));
                      echo $itemr.' ---- '.$valuedr.' ---- '.$entDate.'<br>'.$item['Email'].'<br>';
                };
                $objMailO= $item['mail_opened'];
                 foreach($objMailO as $itemo => $valueo  ){
                     $entDate = date("Y-m-d H:i:s", (substr($valueo, 0, 10)));
                     $event = 1;
                };  

                 $objMailC= $item['mail_clicked'];
                 foreach($objMailC as $itemc => $valuec  ){
                    $entDate = date("Y-m-d H:i:s", (substr($valuec, 0, 10)));
                     $event = 2;
                }; 
                 $objMailU = $item['mail_unsubscribed'];
                 foreach($objMailU as $itemu => $valueu  ){

                     $entDate = date("Y-m-d H:i:s", (substr($valueu, 0, 10)));
                      $event = 4;
                };
                  $output[] =  '<h2>Page Visits</h2>';
                 $pageVitits = $item['anywhere_page_visits'];
                 foreach($pageVitits as $itempv => $valuepv  ){

                };

                 //campaign vars
                 $campaign_name = $valuevr['campaign_name'];

                   $campaign_name_exist =  $this->check_campaign_ref($campaign_title);
                $check_if_email_exist  = $this->getemailuserid($item['Email']);

               if($check_if_email_exist && $campaign_title  != 'Removed Via Baselist' &&   $event != 3) {
                      //actions vars                                            

                    $sent_email = $item['Email'];
                    $email_campaign_id = $this->get_campaign_id($campaign_title);
                  if($email_campaign_id)   $companyFinder = $this->companyFinder($check_if_email_exist ,$email_campaign_id ,$event) ;                                                               
                   
                            $contactList = array(
                                'id' => $last_row_id++,
                                'email_campaign_id' => $email_campaign_id,
                                'sent_action_id' => $contact_list,
                                'contact_id' => $check_if_email_exist , 
                                'email_action_type' => $event,
                                'action_time' => $entDate,
                                'created_by' => 1
                            );
                           // $this->db->insert('email_actions',   $contactList);                    
               }
        }


        
        
    }
    
    
     public function getCustomListDetails($campaign_id = 480,$contact_list = "contactlist_07D36C5F-DFF1-4606-B34E-7137BECC8870",$campaign_title = "MCU: Mar 2016"){
        
       

            $obj = $this->test('https://api2.autopilothq.com/v1/contact/person_000D6E15-40F0-4951-9447-BC063AD453BB');

            $objCont = $obj['custom_fields'] ;
         foreach($objCont as $objr =>$item ){
              
             if($item['value'] == 'Downloaded'){
                 
                 echo $item['value'] . '----' .$item['kind'].'<br>';
                 
             }
             
             //echo $item['value'].'<br>';
             



foreach($item as $custkey => $custItem){
                 //echo $custkey['value'].'<br>';
                 if($custkey == 'Downloaded'){
                   // echo  $custkey.'-----'.$custItem;  
                 }
             }
             

          
        }


        
        
    }
     
    //find the company id baised on the campaign name and insert FK into  the emails action table
    public function companyFinder($contactidd,$campaignID,$event){
        
          $sql =  "SELECT email_campaign_id FROM email_actions WHERE contact_id=".$contactidd." AND email_campaign_id=".$campaignID." AND email_action_type=".$event."  ";
            $querye = $this->db->query($sql);
      return  $querye->num_rows();  //tested ok 
        
    }
    
    
    
    public function get_campaign_id($campaign)
{ //checks campaign name and if exist returns the ID 
        $words  = array('\'');
        $campaign =  str_replace($words, '', $campaign);
        
        $sql = "SELECT id FROM email_campaigns WHERE name='".$campaign."'  ";
    $query = $this->db->query($sql);
     foreach ($query->result_array() as $row)
     {
         return $row['id'];
     }
    return false;          
}
    
    public function check_campaign_ref($campaign_name){
        
        
         $words  = array('\'');
        $campaign_name =  str_replace($words, '', $campaign_name);
           $queryone = $this->db->query("SELECT sent_id FROM email_campaigns WHERE name='".$campaign_name."' "); 
        if($queryone->num_rows()){
            return false;
            
        }
        return true;
        
    }
    
    public function getemailuserid($email)
{
        $sql =  "SELECT * FROM contacts WHERE email='".$email."' LIMIT 1 ";
    $query = $this->db->query($sql);
  
    foreach ($query->result_array() as $row){
        return $row['id'];
    }
        return false;
}
    
    public function loaddata(){
        
     
  $DB1 = $this->load->database('olive',true);
     //$i =  $this->db->query('SELECT * FROM tracks');
        
  $q = '
     SELECT id
     FROM baselist.open_email
      
     LIMIT 1
    ';
    $result = $this->db->query($q);
        //$this->db->close();
       
      // var_dump($result->conn_id);
        echo '<br><br>';
        echo 'ok';
        // var_dump($result);
        
        
        $this->db->close();
        $this->load->database('debug',true);
        
    }
    
    
    
     public function getCompanyHouseDetails($url = 0) 
	{
 
            $server_output = array();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_GET, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = 'autopilotapikey: ed278f3d19a5453fb807125aa945a81a';
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $server_output = curl_exec ($ch);
            $result  = json_decode($server_output, true);
             return  $result; 
            curl_close ($ch); 
         
         
         
     }
    
    
    function recurr(){
        
        
        
        
    }
    
    
    function recur($value){
        if(!is_array($value)){
          foreach($value as $items  => $value){
                        //echo $items['email'];
              if(!is_array($value)){
                        return  $items['Email'];
              }else{
                  
                  
                  
              }

                    }
        }
        
    }
    
     
    
    
    
    public function test($url = 0){
        
        
        $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 264,
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
    
}