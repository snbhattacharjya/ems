<?php
session_start();
$userid=$_SESSION['UserID'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
//die(array("Status"=>"Fail"));
$personcd=$_POST['personcd'];
$training_type='01';

$unmark_training1_absent_query=$mysqli->prepare("DELETE FROM personnel_training_absent WHERE personcd = ? AND training_type = ?") or die(json_encode(array("Status"=>$mysqli->error)));

$unmark_training1_absent_query->bind_param("ss",$personcd,$training_type) or die(json_encode(array("Status"=>$unmark_training1_absent_query->error)));

$unmark_training1_absent_query->execute() or die(json_encode(array("Status"=>$unmark_training1_absent_query->error)));

$unmark_training1_absent_query->close();
$mysqli->close();
echo json_encode(array("Status"=>"Success"));
?>
