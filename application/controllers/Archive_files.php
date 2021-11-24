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

class Archive_files extends MY_Controller {
	
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
		$this->load->model("Sanction_files_model");
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
		$data['breadcrumbs'] = 'Archive Files';
		$data['path_url'] = 'archive_files';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('102',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("e-file/archive_files", $data, TRUE);
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
		$tbl .= $r->created_at." -- ".$user[0]->first_name. " ".$user[0]->last_name." -- ".'<br>'; 
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
	
	// create pdf - file
		 public function file_list_pdf() {
		 
		$this->load->library('Pdf');
		 // create new PDF document
   		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$id = $this->uri->segment(4);
		//$payment = $this->Payroll_model->read_make_payment_information($id);
		// $user = $this->Xin_model->read_user_info($payment[0]->employee_id);
		// $_des_name = $this->Designation_model->read_designation_information($user[0]->designation_id);
		// $department = $this->Department_model->read_department_information($user[0]->department_id);
		// $location = $this->Xin_model->read_location_info($department[0]->location_id);
		// // company info
		// $company = $this->Xin_model->read_company_info($location[0]->company_id);
		$footer_string = "DCI";
		$system = $this->Xin_model->read_setting_info(1);
		$file = $this->Files_model->get_files_list_download();	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
	
		// set document information
		$pdf->SetCreator('Workable-Zone');
		$pdf->SetHeaderData('../../../uploads/logo/payroll/'.$system[0]->payroll_logo, 40, $system[0]->application_name, '');
		$pdf->setFooterData($footer_string);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array('helvetica', '', 11.5));
		$pdf->setFooterFont(Array('helvetica', '', 8));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont('courier');
		
		// set margins
		$pdf->SetMargins(15, 27, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);
		
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 25);
		
		// set image scale factor
		$pdf->setImageScale(1.25);
		$pdf->SetAuthor('DCI');
		$pdf->SetTitle($system[0]->application_name.' E-file-DCI');
		$pdf->SetSubject('Payslip');
		$pdf->SetKeywords('Payslip');
		// set font
		$pdf->SetFont('helvetica', 'B', 11);
		
		// add a page
		$pdf->AddPage();
		
		$pdf->SetFont('helvetica', '', 10);
		
		// -----------------------------------------------------------------------------

		$tbl = '
		<h1>List of Files</h1>
		<table cellpadding="1" cellspacing="1" border="1" align="center">
		<tr>
			<td><strong>Employee</strong></td>
			<td><strong>File Name</strong></td>
			<td><strong>Subject Line</strong></td>
			<td><strong>Current Status</strong></td>
			<td><strong>Current Sanction Officer</strong></td>
			<td><strong>Last Update</strong></td>
		</tr>';
		
	foreach($file->result() as $r){
		$user = $this->Xin_model->read_user_info($r->employee_id);
		$full_name = htmlentities($user[0]->first_name). ' '.htmlentities($user[0]->last_name);
		$reporting_officer = $this->Xin_model->read_user_info($r->reporting_officer);
		$reporting_officer_full_name = htmlentities($reporting_officer[0]->first_name). ' '.htmlentities($reporting_officer[0]->last_name);	
		
		$tbl .='<tr>
				<td>'.$full_name.'</td>
				<td>'.$r->file_name.'</td>
				<td>'.$r->subject_line.'</td>
				<td>'.$r->status.'</td>
				<td>'.$reporting_officer_full_name.'</td>
				<td>'.$r->updated_at.'</td>
				</tr>';
	}
		$tbl .='</table>';
		
