<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");


if(!isset($_SESSION['Subdiv'])){
    $assembly_details_query=$mysqli->prepare("SELECT assemblycd AS AssemblyCode, assemblyname AS AssemblyName FROM assembly ORDER BY assemblycd") or die($mysqli->error);
}
else{
    $assembly_details_query=$mysqli->prepare("SELECT assemblycd AS AssemblyCode, assemblyname AS AssemblyName FROM assembly WHERE subdivisioncd = ? ORDER BY assemblycd") or die($mysqli->error);
    $assembly_details_query->bind_param("s",$_SESSION['Subdiv']) or die($assembly_details_query->error);
}

$assembly_details_query->execute() or die($assembly_details_query->error);
$assembly_details_query->bind_result($asm_code,$asm_name) or die($assembly_details_query->error);
$return=array();
while($assembly_details_query->fetch())
{
	$return[]=array("AssemblyCode"=>$asm_code,"AssemblyName"=>$asm_name);
}	
echo json_encode($return);
?>