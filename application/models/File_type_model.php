<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class file_type_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_file_type($id) {
		
		$this->db->select('*');
		$this->db->from('xin_employee_travels');
		//$this->db->where('added_by',$id);
		$this->db->order_by('travel_id', 'DESC');
		$this->db->where('reporting_officer',$id);
		$query = $this->db->get();		
	 	return $query;
	  //return $this->db->get("xin_employee_travels");
	}
	
	public function get_all_file_type() {
	  $this->db->select('*');
	  $this->db->from('xin_file_type');		
	  $this->db->where('is_active','1');
	  $this->db->order_by('id', 'DESC');
	  return $this->db->get();
	}
	
	public function file_type_count(){
	  $this->db->select('count(*)');
	  $this->db->from('xin_file_type');		
	  $query = $this->db->get();
  	  return $query->result();
	}
	// public function get_employee_travel($id) {

		// $this->db->where('employee_id',$id);
		// $query =$this->db->get('xin_employee_travels');
	 	// return $query;
	// }
	
	// public function get_employee_id_travel($id){
		
		// $this->db->select('*');
		// $this->db->from('xin_file_type');
		// $this->db->where('id',$id);
		// $query = $this->db->get();
		
		// if($query->num_rows() > 0){
			// return $query->result();
		// }else{
			// return null;
		// }
		
	// }
	
	// public function all_employee_name() {

	  // $query = $this->db->query("SELECT * from xin_employees");

  	  // return $query->result();

	// }
	 public function read_file_type_information($id) {
	
		$condition = "id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_file_type');
		$this->db->where('id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	// // get all travel arrangement types
	// public function travel_arrangement_types()
	// {
	  // $query = $this->db->query("SELECT * from xin_travel_arrangement_type");
  	  // return $query->result();
	// }
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_file_type', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		$this->db->set('is_active','0');
		if( $this->db->update('xin_file_type',$data)) {
			return true;
		} else {
			return false;
		}
	//	$this->db->where('id', $id);
	//	$this->db->delete('xin_file_type');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('id', $id);
		if( $this->db->update('xin_file_type',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>