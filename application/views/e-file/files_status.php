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
				<div class="col-md-3">
                    <div class="form-group">
					<label for="file_name">File No.</label>					
                        <input class="form-control" placeholder="File Name" name="file_name" type="text">
						</div>
                    </div>
					
                    <div class="col-md-3">
                      <div class="form-group">
					<label for="file_type">File Type</label>					
					<select id="file_type" class="form-control" name="file_type"  data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_file_type');?>">
                        <option value="">Choose File Type</option>						  
                        <?php foreach($all_file_type as $row){?>
                          <option value="<?php echo $row->file_type; ?>"><?php echo $row->file_type; ?></option>
                        <?php } ?>
                        </select>
						</div>
                    </div>
					
					<div class="col-md-3">
                    <div class="form-group">
					<label for="status">Status</label>					
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
					<select id="select2" class="form-control" name="priority" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_file_priority');?>">
                        <option value="Normal">Normal</option>						  
                        <option value="Urgent">Urgent</option>						  
                        <option value="Most urgent">Most urgent</option>						  
                        </select>
						</div>
                    </div>		
					
                </div>
				
               <div class="row">
				<div class="col-md-12">
                    <div class="form-group">
					<label for="subject_line">Subject of File </label>					
                        <input class="form-control" placeholder="Subject Line" name="subject_line" type="text">
						</div>
                    </div>		
					</div>
					
				<div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
						<label for="description">Notesheet</label>
                    <textarea class="form-control textarea" placeholder="Description" name="description" cols="60" rows="30" id="description" disabled></textarea>
						</div>
					</div>
					
					<div class="col-md-4">
                      <div class="form-group">
						<label for="remark">Remark</label>
                    <textarea class="form-control textarea" placeholder="Remark" name="remark" cols="60" rows="30" id="remark"></textarea>
						</div>
					</div>
					
				</div>

				<div class="row">
				
					
								

				<div class="col-md-6">
                    <div class="form-group">
					<label for="reporting_person">Sanction Officer / Reporting Officer</label>					
                        <select name="reporting_officer" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="Choose Sanction Officer / Reporting Officer">
                      <option value="">Choose Sanction Officer / Reporting Officer</option>
                      <?php foreach($all_employees as $employee) {?>
                      <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                      <?php } ?>
                    </select>
						</div>
                    </div>	
				</div>
 
	<!--		<div class="row">
			    <div class="col-md-3">
                    <div class='form-group'>
                      <div><label for="attachment_file">Upload Reference File 1</label></div>
                      	<span class="btn btn-primary btn-file"> 
                          Browse  <input type="file" name="attachment_file">
                        </span>
                      <br>
                      <small>Upload file only: PDF</small><br><small>Upload file size not more than: 1MB</small> </div> 
                  </div> 
				  <div class="col-md-3">
                    <div class='form-group'>
                      <div><label for="attachment_file1">Upload Reference File 2</label></div>
                      	<span class="btn btn-primary btn-file"> 
                          Browse  <input type="file" name="attachment_file1">
                        </span>
                      <br>
                      <small>Upload file only: PDF</small><br><small>Upload file size not more than: 1MB</small> </div> 
                  </div>
				  <div class="col-md-3">
                    <div class='form-group'>
                      <div><label for="attachment_file2">Upload Reference File 3</label></div>
                      	<span class="btn btn-primary btn-file"> 
                          Browse  <input type="file" name="attachment_file2">
                        </span>
                      <br>
                      <small>Upload file only: PDF</small><br><small>Upload file size not more than: 1MB</small> </div> 
                  </div> 
				   <div class="col-md-3">
                    <div class='form-group'>
                      <div><label for="attachment_file3">Upload Reference File 4</label></div>
                      	<span class="btn btn-primary btn-file"> 
                          Browse  <input type="file" name="attachment_file3">
                        </span>
                      <br>
                      <small>Upload file only: PDF</small><br><small>Upload file size not more than: 1MB</small> </div> 
                  </div> 
			</div> -->
			
<!--						<div class="row">
			    <div class="col-md-3">
                    <div class='form-group'>
                      <div><label for="attachment_file">Upload Reference File 1</label></div>
                      	<span> 
                         <input type="file" name="attachment_file">
                        </span>
                      <br>
                      <small>Upload file only: PDF</small><br><small>Upload file size not more than: 1MB</small> </div> 
                  </div> 
				  <div class="col-md-3">
                    <div class='form-group'>
                      <div><label for="attachment_file1">Upload Reference File 2</label></div>
                      	<span> 
                          <input type="file" name="attachment_file1">
                        </span>
                      <br>
                      <small>Upload file only: PDF</small><br><small>Upload file size not more than: 1MB</small> </div> 
                  </div>
				  <div class="col-md-3">
                    <div class='form-group'>
                      <div><label for="attachment_file2">Upload Reference File 3</label></div>
                      	<span> 
                         <input type="file" name="attachment_file2">
                        </span>
                      <br>
                      <small>Upload file only: PDF</small><br><small>Upload file size not more than: 1MB</small> </div> 
                  </div> 
				   <div class="col-md-3">
                    <div class='form-group'>
                      <div><label for="attachment_file3">Upload Reference File 4</label></div>
                      	<span> 
                          <input type="file" name="attachment_file3">
                        </span>
                      <br>
                      <small>Upload file only: PDF</small><br><small>Upload file size not more than: 1MB</small> </div> 
                  </div> 
			</div>  -->
			


			<div class="row">
                    
			</div>	


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
  } 
} 

// function myFunctionButton() {
  // var x = document.getElementById("myDivButton");
  // if (x.style.display === "block") {
    // x.style.display = "none";
  // } 
// } 
</script>
<div class="field_wrapper">
    <div>
			<div class='form-group'>
			  <div><label>Upload Reference File <a href="javascript:void(0);" class="add_button" title="Add field"><img src="<?php echo base_url().'uploads/image/attachment.png';?>"/></a></label></div>
        <input class="form-control" type="file" name="file[]" value=""/>
    </div>
    </div>
</div>			
	
<!--	<div id="myDivButton">
			<button onclick="myFunction()" class="btn btn-primary save">Submit</button>
	</div>	-->	
	<!--		<div id="myDIV" style="display:none;">
			 <div class="row">						
				<div class="col-md-3">
                    <div class="form-group">
					<label for="verification_code">Verification Code</label>					
                        <input class="form-control" placeholder="Verification Code" name="verification_code" type="text">
						</div>
                    </div>	
					</div>			 -->		
	
              <button type="submit" class="btn btn-primary save">Submit</button>				
			<!--	</div> -->
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="box box-block bg-white">
  <h2><strong>List All</strong> Files Movement</h2>
  
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
          <th>Subject Line</th>
          <th>Due Date</th>
          <th>Current Status</th>
          <th>Priority</th>
          <th>Reporting Officer</th>
          <th>Reference File</th>
          <th>Supporting Files</th>
          <th>Last Update</th>
       <!--   <th>Action</th>	-->	
		<?php if($session['user_role_id'] == 1){ ?>	
          <th>Action</th>	
		<?php } ?>	
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