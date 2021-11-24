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

  <div class="modal-body">  
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
	<div class="col-md-6">
		<div class="form-group">
			<label for="title_manual">Title of Manual</label>					
			<input class="form-control" placeholder="Title of Manual" name="title_manual" value="<?php echo $title_manual;?>" type="text">
		</div>
	</div>	
	</div>
	  </div>
		  </div>
 		<div class="row">
	  <div class="col-md-12">
		  <div class="form-group">
			<label for="reference_attachment_file">User Manual file</label>
			<a target="_blank" href="<?php echo 'uploads/user_manual/'.$user_manual_file;?>"><?php echo $user_manual_file;?></a>
			<input accept="image/*, application/pdf" name="user_manual_file" class="uploadjs form-control" data-id="3" type="hidden" value="<?php echo $user_manual_file;?>">
		    <?php if(($user_manual_file != '') || ($user_manual_file != null)){?>
			<embed src="<?php echo 'uploads/user_manual/'.$user_manual_file;?>" type="application/pdf" width="100%" height="525px" />
			<?php }else{ ?>
			<p style="border:2px solid; height:525px; padding:10px;" readonly>
			No Reference file uploaded.
			</p>
			<?php } ?>
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
            url : "<?php echo site_url("User_manual/user_manual_list") ?>",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    	});	

		$("#edit_user_manual").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		fd.append("is_ajax", 1);
		fd.append("edit_type", 'edit_user_manual');
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
<?php } else if(isset($_GET['jd']) && isset($_GET['id']) && $_GET['data']=='view_user_manual'){?>
<?php $result_upload = $this->Files_model->read_file_information_upload($id); ?>


<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">View User Manual</h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
 
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
	<div class="col-md-6">
		<div class="form-group">
			<label for="title_manual">Title of Manual</label>					
			<input class="form-control" placeholder="Title of Manual" name="title_manual" readonly value="<?php echo $title_manual;?>" type="text">
		</div>
	</div>	
	</div>
	  </div>
		  </div>

		<div class="row">
	  <div class="col-md-12">
		  <div class="form-group">
			<label for="reference_attachment_file">User Manual file</label>
			<a target="_blank" href="<?php echo 'uploads/user_manual/'.$user_manual_file;?>"><?php echo $user_manual_file;?></a>
			<input accept="image/*, application/pdf" name="user_manual_file" class="uploadjs form-control" data-id="3" type="hidden" value="<?php echo $user_manual_file;?>">
		    <?php if(($user_manual_file != '') || ($user_manual_file != null)){?>
			<embed src="<?php echo 'uploads/user_manual/'.$user_manual_file;?>" type="application/pdf" width="100%" height="525px" />
			<?php }else{ ?>
			<p style="border:2px solid; height:525px; padding:10px;" readonly>
			No User Manual file uploaded.
			</p>
			<?php } ?>
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
