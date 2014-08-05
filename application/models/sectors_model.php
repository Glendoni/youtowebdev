<?php
class Sectors_model extends CI_Model {
	
	function get_all()
	{
		$query = $this->db->get_where('sectors',array('display'=>'True'));	
		return $query->result();
	}

	function get_all_in_array()
	{
		$this->db->select('id, name');
		$this->db->order_by('name','asc');
		$query = $this->db->get_where('sectors',array('display'=>'True'));

		foreach($query->result() as $row)
		{
		  $sectors_array[$row->id] = $row->name;
		} 
		return $sectors_array;
	}
	

	function get_by_id($id)
	{
		$query = $this->db->get_where('sectors',array('id'=>$id));
		return $query->result();
	}

	function get_by_name($name)
	{
		$query = $this->db->get_where('sectors',array('name'=>$name));
		return $query->result();
	}

	function insert_sector($name,$display)
	{
        $this->name   = $name; // please read the below note
        $this->display = $display;
        $this->db->insert('sectors', $this);
    }
}