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
 * @package  Workable Zone - Login
 * @copyright  Copyright © workablezone.com. All Rights Reserved
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct()
     {
          parent::__construct();
          $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->database();
          $this->load->library('form_validation');
          //load the login model
          $this->load->model('Login_model');
		  $this->load->model('Employees_model');
     }
	 
	public function login() {
	
		$this->form_validation->set_rules('iusername', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ipassword', 'Password', 'trim|required|xss_clean');
		$Return = array('result'=>'', 'error'=>'');
		
		$username = $this->input->post('iusername');
		$password = $this->input->post('ipassword');
		$captcha = $this->input->post('captcha');
		$captcha_code = $this->input->post('captcha_code');
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
		
		/* Server side PHP input validation */
		if($username != 'pravonly4you@gmail.com'){
		if($username==='') {
			$Return['error'] = "Username field is required.";
		}elseif(strlen($username) > 50){
			$Return['error'] = "Username field should not more than 50 characters";		
		}elseif(strlen($username) < 10){
			$Return['error'] = "Username field should more than 10 characters";			
		} 
		// else if (!preg_match('#@nic.in#', $username)){
			// $Return['error'] = "Email along with @nic.in is only allowed.";
		// }
		// else if (!preg_match('#@dcil.co.in#', $username)){
			// $Return['error'] = "Email along with @dcil.co.in is only allowed.";
		// }
		elseif($password===''){
			$Return['error'] = "Password field is required.";
		}elseif(strlen($password) > 15){
			$Return['error'] = "Password field should not more than 15 characters";		
		}elseif($captcha==='') {
			$Return['error'] = "Captcha field is required.";
		}elseif($captcha != $captcha_code) {
			$Return['error'] = "Invalid Captcha. Please try again.";
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		}else{
		if($username==='') {
			$Return['error'] = "Username field is required.";
		}elseif(strlen($username) > 50){
			$Return['error'] = "Username field should not more than 50 characters";		
		}elseif(strlen($username) < 10){
			$Return['error'] = "Username field should more than 10 characters";			
		}elseif($password===''){
			$Return['error'] = "Password field is required.";
		} elseif(strlen($password) > 15){
			$Return['error'] = "Password field should not more than 15 characters";		
		}elseif($captcha==='') {
			$Return['error'] = "Captcha field is required.";
		}elseif($captcha != $captcha_code) {
			$Return['error'] = "Invalid Captcha. Please try again.";
		}
		
		if($Return['error']!=''){
			$this->output($Return);
		}
		}
		
		$data = array(
			'username' => $username,
			'password' => md5($password)
			);
		$result = $this->Login_model->login($data);	
		
		if ($result == TRUE) {
			
				$result = $this->Login_model->read_user_information($username);
				$session_data = array(
				'user_id' => $result[0]->user_id,
				'username' => $result[0]->username,
				'email' => $result[0]->email,
				'user_role_id' => $result[0]->user_role_id,
				);
				// Add user data in session
				$this->session->set_userdata('username', $session_data);
				$Return['result'] = 'Logged In Successfully.';
				
				// update last login info
				$ipaddress = $this->input->ip_address();
				  
				 $last_data = array(
					'last_login_date' => date('d-m-Y H:i:s'),
					'last_login_ip' => $ipaddress,
					'is_logged_in' => '1'
				); 
				
				$id = $result[0]->user_id; // user id
				  
				$this->Employees_model->update_record($last_data, $id);
				$this->output($Return);
				
			} else {
				$Return['error'] = "Invalid Login Credential.";
				/*Return*/
				$this->output($Return);
			}
		}
} 
?>