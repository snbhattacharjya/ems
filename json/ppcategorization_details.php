<?php
//session_start();
//$offcat=$_POST['OfficCategory'];
$subdiv=$_POST[''];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$PPCategory_details_query="SELECT id, parameter, query FROM categorizationpp ORDER BY id";

$ppcategory_details_result=mysqli_query($DBLink,$PPCategory_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($ppcategory_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
