<?php
session_start();
$userid=$_SESSION['UserID'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");

//die(json_encode(array("Status"=>"Fail")));

//Officer Name
$update_booth_personnel_query=$mysqli->prepare("UPDATE policestation_booth_personnel INNER JOIN policestation_personnel ON policestation_booth_personnel.personcd = policestation_personnel.personcd SET policestation_booth_personnel.officer_name = policestation_personnel.officer_name") or die(json_encode(array("Status"=>$mysqli->error)));
$update_booth_personnel_query->execute() or die(json_encode(array("Status"=>$update_booth_personnel_query->error)));
$update_booth_personnel_query->close();

//Assembly Name
$update_booth_personnel_query=$mysqli->prepare("UPDATE policestation_booth_personnel INNER JOIN assembly ON policestation_booth_personnel.assemblycd = assembly.assemblycd SET policestation_booth_personnel.assemblyname = assembly.assemblyname") or die(json_encode(array("Status"=>$mysqli->error)));
$update_booth_personnel_query->execute() or die(json_encode(array("Status"=>$update_booth_personnel_query->error)));
$update_booth_personnel_query->close();

//Police Station Name
$update_booth_personnel_query=$mysqli->prepare("UPDATE policestation_booth_personnel INNER JOIN policestation ON policestation_booth_personnel.policestationcd = policestation.policestationcd SET policestation_booth_personnel.policestation = policestation.policestation") or die(json_encode(array("Status"=>$mysqli->error)));
$update_booth_personnel_query->execute() or die(json_encode(array("Status"=>$update_booth_personnel_query->error)));
$update_booth_personnel_query->close();

//Polling Station Name
$update_booth_personnel_query=$mysqli->prepare("UPDATE policestation_booth_personnel INNER JOIN policestation_booth ON policestation_booth_personnel.assemblycd = policestation_booth.assemblycd AND policestation_booth_personnel.psno = policestation_booth.psno SET policestation_booth_personnel.psname = policestation_booth.psname") or die(json_encode(array("Status"=>$mysqli->error)));
$update_booth_personnel_query->execute() or die(json_encode(array("Status"=>$update_booth_personnel_query->error)));
$update_booth_personnel_query->close();

$mysqli->close();	
echo json_encode(array("Status"=>"Success"));
?>