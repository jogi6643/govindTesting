<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['id']) && $_GET['data']=='edit_sanction_file'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $all_file_type = $this->Templates_model->all_file_type(); ?>
<?php $all_reporting_officer = $this->Employees_model->all_employee_name(); ?>
<?php $report = $this->Xin_model->reporting_officer($session['user_id']);?>
<?php $all_reporting_employees = $this->Xin_model->all_reporting_employees(); ?>
<?php $result_upload = $this->Files_model->read_file_information_upload($id); ?>
<?php $user_id = $session['user_id'];?> 
 <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Edit File</h4>
</div>
<form class="m-b-1" action="<?php echo site_url("sanction_files/update").'/'.$id; ?>" method="post" name="edit_sanction_file" id="edit_sanction_file">
<?php
	$csrf=array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
?>
   <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>"/>
  <input type="hidden" name="_method" value="EDIT">
  <input type="hidden" name="_token" value="<?php echo "ID:". $id;?>">
  <input type="hidden" name="employee_id" value="<?php echo $employee_id;?>">


  <div class="modal-body">
        <div class="row">
		       <div class="col-md-3">
				<div class="form-group">
				 <label for="file_name">File No</label>
              <input class="form-control" placeholder="File No" name="file_name" type="text" value="<?php echo $file_name;?>" readonly>
            </div>
          </div>
		  
          <div class="col-md-3">
            <div class="form-group">
              <label for="file_type">File Template</label>
              <input class="form-control" placeholder="File Template" name="file_type" type="text" value="<?php echo $file_type;?>" readonly> 
            <!--<select id="select2" class="form-control" name="file_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_file_type');?>">
                        <option value="">Choose File Type</option>						  
                        <?php foreach($all_file_type as $row){?>
                          <option value="<?php echo $row->file_type; ?>"><?php echo $row->file_type; ?></option>
                        <?php } ?>
                        </select>-->
			</div>
          </div>
		  
			   <div class="col-md-3">
				<div class="form-group">
				 <label for="status">Status</label>
			<!--	<input class="form-control" placeholder="Status" name="status" type="text" value="<?php echo $status;?>" readonly> -->
				<select id="status" class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_file_status');?>">
                        <option value="">Choose File Status</option>						  
                        <option <?php if($status == 'In process'):?> selected <?php endif;?> value="In process">In process</option>						  
                        <option <?php if($status == 'Approved'):?> selected <?php endif;?> value="Approved">Approved</option>						  
                        <option <?php if($status == 'On Hold'):?> selected <?php endif;?> value="On Hold">On Hold</option>						  
                        <option <?php if($status == 'Rejected'):?> selected <?php endif;?> value="Rejected">Rejected</option>						  
                        <option <?php if($status == 'Draft'):?> selected <?php endif;?> value="Draft">Draft</option>						  
				</select>
            </div>
          </div>
		  
		  	<div class="col-md-3">
				<div class="form-group">
				<label for="priority">Priority</label>
			<!--	<input class="form-control" placeholder="Priority" name="priority" type="text" value="<?php echo $priority;?>" readonly> -->
				<select id="select2" class="form-control" name="priority" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_priority');?>">
						<option value="">Choose Priority</option>						  
						<option <?php if($priority == 'Normal'):?> selected <?php endif;?> value="Normal">Normal</option>						  
                        <option <?php if($priority == 'Urgent'):?> selected <?php endif;?> value="Urgent">Urgent</option>						  
                        <option <?php if($priority == 'Most urgent'):?> selected <?php endif;?> value="Most urgent">Most urgent</option>						  
                </select>
            </div>
          </div>
        </div>

		<div class="row">
		<div class="col-md-6">
        <div class="form-group">
          <label for="subject_line">Subject Line</label>
            <input class="form-control" placeholder="Subject Line" name="subject_line" type="text" value="<?php echo $subject_line;?>">
        </div>
      </div>
	  
			<div class="col-md-3">
                    <div class="form-group">
					<label for="due_date">Due Date </label>					
                        <input class="form-control" placeholder="Due Date" name="due_date" type="text" value="<?php echo $due_date; ?>" readonly>
						</div>
			</div>
					
			<div class="col-md-3">
                    <div class="form-group">
					<label for="file_delivery_mode">File Delivery Mode</label>					
			<!--	<input class="form-control" placeholder="File Delivery Mode" name="file_delivery_mode"  value="<?php echo $file_delivery_mode; ?>" readonly type="text">
			-->		<select id="select3" class="form-control" name="file_delivery_mode" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_file_priority');?>">
						<option value="">Choose Delivery Mode</option> 
						<option <?php if($file_delivery_mode == 'E-Mail'):?> selected <?php endif;?> value="E-Mail">E-Mail</option>						  
                        <option <?php if($file_delivery_mode == 'Physical'):?> selected <?php endif;?> value="Physical">Physical</option>						  
                        <option <?php if($file_delivery_mode == 'Online'):?> selected <?php endif;?> value="Online">Online</option>						  
                        </select>
						</div>
			</div>	
					
      </div>


