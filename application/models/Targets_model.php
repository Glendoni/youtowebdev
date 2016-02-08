<?php
class Targets_model extends MY_Model {
	
	function add_company_to_campaign($campaing_id,$company_id,$created_by)
	{
        $this->campaign_id = $campaign_id; // please read the below note
        $this->company_id = $company_id;
        $this->created_at = date('Y-m-d H:i:s');
        $this->created_by = $created_by
        $this->db->insert('targets', $this);
        if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			//return user if insert was successful 
			$target_id = $this->db->insert_id();
			return $target_id;
		}
    }
}