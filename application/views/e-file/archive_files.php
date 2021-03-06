<?php
/* Files view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $all_reporting_officer = $this->Employees_model->all_employee_name(); ?>
<?php $report = $this->Xin_model->reporting_officer($session['user_id']);?>
<?php $file = $this->Templates_model->all_file_type(); ?>	

	<!--<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
	<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>-->
	<!--    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.js"></script> -->


<div class="add-form" style="display:none;">
  <div class="box box-block bg-white">
    <h2><strong>Add New</strong> File 			
      <div class="add-record-btn">
        <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-minus icon"></i> Hide</button>
      </div>
    </h2>
    <div class="row m-b-1">
      <div class="col-md-12">
        <form action="<?php echo site_url("files/add_file") ?>" method="post" name="add_file" id="xin-form">
		<?php
	$csrf=array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
?>
   <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>"/>
	<input type="hidden" name="user_id" value="<?php echo $session['user_id'];?>">		  
	  <input type="hidden" name="employee_id" value="<?php echo $session['user_id'];?>">
	<!--	<input type="hidden" name="counter" value="<?php echo $counter;?>"> -->

		  
          <div class="bg-white">
            <div class="box-block">
               <div class="row">
				<div class="col-md-2">
                    <div class="form-group">
					<label for="file_name">File No.</label>
						<?php
						$user = $this->Xin_model->read_user_info($session['user_id']);
						$department = $this->Department_model->read_department_information($user[0]->department_id);
						$department_name = $department[0]->department_name;
						$file_no = substr($department_name, 0, 3)."/"."file"."/".date('Y')."/";
						?>	
                        <input class="form-control" placeholder="File No." id="file_name" name="file_name" value="<?php echo $file_no; ?>" readonly type="text">
						</div>
                    </div>
					<div class="col-md-1">
					<input class="form-control" style="margin: 26px 0 0px 0px;" id="auto_number" name="auto_number" placeholder="File No" type="text">
					</div>
                    
					<div class="col-md-3">
                      <div class="form-group">
					<label for="file_type">File Template</label>					
					<select id="file_type" class="form-control" name="file_type"  data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_file_type');?>">
                        <option value="">Choose File Template</option>						  
                        <?php foreach($all_file_type as $row){?>
                          <option value="<?php echo $row->file_type; ?>"><?php echo $row->file_type; ?></option>
                        <?php } ?>
                        </select>
						</div>
                    </div>
					
					<div class="col-md-3">
                    <div class="form-group">
					<label for="status">Status</label>					
					<select id="status" class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_file_status');?>">
                        <option value="">Choose File Status</option>						  
                        <option value="In process">In process</option>						  
                        <option value="Approved">Approved</option>						  
                        <option value="On Hold">On Hold</option>						  
                        <option value="Rejected">Rejected</option>
						<option value="Draft">Draft</option>						
                        </select>
						</div>
                    </div>	
					
					<div class="col-md-3">
                    <div class="form-group">
					<label for="priority">Priority</label>					
					<select id="select2" class="form-control" name="priority" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_file_priority');?>">
                        <option value="">Choose Priority</option>		
						<option value="Normal">Normal</option>						  
                        <option value="Urgent">Urgent</option>						  
                        <option value="Most urgent">Most urgent</option>						  
                        </select>
						</div>
                    </div>		
					
                </div>
				
               <div class="row">
				<div class="col-md-6">
                    <div class="form-group">
					<label for="subject_line">Subject of File </label>					
                        <input class="form-control" placeholder="Subject of File" name="subject_line" type="text">
						</div>
                    </div>	
					<div class="col-md-3">
                    <div class="form-group">
					<label for="due_date">Due Date </label>					
                        <input class="form-control" id="datepicker" placeholder="Due Date" name="due_date" type="text">
						</div>
                    </div>	
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script type="text/javascript">
$(function() {
    $( "#datepicker" ).datepicker({ minDate: 0});
  });
</script>					
					<div class="col-md-3">
                    <div class="form-group">
					<label for="file_delivery_mode">File Delivery Mode</label>					
                        <select id="select3" class="form-control" name="file_delivery_mode" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_file_priority');?>">
                         <option value="">Choose Delivery Mode</option>
						<option value="E-Mail">E-Mail</option>						  
                        <option value="Physical">Physical</option>						  
                        <option value="Online">Online</option>						  
                        </select>
						</div>
                    </div>	


					
					</div>
					
				<div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
						<label for="description">Notesheet</label>
                    <textarea class="form-control textarea" placeholder="Description" name="description" cols="60" rows="20" id="description" disabled></textarea>
						</div>
					</div>
					
					<div class="col-md-4">
                      <div class="form-group">
						<label for="remark">Reference file</label><input accept="image/*, application/pdf" name="attachment_file1" class="uploadjs form-control" data-id="3" type="file">
					  <iframe id="preview-3_1" src="" style="width:100%; height:500px;" frameborder="1" scrolling="yes">
						<p>Your web browser doesn't support iframes.</p>
					 </iframe>					
					</div>
					</div>
					

					
				</div>

				<div class="row">
				
				<div class="col-md-12">
                      <div class="form-group">
						<label for="remark">Remark</label>
                    <textarea class="form-control textarea" placeholder="Remark" name="remark" cols="60" rows="30" id="remark"></textarea>
						</div>
				</div>
				</div>
								

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>


<div class="preview">
  <img id="preview-3" alt="">
</div>			
<script>
function readURL(input, id) 
{
    var mime= input.files[0].type;
    
    if (input.files && input.files[0]) 
    {
        var reader = new FileReader();
        
        reader.onload = function (e) 
        {
            if(mime.split("/")[0]=="image")
            {
                $('#preview-'+id+'_1').attr('src', '');
                $('#preview-'+id).attr('src', e.target.result);

            }
            else
            {
                $('#preview-'+id).attr('src', '');
                $('#preview-'+id+'_1').attr('src', e.target.result);
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
    
$(function()
{
    $(".uploadjs").change(function()
    {
        var id = $(this).data('id')
        readURL(this, id);
    });
})
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>	  
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
function myFunction() {
  var x = document.getElementById("myDIV");
    var y = document.getElementById("myDivButton");
  if (x.style.display === "none") {
    x.style.display = "block";
	y.style.display = "none";
	document.getElementById("myBtn").value = "Verification_code_send";
	document.getElementById("myBtn2").value = "";
	document.getElementById("myBtn3").value = "";
	$('#verification_code').prop('disabled', false);

  }else{
    x.style.display = "none";
	y.style.display = "block";
	document.getElementById("myBtn").value = "";
	// document.getElementById("myBtn2").value = "Without_verification_code_send";
	$('#verification_code').prop('disabled', true);
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
    }
}

 $(function () {
        $("#status").change(function () {
            if ($(this).val() == "Draft") {
                $("#save").show();
                $("#send").show();
                $("#esign").hide();
                $("#esign_and_submit").hide();
            }else {
                $("#esign").show();
				$("#esign_and_submit").show();
				$("#save").hide();
                $("#send").hide();
            }
        });
    });
</script>

<div class="row">
				<div class="col-md-6">
				<div class="field_wrapper">
					<div>
							<div class='form-group'>
							  <div><label>Supporting File (Part / Duplicate File) <a href="javascript:void(0);" class="add_button" title="Add field"><img src="<?php echo base_url().'uploads/image/add-icon.png';?>"/></a></label></div>
						<input class="form-control" type="file" name="file[]" value=""/>
					</div>
					</div>
				</div>			
				</div>	

				<div class="col-md-3">
                    <div class="form-group">
					<label for="reporting_person">Reporting Officer</label> 
					<select name="selection_dropdown" id="selection_dropdown" class="form-control" data-plugin="select_hrm" data-placeholder="Choose Reporting Officer">
                      <option value="1">Departmental Hierarchy</option>
                      <option value="2">All Contacts</option>
                    </select>		
					</div>
					</div>

					<div class="col-md-3">
                   <div class="form-group" style="padding: 26px 0px 0px 0px;">
					<select name="reporting_officer" id="reporting_officer" class="form-control" data-plugin="select_hrm" data-placeholder="Choose Reporting Officer" hidden="">
                      <option value="">Choose Reporting Officer</option>
                     <!-- <?php foreach($all_employees as $employee) {?>
                      <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                      <?php } ?> -->
                    </select>
						</div>
                    </div>			
</div>


	<div id="myDivButton">
			<button type="submit" id="save"  onclick="myFunction4()" class="btn btn-primary save" style="display:none;">Save</button>
			<button type="submit" id="send" onclick="myFunction3()" class="btn btn-primary save" style="display:none;">Send</button>
			<button id="esign" onclick="myFunction()" name="esign" class="btn btn-primary" style="display:none;">e-Sign & Submit</button>
<!--	    <button id="esign_and_submit" onclick="myFunction2()" name="esign_and_submit" class="btn btn-primary" style="display:none;">e-Sign & Submit</button> 
-->				<input type="hidden" name="verify" id="myBtn" value="">
				<input type="hidden" name="without_verify" id="myBtn2" value="">
				<input type="hidden" name="send" id="myBtn3" value="">
	</div>	
			<div id="myDIV" style="display:none;"> 
			 <div class="row">						
				<div class="col-md-6">
                    <div class="form-group">
					<!--<label for="verification_code">Enter Verification Code sent on your registered e-mail Id to verify your e-Sign</label> -->					
					<label for="verification_code">Enter Verification Code</label> 				
                        <input class="form-control" placeholder="Verification Code" id="verification_code" name="verification_code" disabled="true" type="text">
						<?php 	
						function generateRandomString($length = 10) {
						$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
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
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="box box-block bg-white">
  <h2><strong>List All</strong> Archive Files 
<!--  <div class="add-record-btn">
    <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-plus icon"></i> Add New</button>
	<?php if($session['user_role_id'] == 1){ ?>	
    <a href="<?php echo site_url();?>files/file_list_pdf/" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="PDF"><span <i="" class="fa fa-file-pdf-o"></span> Download</a> 
    <?php } ?>	
	</div>
-->
  </h2>
  
    <div class="alert alert-success" style="display:none;" id="tender_display"></div>
            <?php if($this->session->flashdata('error')!='')
                                {
                                    ?>
		<div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">??</button>
                                <strong><i class="icon24 i-close-4"></i><?php echo $this->session->flashdata('error')?></strong>
                            </div>
                                <?php }?>
                                <?php if($this->session->flashdata('success')!='')
                                {
                                    ?>
		<div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">??</button>
                                <strong><i class="icon24 i-close-4"></i><?php echo $this->session->flashdata('success')?></strong>
                            </div>
                                <?php } ?>
  
  <div class="table-responsive" data-pattern="priority-columns">
    <table class="table table-striped table-bordered dataTable" id="xin_table">
      <thead>
        <tr>
          <th>Action</th>
          <th>Creator</th>
          <th>File No.</th>
         <!-- <th>File Type</th>-->
          <th>Subject</th>
          <th>Due Date</th>
          <th>Current Status</th>
          <th>Priority</th>
          <th>Reporting Officer</th>
          <th>Reference file</th>
          <th>Supporting Files</th>
          <th>Last Update</th>
          <th>Action</th>	
		</tr>
      </thead>
    </table>
  </div>
</div>
<?php $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
);
?>
<script type="text/javascript">
// $(document).ready(function() {

 		// $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		// $('[data-plugin="select_hrm"]').select2({ width:'100%' });	
// });
	var url="<?php echo base_url();?>";
    function deletep(id){
		
	
       var r=confirm("Do you want to delete this?")
        if (r==true)
		{
			var dataString = 'id='+ id+'&<?=$csrf['name'];?>='+'<?=$csrf['hash'];?>';
			$.ajax
			({
			type: "POST",
			url: url+"files/delete/",
			data: dataString,
			cache: false,
			beforeSend: function() {
			// setting a timeout
		   $("#tender_display").show(10);
		   $("#tender_display").html("<strong><i class='icon24 i-close-4'></i>File Deleted Successfully</strong>");
		  window.setTimeout(function(){location.reload()},1200)
			},
			success: function(html)
			{
				if(html ==1){
			 $("#tr_"+id).remove();
			 var num_count= $("#num_count").text();
			$("#num_count").text(num_count-1);
			$("#tender_display").html("<strong><i class='icon24 i-close-4'></i>File Deleted Successfully</strong>");
				}
				else
				$("#tender_display").html("Error while deleting.");
			} 
			});	
		}
        else
          return false;
        }

</script>