<?php

class Api_model extends MY_Model {

    public function logAgent($header_post)
    {

        if(is_array($header_post)){

            $query = $this->db->query("SELECT id FROM companies WHERE registration='".$header_post['companyRegistration']."'");
            if($query->num_rows()){

                $incoming =  $header_post;
                $data = array('sonovate_id' => $incoming['sonovate3Id']);
                $this->db->where('registration', $incoming['companyRegistration']);
                $this->db->update('companies', $data);
                return true;

            }else{

                return false; 
            }
        }
    }
    
    public function get_placement_data($comp_reg_num)
    {
        $agency_stats =  getenv(PLACEMENT_AGENCY_STATS);   
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://invoicing-api.sonovate.com/api/agencyStats/?companyRegNumber=12345",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "authorization: Basic U29ub3ZhdGU0OnJObWxnTWFBOG5wT1dXTXFkdTZNMTJVWjdETWhBel9JZ0hUMkZzcjVxWHBpRUpFaVZObjh4WUlJRUI5ZjlCWk5rOEhwWmJVWUhqVGFSVzhFa0VOMk5NQmRBQUE=",
            "cache-control: no-cache"
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
