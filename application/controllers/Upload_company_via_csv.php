<?php if ( ! defined('BASEPATH')); //exit('No direct script access allowed');
class Upload_company_via_csv extends MY_Controller {
	
    //public $DB1;
    
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
		// $DB1 = $this->load->database('autopilot',true);
	}
	
	public function index() 
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
                            $compID = $this->Companies_model->create_company_from_CH($post,1); 
                       
                            //echo '<hr />';

                        //echo $col[8] . '' . $col[1].' '.$col3.' <br>';
                        }
                    }
                  
                    fclose($handle);
                }
                echo "File data successfully imported to database!!";
           }else{

            echo "Cannot find companies.csv file!!";   

           }
    }
    

    public function getCompanyHouseChargesApi($id,$compID)
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
                           $this->Companies_model->insert_charges_CSV($output);
                   
               // echo  $output['company_id'];
                // $this->Companies_model->insert_charges_CSV($output);
                // echo $id .'<br>';
               //echo   $value['persons_entitled'][0]['name']. '<br>'. $value['etag'].'<br>';  //prividers_id
               //echo $value['etag'].'<br>'; //ref
               //echo $value['status'].'<br>'; //stage
               //echo $value['transactions'][0]['delivered_on'].'<br>'; //eff_from
               //echo  '<br><br>';//
                           
                             return true;
                       }else{
                           return false; 
                       }
           }
        }
        
    }
    
    public function ipp($lmt = 100 ,$oft= 0)
    {
        
        
      
        $sql = "SELECT registration,id FROM companies WHERE  created_at >= '2016-03-10' ORDER BY id LIMIT ".$lmt."  OFFSET ".$oft."   ";
    $query = $this->db->query($sql);
    
        echo $sql.'<br>';
            echo  $query->num_rows();
          foreach ($query->result_array() as $row)
          {          
              echo $row['registration'].' ' .$row['id'] .'  - ';
            echo  $this->getCompanyHouseChargesApi($row['registration'],$row['id']) ? 'Found' : ' Not found' .'<br>';
          } 
        
     
        //unlink('companies.csv');
    }
    
    
 public function runMorgageCheck($ref)
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
}