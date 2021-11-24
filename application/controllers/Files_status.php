<?php
 /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Workable Zone License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.workablezone.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to workablezone@gmail.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * versions in the future. If you wish to customize this extension for your
 * needs please contact us at workablezone@gmail.com for more information.
 *
 * @author   Mian Abdullah Jan - Workable Zone
 * @package  Workable Zone - File_type
 * @author-email  workablezone@gmail.com
 * @copyright  Copyright 2017 © workablezone.com. All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Files_status extends MY_Controller {
	
	 public function __construct() {
        Parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->library('upload');
		//load the model
		$this->load->model("Templates_model");
		$this->load->model("File_type_model");
		$this->load->model("Files_model");
		$this->load->model("Files_out_model");
		$this->load->model("Files_status_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Payroll_model");
		$this->load->model("Employees_model");
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	 public function index()
     {
		$data['title'] = $this->Xin_model->site_title();
		$data['all_employees'] = $this->Xin_model->all_employees();
		$data['all_file_type'] = $this->Templates_model->all_file_type();
		$data['breadcrumbs'] = 'Files Movement';
		$data['path_url'] = 'files_status';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('105',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("e-file/files_status", $data, TRUE);
			$this->load->view('layout_main', $data); //page load
			} else {
				redirect('');
			}
		} else {
			redirect('dashboard/');
		}
     }
	
	
    public function file_status_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("e-file/files_status", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	
		 if($session['user_role_id'] == 1){
		$file = $this->Files_status_model->get_files();	 
		 }
		 else{
		 $file = $this->Files_status_model->get_files_user($session['user_id']);
		 }
		$data = array();
        foreach($file->result() as $r) {
		
		$user = $this->Xin_model->read_user_info($r->employee_id);
		$full_name = htmlentities($user[0]->first_name). ' '.htmlentities($user[0]->last_name);
		$reporting_officer = $this->Xin_model->read_user_info($r->reporting_officer);
		if($reporting_officer != null){
		$reporting_officer_full_name = htmlentities($reporting_officer[0]->first_name). ' '.htmlentities($reporting_officer[0]->last_name);
		}else{
		$reporting_officer_full_name = "";	
		}
		$payslip = '<a class="text-success" href="'.site_url().'files/pdf_create/id/'.$r->id.'/">Download</a>';
		$supporting_file = $this->Files_model->read_file_upload($r->id); 
		
		$part_file = '';
		if($supporting_file != null){
		foreach($supporting_file as $sfs){
			$supporting_part_file = $sfs->attachment_file;			
			$part_file .= "<a href=".base_url()."uploads/files/".$supporting_part_file." target='_blank'>"."<img src=".base_url()."uploads/image/attachment.png".">".$supporting_part_file."</a><br>";
		}
		}else{
			$part_file = "No Supporting/Part file upload";	
		}
		if($r->attachment_file != null){
		$reference_file = "<a href=".base_url()."uploads/files/".$r->attachment_file." target='_blank'>"."<img src=".base_url()."uploads/image/attachment.png".">".$r->attachment_file."</a><br>";
		}else{
		$reference_file	= "No Reference file uploaded";
		}

		$updated_at = strtotime($r->updated_at);
		$updated_date = date("d-m-Y H:i:s", $updated_at); 
		
		if($session['user_role_id'] == 1){
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="View"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-id="'. $r->id . '"><i class="fa fa-eye"></i></button></span>',
			$full_name,
			$r->file_name,
			//$r->file_type,
			$r->subject_line,
			$r->due_date,
			$r->status,
			$r->priority,
			$reporting_officer_full_name,
			$reference_file,
			$part_file,
			$updated_date,
			$payslip,
			
		);
		}else{
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="View"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-id="'. $r->id . '"><i class="fa fa-eye"></i></button></span>',
			$full_name,
			$r->file_name,
			//$r->file_type,
			$r->subject_line,
			$r->due_date,
			$r->status,
			$r->priority,
			$reporting_officer_full_name,
			$reference_file,
			$part_file,
			$updated_date,
			//$payslip,
			
		);	
		}
	}

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $file->num_rows(),
			 "recordsFiltered" => $file->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	
		
	 public function read()
	{	
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('id');
		$file_id = $this->input->get('file_id');
		$result = $this->Files_status_model->read_file_information($id); 
		$reporting_officer = $this->Xin_model->read_user_info($result[0]->reporting_officer);
		if(($reporting_officer != null) || ($reporting_officer != 0)){
		$reporting_officer_full_name = htmlentities($reporting_officer[0]->first_name). ' '.htmlentities($reporting_officer[0]->last_name);
		}else{
		$reporting_officer_full_name = "";	
		}
		$data = array(
				'id' => $result[0]->id,
				// 'counter' => $result[0]->counter,
				'employee_id' => $result[0]->employee_id,
				'file_name' => $result[0]->file_name,
				// 'file_id' => $result[0]->file_id,
				'file_type' => $result[0]->file_type,
				'subject_line' => $result[0]->subject_line,
				'description' => $result[0]->description,
				'status' => $result[0]->status,
				'priority' => $result[0]->priority,
				'file_delivery_mode' => $result[0]->file_delivery_mode,
				'reporting_officer' => $reporting_officer_full_name,
				'attachment_file' => $result[0]->attachment_file,
				'attachment_file1' => $result[0]->attachment_file1,
				'attachment_file2' => $result[0]->attachment_file2,
				'attachment_file3' => $result[0]->attachment_file3,
				'remark' => $result[0]->remark,
				//'attachment_file' => $result_upload[0]->attachment_file,	
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('e-file/dialog_files_status', $data);
		} else {
			redirect('');
		}
	}
	


	public function update() {
	
	if($this->input->post('edit_type')=='edit_file_status') {
		date_default_timezone_set('Asia/Kolkata'); 
		$post_data = $this->input->post();
	    $post_data=$this->security->xss_clean($post_data);
			
		$id = $this->uri->segment(3);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
			
		/* Server side PHP input validation */
		$file_name = $post_data['file_name'];
		$file_type = $post_data['file_type'];
		$subject_line = $post_data['subject_line'];
		$description = $post_data['description'];
		$status = $post_data['status'];
		$reporting_officer = $post_data['reporting_officer'];
		$remark = $post_data['remark'];
		// $attachment_file1 = $post_data['attachment_file1'];
		// echo $attachment_file1;
		//$qt_template = htmlspecialchars(addslashes($template), ENT_QUOTES);
		
		if($this->input->post('file_name')==='') {
        	$Return['error'] = "The file name field is required.";
		} else if($this->input->post('file_type')==='') {
			$Return['error'] = "The file type field is required.";	
		}else if($this->input->post('subject_line')==='') {
			$Return['error'] = "The subject line field is required.";	
		}else if($this->input->post('description')==='') {
			$Return['error'] = "The description field is required.";	
		}else if($this->input->post('status')==='') {
			$Return['error'] = "The status field is required.";	
		}else if($this->input->post('reporting_officer')==='') {
			$Return['error'] = "The reporting officer field is required.";	
		}else if($this->input->post('remark')==='') {
			$Return['error'] = "The remark field is required.";	
		}
		else{
		$data = array(
        'file_name' => $post_data['file_name'],
        'file_type' => $post_data['file_type'],
        'subject_line' => $post_data['subject_line'],
        'description' => $post_data['description'],
        'status' => $post_data['status'],
        'priority' => $post_data['priority'],
        'file_delivery_mode' => $post_data['file_delivery_mode'],
        'reporting_officer' => $post_data['reporting_officer'],
       // 'counter' => $post_data['counter'],
        'employee_id' => $post_data['employee_id'],
        'remark' => $post_data['remark'],
  //	 'created_at' => date("Y-m-d h:i:sa"),
        'updated_at' => date("Y-m-d H:i:s"),
        );    
        $result = $this->Files_model->update_record($data,$id);
		if($result == TRUE){
		foreach($_FILES['file']['tmp_name'] as $key => $tmp_name){
			$allowed =  array('pdf');
			$filename = $_FILES['file']['name'][$key];
			$_FILES['file']['size'][$key] == 1000000;
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if(in_array($ext,$allowed)){
			$tmp_name = $_FILES["file"]["tmp_name"][$key];
			$bill_copy = "./uploads/files/";
			$lname 	= basename($_FILES["file"]["name"][$key]);
		//	$newfilename = $lname."_".$key."_".round(microtime(true)).'.'.$ext;
			$newfilename = $lname;
			move_uploaded_file($tmp_name, $bill_copy.$newfilename);
			$fname = $newfilename;
			//$get_files_id = $this->Files_model->get_files_id();			
			$data1 = array(
			'file_id' => $id,
			'reporting_officer' => $post_data['reporting_officer'],
			'employee_id' => $post_data['employee_id'],
			'attachment_file' => $fname,
			'created_at' => date("Y-m-d H:i:s"),
			);
			$result_upload = $this->Files_model->add_files_upload($data1);
				}
			} 
		}
        if ($result == TRUE) {
            $Return['result'] = 'File added.';
        } else {
            $Return['error'] = 'Bug. Something went wrong, please try again.';
        }
        $this->output($Return);
        exit;
        //$Return['error'] = $this->lang->line('xin_error_attatchment_type_pdf');
    //        }
		}
	}
	
	}
	
	public function delete() { 
		
		$id=$this->input->post('id');
		$update = $this->Files_model->delete_record($id);
        if ($update) {
			$Return['result'] = 'File deleted.';
			$this->output($Return);
	            echo 1;
        } else {
            echo 0;
			$Return['error'] = 'Bug. Something went wrong, please try again.';
			$this->output($Return);
        }
    }	
	
}
