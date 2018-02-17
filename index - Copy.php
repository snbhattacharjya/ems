<?php
include("config/config.php");
$select=mysql_query("SELECT environment, distnm_cap, distnm_sml FROM environment");
$fetch=mysql_fetch_assoc($select);
?>
<html>
  <head>
    <title>EMS</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="plugins/font-awesome-4.3.0/css/font-awesome.min.css">
     
        <!-- select2-->
    <link rel="stylesheet" href="plugins/select2/select2.css" />
    <!-- DATA TABLES -->
    <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	<!-- Ion Slider -->
    <link rel="stylesheet" href="plugins/ionslider/ion.rangeSlider.css">
    <!-- ion slider Nice -->
    <link rel="stylesheet" href="plugins/ionslider/ion.rangeSlider.skinNice.css">
        <!-- Daterange picker -->
    <link href="plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/toogle_switch.css">
    <!-- main css -->
    <link href="css/ems.min.css" rel="stylesheet" type="text/css" />
    <!-- EMS Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    
    <style>
	.login-page {
		background:url(img/devoops_pattern_b10.png) #CAE3D0 repeat;
	}
	
	.form-1 {
    /* Size & position */
    width: 300px;
    margin: 0px auto 30px;
    padding: 10px;
	padding-top:20px;
    position: relative; /* For the submit button positioning */

    /* Styles */
    box-shadow: 
        0 0 1px #999999, 
        0 3px 7px #999999, 
        inset 0 1px rgba(255,255,255,1),
        inset 0 -3px 2px rgba(0,0,0,0.25);
    border-radius: 5px;
    background: linear-gradient( #5248FF, #55AAF0 50%);
}

.form-1 .field {
    position: relative; /* For the icon positioning */
}
.form-1 .field i {
    /* Size and position */
    left: 0px;
    top: 0px;
    position: absolute;
    height: 36px;
    width: 36px;

    /* Line */
    border-right: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 1px 0 0 rgba(255, 255, 255, 0.7);

    /* Styles */
    color: #777777;
    text-align: center;
    line-height: 43px;
    transition: all 0.3s ease-out;
    pointer-events: none;
}
.form-1 input[type=text],
.form-1 input[type=password] {
    font-family: 'Lato', Calibri, Arial, sans-serif;
    font-size: 14px;
	font-weight: 900;
    text-shadow: 0 1px 0 rgba(255,255,255,0.8);

    /* Size and position */
    width: 100%;
    padding: 10px 18px 10px 45px;

    /* Styles */
    border: none; /* Remove the default border */
    box-shadow: 
        inset 0 0 5px rgba(0,0,0,0.1),
        inset 0 3px 2px rgba(0,0,0,0.1);
    border-radius: 3px;
    background: #EFEFED;
    color: #777;
    transition: color 0.3s ease-out;
}

.form-1 input[type=text] {
    margin-bottom: 10px;
}
.form-1 input[type=text]:hover ~ i,
.form-1 input[type=password]:hover ~ i {
    color: #52cfeb;
}

.form-1 input[type=text]:focus ~ i,
.form-1 input[type=password]:focus ~ i {
    color: #42A2BC;
}

.form-1 input[type=text]:focus,
.form-1 input[type=password]:focus,
.form-1 button[type=submit]:focus {
    outline: none;
}
.form-1 .submit {
    /* Size and position */
    width: 65px;
    height: 65px;
    position: absolute;
    top: 30px;
    right: -25px;
	padding: 10px;
    z-index: 2;
	
	background: #ffffff;
    border-radius: 50%;
	    box-shadow: 
        inset 0 -3px 2px #CCCCCC;
}
.form-1 .submit:after {
    /* Size and position */
    width: 10px;
    height: 10px;
    position: absolute;
    top: -2px;
    left: 30px;

    /* Styles */
    
    /* Other masks trick */
    box-shadow: 0 62px white, -32px 31px white;
}
.form-1 button {
    /* Size and position */
    width: 100%;
    height: 100%;
    margin-top: -1px;

    /* Icon styles */
    font-size: 1.4em;
    line-height: 1.75;
    color: white;

    /* Styles */
    border: none; /* Remove the default border */
    border-radius: inherit;
    background: linear-gradient(#52cfeb, #42A2BC);
    box-shadow: 
        inset 0 1px 0 rgba(255,255,255,0.3),
        0 1px 2px rgba(0,0,0,0.35),
        inset 0 3px 2px rgba(255,255,255,0.2),
        inset 0 -3px 2px rgba(0,0,0,0.1);

    cursor: pointer;
}
.form-1 button:hover,
.form-1 button[type=submit]:focus {
    background: #52cfeb;
    transition: all 0.3s ease-out;
}

.form-1 button:active {
    background: #42A2BC;
    box-shadow: 
        inset 0 0 5px rgba(0,0,0,0.3),
        inset 0 3px 4px rgba(0,0,0,0.3);
}
	
	</style>
  </head>
  <body id="body" class="login-page">
    <div class="login-box" id="login_box">
      <div class="login-logo bg-white">
        <a href="index.php">
        <img src="img/india-ashoka-emblem.gif" height="100">
        <br>
        Welcome to<br>
        <b><?php echo $fetch['environment']; ?> <?php echo $fetch['distnm_cap']; ?> District</b></a>
      </div><!-- /.login-logo -->
      
            <form class="form-1">
            <p class="field">
            <input type="text" placeholder="UserId" id="userid">
            <i class="fa fa-user"></i>
            </p>
            <p class="field">
            <input type="password" name="password" placeholder="Password" id="password">
            <i class="fa fa-key"></i>
            </p>        
            <div class="submit">
            <button type="button" id="loginBtn"><i class="fa fa-arrow-right"></i></button>
            </div>
            </form>

    </div><!-- /.login-box -->
<div class="wrapper" id="main_page_div" hidden="">
   <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>E</b>MS</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="img/india-ashoka-emblem.gif" alt="Logo" height="40" width="40" class=" text-left">
          
          <b>EMS</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="glyphicon glyphicon-align-justify"></span>
          </a>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                 <!-- <span class="label label-info">0</span>
                </a>
                
              </li>
              <!-- Notifications: style can be found in dropdown.less 
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="glyphicon glyphicon-bell"></i>
                  <!--<span class="label label-warning">0</span>
                </a>
               </li>
                
              <!-- Tasks: style can be found in dropdown.less 
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class=" glyphicon glyphicon-tasks"></i>
                  <!--<span class="label label-danger">0</span>
                </a>
              </li>
                
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu" id="userprofile">
               
              </li>
          
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less --> 
        <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
              <img src="img/ar7110Male.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
				<p></p>
              <i class="fa fa-circle text-success"></i>&nbsp;&nbsp;Online
            </div>
          </div>
       

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <div id="menu">
          </div>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div id="main_container" class="content-wrapper">
        <section class="content-header">
        <h1>
        Welcome to Election Management System,
        <?php echo $fetch['distnm_sml']; ?> District
          </h1>
				<ol class="breadcrumb">
					<li class="active" id="PageTitle">Dashboard</li>
				</ol>

        </section>

        <section class="content">
		<div class="row">
			<div class="col-sm-12" id="timer_div" hidden="">
              <div class="info-box bg-purple" hidden="">
                <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Comments</span>
                  <span class="info-box-number" id="time_left">41,410</span>
                  <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                  </div>
                  <span class="progress-description">
                    <b id="start_time"></b>
					<b id="end_time"></b>
                  </span>
                </div><!-- /.info-box-content --> 
              </div><!-- /.info-box -->
            </div><!-- /.col -->
		</div>
        <div class="row" id="authorization_div"  hidden="">
        	<div class="col-sm-12">
                <div class="callout callout-danger">
            	<h4><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;AUTHORIZATION NOT GRANTED.</h4>
            	<p>You are not authorized to open the page. Please contact the Administrator.</p>
            </div>
            </div>
        </div>
		<div id="page_content">
			<!-- Your Page Content Here -->
		</div>
        </section><!-- /.content -->
</div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right">
        <img src="img/logo_nic.png" height="35">
        </div>
        <strong>Developed & maintained by NIC, Hooghly </strong>
      </footer>
</div><!-- /.wrapper -->

  </body>
   <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>

	<script src="plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/Bank.js" type="text/javascript"></script>
	<script src="js/Assembly.js" type="text/javascript"></script>
    <script src="js/pc.js" type="text/javascript"></script>
    <script src="js/Language.js" type="text/javascript"></script>
	<script src="js/District.js" type="text/javascript"></script>
	<script src="js/Qualification.js" type="text/javascript"></script>
	<script src="js/Remarks.js" type="text/javascript"></script>
	<script src="js/Subdivision.js" type="text/javascript"></script>
	<script src="js/personnel.js" type="text/javascript"></script>
	<script src="js/validator.js" type="text/javascript"></script>
	<script src="js/gender.js" type="text/javascript"></script>
	<script src="js/Nature.js" type="text/javascript"></script>
	<script src="js/Category.js" type="text/javascript"></script>
    <script src="js/PoliceStation.js" type="text/javascript"></script>
    <script src="js/Municipality.js" type="text/javascript"></script>
	<!--<script src="js/PPCategorization.js"></script>-->
	<script src="js/usertype.js" type="text/javascript"></script>
	<script src="js/users.js" type="text/javascript"></script>
    <script src="js/login.js" type="text/javascript"></script>
    <script src="js/logout.js" type="text/javascript"></script>
	<script src="js/timer.js" type="text/javascript"></script>
	<script src="js/settings.js" type="text/javascript"></script>
    <script src="js/audit.js" type="text/javascript"></script>
	<script src="js/insert_employee.js"  type="text/javascript"></script>
    <script src="js/office.js" type="text/javascript"></script>
    <script src="js/dashboard.js" type="text/javascript"></script>
    <!-- input mask-->
    <script src="plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/moment.js" type="text/javascript"></script>
    <script src="plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="plugins/select2/select2.min.js"></script>
    <!-- Ion Slider -->
   <script src="plugins/ionslider/ion.rangeSlider.min.js" type="text/javascript"></script>
    
    <script>
		$('#loginBtn').click(function(e) {
            e.preventDefault();
			login();
        });
	</script>
</html>