<?php
class Companies_model extends CI_Model {
	
	function get_all(){
		$this->db->order_by('id','ASC');
		$query = $this->db->get('newpublic.companies')->limit('10');
		return $query->result();
	}
}
?>