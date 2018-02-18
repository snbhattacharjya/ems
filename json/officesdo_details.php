<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$officecd=$_SESSION['Office'];

$office_details_query="SELECT * FROM office WHERE officecd='$officecd'";

$office_details_result=mysqli_query($DBLink,$office_details_query) or die(mysqli_error());

$return=mysqli_fetch_assoc($office_details_result);
echo json_encode($return);
?>