		$pdf->writeHTML($tbl, true, false, false, false, '');
		//Close and output PDF document
		$pdf->Output('e-file'.'_'.'file_list'.'_'.date('Y-m-d').'.pdf', 'D');		  
     }
	
    public function file_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("e-file/archive_files", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		//print_r($session);die;
		//$travel = $this->Travel_model->get_travel();
		// $role_id = $session['user_role_id'];
		// print_r($role_id);die;
		
		 if($session['user_role_id'] == 1){
		 $file = $this->Files_model->get_archive_files();	
		 }else{
		 $file = $this->Files_model->get_archive_files_user($session['user_id']);
		 }
		
		
		$data = array();
        foreach($file->result() as $r) {
		
		$user = $this->Xin_model->read_user_info($r->employee_id);
		$full_name = htmlentities($user[0]->first_name). ' '.htmlentities($user[0]->last_name);
		$reporting_officer = $this->Xin_model->read_user_info($r->reporting_officer); 
		$reporting_officer_full_name = "";
		if($reporting_officer != null){
		$reporting_officer_full_name = htmlentities($reporting_officer[0]->first_name). ' '.htmlentities($reporting_officer[0]->last_name);
		}
		$payslip = '<a class="text-success" href="'.site_url().'archive_files/pdf_create/id/'.$r->id.'/">Download</a>';
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
			// '<span data-toggle="tooltip" data-placement="top" title="Edit"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-id="'. $r->id  . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="View"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-id="'. $r->id . '"><i class="fa fa-eye"></i></button></span><a href="javascript:void(0);" onclick="deletep('.$r->id.');" title="Delete"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal"><i class="fa fa-trash-o"></i></button></a>',
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
	
	public function get_template(){
	$data['title'] = $this->Xin_model->site_title();
	$file_type = $this->input->post('file_type');
	$data = $this->Files_model->get_template($file_type);
	//print_r($data);
	$pro_select_box  ="";

		foreach ($data as $row){
			//print_r($row->template);
			$pro_select_box .=html_entity_decode("$row->template");
		}	
		echo $pro_select_box;
	}

	public function get_reporting_officer(){
	$data['title'] = $this->Xin_model->site_title();
	$session = $this->session->userdata('username');	

	$selection_dropdown = $this->input->post('selection_dropdown');
	$user_id = $session['user_id'];	
	$department_id = $this->Files_model->get_user_details($user_id);
	if($selection_dropdown == '1'){
	$data = $this->Files_model->get_all_user_by_department($department_id[0]->department_id,$user_id);
	}
	if($selection_dropdown == '2'){
	$data = $this->Files_model->get_all_user();
	}
	if(count($data) == 0){
		$pro_select_box = "";
		$pro_select_box = "<option value='0'>No Reporting officer found </option>";
		echo $pro_select_box;
	}
	if(count($data) > 0){
		$pro_select_box  ="<option value=''>Choose Reporting Officer</option>";
		foreach ($data as $row){
				$designation_name = $this->Files_model->get_designation_details($row->designation_id);
				$location_id = $this->Files_model->get_department_details($row->department_id);
				$location_name = $this->Files_model->get_location_details($location_id[0]->location_id);
				$des_name = $designation_name[0]->designation_name;
				$loc_name = $location_name[0]->city;
			$pro_select_box .="<option value='$row->user_id'>$row->first_name $row->last_name ($loc_name - $des_name)</option>";
		}	
		echo $pro_select_box;
	}
	}
	
	 public function read()
	{	
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('id');
		$result = $this->Files_model->read_file_information($id);
		//$result_upload = $this->Files_model->read_file_information_upload($id);
		
		$reporting_officer = $this->Xin_model->read_user_info($result[0]->reporting_officer);
		$reporting_officer_full_name = htmlentities($reporting_officer[0]->first_name). ' '.htmlentities($reporting_officer[0]->last_name);

		$data = array(
				'id' => $result[0]->id,
				// 'counter' => $result[0]->counter,
				'employee_id' => $result[0]->employee_id,
				'file_name' => $result[0]->file_name,
				'file_type' => $result[0]->file_type,
				'due_date' => $result[0]->due_date,
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
			$this->load->view('e-file/dialog_archive_files', $data);
		} else {
			redirect('');
		}
	}

}