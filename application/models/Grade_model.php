<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grade_model extends CI_Model {
 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_grade', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function get_grade() {
	  $this->db->select('*');
	  $this->db->from('xin_grade');		
	  $this->db->order_by('updated_at', 'DESC');
	  return $this->db->get();
	}
	
	public function all_grade() {
	  $this->db->select('*');
	  $this->db->from('xin_grade');		
	  $this->db->order_by('updated_at', 'DESC');
	  $query = $this->db->get();
	  return $query->result();
	}
	
	 public function read_file_information($id) {	
		$condition = "id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_grade');
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
		if($this->db->delete('xin_grade')) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('id', $id);
		if( $this->db->update('xin_grade',$data)) {
			return true;
		} else {
			return false;
		}		
	}


}
?>