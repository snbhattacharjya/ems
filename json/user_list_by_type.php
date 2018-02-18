<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$user_type_id=$_POST['UserTypeID'];
$user_details_query="SELECT UserID, UserTypeID, UserName,  Designation FROM users WHERE UserTypeID=$user_type_id ORDER BY UserID";
$user_details_result=mysqli_query($DBLink,$user_details_query) or die(mysqli_error());
$return=array();
while($row=mysqli_fetch_assoc($user_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>