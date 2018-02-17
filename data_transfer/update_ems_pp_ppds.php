<?php
session_start();
require("../config/config.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$personcd=$_POST['personcd'];
$forassembly=$_POST['forassembly'];
$booked=$_POST['booked'];
$training1_sch=$_POST['training1_sch'];
$training2_sch=$_POST['training2_sch'];

$ems_ppds_update_query=$mysqli->prepare("UPDATE personnel SET forassembly = ?, booked = ?, training1_sch = ?, training2_sch = ? WHERE personcd = ?") or die(json_encode(array("Status"=>$mysqli->error)));
$ems_ppds_update_query->bind_param("sssss",$forassembly,$booked,$training1_sch,$training2_sch,$personcd) or die(json_encode(array("Status"=>$ems_ppds_update_query->error)));
$ems_ppds_update_query->execute() or die(json_encode(array("Status"=>$ems_ppds_update_query->error)));

$ems_ppds_update_query->close();
$mysqli->close();
echo json_encode(array("Status"=>"Success"));
?>