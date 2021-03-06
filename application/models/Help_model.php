<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class help_model extends CI_Model {
 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
	public function get_files() {
	  $this->db->select('*');
	  $this->db->from('xin_files');		
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
	  $this->db->where('status !=','Draft');
	  $this->db->order_by('id', 'DESC');
	  return $this->db->get();
	}	
	
	public function get_files_user_draft($user_id){
	  $this->db->select('*');
	  $this->db->from('xin_files');		
	  $this->db->where('employee_id',$user_id);
	  $this->db->where('status','Draft');
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

	public function read_make_file_information($id){
	  $this->db->select('*');
	  $this->db->from('xin_files');		
	  $this->db->where('id',$id);
	  $query = $this->db->get();		
	  return $query->result();
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
		$this->db->from('xin_files');
		$this->db->where('id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
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
	
	public function get_user_details($user_id) {
		$this->db->select('*');
		$this->db->from('xin_employees');		
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_user_by_department($department_id,$user_id) {
		$this->db->select('*');
		$this->db->from('xin_employees');		
		$this->db->where('department_id', $department_id);
		$this->db->where('user_id !=', $user_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_designation_details($designation_id) {
		$this->db->select('*');
		$this->db->from('xin_designations');		
		$this->db->where('designation_id', $designation_id);
		$query = $this->db->get();
		return $query->result();
	}	
	
	public function get_department_details($department_id) {
		$this->db->select('*');
		$this->db->from('xin_departments');		
		$this->db->where('department_id', $department_id);
		$query = $this->db->get();
		return $query->result();
	}	
	
	public function get_location_details($location_id) {
		$this->db->select('*');
		$this->db->from('xin_office_location');		
		$this->db->where('location_id', $location_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_user() {
		$this->db->select('*');
		$this->db->from('xin_employees');		
		$query = $this->db->get();
		return $query->result();
	}

	public function read_file_upload($file_id) {
		$this->db->select('*');
		$this->db->from('xin_files_upload');	
		$this->db->where('file_id', $file_id);
		$query = $this->db->get();
		// return $query->result();
		if ($this->db->affected_rows() > 0) {
		return $query->result();
		} else {
			return false;
		}
	}

}
?>