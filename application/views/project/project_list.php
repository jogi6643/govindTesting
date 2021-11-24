<?php
/* Project view
*/
?>
<?php $session = $this->session->userdata('username');?>

<div class="add-form" style="display:none;">
  <div class="box box-block bg-white">
    <h2><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo "Document Diary";?>
      <div class="add-record-btn">
        <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-minus icon"></i> <?php echo $this->lang->line('xin_hide');?></button>
      </div>
    </h2>
    <div class="row m-b-1">
      <div class="col-md-12">
        <form action="<?php echo site_url("project/add_project") ?>" method="post" name="add_project" id="xin-form">
          <input type="hidden" name="user_id" value="<?php echo $session['user_id'];?>">
          <div class="bg-white">
            <div class="box-block">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="title"><?php echo $this->lang->line('xin_title');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_title');?>" name="title" type="text">
                  </div>
				</div> 
				<div class="col-md-3">
                  <div class="form-group">
                    <label for="title"><?php echo $this->lang->line('xin_delivery_mode');?></label>
                    
					<select name="delivery_mode" id="select2-demo-6" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_delivery_mode');?>">
                        <option value="">Select Delivery Mode</option>
						<option value="Email">Email</option>
                        <option value="Physical">Physical</option>
                        <option value="Online">Online</option>
                       
                      </select>
                  </div>
				</div> 
				<div class="col-md-3">
                  <div class="form-group">
                    <label for="title"><?php echo $this->lang->line('xin_file_letter_reference_no');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_file_letter_reference_no');?>" name="file_letter_reference_no" type="text">
                  </div>
				</div> 
			 </div>
                  <div class="row" >
				  <div style="padding:10px 0 0 13px; font-weight:bold;"><label for="title">From Sender Details</label></div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="client_name"><?php echo $this->lang->line('xin_client_name');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_client_name');?>" name="client_name" type="text">
                      </div>
                    </div>
					 <div class="col-md-3">
                      <div class="form-group">
                        <label for="designation"><?php echo $this->lang->line('xin_designation');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_designation');?>" name="designation" type="text">
                      </div>
                    </div>
					<div class="col-md-3">
                      <div class="form-group">
                        <label for="organization_name"><?php echo $this->lang->line('xin_organization_name');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_organization_name');?>" name="organization_name" type="text">
                      </div>
                    </div>           
                                    
					<div class="col-md-3">
                      <div class="form-group">
                        <label for="client_name"><?php echo $this->lang->line('xin_organization_address');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_organization_address');?>" name="organization_address" type="text">
                      </div>
                    </div>
                   
                  </div>
				  
				     <div class="row">
				  
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="client_name"><?php echo $this->lang->line('xin_contact_number');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_no" type="text">
                      </div>
                    </div>
					<div class="col-md-3">
                      <div class="form-group">
                        <label for="client_name"><?php echo $this->lang->line('xin_fax_no');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_fax_no');?>" name="fax_no" type="text">
                      </div>
                    </div>
					<div class="col-md-3">
                      <div class="form-group">
                        <label for="client_name"><?php echo $this->lang->line('xin_mobile_no');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_mobile_no');?>" name="mobile_no" type="text">
                      </div>
                    </div>
					<div class="col-md-3">
                      <div class="form-group">
                        <label for="client_name"><?php echo $this->lang->line('xin_email');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email_id" type="text">
                      </div>
                    </div>
                   
                  </div>
				  
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="start_date"><?php echo $this->lang->line('xin_start_date');?></label>
                        <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text">
                      </div>
                    </div>
					 <div class="col-md-3">
                    <div class="form-group">
                      <label for="employee"><?php echo $this->lang->line('xin_p_priority');?></label>
                      <select name="priority" id="select2-demo-6" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_p_priority');?>">
                        <option value="1">Highest</option>
                        <option value="2">High</option>
                        <option value="3">Normal</option>
                        <option value="4">Low</option>
                      </select>
                    </div>
                  </div>
				  <div class="col-md-6">
					<div class='form-group'>
					  <label>Document</label>
						<input class="form-control" type="file" name="document" value=""/>
					</div>
					</div>
                   
                  </div>
                   <div class="row">
			   <div style="padding:10px 0 0 13px; font-weight:bold;"><label for="title">To Receiver Details</label></div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="employee"><?php echo $this->lang->line('xin_project_manager');?></label>
                  <select multiple name="assigned_to[]" id="select2-demo-6" class="form-control select-border-color border-warning" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project_manager');?>">
                    <option value=""></option>
                    <?php foreach($all_employees as $employee) {?>
                    <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
			  <div class="col-md-3">
                      <div class="form-group">
                        <label for="end_date"><?php echo $this->lang->line('xin_end_date');?></label>
                        <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text">
                      </div>
                    </div>
			  
             <!-- <div class="col-md-3">
                <div class="form-group">
                  <label for="summary"><?php echo $this->lang->line('xin_summary');?></label>
                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_summary');?>" name="summary" cols="30" rows="1" id="summary"></textarea>
                </div>
              </div>-->
            </div>
                </div>
              
			  
             
            
			<div class="row">
			  <div class="col-md-12">
                  <div class="form-group">
                    <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                    <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" cols="30" rows="15" id="description"></textarea>
                  </div>
                </div>
			</div>
              <div class="text-right">
              <button type="submit" class="btn btn-primary save">Save <i class="icon-circle-right2 position-right"></i> <i class="icon-spinner3 spinner position-left"></i></button>
            </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

<div class="box box-block bg-white">
  <h2><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo "Document Diary";?>
    <div class="add-record-btn">
      <button class="btn btn-sm btn-primary add-new-form"><i class="fa fa-plus icon"></i> <?php echo $this->lang->line('xin_add_new');?></button>
    </div>
  </h2>
  <div class="table-responsive" data-pattern="priority-columns">
    <table class="table table-striped table-bordered dataTable" id="xin_table" style="width:100%;">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
        <th><?php echo "Document Summary"?></th>
  <!--      <th><?php echo $this->lang->line('xin_project_summary');?></th> -->
        <th><?php echo $this->lang->line('xin_p_priority');?></th>
        <th><?php echo $this->lang->line('xin_p_enddate');?></th>
        <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
        <th><?php echo $this->lang->line('xin_project_users');?></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
