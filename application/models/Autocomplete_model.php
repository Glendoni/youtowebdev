<?php
class Autocomplete_model extends CI_Model {
	    public function get_autocomplete($search_data) {
        $this->db->select('name');
        $this->db->select('id');
        $this->db->like('name', $search_data, 'both'); 
        $this->db->order_by("name", "asc"); 

        return $this->db->get('companies', 10);
    }



}