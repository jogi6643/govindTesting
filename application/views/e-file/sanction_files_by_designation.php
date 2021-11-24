<?php
/* Sanction Files view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $all_reporting_officer = $this->Employees_model->all_employee_name(); ?>
<?php $report = $this->Xin_model->reporting_officer($session['user_id']);?>
<?php $file = $this->Templates_model->all_file_type(); ?>	


<div class="box box-block bg-white">
  <h2><strong>List All</strong></h2>
  <div class="add-record-btn">

	<div class="col-md-8">
	<div class="form-group">
		<select class="form-control" name="designation_id" id="designation_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_department');?>">
			<option value="">All Designation</option>
			<?php foreach($all_designations as $designation) {
			$department_name = $this->Department_model->read_department_information($designation->department_id);	
			$depart_name = $department_name[0]->department_name;
			?>
			
			<option value="<?php echo $designation->designation_id;?>"><?php echo $designation->designation_name." (".$depart_name.")";?></option>
			<?php } ?>
		</select>
	</div>
	</div> 

	<div class="col-md-4">
		<a href="<?php echo site_url();?>sanction_files_by_designation/file_list_pdf/" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="PDF"><span <i="" class="fa fa-file-pdf-o"></span> Download</a> 
	</div>
 </div>

  
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
          <!--<th>File Type</th>-->
          <th>Subject Line</th>
          <th>Current Status</th>
          <th>Priority</th>
          <th>Designation</th>
          <th>Sanction Officer / Reporting Officer</th>
          <th>Last Update</th>		  
<!--<?php if($session['user_role_id'] == '1'){	?>	  
		<th>Action</th>		  
<?php } ?>		-->
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