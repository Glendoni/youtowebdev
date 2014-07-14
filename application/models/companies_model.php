<?php
class Lat_model extends CI_Model {
	function ambil_data(){
		$this->db->order_by(‘id’,’ASC’);
		$query = $this->db->get(‘tbllat’);
		return $query->result();
	}
}
?>