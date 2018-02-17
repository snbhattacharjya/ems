<?php
session_start();
$subdiv=$_SESSION['Subdiv'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$pc_details_query="SELECT DISTINCT(assembly.pccd), pc.pcname FROM assembly INNER JOIN pc ON assembly.pccd=pc.pccd WHERE assembly.subdivisioncd='$subdiv'";


$pc_details_result=mysql_query($pc_details_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($pc_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>