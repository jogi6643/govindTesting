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
    <h2><strong>Add </strong> Manual 			
      <div class="add-record-btn">
        <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-minus icon"></i> Hide</button>
      </div>
    </h2>
    <div class="row m-b-1">
      <div class="col-md-12">
        <form action="<?php echo site_url("user_manual/add_user_manual") ?>" method="post" name="add_user_manual" id="xin-form">
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
			<div class="col-md-12">
			<div class="form-group">
			<div class="col-md-6">
				<div class="form-group">
					<label for="title_manual">Title of Manual</label>					
					<input class="form-control" placeholder="Title of Manual" name="title_manual" type="text">
				</div>
			</div>	
			</div>
			  </div>
				  </div>
				
				<div class="row">
					<div class="col-md-12">
                      <div class="form-group">
						<label for="user_manual_file">User Manual file</label><br><small>(max upload file size is 20 MB and PDF only)</small><input accept="image/*, application/pdf" name="user_manual_file" class="uploadjs form-control" data-id="3" type="file">
						<iframe id="preview-3_1" src="" style="width:100%; height:500px;" frameborder="1" scrolling="yes">
						<p>Your web browser doesn't support iframes.</p>
					 </iframe>					
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

              <button type="submit" class="btn btn-primary">Submit</button>		

			</div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="box box-block bg-white">
  <h2><strong>User Manual</strong> 
  <div class="add-record-btn">
 	<?php if($session['user_role_id'] == 1){ ?>	
		<button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-plus icon"></i> Add New</button>
<!--    <a href="<?php echo site_url();?>files/file_list_pdf/" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="PDF"><span <i="" class="fa fa-file-pdf-o"></span> Download</a> 
-->    <?php } ?>	
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
          <th>User Manual</th>
			<th>Last Update</th>
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
			url: url+"User_manual/delete/",
			data: dataString,
			cache: false,
			beforeSend: function() {
			// setting a timeout
		   $("#tender_display").show(10);
		   $("#tender_display").html("<strong><i class='icon24 i-close-4'></i>User Manual Deleted Successfully</strong>");
		  window.setTimeout(function(){location.reload()},1200)
			},
			success: function(html)
			{
				if(html ==1){
			 $("#tr_"+id).remove();
			 var num_count= $("#num_count").text();
			$("#num_count").text(num_count-1);
			$("#tender_display").html("<strong><i class='icon24 i-close-4'></i>User Manual Deleted Successfully</strong>");
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
