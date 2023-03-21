<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.2/css/select.dataTables.min.css">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Daily Time Record</h3>
            	<div class="box-tools">
                    <a href="<?= site_url('employee_time') ?>" class="btn btn-success btn-sm">Log Employee Time</a> 
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped display" style="width:100%" id="employee_time_table" >
                    <thead>
                        <tr>
    						<th>Logged ID</th>
    						<th>Employee</th>
    						<th>Logged By</th>
                            <th>Date</th>
    						<th>Time In</th>
    						<th>Time Out</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>              
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.min.js"></script>
<script src="<?php echo site_url('resources/js/custom/employee_dtr.js');?>"></script>
