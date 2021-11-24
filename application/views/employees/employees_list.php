<?php
/* Employees view
*/
?>
<?php 
$session = $this->session->userdata('username');
?>

<div class="add-form" style="display:none;">
  <div class="box box-block bg-white">
    <h2><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_employee');?>
      <div class="add-record-btn">
        <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-minus icon"></i> <?php echo $this->lang->line('xin_hide');?></button>
      </div>
    </h2>
    <div class="row m-b-1">
      <div class="col-md-12">
        <form action="<?php echo site_url("employees/add_employee") ?>" method="post" name="add_employee" id="xin-form">
          <input type="hidden" name="_user" value="<?php echo $session['user_id'];?>">
          <div class="bg-white">
		  <p><span class="alerts">*</span> Marked field are mandatory</p>
            <div class="box-block">
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="first_name"><?php echo $this->lang->line('xin_employee_first_name');?><span class="alerts">*</span></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="last_name" class="control-label"><?php echo $this->lang->line('xin_employee_last_name');?><span class="alerts">*</span></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="department"><?php echo $this->lang->line('xin_employee_department');?><span class="alerts">*</span></label>
                        <select class="form-control" name="department_id" id="aj_department" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_department');?>">
                          <option value=""></option>
                          <?php foreach($all_departments as $department) {?>
                          <option value="<?php echo $department->department_id?>"><?php echo $department->department_name?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" id="designation_ajax">
                        <label for="designation"><?php echo $this->lang->line('xin_designation');?><span class="alerts">*</span></label>
                        <select class="form-control" name="designation_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="username"><?php echo $this->lang->line('dashboard_username')."/Email";?><span class="alerts">*</span></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username')."/Email";?>" name="username" type="text" value="">
					
                      </div>
                    </div>
					<div class="col-md-6">
                      <div class="form-group">
                        <label for="xin_employee_password"><?php echo $this->lang->line('xin_employee_password');?><span class="alerts">*</span></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="password" value="">
                      </div>
                    </div>
                   <div class="col-md-6">
                      <div class="form-group">
                        <label for="email" class="control-label"><?php echo $this->lang->line('dashboard_email');?><span class="alerts">*</span></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="text" value="">
                      </div>
                    </div> 
                  </div>
                  <div class="row">
               <!--     <div class="col-md-6">
                      <div class="form-group">
                        <label for="date_of_birth"><?php echo $this->lang->line('xin_employee_dob');?></label>
                        <input class="form-control date_of_birth" readonly placeholder="<?php echo $this->lang->line('xin_employee_dob');?>" name="date_of_birth" type="text" value="">
                      </div>
                    </div> -->
                 <!--   <div class="col-md-6">
                      <div class="form-group">
                        <label for="contact_no" class="control-label"><?php echo $this->lang->line('xin_contact_number');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_no" type="text" value="">
                      </div>
                    </div> -->
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="employee_id"><?php echo $this->lang->line('dashboard_employee_id');?><span class="alerts">*</span></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_employee_id');?>" name="employee_id" type="text" value="">
                      </div>
                    </div>
            <!--        <div class="col-md-6">
                      <div class="form-group">
                        <label for="date_of_joining" class="control-label"><?php echo $this->lang->line('xin_employee_doj');?></label>
                        <input class="form-control date_of_joining" readonly placeholder="<?php echo $this->lang->line('xin_employee_doj');?>" name="date_of_joining" type="text" value="">
                      </div>
                    </div> -->
					<div class="col-md-6">
                      <div class="form-group">
                        <label for="contact_no" class="control-label"><?php echo $this->lang->line('xin_contact_number');?><span class="alerts">*</span></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_no" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
					<div class="col-md-6">
                      <div class="form-group">
                        <label for="grade" class="control-label"><?php echo "Grade";?></label>
                        <select class="form-control" name="grade" data-plugin="select_hrm" data-placeholder="Select Grade">
						<option value="">Select Grade</option>
						<?php foreach($all_grades as $all_grade){ ?>
                          <option value="<?php echo $all_grade->id; ?>"><?php print_r($all_grade->grade); ?></option>
						<?php } ?>
                        </select>
                      </div>
                    </div>
					<div class="col-md-6">
                      <div class="form-group">
                        <label for="role"><?php echo $this->lang->line('xin_employee_role');?><span class="alerts">*</span></label>
                        <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_role');?>">
                          <option value=""></option>
                          <?php foreach($all_user_roles as $role) {?> 
						  <?php if($role->role_id != 1){?>
                          <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                          <?php }} ?>
                        </select>
                      </div>
                    </div>
                  </div>
           <!--        <div class="row">
                   <div class="col-md-12">
                      <div class="form-group">
                        <label for="office_shift_id" class="control-label"><?php echo $this->lang->line('xin_employee_office_shift');?></label>
                        <select class="form-control" name="office_shift_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_office_shift');?>">
                          <?php foreach($all_office_shifts as $shift) {?>
                          <option value="<?php echo $shift->office_shift_id?>"><?php echo $shift->shift_name?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div> 
                  </div> -->
				  
                  <div class="row">
                 <!--   <div class="col-md-6">
                      <div class="form-group">
                        <label for="xin_employee_password"><?php echo $this->lang->line('xin_employee_password');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="text" value="">
                      </div>
                    </div> -->
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="confirm_password" class="control-label"><?php echo $this->lang->line('xin_employee_cpassword');?><span class="alerts">*</span></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_cpassword');?>" name="confirm_password" type="password" value="">
                      </div>
                    </div>
					<div class="col-md-6">
                      <div class="form-group">
                        <label for="gender" class="control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
                        <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
	
		<div class="row">
		<div class="col-md-6">
			<div class='form-group'>
			  <div><label for="dsc_signature">Upload DSC Signature</label></div>
				<span> 
				 <input type="file" name="dsc_signature">
					</span>
                      <br>
				  <small>Upload file only: JPG,PNG</small><br><small>Image size: Not more than 200 KB </small><br><small>Diamension: Should be 200(W) X 100(H)</small> </div> 
                  </div>

			    <div class="col-md-6">
                    <div class='form-group'>
                      <div><label for="signature">Upload e-Signature</label></div>
                      	<span> 
                         <input type="file" name="signature" onchange="readURL(this);">
                        </span>
                      <br>
                      <small>Upload file only: JPG,PNG</small><br><small>Image size: Not more than 200 KB </small><br><small>Diamension: Should be 200(W) X 100(H)</small> </div> 
                  </div>
				  <img id="blah" src="#" alt="" />
				</div>	

	<script type="text/javascript">
	     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(80)
                        .height(80);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
	</script>
	
              <div class="form-group">
                <label for="address"><?php echo $this->lang->line('xin_employee_address');?></label>
                <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_address');?>" name="address" cols="30" rows="3" id="address"></textarea>
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
  <h2><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_employees');?>
<?php if($session['user_role_id'] == 1){ ?>   
   <div class="add-record-btn">
      <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-plus icon"></i> <?php echo $this->lang->line('xin_add_new');?></button>
    </div>
<?php } ?>	
  </h2>
  <div class="table-responsive" data-pattern="priority-columns">
    <table class="table table-striped table-bordered dataTable" id="xin_table">
      <thead>
        <tr>
		<?php if($session['user_role_id'] == 1){ ?>
			<th><?php echo $this->lang->line('xin_action');?></th>
			<th><?php echo $this->lang->line('xin_employees_id');?></th>
			<th><?php echo $this->lang->line('xin_employees_full_name');?></th>
			<th><?php echo $this->lang->line('dashboard_email');?></th>
			<th><?php echo $this->lang->line('left_location');?></th>
			<th><?php echo $this->lang->line('left_department');?></th>
			<th><?php echo $this->lang->line('xin_employee_role');?></th>
			<th><?php echo $this->lang->line('xin_designation');?></th>
			<th><?php echo "Grade";?></th>
			<th><?php echo $this->lang->line('dashboard_xin_status');?></th> 
		 <?php }else{ ?>
			<th><?php echo $this->lang->line('xin_employees_full_name');?></th>
			<th><?php echo $this->lang->line('dashboard_email');?></th>
			<th><?php echo $this->lang->line('left_location');?></th>
			<th><?php echo $this->lang->line('left_department');?></th>
			<th><?php echo $this->lang->line('xin_designation');?></th>
			<th><?php echo "Grade";?></th>
		 <?php } ?>	 
         
		 <th><?php echo $this->lang->line('dashboard_contact_no');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>