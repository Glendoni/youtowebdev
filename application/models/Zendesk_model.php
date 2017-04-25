<?php
class Zendesk_model extends MY_Model {
    
    
   function get_placement_data($comp_reg_num){
       
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://invoicing-api-dev.sonovate.com/api/agencyStats/?companyRegNumber=12345",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "authorization: Basic YmFzZWxpc3Q6ck5tbGdNYUE4bnBPV1dNcWR1Nk0xMlVaN0RNaEF6X0lnSFQyRnNyNXFYcGlFSkVpVk5uOHhZSUlFQjlmOUJaTms4SHBaYlVZSGpUYVJXOEVrRU4yTk1CZEFBQQ==",
            "cache-control: no-cache",
            "postman-token: 8cfb28f3-1649-9397-261f-85382773e6cd"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          return $response;
        }   
   }
    
}