<?php
session_start();
$userid=$_SESSION['UserID'];
$subdiv=$_SESSION['Subdiv'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$policestation_details_query="SELECT policestationcd AS PoliceStationCode, policestation AS PoliceStation FROM policestation WHERE subdivisioncd='$subdiv'";


$policestation_details_result=mysqli_query($DBLink,$policestation_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($policestation_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
