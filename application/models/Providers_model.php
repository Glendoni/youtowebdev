<?php
class Providers_model extends MY_Model {
	
	function get_all()
	{
		$query = $this->db->get_where('providers');	
		return $query->result();
	}

	function get_all_in_array()
	{

		$this->db->select('id, name');
		$query = $this->db->get_where('providers');

		foreach($query->result() as $row)
		{
		  $providers_array[$row->id] = ucwords(strtolower($row->name));
		} 	
		return $providers_array;
	}

	function get_top_10_in_array()
	{
		$top10 = array('2686', '2582', '2329', '2744', '2825', '2337', '2960', '2413', '2652', '3000');

		$this->db->select('id, name');
		$this->db->where_in('id', $top10);
		$query = $this->db->get_where('providers');

		foreach($query->result() as $row)
		{
		  $providers_top10_array[$row->id] = ucwords(strtolower($row->name));
		} 	
		return $providers_top10_array;
	}

	function get_by_id($id)
	{
		$query = $this->db->get_where('providers',array('id'=>$id));
		return $query->result();
	}

	function get_by_name($name)
	{
		$query = $this->db->get_where('providers',array('name'=>$name));
		return $query->result();
	}

	function get_by_url($url)
	{
		$query = $this->db->get_where('providers',array('url'=>$url));
		return $query->result();
	}

	function insert_provider($name,$url)
	{
        $this->name   = $name; // please read the below note
        $this->url = $url;
        $this->db->insert('providers', $this);
    }
}