<?php $file_log = $this->Files_model->get_files_by_id($id);
	$i= 1;
	foreach($file_log as $file_logs){
	$user = $this->Xin_model->read_user_info($file_logs->current_employee_id);
	$payslip = '<a class="text-success" id="e-file'.$i.'" onclick = "openPdf('.$i.')" value="'.site_url().'sanction_files/pdf_create_id/id/'.$file_logs->id.'/'.$file_logs->file_id.'" href="javascript:void(0)">Notesheet by '.$user[0]->first_name." ".$user[0]->last_name.'</a><br>';
	echo $payslip;
	$i++;
	}
?>
<script>
function openPdf(i)
{
document.getElementById('open_div').style.display="block";
var omyFrame = document.getElementById("e-pdf-iframe");
omyFrame.style.display="block";
omyFrame.src = $('#e-file'+i).attr('value');
// alert(omyFrame.src);


}
</script>



		<div class="row">
			<div class="col-md-8">
			
	  <div class="form-group" style="display:none" id="open_div">
		<label for="reference_attachment_file">Notesheet file</label>		
		  <iframe id="e-pdf-iframe" style="display:none" width="100%" height="325px"></iframe>		
		</div>
		
			<div class="form-group">
				<?php date_default_timezone_set("Asia/Calcutta"); //India time (GMT+5:30) echo date('d-m-Y H:i:s'); ?>
				<?php $employee_name = $this->Employees_model->read_employee_information($user_id);?>		
				<?php $employee_names = $employee_name[0]->first_name." ".$employee_name[0]->last_name;?>
			<label for="description">Main Notesheet Description</label><?php $descriptions = $description;?><?php $description = '<br><br>'.date('d-m-Y H:i:s')." -- ".$employee_names." -- ";?>
<!--			<textarea class="form-control textarea" placeholder="Description" name="description" cols="30" rows="10" id="description2"><?php echo $descriptions;?><?php echo $description;?></textarea>-->
			<textarea class="form-control textarea" placeholder="Description" name="description" cols="30" rows="10" id="description2"></textarea>
        </div>

      </div>
	  
	  <div class="col-md-4">
		  <div class="form-group">
			<a target="_blank" href="<?php echo 'uploads/files/'.$attachment_file;?>"><?php echo $attachment_file;?></a>
			<label for="reference_attachment_file">Reference file</label><br><small>(max upload file size is 20 MB and PDF,Doc & JPEG only)</small>
			<input accept="image/*, application/pdf" name="attachment_file" class="uploadjs form-control" data-id="3" type="hidden" value="<?php echo $attachment_file;?>">
			<input accept="image/*, application/pdf" name="attachment_file1" class="uploadjs form-control" data-id="3" type="file">
		    <?php if(($attachment_file != '') || ($attachment_file != null)){?>
			<embed src="<?php echo 'uploads/files/'.$attachment_file;?>" type="application/pdf" width="100%" height="700px" />
			<?php }else{ ?>
			<p style="border:2px solid; height:700px; padding:10px;" readonly>
			No Reference file uploaded.
			</p>
			<?php } ?>
		</div>
		</div>
					
      </div>
	  
	
	<div class="row">
		<div class="col-md-12">
        <div class="form-group">
          <label for="remark">Remark <small>(This is only for reference)</small></label>
          <textarea class="form-control textarea" placeholder="Remark" name="remark" cols="30" rows="10" id="remark2"><?php echo $remark;?></textarea>
        </div>
      </div>
      </div>

