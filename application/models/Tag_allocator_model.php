<?php
class Tag_allocator_model extends MY_Model {
	
    
    function contractOnly(){
        
        
        
    }
    
    function placing_contract(){
       
             $query = $this->db->query("SELECT id FROM companies c WHERE c.contract=true");
       
             if ($query->num_rows() > 0)
                {
                 	 	
                    foreach($query->result() as $row)
                    {
                            $output =  $this->checkpcTags($row->id, 185); //184 npc  - 185 pc  - 281 permanent placements 
                        echo $output ? $output.' -  Found <br>' : false;
                        if(!$output){
                            echo $row->id.'<br>'; //insert tag 185 and company ID

$this->insert_system_tag(185, $row->id);
                      
                            }}}
}
    
    
        function placing_perm_contrators(){
       
             $query = $this->db->query("SELECT id FROM companies c WHERE c.perm=true and  c.contract=true");
       
             if ($query->num_rows() > 0)
                {
                 	 	
                    foreach($query->result() as $row)
                    {
                            $output =  $this->checkpcTags($row->id, 281); //184 npc  - 185 pc  - 281 permanent placements 
                        echo $output ? $output.' -  Found <br>' : false;
                        if(!$output){
                            echo $row->id.'<br>'; //insert tag 185 and company ID

                            $this->insert_system_tag(281, $row->id); //Placing Contract
                      
                            }}}
        }
    
       function not_placing_contract(){ //good
       
             $query = $this->db->query("SELECT id FROM companies c WHERE c.perm=true AND c.contract IS NULL");
       
             if ($query->num_rows() > 0)
                {
                 	 	
                    foreach($query->result() as $row)
                    {
                            $output =  $this->checkpcTags($row->id, 184); //184 npc  - 185 pc  - 281 permanent placements 
                        echo $output ? $output.' -  Found <br>' : false;
                        if(!$output){
                            echo $row->id.'<br>'; //insert tag 185 and company ID

$this->insert_system_tag(184, $row->id);
                      
                            }}}
        }
    
    
    
    
    
    private function insert_system_tag($tagid, $companyID ){
        
        
             $arrSql = array(
                                         'tag_id' => $tagid,
                                         'eff_from' => date('Y-m-d'),
                                         'created_by' => 1,
                                         'company_id' => $companyID
                                    );

                            $this->db->insert('company_tags', $arrSql);
    }
    
    
    

    function  contAndPerm(){
        
             $query = $this->db->query("");
        
            if ($query->num_rows() > 0)
                {
                 	 	
		foreach($query->result() as $row)
		{
		 echo $row->comp_id;
		} 	
		//return $array;
        
                }
        
        
    }
    
    
    function checkpcTags($comp_id, $tag_id){
        $query = $this->db->query("SELECT company_id FROM company_tags WHERE company_id=".$comp_id."  and  tag_id =".$tag_id." AND eff_to IS NULL ORDER BY created_at DESC LIMIT 1");
       
                if ($query->num_rows() > 0)
                {
                    $row = $query->row(); 
                    return  $row->company_id;
         
                }else{
                    
                    return false;
                }
         
    }

}