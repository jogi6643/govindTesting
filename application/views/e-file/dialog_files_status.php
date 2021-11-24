<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$session = $this->session->userdata('username');
if(isset($_GET['jd']) && isset($_GET['id']) && $_GET['data']=='edit_file_status'){
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
  <h4 class="modal-title" id="edit-modal-data">Edit File Status</h4>
</div>
<form class="m-b-1" action="<?php echo site_url("files/update").'/'.$id; ?>" method="post" name="edit_file_status" id="edit_file_status">
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
  <input type="hidden" name="file_id" value="<?php echo $file_id;?>">
  <!--<input type="hidden" name="counter" value="<?php echo $counter + 1;?>">-->

  <div class="modal-body">
        <div class="row">
		       <div class="col-md-6">
				<div class="form-group">
				 <label for="file_name">File Name</label>
              <input class="form-control" placeholder="File Name" name="file_name" type="text" value="<?php echo $file_name;?>">
            </div>
          </div>
		  
          <div class="col-md-6">
            <div class="form-group">
              <label for="file_type">File Template</label>
              <input class="form-control" placeholder="File Type" name="file_type" type="text" value="<?php echo $file_type;?>" readonly> 
            <!--<select id="select2" class="form-control" name="file_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_file_type');?>">
                        <option value="">Choose File Type</option>						  
                        <?php foreach($all_file_type as $row){?>
                          <option value="<?php echo $row->file_type; ?>"><?php echo $row->file_type; ?></option>
                        <?php } ?>
                        </select>-->
			</div>
          </div>
        </div>

		<div class="row">
		<div class="col-md-12">
        <div class="form-group">
          <label for="subject_line">Subject Line</label>
            <input class="form-control" placeholder="Subject Line" name="subject_line" type="text" value="<?php echo $subject_line;?>">
        </div>
      </div>
      </div>
		
		<div class="row">
		<div class="col-md-8">
        <div class="form-group">
		<?php date_default_timezone_set("Asia/Calcutta"); //India time (GMT+5:30) echo date('d-m-Y H:i:s'); ?>
		<?php $employee_name = $this->Employees_model->read_employee_information($user_id);?>		
		<?php $employee_names = $employee_name[0]->first_name." ".$employee_name[0]->last_name;?>
          <label for="description">Description</label><?php $descriptions = $description;?><?php $description = '<br><br>'.date('d-m-Y H:i:s')." -- ".$employee_names." -- ";?>
          <textarea class="form-control textarea" placeholder="Description" name="description" cols="30" rows="10" id="description2"><?php echo $descriptions;?><?php echo $description;?></textarea>
        </div>
      </div>
      </div>
	  
	   <div class="row">
		       <div class="col-md-3">
				<div class="form-group">
				 <label for="status">Status</label>
              <input class="form-control" placeholder="Status" name="status" type="text" value="<?php echo $status;?>" readonly> 
			  <select id="select2" class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_file_status');?>">
                        <option value="">Choose File Status</option>						  
                        <option value="In process">In process</option>						  
                        <option value="Approved">Approved</option>						  
                        <option value="On Hold">On Hold</option>						  
                        <option value="Rejected">Rejected</option>						  
                        </select>
            </div>
          </div>
		  
		  		<div class="col-md-3">
				<div class="form-group">
				 <label for="priority">Priority</label>
              <input class="form-control" placeholder="Priority" name="priority" type="text" value="<?php echo $priority;?>" readonly> 
			  <select id="select2" class="form-control" name="priority" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_priority');?>">
                        <option value="Normal">Normal</option>						  
                        <option value="Urgent">Urgent</option>						  
                        <option value="Most urgent">Most urgent</option>						  
                        </select>
            </div>
          </div>


		  
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
        </div>
<!--		
<div class="row">
			<div class="col-md-3">
				<div class="form-group">
				<label for="attachment_file">Uploaded Reference File 1</label><br>
				<?php if($attachment_file !='' && $attachment_file != null && $attachment_file!='no file') {?>
				<input type="hidden" name="attachment_file" value="<?php echo $attachment_file;?>">
				<a href="<?php echo base_url().'uploads/files/'.$attachment_file;?>" target="_blank">		
				<span class="btn btn-primary btn-file"> 
				Download file
				<span></a>
				<?php }else{ ?>
				<span><input type="file" name="attachment_file"></span>
				<?php }?>	
				</div></div>
				
			<div class="col-md-3">
				<div class="form-group">
				<label for="attachment_file1">Uploaded Reference File 2</label><br>		
				<?php if($attachment_file1 !='' && $attachment_file1 != null && $attachment_file1 !='no file') {?>
				<input type="hidden" name="attachment_file1" value="<?php echo $attachment_file1;?>">
				<a href="<?php echo base_url().'uploads/files/'.$attachment_file1;?>" target="_blank">		
				<span class="btn btn-primary btn-file"> 
				Download file
				<span></a>
				<?php }else{ ?>
				<span><input type="file" name="attachment_file1"></span>
				<?php }?>	
				</div></div>
			
			<div class="col-md-3">
				<div class="form-group">
				<label for="attachment_file2">Uploaded Reference File 3</label><br>
				<?php if($attachment_file2 !='' && $attachment_file2 != null && $attachment_file2 !='no file') {?>
				<input type="hidden" name="attachment_file2" value="<?php echo $attachment_file2;?>">
				<a href="<?php echo base_url().'uploads/files/'.$attachment_file2;?>" target="_blank">		
				<span class="btn btn-primary btn-file"> 
				Download file
				<span></a>
				<?php }else{ ?>
				<span><input type="file" name="attachment_file2"></span>
				<?php }?>	
				</div></div>	

			<div class="col-md-3">
				<div class="form-group">
				<label for="attachment_file3">Uploaded Reference File 4</label><br>	
				<?php if($attachment_file3 !='' && $attachment_file3 != null && $attachment_file3!='no file') {?>
				<input type="hidden" name="attachment_file3" value="<?php echo $attachment_file3;?>">
				<a href="<?php echo base_url().'uploads/files/'.$attachment_file3;?>" target="_blank">		
				<span class="btn btn-primary btn-file"> 
				Download file
				<span></a>
				<?php }else{ ?>
				<span><input type="file" name="attachment_file3"></span>
				<?php }?>	
				</div></div>
	</div> 
-->		
		<div class="row">
		<div class="col-md-12">
        <div class="form-group">
          <label for="remark">Remark</label>
          <textarea class="form-control textarea" placeholder="Remark" name="remark" cols="30" rows="10" id="remark2"><?php echo $remark;?></textarea>
        </div>
      </div>
      </div>
	  


<div class="field_wrapper">
    <div>
			<div class='form-group'>
			  <div><label>Upload Reference File <a href="javascript:void(0);" class="add_button" title="Add Attachment"><img src="<?php echo base_url().'uploads/image/attachment.png';?>"/></a></label></div>
		
		<?php if($attachment_file !='' && $attachment_file != null && $attachment_file!='no file') {?>
				<a href="<?php echo base_url().'uploads/files/'.$attachment_file;?>" target="_blank">		
				<?php echo $attachment_file;?>
				</a><br>
				<?php } ?>
			<?php if($attachment_file1 !='' && $attachment_file1 != null && $attachment_file1!='no file') {?>
				<a href="<?php echo base_url().'uploads/files/'.$attachment_file1;?>" target="_blank">		
				<?php echo $attachment_file1;?>
				</a><br>
				<?php } ?>
			<?php if($attachment_file2 !='' && $attachment_file2 != null && $attachment_file2 !='no file') {?>
				<a href="<?php echo base_url().'uploads/files/'.$attachment_file2;?>" target="_blank">		
				<?php echo $attachment_file2;?>
				</a><br>
				<?php } ?>
			<?php if($attachment_file3 !='' && $attachment_file3 != null && $attachment_file3 !='no file') {?>
				<a href="<?php echo base_url().'uploads/files/'.$attachment_file3;?>" target="_blank">		
				<?php echo $attachment_file3;?>
				</a><br>
				<?php } ?>

<?php
foreach($result_upload as $res){ ?>
<a href="<?php echo base_url().'uploads/files/'.$res->attachment_file;?>" target="_blank">
		<?php echo $res->attachment_file ?>
				</a></br>
	<?php }?>
	</div>
	<div class='form-group'>
        <input type="file"  class="form-control" name="file[]" value=""/>
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
            url : "<?php echo site_url("files_status/file_status_list") ?>",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    	});
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('#description2').summernote({
		  height: 800,
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

		$("#edit_file_status").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		var description = $("#description2").code();
		var n = $("#remark2")["code"]();
		fd.append("is_ajax", 1);
		fd.append("edit_type", 'edit_file_status');
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
<?php } else if(isset($_GET['jd']) && isset($_GET['id']) && $_GET['data']=='view_file_status'){?>
<?php $result_upload = $this->Files_status_model->read_file_information_upload($id); ?>


<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View File Status</h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <div class="table-responsive" data-pattern="priority-columns">
    <table class="table table-striped table-bordered dataTable" id="xin_table">
      <thead>
        <tr>
          <th>Creator</th>
          <th>File Name</th>
          <th>Current User</th>
          <th>Current Status</th>
          <th>Priority</th>
          <th>Reporting Officer</th>
          <th>Last Update</th>
		</tr>
      </thead>


	<?php 
	if($session['user_id'] == '1'){
	$result = $this->Files_status_model->read_file_information_file_out_by_admin($id);	
	}else{	
	$result = $this->Files_status_model->read_file_information_file_out($session['user_id'],$id); 
	}	foreach($result as $res){
	?>
	<tbody>	
	  <td>
	  <?php 
		$employee = $this->Files_status_model->read_employee_information($res->employee_id);
		echo $employee[0]->first_name." ".$employee[0]->last_name;
		?>
		</td>
	  <td><?php echo $res->file_name;?></td>
	  <td>
	  <?php 
		$employee = $this->Files_status_model->read_employee_information($res->current_employee_id);
		echo $employee[0]->first_name." ".$employee[0]->last_name;
		?>
		</td>	  
	  <td><?php echo $res->status;?></td>
	  <td><?php echo $res->priority;?></td>
	  <td>
	  <?php 
		$employee = $this->Files_status_model->read_employee_information($res->reporting_officer);
		if($employee != null){
		echo $employee[0]->first_name." ".$employee[0]->last_name;
		}else{
			echo $employee;
		}
		?>
		</td>
	  <td><?php echo $res->updated_at;?></td>
	</tbody>
		<?php } ?> 
	  
    </table>
  </div>
      
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  </div>
</form>
<?php }
?>
