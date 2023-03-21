<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>dtrqr</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap.min.css');?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo site_url('resources/css/font-awesome.min.css');?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Datetimepicker -->
        <link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap-datetimepicker.min.css');?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo site_url('resources/css/AdminLTE.min.css');?>">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo site_url('resources/css/_all-skins.min.css');?>">
        <!-- jQuery 2.2.4 -->
        <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    </head>
    
    <body class="hold-transition">
    	<br><br><br><br>
    	<div class="wrapper">
    		<?= form_open('login') ?>
	    		<div class="row">
		    		<div class="col-md-offset-4 col-md-4">
						<div class="box">
							<div class="box-header text-center">
								<h4 class="box-title">DTR-QR SYSTEM LOGIN</h4>
							</div>
							<div class="box-body">
								<label for="user_name" class="control-label">User Name</label>
						        <div class="form-group">
						            <input type="text" name="user_name" autofocus="" class="form-control" id="user_name" required />
						            <span class="text-danger"><?php echo form_error('user_name');?></span>
						        </div>
						        <label for="user_password" class="control-label">Password</label>
						        <div class="form-group">
						            <input type="password" name="user_password" class="form-control" id="user_password" required />
						            <span class="text-danger"><?php echo form_error('user_password');?></span>
						        </div>
						        <div class="text-center form-group">
							        <span id="err_msg" class="text-danger"><?= $err_msg ?></span>
							    </div>
						        <div class="form-group text-right">
						        	<button type="submit" class="btn btn-md btn-primary btn-block">Log In</button>
						        </div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
        <!-- ./wrapper -->
        <input type="hidden" id="base_url" value="<?= base_url() ?>">

        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo site_url('resources/js/bootstrap.min.js');?>"></script>
        <!-- FastClick -->
        <script src="<?php echo site_url('resources/js/fastclick.js');?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo site_url('resources/js/app.min.js');?>"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo site_url('resources/js/demo.js');?>"></script>
        <!-- DatePicker -->
        <script src="<?php echo site_url('resources/js/moment.js');?>"></script>
        <script src="<?php echo site_url('resources/js/bootstrap-datetimepicker.min.js');?>"></script>
        <script src="<?php echo site_url('resources/js/global.js');?>"></script>
    </body>
</html>