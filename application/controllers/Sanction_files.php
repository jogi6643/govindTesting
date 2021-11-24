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

class Sanction_files extends MY_Controller {
	
	 public function __construct() {
        Parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('sms');
		$this->load->helper('send_email');
		$this->load->database();
		$this->load->library('form_validation');
		//load the model
		$this->load->model("Templates_model");
		$this->load->model("File_type_model");
		$this->load->model("Files_model");
		$this->load->model("Files_out_model");
		$this->load->model("Payroll_model");
		$this->load->model("Sanction_files_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
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
		$data['all_reporting_employees'] = $this->Xin_model->all_reporting_employees();
		$data['all_file_type'] = $this->Templates_model->all_file_type();
		$data['breadcrumbs'] = 'Files In';
		$data['path_url'] = 'sanction_files';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('103',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("e-file/sanction_files", $data, TRUE);
			$this->load->view('layout_main', $data); //page load
			} else {
				redirect('');
			}
		} else {
			redirect('dashboard/');
		}
     }
	
	 // create pdf - file
	public function pdf_create() {
 		$this->load->library('Pdf');
		 // create new PDF document
   		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$id = $this->uri->segment(4);
		$file_info = $this->Files_model->read_make_file_information($id); 
		$sanction_file_info = $this->Sanction_files_model->read_make_file_information($id); 
		$user = $this->Xin_model->read_user_info($file_info[0]->employee_id);
		$_des_name = $this->Designation_model->read_designation_information($user[0]->designation_id);
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		$location = $this->Xin_model->read_location_info($department[0]->location_id);
		// // company info
		 $company = $this->Xin_model->read_company_info($location[0]->company_id);
		 $system = $this->Xin_model->read_setting_info(1);
		 $file = $this->Files_model->get_files_download($id);	
		foreach($file->result() as $filee){
			$file_name = $filee->file_name;
		}
		$signature = $this->Files_model->get_files_signature($id);
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		 $company_name = $company[0]->name;
		//set default header data
		// $c_info_email = $company[0]->email;
		// $c_info_phone = $company[0]->contact_number;
		// $country = $this->Xin_model->read_country_info($company[0]->country);
		// $c_info_address = $company[0]->address_1.' '.$company[0]->address_2.', '.$company[0]->city.' - '.$company[0]->zipcode.', '.$country[0]->country_name;
		// $header_string ="Email : $c_info_email | Phone : $c_info_phone \nAddress: $c_info_address";
		//$header_string ="$file_name";
		$header_file_string ="File No: $file_name";
		$footer_string = "$file_name";
		// set document information
		$pdf->SetCreator('e-File Management System'); //print_r(base_url().'uploads/logo/payroll/'.$system[0]->payroll_logo);die;
		 $pdf->setHeaderData('../../../uploads/logo/payroll/'.$system[0]->payroll_logo, 35, '', '',$header_file_string);
		// echo getcwd().'/uploads/logo/payroll/'.$system[0]->payroll_logo; die;
		//$pdf->SetHeaderData(base_url().'uploads/logo/payroll/'.$system[0]->payroll_logo, 35, '', '',$header_file_string);
		$pdf->setFooterData($footer_string);
		// set header and footer fonts
		$pdf->setHeaderFont(Array('helvetica', '', 8));
		$pdf->setFooterFont(Array('helvetica', '', 8));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont('courier');
		
		// set margins
		$pdf->SetMargins(15, 25, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(15, 17, 15);
		
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 15);
		
		// set image scale factor
		$pdf->setImageScale(1.25);
		$pdf->SetAuthor('CPPRI');
		$pdf->SetTitle($company[0]->name.' E-file-CPPRI');
		$pdf->SetSubject('Payslip');
		$pdf->SetKeywords('Payslip');
		// set font
		$pdf->SetFont('helvetica', 'B', 10);



		// add a page
		$pdf->AddPage();
		
		$pdf->SetFont('helvetica', '', 10);
		// -----------------------------------------------------------------------------
		foreach($file->result() as $r){ 
		//$tbl = '<br><br>'."File Name: ".$r->file_name.'<br><br>'."Subject: ". $r->subject_line .'<br><br>'. html_entity_decode($r->description) .'<br>';
		$tbl = "Subject: ". $r->subject_line .'<br><br>';
		}
		foreach($sanction_file_info->result() as $r){
		$tbl .=  html_entity_decode($r->description).'<br>';			 
		$user = $this->Xin_model->read_user_info($r->current_employee_id);
		$tbl .= $r->created_at." -- ".$user[0]->first_name. " ".$user[0]->last_name." -- ".'<br><hr><br>'; 
		}
		foreach($file->result() as $r){ 
		if($r->attachment_file != null){
		$tbl .= '<p>'."Reference File :".'</p>'.'<a href="'.base_url().'uploads/files/'.$r->attachment_file.'"target="_blank">'.$r->attachment_file.'</a><br>';
		}
		}
		
		$file_upload = $this->Files_model->read_file_information_upload($r->id);
		if($file_upload != null){
		$tbl .= '<p>'."Supporting/Part Files :".'</p>';
		foreach($file_upload as $file_uploads){
		$tbl .= '<a href="'.base_url().'uploads/files/'.$file_uploads->attachment_file.'"target="_blank">'.$file_uploads->attachment_file.'</a><br>';
		}
		}
		
		foreach($signature->result() as $signaturee){
			$signature_name = $signaturee->signature;
			$updated_time = $signaturee->created_at;
			$signature_employee_id = $signaturee->employee_signature_id;
			$employee_name = $this->Employees_model->read_employee_information($signature_employee_id);
			$designation_id = $this->Designation_model->read_designation_information($employee_name[0]->designation_id);
			$employee_names = $employee_name[0]->first_name." ".$employee_name[0]->last_name;
			// $tbl .= '<img src= "/var/www/html/erp/hrms/uploads/signature/'.$signature_name.'" width="100" height="50">'.'<p style= "float:left;">'.$employee_names.'<br>'.$designation_id[0]->designation_name.'</p>';
		 $tbl .= '<img src="'.base_url().'uploads/signature/'.$signature_name.'" width="100" height="50">'.'<p style= "float:left;">'.$updated_time.'<br>'."e-Sign by ".$employee_names.'<br>'.$designation_id[0]->designation_name.'</p>';

		}

		$pdf->writeHTML($tbl, true, false, false, false, '');	 
  		// Image example with resizing
		//$pdf->Image(base_url().'uploads/signature/'.$signature_name, 25, 25, 25, 25, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);	

	
		//Close and output PDF document
		$pdf->Output('e-file'.'_'.$r->created_at.'.pdf', 'D');		  
     }
	 
