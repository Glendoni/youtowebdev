<?php
class Tagging_model extends MY_Model {
    
    
	function __construct() {
		parent::__construct();
		// Some models are already been loaded on MY_Controller
         $this->load->helper('date');
        $this->load->helper('string');
	}
    
    public function add_category($post,$userID)
    {
         
        
        
       
      //  return $this->data['current_user']['id'];
        
        //$status = substr($post['monthupdate'], 0, 2);
            //$newmonth =   str_replace($status, '', $post['monthupdate']); 
        
        
        
        
    $data = array(
          'created_at' => date('Y-m-d H:i:s'),
        'name' => quotes_to_entities($post['name']),
           'eff_from' => $post['eff_from'],
           'eff_to' => $post['eff_to'] ? $post['eff_to'] : NULL,
          'created_by' => $userID
       );
       
       $this->db->insert('tag_categories', $data);
        
        
         return $post['userID'];
       
    }
    public function show_category($id)
    {
   $sql = "SELECT * 
FROM tags t
LEFT JOIN tag_categories tc
ON t.category_id = tc.id
LEFT JOIN company_tags ct
ON tc.id= ct.tag_id
LEFT JOIN contact_tags con
ON tc.id = con.tag_id";
        
      $query = $this->db->query($sql);
      return json_encode($query->result_array());
    }
    public function update_category($post)
    {

    }
    public function delete_category($id)
    {

    }
    
    //Tag
    public function add_tag($post)
    {
        $data = array(
          'category_id' => isset($post['masterId']) ? $post['masterId'] : 2,
          'name' => isset($post['name']) ? $post['name'] : 'Mews',
           'tag_type' => isset($type) ? $type : 1,
           'created_at' => date('Y-m-d'),
           'eff_from' => date('Y-m-d'),
           'eff_to' => date('Y-m-d'),
          'created_by' => $post['userID']
       );
       
       $this->db->insert('tags', $data);
        
    }
    public function show_tag($id)
    {

    }
    public function update_tag($post)
    {

    }
    public function delete_tag($id)
    {

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
    
    public function checkCategoryName($cat_name){ //Check if category tag exist
        
        $query = $this->db->query("SELECT name FROM tag_categories WHERE name  ilike '".quotes_to_entities($cat_name)."'  LIMIT 1");
       
            if ($query->num_rows() > 0)
                {
                  // $row = $query->row(); 
        return false;
                   //return $row->company_id;
        
                }
        
        return true;
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