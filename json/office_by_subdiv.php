<?php
session_start();
if(isset($_SESSION['Subdiv']))
{
$subdiv=$_SESSION['Subdiv'];
}
else
{
	die(json_encode());	
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$office_subdiv_query="SELECT officecd AS OfficeCode, office AS OfficeName, office_unique_id AS UniqueID FROM office WHERE subdivisioncd='$subdiv' ORDER BY MID(officecd,7,4)";

$office_subdiv_result=mysql_query($office_subdiv_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($office_subdiv_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>