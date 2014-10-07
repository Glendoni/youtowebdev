<?php
class Sectors_model extends CI_Model {
	
	function get_all()
	{
		$query = $this->db->get_where('sectors',array('display'=>'True'));	
		return $query->result();
	}

	function get_all_in_array()
	{
		$sql ='
		SELECT s.id,s.name,count(O.id)
		FROM sectors s
		LEFT JOIN operates O on s.id = O.sector_id
		WHERE s.display = \'True\'
		GROUP BY s.id,s.name
		ORDER BY count desc
		';
		
		$query = $this->db->query($sql);

		foreach($query->result() as $row)
		{
		  $sectors_array[$row->id] = $row->name.' ('.$row->count.')';
		  $sectors_count_array[$row->id] = $row->count;
		} 
		return array ('sectors'=>$sectors_array,'sectors_count'=>$sectors_count_array);
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