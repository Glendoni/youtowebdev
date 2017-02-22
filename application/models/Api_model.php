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
}