<?php $reporting_officer_hierarchy = $this->Files_model->read_reporting_officer($id); 
if(!empty($reporting_officer_hierarchy)){	
?>
<div class="row">
	<div class="col-md-12">
	<div class="form-group">
	<label for="file_name">File Movement Hierarchy Trail</label><br>
	<?php 
		
		foreach($reporting_officer_hierarchy as $key => $value){
			$user1 = $this->Xin_model->read_user_info($value->current_employee_id);
			$user2 = $this->Xin_model->read_user_info($value->reporting_officer);
			if($session['user_id'] == $value->current_employee_id){
			echo '<strong>'.$user1[0]->first_name." ".$user1[0]->last_name.'</strong>'." -> ";		
			}else{
			echo $user1[0]->first_name." ".$user1[0]->last_name." -> ";	
			
			}
			

		}
		if($session['user_id'] == $value->current_employee_id){
		echo '<strong>'.$user2[0]->first_name." ".$user2[0]->last_name.'</strong>';	
		}else{
		echo $user2[0]->first_name." ".$user2[0]->last_name;			
		}
		?>
	</div>
	</div>
	</div>
<?php } ?>		
		<div class="row">
        
			<div class="col-md-6">
			<div class="field_wrapper">
			<div>
			<div class='form-group'>
			<div><label>Supporting File (Part / Duplicate File)<a href="javascript:void(0);" class="add_button" title="Add Attachment"><img src="<?php echo base_url().'uploads/image/add-icon.png';?>"/></a></label></div>
			<small>(max upload file size is 20 MB and PDF only)</small>
			
			<?php
			foreach($result_upload as $res){ ?>
			<a href="<?php echo base_url().'uploads/files/'.$res->attachment_file;?>" target="_blank">
			<?php echo "<img src=".base_url().'uploads/image/attachment.png'.">".$res->attachment_file ?>
			</a></br>
			<?php }?>
			</div>
			<div class='form-group'>
			<input type="file"  class="form-control" name="file[]" value=""/>
			</div>
			</div>
			</div>	
			</div>	
			
			<?php	
			$reporting_officer = $this->Xin_model->read_user_info($reporting_officer);
			if($reporting_officer != null){
			$reporting_officer_full_name = htmlentities($reporting_officer[0]->first_name). ' '.htmlentities($reporting_officer[0]->last_name);
			}else{
			$reporting_officer_full_name = "";	
			}?>		  
			<div class="col-md-6">
			<div class="form-group">
			<label for="reporting_officer">Reporting Officer</label>
	<!--		<input class="form-control" readonly="readonly" style="border:0" name="reporting_officer" type="text" value="<?php echo $reporting_officer_full_name;?>">
	-->		
					<?php $select_reporting_officer = $this->Files_model->select_reporting_officer($id,$session['user_id']);?>
			
		<select name="reporting_officer" id="select2-demo-6"  data-plugin="select_hrm" class="form-control" data-placeholder="Choose Sanction Officer / Reporting Officer">
			<option value="">Choose Reporting Officer</option>
			<?php if($select_reporting_officer != null){?>
					<?php foreach($all_reporting_employees as $employee) {
					$designation_name = $this->Files_model->get_designation_details($employee->designation_id);
					$location_id = $this->Files_model->get_department_details($employee->department_id);
					$location_name = $this->Files_model->get_location_details($location_id[0]->location_id);
					$des_name = $designation_name[0]->designation_name;
					$loc_name = $location_name[0]->city;  	
					$userid = $employee->user_id;		
			?>					  
		  <option <?php if($select_reporting_officer[0]->reporting_officer == $userid):?> selected <?php endif;?> value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name.' ('.$loc_name. '-' .$des_name.')';?></option>
			<?php } }else{?>
			<?php foreach($all_reporting_employees as $employee) {
					$designation_name = $this->Files_model->get_designation_details($employee->designation_id);
					$location_id = $this->Files_model->get_department_details($employee->department_id);
					$location_name = $this->Files_model->get_location_details($location_id[0]->location_id);
					$des_name = $designation_name[0]->designation_name;
					$loc_name = $location_name[0]->city;  	
					$userid = $employee->user_id;		
			?>					  
	<!--	  <option <?php if($reporting_officer[0]->user_id == $userid):?> selected <?php endif;?> value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name.' ('.$loc_name. '-' .$des_name.')';?></option>
	-->	  <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name.' ('.$loc_name. '-' .$des_name.')';?></option>
			<?php } } ?>
			 
			</select>
			</div>
          </div>
	</div>	  
 
  
  <script type="text/javascript">