	public function pdf_create_id() {
 		$this->load->library('Pdf');
		 // create new PDF document
   		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$id = $this->uri->segment(4);
		$file_id = $this->uri->segment(5);
		$file_info = $this->Files_model->read_make_file_information_id($id); //print_r($id); die;
		$user = $this->Xin_model->read_user_info($file_info[0]->employee_id);
		$_des_name = $this->Designation_model->read_designation_information($user[0]->designation_id);
		$department = $this->Department_model->read_department_information($user[0]->department_id);
		$location = $this->Xin_model->read_location_info($department[0]->location_id);
		// // company info
		 $company = $this->Xin_model->read_company_info($location[0]->company_id);
		 $system = $this->Xin_model->read_setting_info(1);
		 $file = $this->Files_model->get_files_download_id($id,$file_id);	
		foreach($file->result() as $filee){
			$file_name = $filee->file_name;
		}
		$signature_id = $this->Files_model->get_signature_id($id,$file_id); //print_r($signature_id[0]->current_employee_id); die;
		$signature = $this->Files_model->get_files_signature_id($signature_id[0]->current_employee_id,$file_id);
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		 $company_name = $company[0]->name;
		//set default header data
		// $c_info_email = $company[0]->email;
		// $c_info_phone = $company[0]->contact_number;
		// $country = $this->Xin_model->read_country_info($company[0]->country);
		// $c_info_address = $company[0]->address_1.' '.$company[0]->address_2.', '.$company[0]->city.' - '.$company[0]->zipcode.', '.$country[0]->country_name;
		// $header_string ="Email : $c_info_email | Phone : $c_info_phone \nAddress: $c_info_address";
		//$header_string ="$file_name";
		$header_file_string ="File No: $file_name";
		$footer_string = "$file_name";
		// set document information
		$pdf->SetCreator('e-File Management System'); //print_r(base_url().'uploads/logo/payroll/'.$system[0]->payroll_logo);die;
		 $pdf->setHeaderData('../../../uploads/logo/payroll/'.$system[0]->payroll_logo, 35, '', '',$header_file_string);
		// echo getcwd().'/uploads/logo/payroll/'.$system[0]->payroll_logo; die;
		//$pdf->SetHeaderData(base_url().'uploads/logo/payroll/'.$system[0]->payroll_logo, 35, '', '',$header_file_string);
		$pdf->setFooterData($footer_string);
		// set header and footer fonts
		$pdf->setHeaderFont(Array('helvetica', '', 8));
		$pdf->setFooterFont(Array('helvetica', '', 8));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont('courier');
		
		// set margins
		$pdf->SetMargins(15, 25, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(15, 17, 15);
		
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 15);
		
		// set image scale factor
		$pdf->setImageScale(1.25);
		$pdf->SetAuthor('CPPRI');
		$pdf->SetTitle($company[0]->name.' E-file-CPPRI');
		$pdf->SetSubject('Payslip');
		$pdf->SetKeywords('Payslip');
		// set font
		$pdf->SetFont('helvetica', 'B', 10);



		// add a page
		$pdf->AddPage();
		
		$pdf->SetFont('helvetica', '', 10);
		// -----------------------------------------------------------------------------
		foreach($file->result() as $r){ 
		//$tbl = '<br><br>'."File Name: ".$r->file_name.'<br><br>'."Subject: ". $r->subject_line .'<br><br>'. html_entity_decode($r->description) .'<br>';
		$tbl = "Subject: ". $r->subject_line .'<br><br>'. html_entity_decode($r->description) .'<br>';
		if($r->attachment_file != null){
		$tbl .= '<p>'."Reference File :".'</p>'.'<a href="'.base_url().'uploads/files/'.$r->attachment_file.'"target="_blank">'.$r->attachment_file.'</a><br>';
		}
		}
		
		$file_upload = $this->Files_model->read_file_information_upload_id($r->current_employee_id,$file_id);
		if($file_upload != null){
		$tbl .= '<p>'."Supporting/Part Files :".'</p>';
		foreach($file_upload as $file_uploads){
		$tbl .= '<a href="'.base_url().'uploads/files/'.$file_uploads->attachment_file.'"target="_blank">'.$file_uploads->attachment_file.'</a><br>';
		}
		}
		
		foreach($signature->result() as $signaturee){
			$signature_name = $signaturee->signature;
			$updated_time = $signaturee->created_at;
			$signature_employee_id = $signaturee->employee_signature_id;
			$employee_name = $this->Employees_model->read_employee_information($signature_employee_id);
			$designation_id = $this->Designation_model->read_designation_information($employee_name[0]->designation_id);
			$employee_names = $employee_name[0]->first_name." ".$employee_name[0]->last_name;
			// $tbl .= '<img src= "/var/www/html/erp/hrms/uploads/signature/'.$signature_name.'" width="100" height="50">'.'<p style= "float:left;">'.$employee_names.'<br>'.$designation_id[0]->designation_name.'</p>';
		 $tbl .= '<img src="'.base_url().'uploads/signature/'.$signature_name.'" width="100" height="50">'.'<p style= "float:left;">'.$updated_time.'<br>'."e-Sign by ".$employee_names.'<br>'.$designation_id[0]->designation_name.'</p>';

		}

		$pdf->writeHTML($tbl, true, false, false, false, '');	 
  		// Image example with resizing
		//$pdf->Image(base_url().'uploads/signature/'.$signature_name, 25, 25, 25, 25, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);	

	
		//Close and output PDF document
		//$pdf->Output('e-file'.'_'.$r->created_at.'.pdf', 'D');
		ob_clean();
		$pdf->Output('e-file'.'_'.$r->created_at.'.pdf', 'I');		  
     }

