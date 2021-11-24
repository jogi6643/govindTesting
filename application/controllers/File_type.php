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

class File_type extends MY_Controller {
	
	 public function __construct() {
        Parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		//load the model
		//$this->load->model("Travel_model");
		$this->load->model("File_type_model");
		$this->load->model("Xin_model");
		$this->load->model("Department_model");
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
		$data['all_departments'] = $this->Department_model->all_departments();
		$data['get_all_file_type'] = $this->File_type_model->get_all_file_type();
		$data['breadcrumbs'] = 'File Type';
		$data['path_url'] = 'file_type';
		$session = $this->session->userdata('username');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('100',$role_resources_ids)) {
			if(!empty($session)){ 
			$data['subview'] = $this->load->view("e-file/file_type", $data, TRUE);
			$this->load->view('layout_main', $data); //page load
			} else {
				redirect('');
			}
		} else {
			redirect('dashboard/');
		}
     }
 
    public function file_type_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("e-file/file_type", $data);
		} else {
			redirect('');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		//$travel = $this->Travel_model->get_travel();
		
				
		// if($session['user_id'] == 34){
		$file_type = $this->File_type_model->get_all_file_type();	
		// }else{
		// $file_type = $this->File_type_model->get_file_type($session['user_id']);
		// }
		
		$data = array();
        foreach($file_type->result() as $r) {
		$data[] = array(
			'<span data-toggle="tooltip" data-placement="top" title="Edit"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-id="'. $r->id  . '"><i class="fa fa-pencil-square-o"></i></button></span><span data-toggle="tooltip" data-placement="top" title="View"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-id="'. $r->id . '"><i class="fa fa-eye"></i></button></span><a href="javascript:void(0);" onclick="deletep('.$r->id.');" title="Delete"><button type="button" class="btn btn-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal"><i class="fa fa-trash-o"></i></button></a>',
			$r->file_type,
			$r->created_at,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $file_type->num_rows(),
			 "recordsFiltered" => $file_type->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('id');
		$result = $this->File_type_model->read_file_type_information($id);
		$data = array(
				'id' => $result[0]->id,
				'department_id' => $result[0]->department_id,
				'file_type' => $result[0]->file_type
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('e-file/dialog_file_type', $data);
		} else {
			redirect('');
		}
	}
	
	// Validate and add info in database
	public function add_file_type() {
	
		if($this->input->post('add_type')=='file_type') {		
		
		$post_data = $this->input->post();
		$post_data=$this->security->xss_clean($post_data);
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
			
		/* Server side PHP input validation */
		$file_type = $post_data['file_type'];
		//$created_at = date("Y-m-d h:i:sa");
		
		if($this->input->post('file_type')==='') {
        	$Return['error'] = "The file type field is required.";
		} 				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	                                   
		$data = array(
		'file_type' => $post_data['file_type'],
		'department_id' => $post_data['department_id'],
		'is_active' => '1',
		'created_at' => date("Y-m-d h:i:sa")
		);
		$result = $this->File_type_model->add($data);
		if ($result == TRUE) {
			$Return['result'] = 'File Type added.';
		} else {
			$Return['error'] = 'Bug. Something went wrong, please try again.';
		}
		$this->output($Return);
		exit;
		}
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='edit_file_type') {
			
		$post_data = $this->input->post();
	    $post_data=$this->security->xss_clean($post_data);
			
		$id = $this->uri->segment(3);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'');
			
		/* Server side PHP input validation */
		$file_type = $post_data['file_type'];
		
		if($this->input->post('file_type')==='') {
        	$Return['error'] = "The file type field is required.";
		} 				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'file_type' => $post_data['file_type'],
		'department_id' => $post_data['department_id'],
		);
		
		$result = $this->File_type_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = 'File Type updated.';
		} else {
			$Return['error'] = 'Bug. Something went wrong, please try again.';
		}
		$this->output($Return);
		exit;
		}
	}
	
	
	
	public function delete() { 
		
		$id=$this->input->post('id');
		$update = $this->File_type_model->delete_record($id);
        if ($update) {
			$Return['result'] = 'File Type deleted.';
			$this->output($Return);
	            echo 1;
        } else {
            echo 0;
			$Return['error'] = 'Bug. Something went wrong, please try again.';
			$this->output($Return);
        }
    }	
	
}
