      <?php
//for model.php
class Marketing_model extends MY_Model {
    
    
    public function autopilot_segment(){

       $dbconn = pg_connect("host=ec2-79-125-118-138.eu-west-1.compute.amazonaws.com port=5522 dbname=d7fvbgmrpjg4ba user=ucvie36u7gtubf password=p6lgogrt7mg89411qujnepsgfkf")
    or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$query = "select DISTINCT  identifies.company,CONCAT(identifies.first_name,' ',identifies.last_name) as username, 
to_char(identifies.sent_at, 'DD/MM/YYYY') as Date ,send.event_text as sent,
 _open.event_text as opened, click.event_text as click, unsubscribe.event_text as opened, send.campaign
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
        ";
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
 
            while ($row = pg_fetch_array($result)) 
            {

             
                 //echo  $row[0]." - ".$row[1]." - ".$row[2]." - ".$row[3]." - ".$row[4]." - ". $row[5]."<br>"; 
                if($row[0] ){
                $get_companyID  = $this->getuserdetails($row[0]);
            //
                
                 if($get_companyID) $resultArray[]['companyID'] =   $get_companyID; 
                
                    $resultArray[] = $row; 
                    
               
                
                }
                
            } 
        return $resultArray;
    
    }
     
    public function getuserdetails($string){
         
       $query   =  $this->Companies_model->get_autocomplete($string);
        
        
     if($query->num_rows()){
       
        foreach ($query->result() as $row):
        return  $row->id ;
         endforeach;
         }else{
         
          return false;     
     }
   
    } 
    
    
    public function actions_performed($comp_name){
        
        
      $trading_name =  $comp_name['trading_name'];
         $comp_name =  $comp_name['name'];
           
        $dbconn = pg_connect("host=ec2-79-125-118-138.eu-west-1.compute.amazonaws.com port=5522 dbname=d7fvbgmrpjg4ba user=ucvie36u7gtubf password=p6lgogrt7mg89411qujnepsgfkf")
    or die('Could not connect: ' . pg_last_error());
        
        
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
		AND identifies.company='$comp_name' OR identifies.company='$trading_name'
		ORDER BY identifies.company
		 ";
        
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
 
            while ($row = pg_fetch_array($result)) 
            {

             
                 //echo  $row[0]." - ".$row[1]." - ".$row[2]." - ".$row[3]." - ".$row[4]." - ". $row[5]."<br>"; 
                
            //
                
                 if($get_companyID) $resultArray[]['companyID'] =   $get_companyID; 
                
                    $resultArray[] = $row; 
                
            } 
        return $resultArray;
    
        
    }
    

       
}