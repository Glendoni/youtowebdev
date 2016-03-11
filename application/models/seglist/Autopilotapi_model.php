<?php
class Autopilotapi_model extends MY_Model {
    
 const AUTOPPILOT_API_KEY = 'ff0941e036d54b7a8a1894bed15662fc';
    
     const AUTOPPILOT_API_KEY_PRODUCTION = 'ed278f3d19a5453fb807125aa945a81a';
    
    public function run(){
        
        return '';
        
    }
	
    public function connect($action, $method = "GET")
    {

        header('Content-Type: application/json');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api2.autopilothq.com/".$action,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "autopilotapikey:". self::AUTOPPILOT_API_KEY,
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        } header('Content-Type: application/json');


    }
    
    public function connect_post($action, $json_post_fields ,$method = "POST")
    {

        //return = $json_post_fields;
        //$json_post_fields =  "{ \n    \"contact\": {\n        \"FirstName\": \"Gleno\",\n        \"LastName\": \"Small\",\n  \"unsubscribe\": false,\n        \"Email\": \"gsmall@sonovate.com\",\n        \"custom\": {\n            \"string--Test--Field\": \"This is a test\"\n        }\n\n  }\n\n}" ; 

        header('Content-Type: application/json');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api2.autopilothq.com/".$action,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json_post_fields,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                "autopilotapikey:". self::AUTOPPILOT_API_KEY_PRODUCTION,
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        } header('Content-Type: application/json');


    }


 
}