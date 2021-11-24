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
 * @package  Workable Zone - Announcements
 * @author-email  workablezone@gmail.com
 * @copyright  Copyright 2017 © workablezone.com. All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Managing_directive extends MY_Controller {
	
	 public function __construct() {
        Parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		//load the model
		$this->load->model("Announcement_model");
		$this->load->model("Managing_directive_model");
		$this->load->model("Xin_model");
		$this->load->model("Company_model");
		$this->load->model("Location_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
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
		$data['breadcrumbs'] = $this->lang->line('xin_managing_directive');
		$data['path_url'] = 'managing_directive';
		$data['get_all_companies'] = $this->Company_model->get_all_companies();
		$data['all_office_locations'] = $this->Location_model->all_office_locations();
		$data['all_departments'] = $this->Department_model->all_departments();
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('113',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("managing_directive/managing_directive_list", $data, TRUE);
			$this->load->view('layout_main', $data); //page load
			} else {
				redirect('');
			}
		} else {
			redirect('dashboard/');
		}		  
     }
 
    public function managing_directive_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("managing_directive/managing_directive_list", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		if($session['user_role_id'] == 1){
		$managing_directive = $this->Managing_directive_model->get_managing_directives();
		}else{
		$user =  $this->Xin_model->read_user_info($session['user_id']);	
		$managing_directive = $this->Managing_directive_model->get_managing_directives_user($user[0]->department_id);
		}
		$data = array();

		foreach($managing_directive->result() as $r) {
			 			  
		// get user > added by
		$user = $this->Xin_model->read_user_info($r->published_by);
		// user full name
		$full_name = $user[0]->first_name.' '.$user[0]->last_name;
		// get date
		$sdate = $this->Xin_model->set_date_format($r->start_date);
		$edate = $this->Xin_model->set_date_format($r->end_date);
		
		$department = $this->Department_model->read_department_information($r->department_id);
		if(!empty($department)){
		$department_name = $department[0]->department_name;
		}else{
		$department_name = "All Departments";
		}
		if($session['user_role_id'] == 1){
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-managing_directive_id="'. $r->managing_directive_id . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-managing_directive_id="'. $r->managing_directive_id . '"><i class="fa fa-eye"></i></button></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->managing_directive_id . '"><i class="fa fa-trash-o"></i></button></span>',
			$r->title,
			$r->summary,
			$department_name,
			$sdate,
			$edate,
			$full_name
		);
		}else{
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-managing_directive_id="'. $r->managing_directive_id . '"><i class="fa fa-eye"></i></button></span>',
			$r->title,
			$r->summary,
			$department_name,
			$sdate,
			$edate,
			$full_name
		);			
		}
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $managing_directive->num_rows(),
			 "recordsFiltered" => $managing_directive->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('managing_directive_id');
		$result = $this->Managing_directive_model->read_managing_directive_information($id);
		$data = array(
				'managing_directive_id' => $result[0]->managing_directive_id,
				'title' => $result[0]->title,
				'start_date' => $result[0]->start_date,
				'end_date' => $result[0]->end_date,
				'company_id' => $result[0]->company_id,
				'location_id' => $result[0]->location_id,
				'department_id' => $result[0]->department_id,
				'published_by' => $result[0]->published_by,
				'summary' => $result[0]->summary,
				'description' => $result[0]->description,
				'document' => $result[0]->document,
				'get_all_companies' => $this->Company_model->get_all_companies(),
				'all_office_locations' => $this->Location_model->all_office_locations(),
				'all_departments' => $this->Department_model->all_departments()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('managing_directive/dialog_managing_directive', $data);
		} else {
			redirect('');
		}
	}
	// Validate and add info in database
	public function add_managing_directive() {
	
		if($this->input->post('add_type')=='managing_directive') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
			
		/* Server side PHP input validation */
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$description = $this->input->post('description');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('title')==='') {
       		$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('company_id')==='') {
       		$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('location_id')==='') {
       		$Return['error'] = $this->lang->line('error_location_dept_field');
		} else if($this->input->post('department_id')==='') {
       		$Return['error'] = $this->lang->line('error_department_field');
		} else if($this->input->post('summary')==='') {
       		$Return['error'] = $this->lang->line('xin_error_summary_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$allowed =  array('pdf');
		$filename_receipt = $_FILES['document']['name'];
		$_FILES['document']['size'] == 20000000;
		$ext_receipt = pathinfo($filename_receipt, PATHINFO_EXTENSION);
		if(in_array($ext_receipt,$allowed)){
		$tmp_name_receipt = $_FILES["document"]["tmp_name"];
		$bill_copy = "./uploads/document/";
		//$lname 	= basename($_FILES["attachment_file1"]["name"]);
		//$newfilename = $lname;
		$newfilename_receipt = "document"."_".round(microtime(true)).'.'.$ext_receipt;
		move_uploaded_file($tmp_name_receipt, $bill_copy.$newfilename_receipt);
		}

		if(($_FILES['document']['size'] != '0') || ($_FILES['document']['size'] != null) ){
			$fname_receipt = $newfilename_receipt;
		}else{
			$fname_receipt = '';
		}
			
		$data = array(
		'title' => $this->input->post('title'),
		'start_date' => $this->input->post('start_date'),
		'end_date' => $this->input->post('end_date'),
		'company_id' => $this->input->post('company_id'),
		'location_id' => $this->input->post('location_id'),
		'department_id' => $this->input->post('department_id'),
		'description' => $qt_description,
		'summary' => $this->input->post('summary'),
		'published_by' => $this->input->post('user_id'),
		'document' => $fname_receipt,
		'created_at' => date('d-m-Y'),
		
		);
		$result = $this->Managing_directive_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_add_managing_directive');
			
			//get setting info 
			$setting = $this->Xin_model->read_setting_info(1);
			if($setting[0]->enable_email_notification == 'yes') {
				
				// load email library
				$this->load->library('email');
				$this->email->set_mailtype("html");
				$to_email = array();
				
				/*foreach($this->input->post('designation_id') as $designation_id) {
					
					$user_info = $this->Xin_model->read_user_info_bydesignation($designation_id);				
						//get company info
					$cinfo = $this->Xin_model->read_company_setting_info(1);
					//get email template
					$template = $this->Xin_model->read_email_template(4);
					
					$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
					$logo = base_url().'uploads/logo/'.$cinfo[0]->logo;
					
					$message = '
			<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
			<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var site_url}","{var name}"),array($cinfo[0]->company_name,site_url(),'User'),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
					
					$this->email->from($cinfo[0]->email, $cinfo[0]->company_name);
					$this->email->to($user_info[0]->email);
					
					$this->email->subject($subject);
					$this->email->message($message);
					$this->email->send();
				}*/
			}
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {

		if($this->input->post('edit_type')=='managing_directive') {
			
		$id = $this->uri->segment(3);
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
			
		/* Server side PHP input validation */
		$start_date = $this->input->post('start_date_modal');
		$end_date = $this->input->post('end_date_modal');
		$description = $this->input->post('description');
		$st_date = strtotime($start_date);
		$ed_date = strtotime($end_date);
		$qt_description = htmlspecialchars(addslashes($description), ENT_QUOTES);
		
		if($this->input->post('title')==='') {
       		$Return['error'] = $this->lang->line('xin_error_title');
		} else if($this->input->post('start_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_start_date');
		} else if($this->input->post('end_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_end_date');
		} else if($st_date > $ed_date) {
			$Return['error'] = $this->lang->line('xin_error_start_end_date');
		} else if($this->input->post('company_id')==='') {
       		$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('location_id')==='') {
       		$Return['error'] = $this->lang->line('error_location_dept_field');
		} else if($this->input->post('department_id')==='') {
       		$Return['error'] = $this->lang->line('error_department_field');
		} else if($this->input->post('summary')==='') {
       		$Return['error'] = $this->lang->line('xin_error_summary_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
			
		$allowed =  array('pdf');
		$filename_receipt = $_FILES['document']['name'];
		$_FILES['document']['size'] == 20000000;
		$ext_receipt = pathinfo($filename_receipt, PATHINFO_EXTENSION);
		if(in_array($ext_receipt,$allowed)){
		$tmp_name_receipt = $_FILES["document"]["tmp_name"];
		$bill_copy = "./uploads/document/";
		//$lname 	= basename($_FILES["attachment_file1"]["name"]);
		//$newfilename = $lname;
		$newfilename_receipt = "document"."_".round(microtime(true)).'.'.$ext_receipt;
		move_uploaded_file($tmp_name_receipt, $bill_copy.$newfilename_receipt);
		}

		if(($_FILES['document']['size'] != '0') || ($_FILES['document']['size'] != null)){
			$fname_receipt = $newfilename_receipt;
		}else{
			$fname_receipt = $this->input->post('document_part');
		}
		
		$data = array(
		'title' => $this->input->post('title'),
		'start_date' => $this->input->post('start_date_modal'),
		'end_date' => $this->input->post('end_date_modal'),
		'company_id' => $this->input->post('company_id'),
		'location_id' => $this->input->post('location_id'),
		'department_id' => $this->input->post('department_id'),
		'description' => $qt_description,
		'document' => $fname_receipt,
		'summary' => $this->input->post('summary')		
		);
		
		$result = $this->Managing_directive_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_update_managing_directive');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	public function delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
		$id = $this->uri->segment(3);
		$result = $this->Managing_directive_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_delete_managing_directive');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}