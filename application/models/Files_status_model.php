<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files_status_model extends CI_Model {
 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_files() {
	  $this->db->select('*');
	  $this->db->from('xin_files');		
	  $this->db->where('is_active','1');
	  $this->db->order_by('updated_at', 'DESC');
	  return $this->db->get();
	}
	
	public function get_files_id() {
	  $this->db->select('*');
	  $this->db->from('xin_files');	
	  $this->db->order_by('id', 'DESC');
	  $this->db->limit(1);	  
	  $query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_files_user($user_id){
	  $this->db->select('*');
	  $this->db->from('xin_files');		
	  $this->db->where('employee_id',$user_id);
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
	
	public function get_files_signature($id){
	  $this->db->select('*');
	  $this->db->from('xin_files_signature');		
	  $this->db->where('file_id',$id);
	  //$this->db->order_by('id', 'DESC');
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
	}

	 public function read_file_information($id) {	
		$this->db->select('*');
		$this->db->from('xin_files');
		$this->db->where('id',$id);
		$query = $this->db->get();		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	 public function read_file_information_file_out_by_admin($id) {	
		$this->db->select('*');
		$this->db->from('xin_files_out');
		// $this->db->where('employee_id',$user_id);
		$this->db->where('file_id',$id);
		$query = $this->db->get();
		
		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	 public function read_file_information_file_out($user_id,$id) {	
		$this->db->select('*');
		$this->db->from('xin_files_out');
		$this->db->where('employee_id',$user_id);
		$this->db->where('file_id',$id);
		$query = $this->db->get();
		
		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function read_employee_information($id){
		$this->db->select('*');
		$this->db->from('xin_employees');
		$this->db->where('user_id',$id);
		$query = $this->db->get();
		
		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	 public function read_file_information_upload($id) {
	//	$condition = "file_id =" . "'" . $id . "'";
		// $this->db->select('*');
		// $this->db->from('xin_files_upload');
		// //$this->db->where('file_id',$id);
		// //$this->db->limit(1);
		// $query = $this->db->get();
					// return $query->result();

		// if ($query->num_rows() == 1) {
		// } else {
			// return false;
		// }
	  $query = $this->db->query("SELECT * FROM xin_files_upload WHERE file_id = '$id'");
  	  return $query->result();

	}
	
	// Function to add record in table
	public function add($data){
		$this->db->insert('xin_files', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function to add record in table
	public function add_files_upload($data1){
		$this->db->insert('xin_files_upload', $data1);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
		// Function to add record in table
	public function add_files_signature($data2){
		$this->db->insert('xin_files_signature', $data2);
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