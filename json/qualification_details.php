<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$qualification_query="SELECT qualificationcd AS QualificationCode, qualification AS QualificationName FROM qualification ORDER BY qualificationcd";
$qualification_result=mysql_query($qualification_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($qualification_result))
{
	$return[]=$row;
}

echo json_encode($return);
?>