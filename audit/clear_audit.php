<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$userid=$_SESSION['UserID'];
require_once("../config/config.php");


$audit_query=$mysqli->prepare("DELETE FROM application_audit") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));

$audit_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$audit_query->error)));

$return=array();
$return[]=array("Status"=>"Success","Message"=>"Audit Cleared Successfully");

echo json_encode($return);
?>