function myFunction() {
  var x = document.getElementById("myDIV");
    var y = document.getElementById("myDivButton");
    var z = document.getElementById("myDIV2");
  if (x.style.display === "none") {
    x.style.display = "block";
	y.style.display = "none";
	z.style.display = "none";
	document.getElementById("myBtn").value = "Verification_code_send"; 	
	$('#verification_code').prop('disabled', false);
	$('#dsc_code').prop('disabled', true);
	document.getElementById("myBtn2").value = "";
	//document.getElementById("myBtn33").value = "";
	document.getElementById("myBtn3").value = "";

  }else{
    x.style.display = "none";
	y.style.display = "block";
	document.getElementById("myBtn").value = "";
	// document.getElementById("myBtn2").value = "Without_verification_code_send";
	$('#verification_code').prop('disabled', true);
	$('#dsc_code').prop('disabled', true);
	} 
} 

function myFunction2() {
	var x = document.getElementById("myDIV");
    var y = document.getElementById("myDivButton");
    if (x.style.display === "none") {
    x.style.display = "none";
	y.style.display = "block";
	document.getElementById("myBtn2").value = "Without_verification_code_send";
	$('#verification_code').prop('disabled', true);
			$('#dsc_code').prop('disabled', true);
    }
} 

function myFunction3() {
	var x = document.getElementById("myDIV");
    var y = document.getElementById("myDivButton");
    if (x.style.display === "none") {
    x.style.display = "none";
	y.style.display = "block";
	document.getElementById("myBtn3").value = "Active_reporting_officer_validation";
	$('#verification_code').prop('disabled', true);
		$('#dsc_code').prop('disabled', true);
    }
}

function myFunction4() {
	var x = document.getElementById("myDIV");
    var y = document.getElementById("myDivButton");
    if (x.style.display === "none") {
    x.style.display = "none";
	y.style.display = "block";
	document.getElementById("myBtn3").value = "";
	$('#verification_code').prop('disabled', true);
		$('#dsc_code').prop('disabled', true);
    }
}

function myFunction5() {
	var x = document.getElementById("myDIV");
    var y = document.getElementById("myDivButton");
    var z = document.getElementById("myDIV2");
    if (z.style.display === "none") {
    z.style.display = "block";
	y.style.display = "none";
	document.getElementById("myBtn4").value = "verify_dsc";
	$('#verification_code').prop('disabled', true);
	$('#dsc_code').prop('disabled', false);
//	$("#esign").hide();
//	$("#dsc_esign").hide();
    }else{
	y.style.display = "block";
    x.style.display = "none";
    z.style.display = "none";
	document.getElementById("myBtn4").value = "";
	// document.getElementById("myBtn2").value = "Without_verification_code_send";
	$('#verification_code').prop('disabled', true);
	$('#dsc_code').prop('disabled', true);
	} 
}

 $(function () {
			var status = $('#status').val();
            if (status == "Draft") {
                $("#save").show();
                $("#send").show();
                $("#esign").hide();
				$("#dsc_esign").hide();
                $("#esign_and_submit").hide();
            }else {
                $("#esign").show();
                $("#dsc_esign").show();
				$("#esign_and_submit").show();
				$("#save").hide();
                $("#send").hide();
            }
      //  });
    });
