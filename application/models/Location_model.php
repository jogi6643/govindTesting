<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class location_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_locations()
	{
	  return $this->db->get("xin_office_location");
	}
	 
	 public function read_location_information($id) {
	
		$condition = "location_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_office_location');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_office_location', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('location_id', $id);
		$this->db->delete('xin_office_location');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('location_id', $id);
		if( $this->db->update('xin_office_location',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// Function to update record without logo > in table
	public function update_record_no_logo($data, $id){
		$this->db->where('location_id', $id);
		if( $this->db->update('xin_office_location',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	// get all office locations
	public function all_office_locations() {
	  $query = $this->db->query("SELECT * from xin_office_location");
  	  return $query->result();
	}
	
	 public function read_location_information_by_department($id) {
	
		$condition = "location_id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_office_location');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
}
?>