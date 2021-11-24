<?php
/* Templates view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $all_reporting_officer = $this->Employees_model->all_employee_name(); ?>
<?php $file = $this->Templates_model->all_file_type(); ?>

<div class="add-form" style="display:none;">
  <div class="box box-block bg-white">
    <h2><strong>Add New</strong> Templates 			
      <div class="add-record-btn">
        <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-minus icon"></i> Hide</button>
      </div>
    </h2>
    <div class="row m-b-1">
      <div class="col-md-12">
        <form action="<?php echo site_url("templates/add_template") ?>" method="post" name="add_template" id="xin-form">
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
					<select id="select2" class="form-control" name="file_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_file_type');?>">
                        <option value="">Choose File Type</option>						  
                        <?php foreach($all_file_type as $row){?>
                          <option value="<?php echo $row->file_type; ?>"><?php echo $row->file_type; ?></option>
                        <?php } ?>
                        </select>
						</div>
                    </div>
                </div>
				
				<div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
						<label for="template">Template</label>
                    <textarea class="form-control textarea" placeholder="Template" name="template" cols="60" rows="30" id="template"></textarea>
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
  <h2><strong>List All</strong> Templates 
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
          <th>File Template</th>
          <th>Created At</th>		  
          <!--<th>Templates</th>-->	
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
			url: url+"templates/delete/",
			data: dataString,
			cache: false,
			beforeSend: function() {
			// setting a timeout
		   $("#tender_display").show(10);
		   $("#tender_display").html("<strong><i class='icon24 i-close-4'></i>Template Deleted Successfully</strong>");
		  window.setTimeout(function(){location.reload()},1200)
			},
			success: function(html)
			{
				if(html ==1){
			 $("#tr_"+id).remove();
			 var num_count= $("#num_count").text();
			$("#num_count").text(num_count-1);
			$("#tender_display").html("<strong><i class='icon24 i-close-4'></i>Template Deleted Successfully</strong>");
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