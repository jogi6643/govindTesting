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

class User_manual extends MY_Controller {
	
	 public function __construct() {
        Parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('sms');
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->library('upload');
		//load the model
		$this->load->model("Templates_model");
		$this->load->model("File_type_model");
		$this->load->model("Files_model");
		$this->load->model("Files_out_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		$this->load->model("Payroll_model");
		$this->load->model("Employees_model");
		$this->load->model("User_manual_model");
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
		$data['breadcrumbs'] = 'User Manual';
		$data['path_url'] = 'user_manual';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('114',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("e-file/user_manual", $data, TRUE);
			$this->load->view('layout_main', $data); //page load
			} else {
				redirect('');
			}
		} else {
			redirect('dashboard/');
		}
     }

	
    public function user_manual_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("e-file/user_manual", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		 $file = $this->User_manual_model->get_user_manual();		
		
		
		$data = array();
        foreach($file->result() as $r) {
		if($r->user_manual_file != null){
			$part_file = "<a href=".base_url()."uploads/user_manual/".$r->user_manual_file." target='_blank'>"."<img src=".base_url()."uploads/image/attachment.png".">".$r->user_manual_file."</a><br>";
		}else{
			$part_file = "No Supporting/Part file upload";	
		}

		$updated_at = strtotime($r->updated_at);
		$updated_date = date("d-m-Y H:i:s", $updated_at); 

		if($session['user_role_id'] == 1){
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="View"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-id="'. $r->id . '"><i class="fa fa-eye"></i></button></span><a href="javascript:void(0);" onclick="deletep('.$r->id.');" title="Delete"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal"><i class="fa fa-trash-o"></i></button></a>',
			// '<span data-toggle="tooltip" data-placement="top" title="Edit"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-id="'. $r->id  . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="View"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-id="'. $r->id . '"><i class="fa fa-eye"></i></button></span>',
			$r->title_manual,
			$updated_date,
			
		);
		}else{
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="View"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-id="'. $r->id . '"><i class="fa fa-eye"></i></button></span>',
			$r->title_manual,
			$updated_date,
		
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
		$result = $this->User_manual_model->read_file_information($id);

		$data = array(
				'id' => $result[0]->id,
				'title_manual' => $result[0]->title_manual,
				'user_manual_file' => $result[0]->user_manual_file,
				'created_at' => $result[0]->created_at,
				'updated_at' => $result[0]->updated_at,

				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('e-file/dialog_user_manual', $data);
		} else {
			redirect('');
		}
	}

	
	// Validate and add info in database
	public function add_user_manual() {
	
		if($this->input->post('add_type')=='add_user_manual') {		
		date_default_timezone_set('Asia/Kolkata');
		$session = $this->session->userdata('username');	

		$post_data = $this->input->post();
		$post_data=$this->security->xss_clean($post_data);
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
			
		/* Server side PHP input validation */
		if($this->input->post('file_name')==='') {
        	$Return['error'] = "The file no field is required.";
		}else if(($_FILES['user_manual_file']['size'] > 20000000)) {
			$Return['error'] = "The reference file size should be less than 20 MB.";	
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$allowed =  array('pdf');
		$filename_receipt = $_FILES['user_manual_file']['name'];
		$_FILES['user_manual_file']['size'] == 20000000;
		$ext_receipt = pathinfo($filename_receipt, PATHINFO_EXTENSION);
		if(in_array($ext_receipt,$allowed)){
		$tmp_name_receipt = $_FILES["user_manual_file"]["tmp_name"];
		$bill_copy = "./uploads/user_manual/";
		//$lname 	= basename($_FILES["user_manual_file"]["name"]);
		//$newfilename = $lname;
		$newfilename_receipt = "user_manual_file"."_".round(microtime(true)).'.'.$ext_receipt;
		move_uploaded_file($tmp_name_receipt, $bill_copy.$newfilename_receipt); 
		}
		
		if(($_FILES['user_manual_file']['size'] != '0') || ($_FILES['user_manual_file']['size'] != null) ){
			$fname_receipt = $newfilename_receipt;
		}else{
			$fname_receipt = '';
		}

        $data = array(
        'title_manual' => $post_data['title_manual'],
        'user_manual_file' => $fname_receipt,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s")
        );

		$result = $this->User_manual_model->add($data);

        if ($result == TRUE) {
            $Return['result'] = 'User Manual added.';
        } else {
            $Return['error'] = 'Something went wrong, please try again.';
        }
        $this->output($Return);
        exit;
    }	
		
	}
	

	public function update() {
	
	if($this->input->post('edit_type')=='edit_file') {
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
		} 
		/*else if($this->input->post('file_type')==='') {
			$Return['error'] = "The file type field is required.";	
		}
		*/else if($this->input->post('subject_line')==='') {
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
			$allowed =  array('pdf','docx','jpeg','doc','jpg','xlsx','csv');
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
            $Return['result'] = 'File Updated.';
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
		$update = $this->User_manual_model->delete_record($id);
        if ($update) {
			$Return['result'] = 'User Manual deleted.';
			$this->output($Return);
	            echo 1;
        } else {
            echo 0;
			$Return['error'] = 'Bug. Something went wrong, please try again.';
			$this->output($Return);
        }
    }	
	
}
