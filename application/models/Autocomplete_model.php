<?php
class Autocomplete_model extends CI_Model {
	    public function get_autocomplete($search_data) {
	    		 $query1 = $this->db->query("select name,id from companies where name ilike '".$search_data."%' order by name asc limit 10 ");
				    if ($query1->num_rows() > 0)
						{
						return $query1;
						}
    				else 
						{
						return $this->db->query("select name,id from companies where name ilike '%".$search_data."%' order by name asc limit 5 ");
						}
			}
}