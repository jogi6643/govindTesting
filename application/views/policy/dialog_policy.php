<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['policy_id']) && $_GET['data']=='policy'){
 $all_departments = $this->Department_model->all_departments();
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_policy');?></h4>
</div>
<form class="m-b-1" action="<?php echo site_url("policy/update").'/'.$policy_id; ?>" method="post" name="edit_policy" id="edit_policy">
  <input type="hidden" name="_method" value="EDIT">
  <input type="hidden" name="_token" value="<?php echo $policy_id;?>">
  <input type="hidden" name="ext_name" value="<?php echo $title;?>">
  <div class="modal-body">
    <div class="form-group">
      <label for="company"><?php echo $this->lang->line('module_company_title');?></label>
      <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_company');?>..." name="company">
        <option value="0"><?php echo $this->lang->line('xin_all_companies');?></option>
        <?php foreach($all_companies as $company) {?>
        <option value="<?php echo $company->company_id;?>" <?php if($company_id==$company->company_id):?> selected="selected" <?php endif;?>> <?php echo $company->name;?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="title"><?php echo $this->lang->line('xin_title');?></label>
      <input type="text" class="form-control" name="title" placeholder="<?php echo $this->lang->line('xin_title');?>" value="<?php echo $title;?>">
    </div>
    <div class="form-group">
      <label for="message"><?php echo $this->lang->line('xin_description');?></label>
      <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" id="description2"><?php echo $description;?></textarea>
    </div>
	<div class="form-group">
			<label for="name"><?php echo $this->lang->line('xin_department');?></label>
			<select id="select2" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>..." name="department_id">
			<option value="">Choose Department</option>
			<option <?php if($department_id == '0'):?> selected <?php endif;?> value="0">All Departments</option>
			<?php foreach($all_departments as $deparment) {?>
			<option <?php if($department_id == $deparment->department_id):?> selected <?php endif;?> value="<?php echo $deparment->department_id?>"><?php echo $deparment->department_name?></option>
			<?php } ?>
			</select>
	</div>
	<div class='form-group'>
	<label>Document</label><br>
	<a href="<?php echo base_url().'uploads/document/'.$document;?>" target="_blank">
	<?php echo "<img src=".base_url().'uploads/image/attachment.png'.">".$document ?>
	</a></br>
	<small>(max upload file size is 20 MB and PDF only)</small>
	<input class="form-control" type="file" name="document">
	<input class="form-control" type="hidden" name="document_part" value="<?php echo $document; ?>">
	</div>			
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
</form>
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/select2/dist/css/select2.min.css">
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/select2/dist/js/select2.min.js"></script> 
<script type="text/javascript">
 $(document).ready(function(){
					
		// On page load: datatable
		var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : "<?php echo site_url("policy/policy_list") ?>",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		$('#description2').summernote({
		  height: 151,
		  minHeight: null,
		  maxHeight: null,
		  focus: false
		});
		$('.note-children-container').hide();

		/* Edit data */
/*		$("#edit_policy").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=policy&form="+action,
				cache: false,
				success: function (JSON) {
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('.save').prop('disabled', false);
					} else {
						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('.edit-modal-data').modal('toggle');
						$('.save').prop('disabled', false);
					}
				}
			});
		});
	*/	
		$("#edit_policy").submit(function(e){
		var fd = new FormData(this);
		var obj = $(this), action = obj.attr('name');
		var description = $("#description2").code();
	//	var n = $("#remark2")["code"]();
		fd.append("is_ajax", 1);
		fd.append("edit_type", 'policy');
		fd.append("description", description);
	//	fd.append("remark", n);
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
<?php } else if(isset($_GET['jd']) && isset($_GET['policy_id']) && $_GET['data']=='view_policy'){ 
		$all_departments = $this->Department_model->all_departments();
	?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_policy');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <div class="form-group">
      <label for="company"><?php echo $this->lang->line('module_company_title');?></label>
      <input class="form-control" readonly="readonly" style="border:0" type="text" value="<?php foreach($all_companies as $company) {?><?php if($company_id==$company->company_id):?><?php echo $company->name;?><?php endif;?><?php } ?>">
    </div>
    <div class="form-group">
      <label for="title"><?php echo $this->lang->line('xin_title');?></label>
      <input type="text" class="form-control" readonly="readonly" style="border:0" value="<?php echo $title;?>">
    </div>
    <div class="form-group">
      <label for="message"><?php echo $this->lang->line('xin_description');?></label>
      <br />
      <?php echo html_entity_decode($description);?> </div>
	 
            <div class="form-group">
              <label for="file_type">Department</label>
				<?php foreach($all_departments as $deparment) {?>
				<?php if($department_id == $deparment->department_id):?>			
              <input class="form-control" readonly="readonly" style="border:0" name="file_type" type="text" value="<?php echo $deparment->department_name?>">
             <?php endif;?>
			<?php } ?>
			 <?php if($department_id == 0):?>	
			<input class="form-control" readonly="readonly" style="border:0" name="file_type" type="text" value="<?php echo "All Departments";?>">
			  <?php endif;?>
			</div>
		<div class='form-group'>
			<label>Document</label><br>
				<?php if(($document != null) || ($document != '')){ ?>
				<a href="<?php echo base_url().'uploads/document/'.$document;?>" target="_blank">
				<?php echo "<img src=".base_url().'uploads/image/attachment.png'.">".$document ?>
				<?php }else{ ?>
				No file exists
				<?php } ?>
			</a></br>
		</div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
</form>
<?php }
?>
