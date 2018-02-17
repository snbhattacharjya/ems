<?php
session_start();
require("../config/config.php");
if(!isset($_POST['userid']))
echo die("Error!! Please try again later.");
$uid=$_POST['userid'];

$query_check_userid=mysql_query("SELECT ChangePassword FROM users WHERE UserID='$uid'") or die("Error!! Something went wrong.");

if(mysql_num_rows($query_check_userid))
{
$reset_password_query=mysql_query("UPDATE users SET Password='$uid',ChangePassword=1 WHERE UserID='$uid'") or die("Error!! Something went wrong.");
echo "Reset Password Successful..";
}
else
echo "UserId is incorrect.";
?>