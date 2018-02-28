<?php
session_start();
require("../config/config.php");

$UserID=$_SESSION['UserID'];

$user_details_query="SELECT UserName,Designation FROM users WHERE UserID='$UserID'";

$user_details_result=mysqli_query($DBLink,$user_details_query) or die(mysqli_error($DBLink));

$return=mysqli_fetch_assoc($user_details_result);

$username=$return["UserName"];
$desg=$return['Designation'];

?>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <img src="img/icon.jpg" class="user-image" alt="User" />
      <span class="hidden-xs"><?php echo $username; ?></span>
    </a>
    <ul class="dropdown-menu">
      <!-- User image -->
      <li class="user-header">
        <img src="img/icon.jpg" class="img-circle" alt="User Image" />
        <p>
          <?php echo $username; ?>
          <small><?php echo $desg; ?></small>
        </p>
      </li>
      <!-- Menu Body -->
      <li class="user-body">
        <div class="col-xs-6 text-center">
          <a href="#">Edit Profile</a>
        </div>
        <div class="col-xs- text-center">
          <a href="security/changeUserPassword.php" class="ajax_link">Change Password</a>
        </div>
      </li>
      <!-- Menu Footer-->
      <li class="user-footer">
        <div class="pull-right">
          <a href="#" onclick="LogOut()" class="btn bg-maroon" id="logout">Sign out</a>
        </div>
      </li>
    </ul>
