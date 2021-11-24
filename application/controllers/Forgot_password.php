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
 * @package  Workable Zone - Forgot Password
 * @author-email  workablezone@gmail.com
 * @copyright  Copyright 2017 © workablezone.com. All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller {

	public function __construct() {
        Parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		//load the model
		$this->load->model("Payroll_model");
		$this->load->model("Xin_model");
		$this->load->model("Employees_model");
		$this->load->model("Designation_model");
		$this->load->model("Department_model");
		$this->load->model("Location_model");
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
		$data['title'] = 'e-File Management System';
		$this->load->view('user/forgot_password', $data);
	}
	
	public function send_mail()
	{
		$data['title'] = 'e-File Management System';
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
		/* Server side PHP input validation */
		if($this->input->post('iemail')==='') {
			$Return['error'] = "Please enter your email.";
		} else if (!filter_var($this->input->post('iemail'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = "Invalid email format";
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		
		function generateRandomString($length = 10) {
			 $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			 $charactersLength = strlen($characters);
			 $randomString = '';
			 for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			 }
			 return $randomString;
		}
		
		if($this->input->post('iemail')) {
	
			$this->load->library('email');
			$this->email->set_mailtype("html");
			//get company info
			$cinfo = $this->Xin_model->read_company_setting_info(1);
			//get email template
			$template = $this->Xin_model->read_email_template(2);
			//get employee info
			$query = $this->Xin_model->read_user_info_byemail($this->input->post('iemail'));			
			$user = $query->num_rows();
			if($user > 0) {				
				$user_info = $query->result();
				$user_email = $user_info[0]->email;
				$random_string = generateRandomString();
				$password_md5 = md5($random_string);
				$data = array(
				'password' => $password_md5,
				);
				$password_change = $this->Xin_model->update_employee_password($user_email,$data);
				
				$full_name = $user_info[0]->first_name.' '.$user_info[0]->last_name;
				
				$subject = $template[0]->subject.' - '.$cinfo[0]->company_name;
				$logo = base_url().'uploads/logo/'.$cinfo[0]->logo;
				$cid = $this->email->attachment_cid($logo);

				$message = '
					<div style="background:#f6f6f6;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;padding: 20px;">
					<img src="'.$logo.'" title="'.$cinfo[0]->company_name.'"><br>'.str_replace(array("{var site_name}","{var username}","{var email}","{var password}"),array($cinfo[0]->company_name,$user_info[0]->username,$user_info[0]->email,$random_string),htmlspecialchars_decode(stripslashes($template[0]->message))).'</div>';
	
				$this->email->from($cinfo[0]->email, $cinfo[0]->company_name); 
				$this->email->from('himanshu.sharma0756@gmail.com'); 
				$this->email->set_newline("\r\n");
				$this->email->to($this->input->post('iemail'));
				
				$this->email->subject($subject);
				$this->email->message($message);
				if($this->email->send()){
					$Return['result'] = 'Password has been sent to your email address.';
				}else{$Return['error'] = "e-Mail doesn't send to given email address."; }
			} else {
				/* Unsuccessful attempt: Set error message */
				$Return['error'] = "Email address doesn't exist.";
			}
			$this->output($Return);
			exit;
		}
	}
}
