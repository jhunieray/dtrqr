<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.2/css/select.dataTables.min.css">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">List of Users</h3>
                <div class="box-tools">
                    <button data-toggle="modal" data-target="#userModal" class="btn btn-success btn-sm">Add User</button> 
                    <button disabled id="delete_user" data-toggle="modal" data-target="#deluserModal" class="btn btn-danger btn-sm">Delete</a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped display" style="width:100%" id="user_table" >
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="checkbox select-checkbox"></th>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>User Type</th>
                            <th>Datetime Added</th>
                            <th>Datetime Modified</th>
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
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form_add_user">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="userModalLabel">Add User</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="user_name" class="control-label"><span class="text-danger">*</span>User Name</label>
                    <div class="form-group">
                        <input type="text" name="user_name" autofocus="" value="<?php echo $this->input->post('user_name'); ?>" class="form-control" id="user_name" required />
                        <span class="text-danger"><?php echo form_error('user_name');?></span>
                    </div>
                    <label for="password" class="control-label"><span class="text-danger">*</span>Password <i>(Min. of 10 characters, must contain lowercase, uppercase, number, and special character.)</i></label>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$()!%*?&])[A-Za-z\d@#$()!%*?&]{10,}$" name="user_password" title="Min. of 10 characters, must contain lowercase, uppercase, number, and special character." value="<?php echo $this->input->post('user_password'); ?>" class="form-control" id="user_password" required />
                            <span class="input-group-btn">
                                <button id="btn_gen_pword" class="btn btn-default" type="button">Generate</button>
                            </span>
                        </div>
                        <span class="text-success" id="gen_pword_txt"></span>
                        <span class="text-danger"><?php echo form_error('user_password');?></span>
                    </div>
                    <label for="user_type" class="control-label"><span class="text-danger">*</span>User Type</label>
                    <div class="form-group">
                        <select name="user_type" class="form-control" id="user_type" >
                            <option value="1">Super Admin</option>
                            <option value="2">Admin</option>
                        </select>
                        <span class="text-danger"><?php echo form_error('user_type');?></span>
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

<div class="modal fade" id="edituserModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form_edit_user">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="userModalLabel">Edit User</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="edit_user_name" class="control-label"><span class="text-danger">*</span>User Name</label>
                    <div class="form-group">
                        <input required type="text" name="edit_user_name" readonly value="<?php echo $this->input->post('edit_user_name'); ?>" class="form-control" id="edit_user_name" />
                    </div>
                    <label for="edit_user_type" class="control-label"><span class="text-danger">*</span>User Type</label>
                    <div class="form-group">
                        <select required name="edit_user_type" class="form-control" id="edit_user_type" >
                            <option value="1">Super Admin</option>
                            <option value="2">Admin</option>
                        </select>
                        <span class="text-danger"><?php echo form_error('edit_user_type');?></span>
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

<div class="modal fade" id="editcpModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form_edit_cp">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="userModalLabel">Change Password</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="edit_cp_password" class="control-label"><span class="text-danger">*</span>New Password (Min. of 10 characters, must contain lowercase, uppercase, number, and special character.</label>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$()!%*?&])[A-Za-z\d@#$()!%*?&]{10,}$" name="edit_cp_password" value="<?php echo $this->input->post('edit_cp_password'); ?>" class="form-control" id="edit_cp_password" />
                            <span class="input-group-btn">
                                <button id="btn_gen_pword_cp" class="btn btn-default" type="button">Generate</button>
                            </span>
                        </div>
                        <span class="text-success" id="gen_pword_txt_cp"></span>
                        <span class="text-danger"><?php echo form_error('edit_cp_password');?></span>
                    </div>
                    <input type="hidden" id="edit_cp_id" name="edit_cp_id" value="">
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

<div class="modal fade" id="deluserModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form_del_user">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="userModalLabel">Delete User/s</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center><label>Are you sure you want to delete the following user/s?</label></center>
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
<input type="hidden" value="<?= $this->session->userdata('id') ?>" id="user_id_h">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.min.js"></script>
<script src="<?php echo site_url('resources/js/custom/user.js');?>"></script>
