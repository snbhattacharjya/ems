<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$user_type_id=$_POST['UserTypeID'];
$user_details_query="SELECT UserID, UserTypeID, UserName,  Designation FROM users WHERE UserTypeID=$user_type_id ORDER BY UserID";
$user_details_result=mysql_query($user_details_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($user_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>