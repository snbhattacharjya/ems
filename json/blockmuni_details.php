<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$blockmuni_details_query="SELECT blockminicd AS BlockMuniCode, blockmuni AS BlockMuniName FROM block_muni ORDER BY blockminicd";

$blockmuni_details_result=mysqli_query($DBLink,$blockmuni_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($blockmuni_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
