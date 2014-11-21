<?php
class Email_templates_model extends CI_Model {
	

	// GETS
	function get_all()
	{
		$this->db->order_by('name desc');
		$query = $this->db->get('email_templates');
		return $query->result_object();
	}

	function get_by_id($id)
	{
		$query = $this->db->get_where('email_templates', array('id' => $id));
		return $query->result_object();
	}

}