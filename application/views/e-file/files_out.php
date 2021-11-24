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

<!--
<div class="add-form" style="display:none;">
  <div class="box box-block bg-white">
    <h2><strong>Add New</strong> File 			
      <div class="add-record-btn">
        <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-minus icon"></i> Hide</button>
      </div>
    </h2>
    <div class="row m-b-1">
      <div class="col-md-12">
        <form action="<?php echo site_url("files/add_file") ?>" method="post" name="add_file" id="xin-form" enctype="multipart/form-data">
		<?php
	$csrf=array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
		);
?>
   <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>"/>
          <input type="hidden" name="user_id" value="<?php echo $session['user_id'];?>">		  
          <input type="hidden" name="employee_id" value="<?php echo $session['user_id'];?>">
		  
          <div class="bg-white">
            <div class="box-block">
               <div class="row">
				<div class="col-md-6">
                    <div class="form-group">
					<label for="file_name">File Name</label>					
                        <input class="form-control" placeholder="File Name" name="file_name" type="text">
						</div>
                    </div>
					
                    <div class="col-md-6">
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
                </div>
				
               <div class="row">
				<div class="col-md-12">
                    <div class="form-group">
					<label for="subject_line">Subject Line</label>					
                        <input class="form-control" placeholder="Subject Line" name="subject_line" type="text">
						</div>
                    </div>		
					</div>
					
				<div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
						<label for="description">Description</label>
                    <textarea class="form-control textarea" placeholder="Description" name="description" cols="60" rows="30" id="description" disabled></textarea>
						</div>
					</div>
				</div>

				<div class="row">
				<div class="col-md-3">
                    <div class="form-group">
					<label for="status">Status</label>					
					<select id="select2" class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_file_status');?>">
                        <option value="">Choose File Status</option>						  
                        <option value="In process">In process</option>						  
                        <option value="Approve">Approve</option>						  
                        <option value="Hold">Hold</option>						  
                        <option value="Reject">Reject</option>						  
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

				<div class="col-md-6">
                    <div class="form-group">
					<label for="reporting_person">Reporting Person</label>					
                        <select name="reporting_officer" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="Choose an Reporting Officer">
                      <option value="">Choose Reporting Officer</option>
                      <?php foreach($all_employees as $employee) {?>
                      <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                      <?php } ?>
                    </select>
						</div>
                    </div>						
					</div>

			<!--<div class="row">
			    <div class="col-md-6">
                    <div class='form-group'>
                      <div><label for="document">Document</label></div>
                      	<span class="btn btn-primary btn-file">
                          Browse <input type="file" name="document" id="document">
                        </span>
                      <br>
                      <small>Upload files only: PDF</small> </div>
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

              <button type="submit" class="btn btn-primary save">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> -->
<div class="box box-block bg-white">
  <h2><strong>List All</strong> Files Out
  <div class="add-record-btn">
   <!-- <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-plus icon"></i> Add New</button> -->
	<?php if($session['user_id'] == 34){ ?>	
   <!-- <a href="<?php echo site_url();?>files/file_list_pdf/" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="PDF"><span <i="" class="fa fa-file-pdf-o"></span> Download</a> --> 
    <?php } ?>	
	</div>

  </h2>
  
    <div class="alert alert-success" style="display:none;" id="tender_display"></div>
            <?php if($this->session->flashdata('error')!='')
                                {
                                    ?>
		<div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong><i class="icon24 i-close-4"></i><?php echo $this->session->flashdata('error')?></strong>
                            </div>
                                <?php }?>
                                <?php if($this->session->flashdata('success')!='')
                                {
                                    ?>
		<div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
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
          <th>Supporting File</th>
          <th>Last Update</th>
         <!-- <th>Action</th>	-->	
		<?php if($session['user_id'] == 34){ ?>	
          <th>Action</th>	
		<?php }?>	
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