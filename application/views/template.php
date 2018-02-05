<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Administrator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/fullcalendar/fullcalendar.css');?>"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/datatables/dataTables.bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/select2/select2.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/dist/jquery.fancybox.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/booststrap-validator/bootstrapValidator.min.css');?>"/>        
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-colorpicker/bootstrap-colorpicker.min.css');?>"/>

  	</head>
  	
    <body class="hold-transition skin-blue sidebar-mini">
	
	<div class="wrapper">

  		<header class="main-header">
    		<a href="<?php echo base_url('dashboard'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">MAP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>My Apps</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url('assets/dist/img/avatar5.png'); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata("nama_lengkap"); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url('assets/dist/img/avatar5.png'); ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $this->session->userdata("nama_lengkap"); ?>
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('login/logout'); ?>" onClick="return confirm('Anda yakin ingin keluar dari sistem ?')" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
      </header>
  
  	<aside class="main-sidebar">
		  <?php echo $_sidebar; ?>
	</aside>

  	<div class="content-wrapper">
		<?php echo $_content; ?>
	</div>
	
	<footer class="main-footer">
    	<?php echo $_footer; ?>
  	</footer>

  	<div class="control-sidebar-bg"></div>
</div>

<script src="<?php echo base_url('assets/jQuery/jquery-2.1.4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/select2/select2.full.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/booststrap-validator/bootstrapValidator.min.js');?>"></script>
<script src="<?php echo base_url('assets/fullcalendar/fullcalendar.min.js');?>"></script>
<script src="<?php echo base_url('assets/bootstrap-colorpicker/bootstrap-colorpicker.min.js');?>"></script>
<script src="<?php echo base_url('assets/bootbox/bootbox.min.js');?>"></script>

<script type="text/javascript">
  $(document).ready(function () {
  $('.tanggal').datepicker({
    format: "yyyy-mm-dd",
    autoclose:true
  });
});
</script>

  </body>
</html>