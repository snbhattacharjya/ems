<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$personcd=$_POST['EmpID'];
$person_details_query="SELECT * FROM personnel WHERE personcd='$personcd'";

$person_details_result=mysql_query($person_details_query,$DBLink) or die(mysql_error());

$return=mysql_fetch_assoc($person_details_result);
echo json_encode($return);
?>