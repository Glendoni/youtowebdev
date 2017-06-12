<?php
class Email_templates_model extends MY_Model {
	

	// GETS
	function get_all()
	{
		$this->db->order_by('name desc');
		$query = $this->db->get_where('email_templates',array('active'=>'True'));
		return $query->result_object();
	}

	function get_by_id($id)
	{
		$query = $this->db->get_where('email_templates', array('id' => $id));
		return $query->row();
	}

	function update($post,$user_id,$attachments)
	{
		$data = array(
			'name' => $post['name'],
			'subject' => $post['subject'],
			'message' => $post['message'],
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $user_id,
			);
		if(!empty($attachments)){
			$data['attachments'] = $attachments;
		}
		if(isset($post['template_id']))
		{
			$this->db->where('id', $post['template_id']);
			$this->db->update('email_templates',$data);
		}else{
			$data['created_by'] = $user_id;
			$data['created_at'] = date('Y-m-d H:i:s');
			$this->db->insert('email_templates', $data);
		}
		
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
		}
	}

	function delete($id){
		$data['active'] = 'False';
		$this->db->where('id', $id);
		$this->db->update('email_templates',$data);
		if($this->db->affected_rows() !== 1){
			$this->addError($this->db->_error_message());
			return False;
		}else{
			return True;
		}

	}

	function clear_attachments($id,$user_id){

		$data = array(
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $user_id,
			'attachments' => Null,
			);
		$this->db->where('id', $id);
		$this->db->update('email_templates',$data);
		
		
		if($this->db->affected_rows() !== 1){
			$this->addError('');
			return False;
		}else{
			return True;
		}

	}

}