</script>

			<div id="myDIV" style="display:none;"> 
			 <div class="row">						
				<div class="col-md-6">
                    <div class="form-group">
					<!--<label for="verification_code">Enter Verification Code sent on your registered e-mail Id to verify your e-Sign</label> -->					
					<label for="verification_code">Enter Verification Code</label> 				
                        <input class="form-control" placeholder="Verification Code" id="verification_code" name="verification_code" disabled="" type="text">
						<?php 	
						function generateRandomString($length = 6) {
						/*$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';*/
						$characters = '0123456789';
						$charactersLength = strlen($characters);
						$randomString = '';
						for ($i = 0; $i < $length; $i++) {
						$randomString .= $characters[rand(0, $charactersLength - 1)];
						}
						return $randomString;
						}
						$random_string = generateRandomString();
						?>
                        <input class="form-control" placeholder="Random String" name="random_string" value="<?php echo $random_string;?>" type="hidden">
						</div>
                    </div>	
					</div>	
						<button type="submit" class="btn btn-primary">Submit</button>		
						<button type="submit" class="btn btn-primary">Resend Verification Code</button>		
						<input="button" id="cancel_esign" onclick="myFunction()" name="cancel_esign" class="btn btn-primary" value="Cancel e-Sign & Submit" readonly>Cancel
				</div>
			<div id="myDIV2" style="display:none;"> 
						<?php 	
			$user = $this->Xin_model->read_user_info($session['user_id']);
			$user_dsc_sign = $user[0]->dsc_signature;
			if($user_dsc_sign != null){ ?>	
			 <div class="row">						
				<div class="col-md-6">
                    <div class="form-group">
					<!--<label for="verification_code">Enter Verification Code sent on your registered e-mail Id to verify your e-Sign</label> -->					
					<label for="verification_code">Enter DSC Code</label> 				
                        <input class="form-control" placeholder="DSC Code" id="dsc_code" name="dsc_code" disabled="true" type="text">
							  
						</div>
                    </div>	
					</div>	
					<button type="submit" class="btn btn-primary">Submit</button>	
				<?php } ?>	
			<input="button" id="cancel_esign" onclick="myFunction5()" name="cancel_esign" class="btn btn-primary" value="Cancel & Switch to e-Sign & Submit" readonly>Cancel & Switch to e-Sign & Submit
						
						</div>
	</div>  
  
  <div class="modal-footer">	
  <div id="myDivButton">
<!--	<button type="submit" id="save"  onclick="myFunction4()" class="btn btn-primary save" style="display:none;">Save</button> -->
	<button type="submit" id="send" onclick="myFunction3()" class="btn btn-primary save" style="display:none;">Send</button>
	<button id="esign" onclick="myFunction()" name="esign" class="btn btn-primary" style="display:none;">e-Sign & Submit</button>
	<button id="dsc_esign" onclick="myFunction5()" name="dsc_esign" class="btn btn-primary" style="display:none;">DSC & Submit</button>
<!--<button id="esign_and_submit" onclick="myFunction2()" name="esign_and_submit" class="btn btn-primary" style="display:none;">e-Sign & Submit</button> -->	
	<input type="hidden" name="verify" id="myBtn" value="">
	<input type="hidden" name="without_verify" id="myBtn2" value="">
	<input type="hidden" name="send" id="myBtn3" value="">
	<input type="hidden" name="verify_dsc" id="myBtn4" value="">
  <!--  <button type="submit" class="btn btn-primary">Update</button>	-->
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

 </div>	
	</div>
</form>
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/select2/dist/css/select2.min.css">
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/select2/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/ion.rangeSlider/css/ion.rangeSlider.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css">
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/ion.rangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
    var maxField = 15; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div class="form-control"><input type="file" name="file[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="<?php echo base_url().'uploads/image/remove-icon.png';?>"/> Remove</a></div></div><br>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>
