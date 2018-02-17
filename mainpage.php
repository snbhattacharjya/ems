<?php 
	session_start();
	//$userid=$_GET["userid"];
	//$_SESSION["UserID"]=$userid;	
	include("config/config.php");
	$select=mysql_query("SELECT distnm_sml FROM environment");
	$fetch=mysql_fetch_assoc($select);
?>

    <!-- data table -->
    <script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="plugins/select2/select2.min.js"></script>
<div class="wrapper">
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



