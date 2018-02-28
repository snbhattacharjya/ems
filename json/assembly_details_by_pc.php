<?php
session_start();
$subdiv=$_SESSION['Subdiv'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$pccd=$_POST['pc'];

$assembly_details_query="SELECT assemblycd AS AssemblyCode, assemblyname AS AssemblyName FROM assembly WHERE pccd='$pccd' AND subdivisioncd='$subdiv' ORDER BY assemblycd";

$assembly_details_result=mysqli_query($DBLink,$assembly_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($assembly_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