<script type="text/javascript">
 $(document).ready(function(){
					
		// On page load: datatable
		var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : "<?php echo site_url("sanction_files/sanction_file_list") ?>",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    	});
		
		// $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		// $('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('#description2').summernote({
		  height: 350,
		  minHeight: null,
		  maxHeight: null,
		  focus: false
		});
		$('#remark2').summernote({
		  height: 200,
		  minHeight: null,
		  maxHeight: null,
		  focus: false
		});
		$('.note-children-container').hide();
		$('.d_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1900:' + (new Date().getFullYear() + 10),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
		});

		/* Edit data */
		// $("#edit_sanction_file").submit(function(e){
		// e.preventDefault();
			// var obj = $(this), action = obj.attr('name');
			// $('.save').prop('disabled', true);
			// //var template = $("#description2").summernote('code');
			// //var template = $("#remark2").summernote('code');
			// var m = $("#description2")["code"]();
			// var n = $("#remark2")["code"]();
			// $.ajax({
			// type: "POST",
				// url: e.target.action,
				// data: obj.serialize()+"&is_ajax=1&edit_type=edit_sanction_file&form="+ action + m + n,
				// cache: false,
				// success: function (JSON) {
					// if (JSON.error != '') {
						// toastr.error(JSON.error);
						// $('.save').prop('disabled', false);
					// } else {
						// xin_table.api().ajax.reload(function(){ 
							// toastr.success(JSON.result);
						// }, true);
						// $('.edit-modal-data').modal('toggle');
						// $('.save').prop('disabled', false);
					// }
				// }
			// });
		// });
	// });	
		$("#edit_sanction_file").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		var description = $("#description2").code();
		var n = $("#remark2")["code"]();
		fd.append("is_ajax", 1);
		fd.append("edit_type", 'edit_sanction_file');
		fd.append("description", description);
		fd.append("remark", n);
		fd.append("form", action);
		e.preventDefault();
		$('.icon-spinner3').show();
		$('.save').prop('disabled', true);
		$.ajax({
			url: e.target.action,
			type: "POST",
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
			success: function(JSON)
			{
				if (JSON.error != '') {
					toastr.error(JSON.error);
						$('.save').prop('disabled', false);
						$('.icon-spinner3').hide();
				} else {
					xin_table.api().ajax.reload(function(){ 
						toastr.success(JSON.result);
					}, true);
					$('.icon-spinner3').hide();
					$('.edit-modal-data').modal('toggle');
					$('.save').prop('disabled', false);
				}
			},
			error: function() 
			{
				toastr.error(JSON.error);
				$('.icon-spinner3').hide();
				$('.save').prop('disabled', false);
			} 	        
	   });
	});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['id']) && $_GET['data']=='view_sanction_file'){?>
<?php $result_upload = $this->Files_model->read_file_information_upload($id); ?>
<?php $session = $this->session->userdata('username');?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View File</h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
        <div class="row">
		    <div class="col-md-3">
				<div class="form-group">
              <label for="file_type">File No.</label>
              <input class="form-control" readonly="readonly" name="file_name" type="text" value="<?php echo $file_name;?>">
            </div>
          </div>
		  
          <div class="col-md-3">
            <div class="form-group">
              <label for="file_type">File Template</label>
              <input class="form-control" readonly="readonly" name="file_type" type="text" value="<?php echo $file_type;?>">
            </div>
          </div>
		      <div class="col-md-3">
				<div class="form-group">
              <label for="status">Status</label>
              <input class="form-control" readonly="readonly" name="status" type="text" value="<?php echo $status;?>">
            </div>
          </div>
		  <div class="col-md-3">
				<div class="form-group">
              <label for="priority">Priority</label>
              <input class="form-control" readonly="readonly" name="priority" type="text" value="<?php echo $priority;?>">
            </div>
          </div>
		  
        </div>
				
		<div class="row">
         <div class="col-md-6">
			<div class="form-group">
			<label for="subject_line">Subject Line</label><br />
              <input class="form-control" readonly="readonly" name="subject_line" type="text" value="<?php echo $subject_line;?>">
			</div>
          </div>
		  <div class="col-md-3">
                    <div class="form-group">
					<label for="subject_line">Due Date </label>					
                        <input class="form-control" placeholder="Due Date" name="due_date"  value="<?php echo $due_date; ?>" readonly type="text">
						</div>
                    </div>	
					
					<div class="col-md-3">
                    <div class="form-group">
					<label for="Online">File Delivery Mode </label>					
                        <input class="form-control" placeholder="File Delivery Mode" name="file_delivery_mode"  value="<?php echo $file_delivery_mode; ?>" readonly type="text">
						</div>
                    </div>	
	  </div>	

<?php $file_log = $this->Files_model->get_files_by_id($id);
	$i= 1;
	foreach($file_log as $file_logs){
	$user = $this->Xin_model->read_user_info($file_logs->current_employee_id);
	$payslip = '<a class="text-success" id="e-file'.$i.'" onclick = "openPdf('.$i.')" value="'.site_url().'sanction_files/pdf_create_id/id/'.$file_logs->id.'/'.$file_logs->file_id.'" href="javascript:void(0)">Notesheet by '.$user[0]->first_name." ".$user[0]->last_name.'</a><br>';
	echo $payslip;
	$i++;
	}
?>

<script>
function openPdf(i)
{
document.getElementById('open_div').style.display="block";
var omyFrame = document.getElementById("e-pdf-iframe");
omyFrame.style.display="block";
omyFrame.src = $('#e-file'+i).attr('value');
// alert(omyFrame.src);


}
</script>

		<div class="row">
         <div class="col-md-8">
		 
	  <div class="form-group" style="display:none" id="open_div">
		<label for="reference_attachment_file">Notesheet file</label>		
		  <iframe id="e-pdf-iframe" style="display:none" width="100%" height="325px"></iframe>		
		</div>
		
        <div class="form-group">
          <label for="description">Main Notesheet Description</label><br />
          <?php echo html_entity_decode($description);?>
		</div>
          </div>
	  <div class="col-md-4">
		  <div class="form-group">
			<a target="_blank" href="<?php echo 'uploads/files/'.$attachment_file;?>"><?php echo $attachment_file;?></a>
			<label for="reference_attachment_file">Reference file</label>
			<input accept="image/*, application/pdf" name="attachment_file" class="uploadjs form-control" data-id="3" type="hidden" value="<?php echo $attachment_file;?>">
		    <?php if(($attachment_file != '') || ($attachment_file != null)){?>
			<embed src="<?php echo 'uploads/files/'.$attachment_file;?>" type="application/pdf" width="100%" height="525px" />
			<?php }else{ ?>
			<p style="border:2px solid; height:525px; padding:10px;" readonly>
			No Reference file uploaded.
			</p>
			<?php } ?>
		</div>
		</div>
		</div>
	

		
		
		<div class="row">
         <div class="col-md-12">
			<div class="form-group">
			<label for="remark">Remark <small>(This is only for reference)</small></label><br />
			<?php echo html_entity_decode($remark);?>
			</div>
          </div>
        </div>
<?php $reporting_officer_hierarchy = $this->Files_model->read_reporting_officer($id); 
if(!empty($reporting_officer_hierarchy)){	
?>
<div class="row">
	<div class="col-md-12">
	<div class="form-group">
	<label for="file_name">File Movement Hierarchy Trail</label><br>
	<?php 
		
		foreach($reporting_officer_hierarchy as $key => $value){
			$user1 = $this->Xin_model->read_user_info($value->current_employee_id);
			$user2 = $this->Xin_model->read_user_info($value->reporting_officer);
			if($session['user_id'] == $value->current_employee_id){
			echo '<strong>'.$user1[0]->first_name." ".$user1[0]->last_name.'</strong>'." -> ";		
			}else{
			echo $user1[0]->first_name." ".$user1[0]->last_name." -> ";	
			
			}
			

		}
		if($session['user_id'] == $value->current_employee_id){
		echo '<strong>'.$user2[0]->first_name." ".$user2[0]->last_name.'</strong>';	
		}else{
		echo $user2[0]->first_name." ".$user2[0]->last_name;			
		}
		?>
	</div>
	</div>
	</div>
<?php } ?>	
	   <div class="row">

			<div class="col-md-6">
			<div class='form-group'>
			<div><label>Supporting File (Part / Duplicate File)</label></div>
			<?php foreach($result_upload as $res){ ?>
			<a href="<?php echo base_url().'uploads/files/'.$res->attachment_file;?>" target="_blank">
			<?php echo "<img src=".base_url().'uploads/image/attachment.png'.">".$res->attachment_file ?>
			</a></br>
			<?php }?>
			</div>
			</div>	

			<?php	
			$reporting_officer = $this->Xin_model->read_user_info($reporting_officer);
			if($reporting_officer != null){
			$reporting_officer_full_name = htmlentities($reporting_officer[0]->first_name). ' '.htmlentities($reporting_officer[0]->last_name);
			}else{
			$reporting_officer_full_name = "";	
			}?>			
			<div class="col-md-6">
			<div class="form-group">
			<label for="reporting_officer">Reporting Officer</label>
			<input class="form-control" readonly="readonly" name="reporting_officer" type="text" value="<?php echo $reporting_officer_full_name;?>">
			</div>
			</div>		
        
		</div>
				
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  </div>
</form>
<?php }
?>
