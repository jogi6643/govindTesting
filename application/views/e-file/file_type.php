<?php
/* File Type view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $report = $this->Xin_model->reporting_officer($session['user_id']);?>

<div class="add-form" style="display:none;">
  <div class="box box-block bg-white">
    <h2><strong>Add New</strong> File Type
      <div class="add-record-btn">
        <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-minus icon"></i> Hide</button>
      </div>
    </h2>
    <div class="row m-b-1">
      <div class="col-md-12">
        <form action="<?php echo site_url("file_type/add_file_type") ?>" method="post" name="add_file_type" id="xin-form">
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
                        <label for="file_type">File Type</label>
                        <input class="form-control" placeholder="File Type" name="file_type" type="text">
                      </div>
                    </div>
							
				<div class="col-md-6">			
				<div class="form-group">
					<label for="name"><?php echo $this->lang->line('xin_department');?></label>
					<select id="select2" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>..." name="department_id">
					<option value="">Choose Department</option>
					<?php foreach($all_departments as $deparment) {?>
					<option value="<?php echo $deparment->department_id?>"><?php echo $deparment->department_name?></option>
					<?php } ?>
					</select>
				</div>
				</div>
		  </div>



              <button type="submit" class="btn btn-primary save">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="box box-block bg-white">
  <h2><strong>List All</strong> File Types 
  <div class="add-record-btn">
      <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-plus icon"></i> Add New</button>
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
          <th>File Type</th>
          <th>Created At</th>          
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
			url: url+"file_type/delete/",
			data: dataString,
			cache: false,
			beforeSend: function() {
			// setting a timeout
		   $("#tender_display").show(10);
		   $("#tender_display").html("<strong><i class='icon24 i-close-4'></i>File Type Deleted Successfully</strong>");
		  window.setTimeout(function(){location.reload()},1200)
			},
			success: function(html)
			{
				if(html ==1){
			 $("#tr_"+id).remove();
			 var num_count= $("#num_count").text();
			$("#num_count").text(num_count-1);
			$("#tender_display").html("<strong><i class='icon24 i-close-4'></i>File Type Deleted Successfully</strong>");
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