<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['expense_id']) && $_GET['data']=='expense'){
?>
<?php $all_departments = $this->Department_model->all_departments(); ?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_edit_manual');?></h4>
</div>
<form class="m-b-1" action="<?php echo site_url("expense/update").'/'.$expense_id; ?>" method="post" name="edit_expense" id="edit_expense">
  <input type="hidden" name="_method" value="EDIT">
  <input type="hidden" name="_token" value="<?php echo $expense_id;?>">
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
      <!--  <div class="form-group">
          <label for="employee"><?php echo $this->lang->line('xin_manual_type');?></label>
          <select name="expense_type" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_manual_type');?>">
            <option value=""></option>
            <?php foreach($all_expense_types as $expense_type) {?>
            <option value="<?php echo $expense_type->expense_type_id;?>" <?php if($expense_type->expense_type_id==$expense_type_id):?> selected <?php endif; ?>><?php echo $expense_type->name;?></option>
            <?php } ?>
          </select>
        </div> -->
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="purchase_date"><?php echo $this->lang->line('xin_date_of_expiry');?></label>
              <input class="form-control edate" placeholder="<?php echo $this->lang->line('xin_date_of_expiry');?>" readonly="true" name="purchase_date" type="text" value="<?php echo $purchase_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="amount"><?php echo $this->lang->line('xin_manual_title');?></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_manual_title');?>" name="amount" type="text" value="<?php echo $amount;?>">
            </div>
          </div>
        </div>
 <!--       <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="gift"><?php echo $this->lang->line('xin_purchased_by');?></label>
              <select name="employee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>...">
                <option value=""></option>
                <?php foreach($all_employees as $employee) {?>
                <option value="<?php echo $employee->user_id;?>" <?php if($employee->user_id==$employee_id):?> selected <?php endif; ?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div> -->
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <textarea class="form-control textarea" name="remarks" cols="25" rows="6" id="description2"><?php echo $remarks;?></textarea>
        </div>
      </div>
    </div>
    <div class="row">
<!--      <div class="col-md-6">
        <div class="form-group">
          <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
          <select name="status" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>...">
            <option value="0" <?php if($status=='0'):?> selected <?php endif; ?>>Pending</option>
            <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>>Approved</option>
            <option value="2" <?php if($status=='2'):?> selected <?php endif; ?> >Cancel</option>
          </select>
        </div>
      </div> -->
		 <div class="col-md-6">			
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
        </div>
      <div class="col-md-6">
        <div class='form-group'>
          <h6><?php echo $this->lang->line('xin_manual_attachment');?></h6>
          <span class="btn btn-primary btn-file">
            Browse <input type="file" name="bill_copy" id="bill_copy">
          </span>
          <br>
          <small><?php echo $this->lang->line('xin_expense_allow_files');?></small>
          <?php if($billcopy_file!='' && $billcopy_file!='no file') {?>
          <br />
        //  <a href="<?php echo site_url("download?type=expense&filename=".$billcopy_file."") ?>"><?php echo $this->lang->line('xin_download_file');?></a>
	<a href="<?php echo site_url(".$billcopy_file.") ?>"><?php echo $this->lang->line('xin_download_file');?></a>
          <?php } ?>
        </div>
      </div>
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
				url : "<?php echo site_url("expense/expense_list") ?>",
				type : 'GET'
			},
			"fnDrawCallback": function(settings){
			$('[data-toggle="tooltip"]').tooltip();          
			}
    	});
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		$('#description2').summernote({
		  height: 140,
		  minHeight: null,
		  maxHeight: null,
		  focus: false
		});
		$('.note-children-container').hide();
		$('.edate').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1900:' + (new Date().getFullYear() + 10),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
		});

		/* Edit data */
		$("#edit_expense").submit(function(e){
			var fd = new FormData(this);
			var obj = $(this), action = obj.attr('name');
			var description = $("#description2").code();
			fd.append("is_ajax", 2);
			fd.append("edit_type", 'expense');
			fd.append("description", description);
			fd.append("form", action);
			e.preventDefault();
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
					} else {
						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('.edit-modal-data').modal('toggle');
						$('.save').prop('disabled', false);
					}
				},
				error: function() 
				{
					toastr.error(JSON.error);
					$('.save').prop('disabled', false);
				} 	        
		   });
		});
	});	
  </script>
<?php } else if(isset($_GET['jd']) && isset($_GET['expense_id']) && $_GET['data']=='view_expense'){?>
<?php $all_departments = $this->Department_model->all_departments(); ?>


<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_manual');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <div class="row">
      <div class="col-md-6">
     <!--   <div class="form-group">
          <label for="type"><?php echo $this->lang->line('xin_manual_type');?></label>
          <input class="form-control" readonly="readonly" style="border:0" type="text" value="<?php foreach($all_expense_types as $expense_type) {?><?php if($expense_type_id==$expense_type->expense_type_id):?><?php echo $expense_type->name;?><?php endif;?><?php } ?>">
        </div> -->
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="purchase_date"><?php echo $this->lang->line('xin_date_of_expiry');?></label>
              <input class="form-control edate" readonly="readonly" style="border:0" type="text" value="<?php echo $purchase_date;?>">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="amount"><?php echo $this->lang->line('xin_manual_title');?></label>
              <input class="form-control" readonly="readonly" style="border:0" type="text" value="<?php echo $amount;?>">
            </div>
          </div>
        </div>
        <div class="row">
 <!--         <div class="col-md-12">
            <div class="form-group">
              <label for="xin_purchased_by"><?php echo $this->lang->line('xin_purchased_by');?></label>
              <input class="form-control" readonly="readonly" style="border:0" type="text" value="<?php foreach($all_employees as $employee) {?><?php if($employee_id==$employee->user_id):?><?php echo $employee->first_name.' '.$employee->last_name;?><?php endif;?><?php } ?>">
            </div>
          </div>
        </div>-->
		  <div class="col-md-12">
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
          </div>
	  </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description"><?php echo $this->lang->line('xin_description');?></label>
          <?php echo html_entity_decode($remarks);?>
        </div>
      </div>
    </div>
    <div class="row">
<!--      <div class="col-md-6">
        <div class="form-group">
          <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
          <?php if($status=='0'): $e_status = 'Pending'; ?>  <?php endif; ?>
          <?php if($status=='1'): $e_status = 'Approved';?>  <?php endif; ?>
          <?php if($status=='2'): $e_status = 'Cancel';?>  <?php endif; ?>
          <input class="form-control" readonly="readonly" style="border:0" type="text" value="<?php echo $e_status;?>">
        </div>
      </div> -->
	  
      <div class="col-md-6">
        <div class='form-group'>
          <h6><?php echo $this->lang->line('xin_manual_attachment');?></h6>
          <?php if($billcopy_file!='' && $billcopy_file!='no file') {?>
          <a target="_blank" href="<?php echo site_url("uploads/expense/".$billcopy_file) ?> "><?php echo $billcopy_file;?></a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
</form>
<?php }
?>
