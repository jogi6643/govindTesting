<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['id']) && $_GET['data']=='edit_file'){
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $all_file_type = $this->Templates_model->all_file_type(); ?>
<?php $all_reporting_officer = $this->Employees_model->all_employee_name(); ?>
<?php $report = $this->Xin_model->reporting_officer($session['user_id']);?>
<?php $all_employees = $this->Xin_model->all_employees(); ?>
<?php $result_upload = $this->Files_model->read_file_information_upload($id); ?>
<?php $result_upload = $this->Files_model->read_file_information_upload($id); ?>
<?php $user_id = $session['user_id'];?> 

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Edit File</h4>
</div>
<form class="m-b-1" action="<?php echo site_url("files/update").'/'.$id; ?>" method="post" name="edit_file" id="edit_file">
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
  <!--<input type="hidden" name="counter" value="<?php echo $counter + 1;?>">-->

  <div class="modal-body">
        <div class="row">
		       <div class="col-md-3">
				<div class="form-group">
				 <label for="file_name">File No.</label>
              <input class="form-control" placeholder="File Name" name="file_name" type="text" value="<?php echo $file_name;?>" readonly>
            </div>
          </div>
		  
          <div class="col-md-3">
            <div class="form-group">
              <label for="file_type">File Templates</label>
              <input class="form-control" placeholder="File Type" name="file_type" type="text" value="<?php echo $file_type;?>" readonly> 
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
              <input class="form-control" placeholder="Status" name="status" type="text" value="<?php echo $status;?>" readonly> 
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
              <input class="form-control" placeholder="Priority" name="priority" type="text" value="<?php echo $priority;?>" readonly> 
			  <select class="form-control" name="priority" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_priority');?>">
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
					<label for="file_delivery_mode">File  </label>					
                        <select class="form-control" name="file_delivery_mode" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_file_priority');?>">
                         <option value="">Choose File Delivery Mode</option>
						<option value="E-Mail">E-Mail</option>						  
                        <option value="Physical">Physical</option>						  
                        <option value="Online">Online</option>						  
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
          <textarea class="form-control textarea" placeholder="Description" name="description" cols="30" rows="10" id="description2"><?php echo $descriptions;?><?php echo $description;?></textarea>
        </div>
      </div>
	  <div class="col-md-4">
		  <div class="form-group">
			<label for="reference_attachment_file">Reference file</label>
			<a target="_blank" href="<?php echo 'uploads/files/'.$attachment_file;?>"><?php echo $attachment_file;?></a>
			<input accept="image/*, application/pdf" name="attachment_file" class="uploadjs form-control" data-id="3" type="hidden" value="<?php echo $attachment_file;?>">
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

	  
	<!--   <div class="row">   
          <div class="col-md-6">
            <div class="form-group">
              <label for="reporting_officer">Sanction Officer / Reporting Officer</label>
              <input class="form-control" readonly="readonly" style="border:0" name="reporting_officer" type="text" value="<?php echo $reporting_officer;?>">
           <select name="reporting_officer" id="select2-demo-6" class="form-control" data-placeholder="Choose Sanction Officer / Reporting Officer">
                      <option value="">Choose Sanction Officer / Reporting Officer</option>
                      <?php foreach($all_employees as $employee) {?>
                      <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                      <?php } ?>
                    </select>
			</div>
          </div>
        </div> -->

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
				<div><label>Supporting File (Part / Duplicate File) <a href="javascript:void(0);" class="add_button" title="Add Attachment"><img src="<?php echo base_url().'uploads/image/add-icon.png';?>"/></a></label></div>

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


				<div class="col-md-6">
                   <div class="form-group">
				   <label>Reporting Officer</label>
					<input class="form-control" readonly="readonly" name="reporting_officer" type="text" value="<?php echo $reporting_officer;?>">
					<select name="reporting_officer" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="Choose Reporting Officer">
                      <option value="0">Choose Reporting Officer</option>
                      <?php foreach($all_employees as $employee) {
							$designation_name = $this->Files_model->get_designation_details($employee->designation_id);
							$location_id = $this->Files_model->get_department_details($employee->department_id);
							$location_name = $this->Files_model->get_location_details($location_id[0]->location_id);
							$des_name = $designation_name[0]->designation_name;
							$loc_name = $location_name[0]->city;  					  
					  ?>
					  
                      <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name.' ('.$loc_name. '-' .$des_name.')';?></option>
                      <?php } ?>
                    </select>
						</div>
                    </div>	
		</div>		  
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Update</button>
  </div>
</form>
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/select2/dist/css/select2.min.css">
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/select2/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/ion.rangeSlider/css/ion.rangeSlider.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css">
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/ion.rangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script> 
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>	-->  
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
            url : "<?php echo site_url("files/file_list") ?>",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    	});	
	
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
		
		// $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		// $('[data-plugin="select_hrm"]').select2({ width:'100%' });	

		$("#edit_file").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		var description = $("#description2").code();
		var n = $("#remark2")["code"]();
		fd.append("is_ajax", 1);
		fd.append("edit_type", 'edit_file');
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
<?php } else if(isset($_GET['jd']) && isset($_GET['id']) && $_GET['data']=='view_file'){?>
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
					<label for="file_delivery_mode">File Delivery Mode </label>					
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
			<label for="reference_attachment_file">Reference file</label>
			<a target="_blank" href="<?php echo 'uploads/files/'.$attachment_file;?>"><?php echo $attachment_file;?></a>
			<input accept="image/*, application/pdf" name="attachment_file1" class="uploadjs form-control" data-id="3" type="hidden" value="<?php echo $attachment_file;?>">
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
			<?php
			foreach($result_upload as $res){ ?>
			<a href="<?php echo base_url().'uploads/files/'.$res->attachment_file;?>" target="_blank">
			<?php echo "<img src=".base_url().'uploads/image/attachment.png'.">".$res->attachment_file ?>
			</a></br>
			<?php }?>
			</div>
			</div>
          
		  <div class="col-md-6">
            <div class="form-group">
              <label for="reporting_officer">Reporting Officer</label>
              <input class="form-control" readonly="readonly" name="reporting_officer" type="text" value="<?php echo $reporting_officer;?>">
            </div>
          </div>
		  
		</div>
		
	<!--	<div class="row">
			<div class="col-md-3">
				<div class="form-group">
				<label for="attachment_file">Uploaded Reference File 1</label><br>
				<?php if($attachment_file !='' && $attachment_file != null && $attachment_file!='no file') {?>
				<a href="<?php echo base_url().'uploads/files/'.$attachment_file;?>" target="_blank">		
				<span class="btn btn-primary btn-file"> 
				Download file
				<span></a>
				<?php }else{ echo '<span class="btn btn-primary btn-file"> '."No file exists".'<span>';}?>	
				</div></div>
				
			<div class="col-md-3">
				<div class="form-group">
				<label for="attachment_file1">Uploaded Reference File 2</label><br>				
				<?php if($attachment_file1 !='' && $attachment_file1 != null && $attachment_file1 !='no file') {?>
				<a href="<?php echo base_url().'uploads/files/'.$attachment_file1;?>" target="_blank">		
				<span class="btn btn-primary btn-file"> 
				Download file
				<span></a>	
				<?php }else{ echo '<span class="btn btn-primary btn-file"> '."No file exists".'<span>';}?>	
				</div></div>
			
			<div class="col-md-3">
				<div class="form-group">
				<label for="attachment_file2">Uploaded Reference File 3</label><br>				
				<?php if($attachment_file2 !='' && $attachment_file2 != null && $attachment_file2 !='no file') {?>
				<a href="<?php echo base_url().'uploads/files/'.$attachment_file2;?>" target="_blank">		
				<span class="btn btn-primary btn-file"> 
				Download file
				<span></a>	
				<?php }else{ echo '<span class="btn btn-primary btn-file"> '."No file exists".'<span>';}?>	
				</div></div>		

			<div class="col-md-3">
				<div class="form-group">
				<label for="attachment_file3">Uploaded Reference File 4</label><br>			
				<?php if($attachment_file3 !='' && $attachment_file3 != null && $attachment_file3!='no file') {?>
				<a href="<?php echo base_url().'uploads/files/'.$attachment_file3;?>" target="_blank">		
				<span class="btn btn-primary btn-file"> 
				Download file
				<span></a>				
				<?php }else{ echo '<span class="btn btn-primary btn-file"> '."No file exists".'<span>';}?>	
			</div>
		</div>
	</div> -->
		

  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  </div>
</form>
<?php }
?>
