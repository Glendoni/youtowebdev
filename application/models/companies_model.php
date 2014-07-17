<?php
class Companies_model extends CI_Model {
	
	function get_all(){
		$this->db->order_by('id','ASC');
		$query = $this->db->get('newpublic.companies', 10);
		return $query->result();
	}

	function special_query(){
		$query = $this->db->query('YOUR QUERY HERE');
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