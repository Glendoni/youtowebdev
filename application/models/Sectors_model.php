<?php
class Sectors_model extends MY_Model {
	
	function get_all()
	{
		$this->db->order_by("name", "asc");
		$query = $this->db->get_where('sectors');	

		foreach($query->result() as $row)
		{
		  $sectors_array[$row->id] = $row->name;
		} 
		
		return $sectors_array;
	}

	function get_all_for_search()
	{
		$sql ='
		SELECT s.id,s.name,count(O.id)
		FROM sectors s
		LEFT JOIN operates O on s.id = O.sector_id
		WHERE s.display = \'True\'
		GROUP BY s.id,s.name
		ORDER BY count desc,s.name desc
		';
		
		$query = $this->db->query($sql);

		foreach($query->result() as $row)
		{
		  $sectors_array[$row->id] = $row->name.' ('.number_format($row->count).')';
		    $sectors_array_all = $query->row_array(); 
		} 
		return $sectors_array;
				return $sectors_array_all;

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