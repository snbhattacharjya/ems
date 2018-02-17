<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$clean_personnel_query=$mysqli->prepare("DELETE FROM ppds.personnel") or die(json_encode(array("Status"=>$mysqli->error)));

$clean_personnel_query->execute() or die(json_encode(array("Status"=>$clean_personnel_query->error)));
$personnel_rows=$clean_personnel_query->affected_rows;
$clean_personnel_query->close();

$clean_office_query=$mysqli->prepare("DELETE FROM ppds.office") or die(json_encode(array("Status"=>$mysqli->error)));

$clean_office_query->execute() or die(json_encode(array("Status"=>$clean_office_query->error)));
$office_rows=$clean_office_query->affected_rows;
$clean_office_query->close();

echo json_encode(array("Status"=>"Success","OfficeCount"=>$office_rows,"PersonnelCount"=>$personnel_rows));
?>