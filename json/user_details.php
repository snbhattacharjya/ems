<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$UserID=$_POST['UserID'];

$user_details_query="SELECT users.UserID, users.UserTypeID, user_types.UserType, user_types.DashBoard FROM users INNER JOIN user_types ON users.UserTypeID=user_types.UserTypeID WHERE users.UserID='$UserID'";

$user_details_result=mysqli_query($DBLink,$user_details_query) or die(mysqli_error($DBLink));

$return=mysqli_fetch_assoc($user_details_result);
echo json_encode($return);
?>
