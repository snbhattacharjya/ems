<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$PPStat_details_query="SELECT post_stat,poststatus FROM poststat";

$ppstat_details_result=mysqli_query($DBLink,$PPStat_details_query) or die(mysqli_error());
$return=array();
while($row=mysqli_fetch_assoc($ppstat_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>