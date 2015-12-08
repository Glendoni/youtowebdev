 <?php


function company($id){
// $id ="06848409";
    
    
   

    $ch = curl_init();
 
 curl_setopt($ch, CURLOPT_URL,"https://api.companieshouse.gov.uk/company/".$id."/charges");
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

  header('Content-Type : application/json');  
 
 $results = json_decode($result,TRUE);
  
    return $results;  
}


 $response = company($_GET['like']);

 echo  strtoupper($response['items'][0]['transactions'][0]['delivered_on']);
echo  $response['items'][0]['status'];

//echo  $response['items'][0]['etag'];






/*

{
  "part_satisfied_count": 0,
  "satisfied_count": 0,
  "items": [
    {
      "particulars": {
        "type": "short-particulars",
        "description": "Fixed and floating charge over the undertaking and all property and assets present and future, including goodwill, debts, uncalled capital, buildings, fixtures, fixed plant & machinery. See image for full details."
      },
      "links": {
        "self": "/company/06848409/charges/Cg75ZpQDNcJaKGo22VtK2LsG4Ww"
      },
      "transactions": [
        {
          "delivered_on": "2009-03-31",
          "links": {
            "filing": "/company/06848409/filing-history/MjAyOTg1MTYwOGFkaXF6a2N4"
          },
          "filing_type": "create-charge-pre-2006-companies-act"
        }
      ],
      "created_on": "2009-03-20",
      "secured_details": {
        "type": "amount-secured",
        "description": "All monies due or to become due from the company to the chargee on any account whatsoever under the terms of the aforementioned instrument creating or evidencing the charge"
      },
      "charge_number": 1,
      "persons_entitled": [
        {
          "name": "Sme Invoice Finance Limited"
        }
      ],
      "status": "outstanding",
      "classification": {
        "description": "Debenture",
        "type": "charge-description"
      },
      "etag": "a7e4847fb4291afd169ea5f85359ec77f95c6f04",
      "delivered_on": "2009-03-31"
    }
  ],
  "unfiltered_count": 1,
  "total_count": 1
}

*/


// echo 'company_number '.$results['items']['company_number'];

 
// Decode the response
   // $result = json_decode($result);

   // return $responseData;
//echo $result->items_per_page;
 //print_r($result);

/*
$ch = curl_init();
 curl_setopt($ch, CURLOPT_URL,"https://api.companieshouse.gov.uk/company/".$id."/charges");
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

      //Bugsnag::notifyError("Curl error", "Zoopla property update error", curl_error($ch));

      die(curl_errno($ch).': '.curl_error($ch));
    }

*/
    // Decode the response
   // $result = json_decode($result);

   // return $responseData;
//echo $result->items_per_page;
//print_r($result);


 



    /*
            $id = str_replace(' ', '', $id);
             //$server_output = array();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.companieshouse.gov.uk/search/companies?q=".$id);
            curl_setopt($ch, CURLOPT_GET, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $headers = array();
            $headers[] = 'Authorization: Basic RWFpN0V2N0JOSk1wcDlkcThUTWxkdHZzOXBDSzRTdmt0UGpzVjduWDo=';
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
             $server_output = curl_exec ($ch);
               
             return   json_encode($server_output);
            curl_close ($ch); 
*/

    /*    
           $id = str_replace(' ', '', $id);
             $server_output = array();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.companieshouse.gov.uk/search/companies?q=".$id);
            curl_setopt($ch, CURLOPT_GET, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = 'Authorization: Basic RWFpN0V2N0JOSk1wcDlkcThUTWxkdHZzOXBDSzRTdmt0UGpzVjduWDo=';
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
             $server_output = curl_exec ($ch);
               
             return   json_encode('fsdfs'.$server_output);
            curl_close ($ch); 
            */