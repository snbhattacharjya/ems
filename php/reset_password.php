<?php
session_start();
require("../config/config.php");
if(!isset($_POST['userid']))
echo die("Error!! Please try again later.");
$uid=$_POST['userid'];

$query_check_userid=mysqli_query($DBLink,"SELECT ChangePassword FROM users WHERE UserID='$uid'") or die("Error!! Something went wrong.");

if(mysqli_num_rows($query_check_userid))
{
$reset_password_query=mysqli_query($DBLink,"UPDATE users SET Password='$uid',ChangePassword=1 WHERE UserID='$uid'") or die("Error!! Something went wrong.");
echo "Reset Password Successful..";
}
else
echo "UserId is incorrect.";
?>
