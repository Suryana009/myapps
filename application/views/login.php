<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title>Login Administrator</title>
	
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/dist/css/AdminLTE.min.css')?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/plugins/iCheck/square/blue.css')?>" rel="stylesheet">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
  		<div class="login-logo">
    		<a href="<?php echo base_url(); ?>"><b>My</b>APPS</a>
  		</div>
		
		<div class="login-box-body">
			
			<form action="<?php echo base_url('login/proses');?>" method="post">
      			<div class="form-group has-feedback">
        			<input type="text" name="username" class="form-control" placeholder="Username">
        			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      			</div>
      			<div class="form-group has-feedback">
        			<input type="password" name="password" class="form-control" placeholder="Password">
        			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
      			</div>
      			<div class="row">
					 <div class="col-xs-4">
          				<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        			</div>
				</div>
    		</form>
		</div>
	</div>

<script src="<?php echo base_url('assets/plugins/jQuery/jquery-3.1.1.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
</body>
</html>