<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
if(isset($_SESSION['Office']))
$office=$_SESSION['Office'];
else
die(json_encode("ERROR"));
$subdiv_name_query="SELECT office AS OfficeName FROM office WHERE officecd='$office'";

$subdiv_name_result=mysqli_query($DBLink,$subdiv_name_query) or die(mysqli_error($DBLink));
$return=mysqli_fetch_assoc($subdiv_name_result);

echo json_encode($return);
?>
