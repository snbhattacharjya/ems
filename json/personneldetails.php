<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$personcd=$_POST['EmpID'];
$person_details_query="SELECT * FROM personnel WHERE personcd='$personcd'";

$person_details_result=mysqli_query($DBLink,$person_details_query) or die(mysqli_error($DBLink));

$return=mysqli_fetch_assoc($person_details_result);
echo json_encode($return);
?>
