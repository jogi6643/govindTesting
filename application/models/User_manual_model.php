<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_manual_model extends CI_Model {
 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_user_manual', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function read_file_upload($id) {
		$this->db->select('*');
		$this->db->from('xin_user_manual');	
		$this->db->where('id', $id);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
		return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_user_manual() {
	  $this->db->select('*');
	  $this->db->from('xin_user_manual');		
	  $this->db->order_by('updated_at', 'DESC');
	  return $this->db->get();
	}
	
	 public function read_file_information($id) {	
		$condition = "id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_user_manual');
		$this->db->where('id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		if($this->db->delete('xin_user_manual')) {
			return true;
		} else {
			return false;
		}
	}


}
?>