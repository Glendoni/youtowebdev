<?php
class Mortgages_model extends CI_Model {
	
	function get_all()
	{
		$query = $this->db->get_where('mortgages',array('search','True'));	
		return $query->result();
	}

	function get_by_id($id,$order_by = 'asc')
	{
		$query = $this->db->get_where('mortgages',array('id'=>$id));
		$query->order_by('id', $order_by);
		return $query->result();
	}

	function get_by_company_id($company_id,$order_by = 'asc')
	{
		$query = $this->db->get_where('mortgages',array('company_id'=>$company_id));
		$query->order_by('company_id', $order_by);
		return $query->result();
	}

	function get_by_company_id_with_provider($company_id,$order_by = 'asc')
	{
		$this->db->select('providers.name, mortgages.stage , mortgages.eff_from');
		$this->db->from('mortgages');
		$this->db->where('mortgages',"mortgages.company_id = $company_id ");
		$this->db->join('providers','providers.id = mortgages.provider_id','left');
		$this->db->order_by('mortgages.eff_from', $order_by);
		return $query->result();
	}

	function get_by_provider_id($provider,$order_by = 'asc')
	{
		$query = $this->db->get_where('mortgages',array('provider_id'=>$provider_id));
		$query->order_by('provider_id', $order_by);
		return $query->result();
	}

	function get_by_stage_id($stage,$order_by = 'asc')
	{
		$query = $this->db->get_where('mortgages',array('stage'=>$stage));
		$query->order_by('stage', $order_by);
		return $query->result();
	}

	function get_by_stage_type($type,$order_by = 'asc')
	{
		$query = $this->db->get_where('mortgages',array('type'=>$type));
		$query->order_by('type', $order_by);
		return $query->result();
	}






}