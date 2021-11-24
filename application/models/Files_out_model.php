<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class files_out_model extends CI_Model {
 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_files_out() {
	  $this->db->select('*');
	  $this->db->from('xin_files_out');		
	  $this->db->where('is_active','1');
	  $this->db->order_by('updated_at', 'DESC');
	  return $this->db->get();
	}
	
	public function get_files_user($user_id){
	  $this->db->select('*');
	  $this->db->from('xin_files_out');		
	  $this->db->where('current_employee_id',$user_id);
	  $this->db->where('status !=','Draft');
	  $this->db->where('reporting_officer !=','');
	  $this->db->where('is_active','1');
	  $this->db->order_by('id', 'DESC');
	  return $this->db->get();
	}
	
	public function get_files_download($id){
	  $this->db->select('*');
	  $this->db->from('xin_files');		
	  $this->db->where('id',$id);
	  $this->db->order_by('id', 'DESC');
	  return $this->db->get();
	}
	
	public function get_files_list_download(){
	  $this->db->select('*');
	  $this->db->from('xin_files');		
	 // $this->db->order_by('id', 'DESC');
	  return $this->db->get();
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
	
	
	public function all_file_type() {
	  $query = $this->db->query("SELECT * from xin_file_type");
  	  return $query->result();

	}
	
	public function get_template($file_type){
	
		$this->db->select('*');
		$this->db->from('xin_template');
		$this->db->where('file_type',$file_type);
		$query = $this->db->get();		
	 	return $query->result();
		
		// $select ="SELECT * FROM xin_template WHERE file_type = '$file_type'";
		// $selected =$this->db->query($select);
		// return $selected->result();
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
	 public function read_file_information($id) {
	
		$condition = "id =" . "'" . $id . "'";
		$this->db->select('*');
		$this->db->from('xin_files_out');
		$this->db->where('id',$id);
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
		$this->db->insert('xin_files_out', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to Delete selected record from table
	public function delete_record($id){
		$this->db->where('id', $id);
		$this->db->delete('xin_files');
		
	}
	
	// Function to update record in table
	public function update_record($data, $id){
		$this->db->where('id', $id);
		if( $this->db->update('xin_files',$data)) {
			return true;
		} else {
			return false;
		}		
	}
}
?>