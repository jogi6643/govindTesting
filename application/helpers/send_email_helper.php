<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function send_email($reporting_officer,$current_officer,$file_no,$due_date){
	if($reporting_officer != null || $reporting_officer != ""){
	$CI =& get_instance();
	$employee = $CI->Employees_model->read_employee_information($reporting_officer);
	$current_employee = $CI->Employees_model->read_employee_information($current_officer);
	$to = $employee[0]->username;
	// $cc = $session['email'];
	$CI->load->library('email');
	$CI->email->set_mailtype("html");

	$subject = "DCIL e-office File No: ".$file_no;
	$message = "Dear ".$employee[0]->first_name." ".$employee[0]->last_name.'<br><br>';
	$message .= $current_employee[0]->first_name." ".$current_employee[0]->last_name." has send the file( File No:".$file_no." & "."Due date:".$due_date." ) for your review & kindly login in eoffice for check & revert.";
	$message .= '<br><br>'."Thanks & Regards".'<br>';		
	$message .= "DCIL Webteam";		
	$CI->email->from('eoffice@dcil.co.in'); 
	$CI->email->set_newline("\r\n");
	$CI->email->to($to);
	// $this->email->cc($cc);
		
	$CI->email->subject($subject);
	$CI->email->message($message);
	//print_r($message);
	//die();
	$CI->email->send();
	}
}
?>

