<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$officecd=$_SESSION['Office'];

$office_details_query="SELECT * FROM office WHERE officecd='$officecd'";

$office_details_result=mysql_query($office_details_query,$DBLink) or die(mysql_error());

$return=mysql_fetch_assoc($office_details_result);
echo json_encode($return);
?>