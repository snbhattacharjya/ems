<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$subdiv=$_POST['subdiv'];
$training_date=$_POST['training_date'];

$assembly_query=$mysqli->prepare("SELECT assembly.assemblycd, assembly.assemblyname, COUNT(personnel.personcd) FROM ((personnel INNER JOIN assembly ON personnel.assembly_temp = assembly.assemblycd) INNER JOIN training_schedule ON personnel.training1_sch = training_schedule.schedule_code) INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue WHERE personnel.personcd NOT IN (SELECT personcd FROM personnel_training_absent) AND training_venue.subdivisioncd = ? AND training_schedule.training_dt = ? GROUP BY assembly.assemblycd, assembly.assemblyname ORDER BY assembly.assemblycd") or die($mysqli->error);
$assembly_query->bind_param("ss",$subdiv,$training_date) or die($assembly_query->error);
$assembly_query->execute() or die($assembly_query->error);
$assembly_query->bind_result($assembly_code,$assembly_name,$pp_count) or die($assembly_query->error);
$return=array();
while($assembly_query->fetch())
{
    $return[]=array("AssemblyCode"=>$assembly_code,"AssemblyName"=>$assembly_name,"PPCount"=>$pp_count);
}
echo json_encode($return);
?>
