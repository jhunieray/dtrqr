<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.2/css/select.dataTables.min.css">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Employees</h3>
            	<div class="box-tools">
                    <button data-toggle="modal" data-target="#employeeModal" class="btn btn-success btn-sm">Add Employee</button> 
                    <button disabled id="delete_employee" data-toggle="modal" data-target="#delemployeeModal" class="btn btn-danger btn-sm">Delete</a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped display" style="width:100%" id="employee_table" >
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="checkbox select-checkbox"></th>
    						<th>ID</th>
    						<th>First Name</th>
    						<th>Last Name</th>
                            <th>Created By</th>
    						<th>Datetime Added</th>
    						<th>Datetime Updated</th>
    						<th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>              
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form_add_employee">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="employeeModalLabel">Add Employee</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="first_name" class="control-label"><span class="text-danger">*</span>First Name</label>
                    <div class="form-group">
                        <input required type="text" name="first_name" autofocus="" value="<?php echo $this->input->post('first_name'); ?>" class="form-control" id="first_name" />
                        <span class="text-danger"><?php echo form_error('first_name');?></span>
                    </div>
                    <label for="last_name" class="control-label"><span class="text-danger">*</span>Last Name</label>
                    <div class="form-group">
                        <input required type="text" name="last_name" value="<?php echo $this->input->post('last_name'); ?>" class="form-control" id="last_name" />
                        <span class="text-danger"><?php echo form_error('last_name');?></span>
                    </div>
                    <center><code class="info"></code></center>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="qremployeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="employeeModalLabel">Generate QR Code</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" align="center">
                <img id="qr_img" class="img" width="250px" src=""/>
            </div>
            <div class="modal-footer">
                <a id="print_qr_btn" target="_blank" href="#" type="button" class="btn btn-info">Print</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editemployeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form_edit_employee">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="employeeModalLabel">Edit Employee</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="first_name" class="control-label"><span class="text-danger">*</span>First Name</label>
                    <div class="form-group">
                        <input required type="text" name="first_name" class="form-control" id="edit_first_name" />
                        <span class="text-danger"><?php echo form_error('first_name');?></span>
                    </div>
                    <label for="last_name" class="control-label"><span class="text-danger">*</span>Last Name</label>
                    <div class="form-group">
                        <input required type="text" name="last_name" class="form-control" id="edit_last_name" />
                        <span class="text-danger"><?php echo form_error('last_name');?></span>
                    </div>

                    <input type="hidden" id="edit_id" name="edit_id" value="">
                    <center><code class="info"></code></center>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="delemployeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form_del_employee">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="employeeModalLabel">Delete Employee/s</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center><label>Are you sure you want to delete the following employee/s?</label></center>
                    <p class='ditems'></p>
                    <center><code class="info"></code></center>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.min.js"></script>
<script src="<?php echo site_url('resources/js/custom/employee.js');?>"></script>
