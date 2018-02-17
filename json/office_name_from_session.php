<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
if(isset($_SESSION['Office']))
$office=$_SESSION['Office'];
else
die(json_encode());
$subdiv_name_query="SELECT office AS OfficeName FROM OFFICE WHERE officecd='$office'";

$subdiv_name_result=mysql_query($subdiv_name_query,$DBLink) or die(mysql_error());
$return=mysql_fetch_assoc($subdiv_name_result);

echo json_encode($return);
?>