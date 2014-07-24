<?php
class Companies_model extends CI_Model {
	
	function get_all(){
		$query = $this->db->get('companies',10);	
		return $query->result();
	}

	function special_query($dfds){
		$query = $this->db->query('');
		return $query->result();
	}

	function insert_entry(){
        $this->title   = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('entries', $this);
    }
}
?>