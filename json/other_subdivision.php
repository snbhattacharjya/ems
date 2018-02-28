<?php
session_start();
$user_id=$_SESSION['UserID'];
$block_code=substr($user_id,3,6);
if(isset($_SESSION['Subdiv']))
{
    $subdiv=$_SESSION['Subdiv'];
}
 else {
     die();
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$subdivision_details_query="SELECT subdivisioncd AS SubdivCode, subdivision AS SubdivName FROM subdivision WHERE subdivisioncd NOT IN ('9999','$subdiv') ORDER BY subdivisioncd";
$subdivision_details_result=mysqli_query($DBLink,$subdivision_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($subdivision_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
