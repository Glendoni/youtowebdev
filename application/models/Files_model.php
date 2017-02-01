<?php
class Files_model extends MY_Model {
	/*
    -- Table: files

-- DROP TABLE files;

CREATE TABLE files
(
  id serial NOT NULL,
  name text NOT NULL,
  action_id integer,
  file_location text NOT NULL,
  created_at timestamp without time zone NOT NULL DEFAULT now(),
  created_by integer,
  updated_by integer,
  company_id integer,
  encryption_name text,
  CONSTRAINT files_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE files
  OWNER TO mhcpgrefocjdtf;
    
    
    */

	public function file_uploader($data){
        
        
        
       // file_put_contents('demotestfile.txt', 'I am a file what are noooooooo?');
        
        

        
       $this->db->insert('files', $data);
        
        
    } 
    
    
    function getfile($id){
        
        $query = $this->db->query("SELECT name,file_location FROM files WHERE encryption_name='".$id."' LIMIT 1");
              return $query->result_array();
               
        
        
    }
    
    
    public function upload_image($fileName)
{
if($filename!='' ){
      $filename1 = explode(',',$filename);
  foreach($filename1 as $file){
  $file_data = array(
  'name' => $file,
  'datetime' => date('Y-m-d h:i:s')
  );
  //$this->db->insert('uploaded_files', $file_data);
  }
  }
}
    

}