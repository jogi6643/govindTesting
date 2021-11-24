<?php
/* Expense view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="add-form" style="display:none;">
  <div class="box box-block bg-white">
    <h2><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_manual');?>
      <div class="add-record-btn">
        <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-minus icon"></i> <?php echo $this->lang->line('xin_hide');?></button>
      </div>
    </h2>
    <div class="row m-b-1">
      <div class="col-md-12">
        <form action="<?php echo site_url("expense/add_expense") ?>" method="post" name="add_expense" id="xin-form" enctype="multipart/form-data">
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-6">
         <!--         <div class="form-group">
                    <label for="expense_type"><?php echo $this->lang->line('xin_manual_type');?></label>
                    <select name="expense_type" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_manual_type');?>">
                      <option value=""></option>
                      <?php foreach($all_expense_types as $expense_type) {?>
                      <option value="<?php echo $expense_type->expense_type_id;?>"><?php echo $expense_type->name;?></option>
                      <?php } ?>
                    </select>
                  </div> -->
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="purchase_date"><?php echo $this->lang->line('xin_date_of_expiry');?></label>
                        <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_date_of_expiry');?>" readonly name="purchase_date" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="amount"><?php echo $this->lang->line('xin_manual_title');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_manual_title');?>" name="amount" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
               <!--     <div class="col-md-12">
                      <div class="form-group">
                        <label for="gift"><?php echo $this->lang->line('xin_purchased_by');?></label>
                        <select name="employee_id" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>...">
                          <option value=""></option>
                          <?php foreach($all_employees as $employee) {?>
                          <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div> -->
                 
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="department" class="control-label"><?php echo $this->lang->line('xin_department');?></label>
                       <?php  if($session['user_role_id'] == '1'){ ?>
						<select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_department');?>">
                          <option value=""></option>
                          <option value="0">All Departments</option>
                          <?php 
						  $user =  $this->Xin_model->read_user_info($session['user_id']); 
						  foreach($all_departments as $department) {?>
                          <option value="<?php echo $department->department_id?>"><?php echo $department->department_name?></option>
                          <?php } ?>
                        </select>
					   <?php }else{ ?>
						<select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_department');?>">
                          <option value=""></option>
                          <option value="0">All Departments</option>
                          <?php 
						  $user =  $this->Xin_model->read_user_info($session['user_id']); 
						  foreach($all_departments as $department) {?>
						  <?php if($user[0]->department_id == $department->department_id):?>
                          <option  value="<?php echo $department->department_id?>"><?php echo $department->department_name?></option>
                          <?php endif; ?>
						  <?php } ?>
                        </select>					   
					   <?php } ?>
                      </div>
                    </div>
				</div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class='form-group'>
                        <h6><?php echo $this->lang->line('xin_manual_attachment');?></h6>
                        <span class="btn btn-primary btn-file">
                            Browse <input type="file" name="bill_copy" id="bill_copy">
                          </span>
                        <br>
                        <small><?php echo $this->lang->line('xin_manual_allow_files');?></small> </div>
                    </div>
                  </div>
                  <div class="add_billycopy_fields"></div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                    <textarea class="form-control textarea" name="remarks" cols="25" rows="6" id="description"></textarea>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_save');?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="box box-block bg-white">
  <h2><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_manual');?>
<?php if($session['user_role_id'] == '1' || $session['user_role_id'] == 10){ ?>  
    <div class="add-record-btn">
      <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-plus icon"></i> <?php echo $this->lang->line('xin_add_new');?></button>
    </div>
<?php }else{ 
	$user =  $this->Xin_model->read_user_info($session['user_id']); 
	$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
	$url = $designation[0]->designation_name;
	$str = strpos($url, 'HoD');
	$str1 = strpos($url, 'hod');
	$str2 = strpos($url, 'Hod');
	$str3 = strpos($url, 'HOD');
	if($str == true || $str1 == true || $str2 == true || $str3 == true){
	?>	
    <div class="add-record-btn">
      <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-plus icon"></i> <?php echo $this->lang->line('xin_add_new');?></button>
    </div>
<?php } }?>	
  </h2>
  <div class="table-responsive" data-pattern="priority-columns">
    <table class="table table-striped table-bordered dataTable" id="xin_table">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><?php echo $this->lang->line('xin_department');?></th>
   <!--       <th><?php echo $this->lang->line('xin_manual_type');?></th> -->
          <th><?php echo $this->lang->line('xin_manual_title');?></th>
          <th><?php echo $this->lang->line('xin_date_of_expiry');?></th>
  <!--        <th><?php echo $this->lang->line('dashboard_xin_status');?></th> -->
        </tr>
      </thead>
    </table>
  </div>
</div>