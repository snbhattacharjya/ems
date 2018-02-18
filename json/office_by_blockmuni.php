<?php
session_start();
$user_id=$_SESSION['UserID'];
$block_code=substr($user_id,3,6);
if(isset($_SESSION['Subdiv']))
{
$subdiv=$_SESSION['Subdiv'];
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

if(substr($user_id,0,3) == 'SDO'){
$office_blockmuni_query="SELECT officecd AS OfficeCode, office AS OfficeName, office_unique_id AS UniqueID FROM office WHERE subdivisioncd='$subdiv' ORDER BY MID(officecd,7,4)";
}

else if(substr($user_id,0,3) == 'BDO'){
	$office_blockmuni_query="SELECT officecd AS OfficeCode, office AS OfficeName, office_unique_id AS UniqueID FROM office WHERE subdivisioncd='$subdiv' AND blockormuni_cd='$block_code' ORDER BY MID(officecd,7,4)";
}

else {
	$office_blockmuni_query="SELECT officecd AS OfficeCode, office AS OfficeName, office_unique_id AS UniqueID FROM office ORDER BY officecd";
}
$office_blockmuni_result=mysqli_query($DBLink,$office_blockmuni_query) or die(mysqli_error());
$return=array();
while($row=mysqli_fetch_assoc($office_blockmuni_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>