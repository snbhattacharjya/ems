<?php
session_start();
$subdiv = $_POST['subdiv'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$office_subdiv_query="SELECT officecd AS OfficeCode, office AS OfficeName, office_unique_id AS UniqueID FROM office WHERE subdivisioncd='$subdiv' ORDER BY MID(officecd,7,4)";

$office_subdiv_result=mysqli_query($DBLink,$office_subdiv_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($office_subdiv_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
