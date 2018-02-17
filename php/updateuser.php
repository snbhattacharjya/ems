<?php
session_start();
$userid=$_SESSION['UserID'];
include("../config/config.php");
$username=$_POST['UserName'];
$designation=$_POST['Designation'];
$email=$_POST['EmailId'];
$mobile=$_POST['MobileNumber'];

$result=mysql_query("UPDATE `users` SET `UserName`='$username',`Designation`='$designation',`Email`='$email',`Mobile`='$mobile' WHERE `UserID`='$userid'",$DBLink) or die(mysql_error());
    echo "Record updated successfully at $userid";

?>