<?php
class Tagging_model extends MY_Model {
    
    
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
         $this->load->helper('date');
        $this->load->helper('string');
	}
    
    
    public function create_sub($post,$userID)
    {
       
         $itemid = $post['itemid'];
        
         $data = array(
          'updated_at' => date('Y-m-d H:i:s'),
        'name' => quotes_to_entities($post['name']),
        'master_category_id' => $itemid,
           'eff_from' => $post['eff_from'],
           'eff_to' => $post['eff_to'] ? $post['eff_to'] : NULL,
          'updated_by' => $userID
       );
       
      
        
       $this->db->insert('tag_categories', $data);
        
        
    }
    
    
    
    
    
    
    public function add_category($post,$userID)
    {
         
    $data = array(
          'created_at' => date('Y-m-d H:i:s'),
        'name' => quotes_to_entities($post['name']),
        'master_category_id' => $post['create_category'] ? $post['create_category'] : NULL,
           'eff_from' => $post['eff_from'],
           'eff_to' => $post['eff_to'] ? trim($post['eff_to']) : NULL,
          'created_by' => $userID
       );
       
       $this->db->insert('tag_categories', $data);
        
        
         return $post['userID'];
       
    }
    public function show_category($string= false)
    {
        
        //WHERE t.master_category_id =22
        $string = $string ? '='.$string : 'IS NULL';
 
      $sql = 'SELECT distinct t.*, tcsub.eff_from as cat_eff_from, tcsub.eff_to as cat_eff_to,tcsub.id as sub_id, tcsub.name as sub_name, tcsub.id as sub_master_id  FROM tag_categories t
LEFT JOIN tag_categories tcsub
ON t.id = tcsub.master_category_id 
 WHERE t.master_category_id '.$string.'
ORDER BY t.name';
   
      $query = $this->db->query($sql);
      return json_encode($query->result_array());

    }
    
    
    function getEditTags($id= false){
        
        $sql = 'SELECT   tc.name as name, t.id, t.eff_from, t.eff_to, t.name  as sub_name, t.id as sub_master_id, t.id as tag_id, t.category_id FROM tag_categories tc
LEFT JOIN tags t
ON tc.id = t.category_id
 WHERE t.category_id ='.$id;
        
        
         $query = $this->db->query($sql);
      return json_encode($query->result_array()); 
        
        
        
    }
    
    public function update_category($post)
    {

        $itemid = $post['itemid'];
        $master = $post['masterID'];
        
         $data = array(
          'updated_at' => date('Y-m-d H:i:s'),
        'name' => quotes_to_entities($post['name']),
        'master_category_id' => $master ? $master : NULL,
           'eff_from' => trim($post['eff_from']),
           'eff_to' => trim($post['eff_to']) ? trim($post['eff_to']) : NULL,
          'updated_by' => $userID
       );
       
        $this->db->where('id', quotes_to_entities($itemid));  
        
       $this->db->update('tag_categories', $data);
        
        
    }
    public function delete_category($id)
    {

    }
    
    //Tag
    public function add_tag($post,$userId)
    {
        
         $itemid = $post['itemid'];
        
        $data = array(
          'category_id' => $itemid,
         'name' => quotes_to_entities($post['name']),
           'tag_type' =>  1,
           'created_at' => date('Y-m-d'),
           'eff_from' =>  trim($post['eff_from']),
           'eff_to' =>  trim($post['eff_to']) ? trim($post['eff_to']) : NULL,
          'created_by' => $userId
       );
        
         
       
       $this->db->insert('tags', $data);
        
    }
    
    public function edit_tag($post,$userId)
    {
        
         $itemid = $post['itemid'];
        $master = $post['masterID'];
        $data = array(
         'name' => quotes_to_entities($post['name']),
           'eff_from' =>  trim($post['eff_from']),
           'eff_to' => trim($post['eff_to']) ? trim($post['eff_to']) : NULL,
          'updated_by' => $userId
       );
        
          $this->db->where('id', quotes_to_entities($itemid)); 
       
       $this->db->update('tags', $data);
        
    }
    public function show_tag($id)
    {

        $sql = 'SELECT t.id as tag_id, 
        t.name , 
        tc.id as tac_sub_cat_id,
    tc.name as sub_cat_name,
    tcn.id as sub_parent_cat_id ,
        tcn.name as parent_cat_name , 
          t.tag_type, 
         t.eff_from,
         t.eff_to as eff_to
        FROM tags t
LEFT JOIN tags tt
ON  t.category_id = tt.id
LEFT JOIN tag_categories tc
ON t.category_id  = tc.id

LEFT JOIN tag_categories tcn
ON tc.master_category_id = tcn.id

LEFT JOIN company_tags ct
ON t.id = ct.tag_id

LEFT JOIN contact_tags cont
ON t.id = cont.tag_id

WHERE t.tag_type=1 
AND t.category_id='.$id;
 
        $query = $this->db->query($sql);
      return json_encode($query->result_array());  
        
    }
    public function update_tag($post)
    {
     $itemid = $post['itemid'];
        
         $data = array(
          'updated_at' => date('Y-m-d H:i:s'),
        'name' => quotes_to_entities($post['name']),
           'eff_from' => $post['eff_from'],
           'eff_to' => $post['eff_to'] ? $post['eff_to'] : NULL,
          'updated_by' => $userID
       );
       
        $this->db->where('id', quotes_to_entities($itemid));  
        
       $this->db->update('tags', $data);
    }
    public function delete_tag($id)
    {
$this->db->delete('tags', array('id' => $id)); 
        
        return json_encode(array('success' => 'ok'));
    }
    
      //contact Tags
    public function add_contact_tag($post)
    {
            $data = array(
          'tag_id' => isset($post['tagID']) ? $post['tagID'] : 2,
          'contact_id' => isset($post['name']) ? $post['name'] : 1234,
           'created_at' => date('Y-m-d'),
           'eff_from' => date('Y-m-d'),
           'eff_to' => date('Y-m-d'),
          'created_by' => $post['userID']
       );
       
       $this->db->insert('contact_tags', $data);
    }
    public function show_contact_tag($id)
    {

    }
    public function update_contact_tag($post)
    {

    }
    public function delete_contact_tag($id)
    {

    }
    
          //Company Tags
    public function add_company_tag($post)
    {
            $data = array(
          'tag_id' => isset($post['tagID']) ? $post['tagID'] : 2,
          'company_id' => isset($post['name']) ? $post['name'] : 1234,
           'created_at' => date('Y-m-d'),
           'eff_from' => date('Y-m-d'),
           'eff_to' => date('Y-m-d'),
          'created_by' => $post['userID']
       );
       
       $this->db->insert('company_tags', $data);
    }
    public function show_company_tag($id)
    {

    }
    public function update_company_tag($post)
    {

    }
    public function delete_company_tag($id)
    {

    }
    
        public function checkCategoryName($cat_name, $master_cat_id =false){ //Check if category tag exist
        $master_cat_id = $master_cat_id ?  'AND master_category_id='.quotes_to_entities($master_cat_id) :  '' ;

        $query = $this->db->query("SELECT name FROM tag_categories WHERE name  ilike '".quotes_to_entities($cat_name)."' ".$master_cat_id."  LIMIT 1");

        if ($query->num_rows() > 0)
        {

        return false;
        }
        return true;
        }
    
    
    
    public function checkTagName($cat_name, $master_cat_id =false){ //Check if category tag exist
        
       

        $query = $this->db->query("SELECT name FROM tags WHERE name  ilike '".quotes_to_entities($cat_name)."' AND category_id=".$master_cat_id."  LIMIT 1 ");

        if ($query->num_rows() > 0)
        {

        return false;
        }
        return true;
        }
    
    
    
     
     public function getCategoryName($cat_name){ //Check if category tag exist
        
        $query = $this->db->query("SELECT name FROM tag_categories WHERE name  ilike '".quotes_to_entities($cat_name)."'  LIMIT 1");
       
            if ($query->num_rows() > 0)
                {
                   $row = $query->row(); 
        
                   return $row->id;
        
                }
        
     return false;
            }
    public function check_if_date_in_past($newDate){
         
         $datetime1 = new DateTime(date('Y-m-d'));
$datetime2 = new DateTime($newDate);
$interval = $datetime1->diff($datetime2);
$int =  $interval->format('%R%a');
     
         if($int[0] === '-'){
             
             return false;
             
         }else{
             
              return true ; 
         }
         
    
         
     }
        
        
    
    
}