<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$usertype_details_query="SELECT UserType, UserTypeID FROM user_types ORDER BY UserTypeID";
$usertype_details_result=mysqli_query($DBLink,$usertype_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($usertype_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
