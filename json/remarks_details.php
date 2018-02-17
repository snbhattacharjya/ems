<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");



$remarks_details_query="SELECT remarks_cd AS RemarksCode, remarks AS RemarksName FROM remarks ORDER BY remarks_cd";

$remarks_details_result=mysql_query($remarks_details_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($remarks_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>