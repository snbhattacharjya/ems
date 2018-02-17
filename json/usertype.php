<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$usertype_details_query="SELECT UserType, UserTypeID FROM user_types ORDER BY UserTypeID";
$usertype_details_result=mysql_query($usertype_details_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($usertype_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>