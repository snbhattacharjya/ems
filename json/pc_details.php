<?php
session_start();
$subdiv=$_SESSION['Subdiv'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$pc_details_query="SELECT pc.pccd, pc.pcname FROM pc";


$pc_details_result=mysqli_query($DBLink,$pc_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($pc_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