    public function sanction_file_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("e-file/sanction_files", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		 if($session['user_role_id'] == 1){
			$file = $this->Sanction_files_model->get_sanction_files();	
		 }else{
			$file = $this->Sanction_files_model->get_sanction_files_reporting_officer($session['user_id']);
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
		$payslip = '<a class="text-success" href="'.site_url().'sanction_files/pdf_create/id/'.$r->id.'/">Download</a>';
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
			'<span data-toggle="tooltip" data-placement="top" title="Edit"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-id="'. $r->id  . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="View"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-id="'. $r->id . '"><i class="fa fa-eye"></i></button></span><a href="javascript:void(0);" onclick="deletep('.$r->id.');" title="Delete"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal"><i class="fa fa-trash-o"></i></button></a>',
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
			'<span data-toggle="tooltip" data-placement="top" title="Edit"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-id="'. $r->id  . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="View"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-id="'. $r->id . '"><i class="fa fa-eye"></i></button></span>',
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
		$result = $this->Sanction_files_model->read_sanction_file_information($id);
		$data = array(
				'id' => $result[0]->id,
				'employee_id' => $result[0]->employee_id,
				'file_name' => $result[0]->file_name,
				'file_type' => $result[0]->file_type,
				'due_date' => $result[0]->due_date,
				'subject_line' => $result[0]->subject_line,
				'description' => $result[0]->description,
				'status' => $result[0]->status,
				'priority' => $result[0]->priority,
				'file_delivery_mode' => $result[0]->file_delivery_mode,
				'reporting_officer' => $result[0]->reporting_officer,
				'attachment_file' => $result[0]->attachment_file,
				'attachment_file1' => $result[0]->attachment_file1,
				'attachment_file2' => $result[0]->attachment_file2,
				'attachment_file3' => $result[0]->attachment_file3,
				'remark' => $result[0]->remark,
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('e-file/dialog_sanction_files', $data);
		} else {
			redirect('');
		}
	}
	
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='edit_sanction_file') {
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
		
		if($this->input->post('file_name')==='') {
        	$Return['error'] = "The file name field is required.";
		} 
		/*else if($this->input->post('file_type')==='') {
			$Return['error'] = "The file type field is required.";	
		}*/
		else if($this->input->post('subject_line')==='') {
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
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		else{
		$session = $this->session->userdata('username');
		$reporting_officer = $this->Sanction_files_model->read_sanction_file_information($id);
		$reporting_officer_id = $reporting_officer[0]->reporting_officer;
		
		$allowed =  array('pdf','docx','jpeg','doc','jpg','xlsx','csv');
		$filename_receipt = $_FILES['attachment_file1']['name'];
		$_FILES['attachment_file1']['size'] == 20000000;
		$ext_receipt = pathinfo($filename_receipt, PATHINFO_EXTENSION);
		if(in_array($ext_receipt,$allowed)){
		$tmp_name_receipt = $_FILES["attachment_file1"]["tmp_name"];
		$bill_copy = "./uploads/files/";
		//$lname 	= basename($_FILES["attachment_file1"]["name"]);
		//$newfilename = $lname;
		$newfilename_receipt = "reference_file"."_".round(microtime(true)).'.'.$ext_receipt;
		move_uploaded_file($tmp_name_receipt, $bill_copy.$newfilename_receipt); 
		}
		
		if(($_FILES['attachment_file1']['size'] != '0') || ($_FILES['attachment_file1']['size'] != null) ){
			$fname_receipt = $newfilename_receipt;
		}else{
			$fname_receipt = $post_data['attachment_file'];
		}
       
		// if(($post_data['attachment_file'] != '0') || ($post_data['attachment_file'] != null) ){
			// $fname_receipt = $post_data['attachment_file'];
		// }else{
			// $fname_receipt = '';
		// }
		
		$data = array(
        'file_name' => $post_data['file_name'],
        'file_type' => $post_data['file_type'],
        'due_date' => $post_data['due_date'],
        'subject_line' => $post_data['subject_line'],
        'description' => $post_data['description'],
        'status' => $post_data['status'],
        'priority' => $post_data['priority'],
        'file_delivery_mode' => $post_data['file_delivery_mode'],
		'current_employee_id' => $session['user_id'],
        'reporting_officer' => $post_data['reporting_officer'],
		'attachment_file' => $fname_receipt,
        'employee_id' => $post_data['employee_id'],
        'remark' => $post_data['remark'],
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
        );    
     //   $result = $this->Sanction_files_model->update_record($data,$id);

		$user = $this->Xin_model->read_user_info($session['user_id']);
		$e_sign = $this->input->post('verify');
		$dsc_sign = $this->input->post('verify_dsc');
		$e_sign_submit = $this->input->post('without_verify');
		
		if($e_sign != null){
			if($this->input->post('reporting_officer')==='') {
			$Return['error'] = "The reporting officer field is required.";	
			$this->output($Return);
			}
			$random_string = $this->input->post('random_string');
			$to = $session['username'];
			$cc = $session['email'];
			$this->load->library('email');
			$this->email->set_mailtype("html");
		
			$subject = "Verification Code of efile ";
			$message = "Welcome to Dredging Coporation of India. our Verification Code :".$random_string;
					
			$this->email->from('support@onlinedci.co.in'); 
			$this->email->set_newline("\r\n");
			
			$this->email->to($to);
			$this->email->cc($cc);	
			$this->email->subject($subject);
			$this->email->message($message);
			$mobile_number = $user[0]->contact_no;
			$content = "Welcome to Dredging Coporation of India. "."Your Verification Code is: ";
			// $sms_message = $content.$random_string;
			$sms_message = $random_string;
			$verification_code = $this->input->post('verification_code'); 
			// if($this->email->send()){ 
			if($verification_code != null){
				$verify_code = $random_string;
				//print_r($verification_code." == ". $verify_code);
				if($verification_code == $verify_code){
					$result = $this->Sanction_files_model->update_record($data,$id);
					//send_email($data['reporting_officer'],$data['current_employee_id'],$data['file_name'],$data['due_date']);

					//$get_files_id = $this->Files_model->get_files_id();
					// $id = $get_files_id[0]->id;	
					$employee = $this->Employees_model->read_employee_information($session['user_id']);
					$data2 = array(
					'file_id' => $id,
					'reporting_officer' => $post_data['reporting_officer'],
					'employee_id' => $post_data['employee_id'],
					'employee_signature_id' => $session['user_id'],
					'signature' => $employee[0]->signature,
					'created_at' => date("Y-m-d H:i:s"),
					);
					$result_signature = $this->Files_model->add_files_signature($data2);
					if($result_signature == true){$Return['result'] = 'Verification Code is Matched.';}
					}else{
						$Return['error'] = 'Verification Code is Incorrect.';
						$this->output($Return);
						exit;
					}
			}else{
				sms_send($mobile_number,$sms_message);
				//$this->email->send();
				if($verification_code != null){
					$verify_code = $random_string;
				if($verification_code == $verify_code){
					$result = $this->Sanction_files_model->update_record($data,$id);
					//send_email($data['reporting_officer'],$data['current_employee_id'],$data['file_name'],$data['due_date']);

				//	$get_files_id = $this->Files_model->get_files_id();
				//	$id = $get_files_id[0]->id;	
					$employee = $this->Employees_model->read_employee_information($session['user_id']);
					$data2 = array(
					'file_id' => $id,
					'reporting_officer' => $post_data['reporting_officer'],
					'employee_id' => $post_data['employee_id'],
					'employee_signature_id' => $session['user_id'],
					'signature' => $employee[0]->signature,
					'created_at' => date("Y-m-d H:i:s"),
					);
					$result_signature = $this->Files_model->add_files_signature($data2);
					if($result_signature == true){$Return['result'] = 'Verification Code is Matched.';}
					}else{
						$Return['error'] = 'Verification Code is Incorrect.';
						$this->output($Return);
						exit;
					}
				}else{
					$Return['error'] = 'Verification code has been sent to your registered mobile no. Please enter verification code to attach e-Sign in file.';
					// $Return['error'] = 'Verification code has been sent to your registered e-Mail address. Please enter verification code to attach e-Sign in file.';
					$this->output($Return);
					exit;					
				}
		 }
		 // }else{
			// $Return['error'] = 'Email does not send.';
			// $this->output($Return);
			// exit;		
		// }
		}else if($e_sign_submit != null){
			$result = $this->Sanction_files_model->update_record($data,$id);
			//send_email($data['reporting_officer'],$data['current_employee_id'],$data['file_name'],$data['due_date']);
			// $get_files_id = $this->Files_model->get_files_id();
			// $id = $get_files_id[0]->id;	
			$employee = $this->Employees_model->read_employee_information($session['user_id']);
			$data2 = array(
			'file_id' => $id,
			'reporting_officer' => $post_data['reporting_officer'],
			'employee_id' => $post_data['employee_id'],
			'employee_signature_id' => $session['user_id'],
			'signature' => $employee[0]->signature,
			'created_at' => date("Y-m-d H:i:s"),
			);
			$result_signature = $this->Files_model->add_files_signature($data2);
		}elseif($dsc_sign != null){
			if($this->input->post('reporting_officer')==='') {
			$Return['error'] = "The reporting officer field is required.";	
			$this->output($Return);
			}
			$dsc_code = $this->input->post('dsc_code');
			$user = $this->Xin_model->read_user_info($session['user_id']);
			$user_dsc_sign = $user[0]->dsc_signature;
			
			if($user_dsc_sign != null){			
			if($dsc_code != null){
				if($dsc_code == '12345678'){
					$result = $this->Sanction_files_model->update_record($data,$id);
					//send_email($data['reporting_officer'],$data['current_employee_id'],$data['file_name'],$data['due_date']);
					$employee = $this->Employees_model->read_employee_information($session['user_id']);
					$data2 = array(
					'file_id' => $id,
					'reporting_officer' => $post_data['reporting_officer'],
					'employee_id' => $post_data['employee_id'],
					'employee_signature_id' => $session['user_id'],
					'signature' => $employee[0]->dsc_signature,
					'created_at' => date("Y-m-d H:i:s"),
					);
					$result_signature = $this->Files_model->add_files_signature($data2);
					if($result_signature == true){$Return['result'] = 'DSC Code is Matched.';}	
				}else{
						$Return['error'] = 'DSC Code is Incorrect.';
						$this->output($Return);
						exit;
					}
			}else{
						$Return['error'] = 'Please enter DSC Code to attach e-Sign in file.';
						$this->output($Return);
						exit;				
			}}else{
						$Return['error'] = 'Your DSC signautre is not found. Please contact administrator.';
						$this->output($Return);
						exit;				
			}
		}else{
			$result = $this->Sanction_files_model->update_record($data,$id);
			//send_email($data['reporting_officer'],$data['current_employee_id'],$data['file_name'],$data['due_date']);

		}
		// $result_file_out = $this->Files_out_model->add($data);	
		if($result == TRUE){
		$data2 = array(
        'file_name' => $post_data['file_name'],
        'file_id' => $id,
        'file_type' => $post_data['file_type'],
        'due_date' => $post_data['due_date'],
        'subject_line' => $post_data['subject_line'],
        'description' => $post_data['description'],
        'status' => $post_data['status'],
        'priority' => $post_data['priority'],
        'file_delivery_mode' => $post_data['file_delivery_mode'],
		'current_employee_id' => $session['user_id'],
        'reporting_officer' => $post_data['reporting_officer'],
		'attachment_file' => $fname_receipt,
        'employee_id' => $post_data['employee_id'],
        'remark' => $post_data['remark'],
        'is_active' => '1',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
        );  	
		$result_file_out = $this->Files_out_model->add($data2);
		foreach($_FILES['file']['tmp_name'] as $key => $tmp_name){
			$allowed =  array('pdf','docx','jpeg','doc','jpg','xlsx','csv');
			$filename = $_FILES['file']['name'][$key];
			$_FILES['file']['size'][$key] == 20000000;
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if(in_array($ext,$allowed)){
			$tmp_name = $_FILES["file"]["tmp_name"][$key];
			$bill_copy = "./uploads/files/";
			$lname 	= basename($_FILES["file"]["name"][$key]);
		//	$newfilename = $post_data['file_name']."_".$key."_".round(microtime(true)).'.'.$ext;
			$newfilename = $lname;
			move_uploaded_file($tmp_name, $bill_copy.$newfilename);
			$fname = $newfilename;
			//$get_files_id = $this->Files_model->get_files_id();			
			$data1 = array(
			'file_id' => $id,
			'reporting_officer' => $post_data['reporting_officer'],
			'employee_id' => $post_data['employee_id'],
			'current_employee_id' => $session['user_id'],
			'attachment_file' => $fname,
			'created_at' => date("Y-m-d H:i:s"),
			);
			
			$result_upload = $this->Files_model->add_files_upload($data1);
	
			}
		} 

/*			$employee_signature_id = $this->Sanction_files_model->read_employee_file_information($id,$session['user_id']); 

			if($employee_signature_id == 0){
			$employee = $this->Employees_model->read_employee_information($reporting_officer_id);
			$data2 = array(
			'file_id' => $id,
			'reporting_officer' => $post_data['reporting_officer'],
			'employee_id' => $post_data['employee_id'],
			'employee_signature_id' => $session['user_id'],
			'signature' => $employee[0]->signature,
			'created_at' => date("Y-m-d H:i:s"),
			);
			$result_signature = $this->Files_model->add_files_signature($data2); 
			}
*/		}
        if ($result == TRUE) {
            $Return['result'] = 'File updated.';
        } else {
            $Return['error'] = 'Bug. Something went wrong, please try again.';
        }
        $this->output($Return);
        exit;
		}
	}
	
	}
	
	
	
}
