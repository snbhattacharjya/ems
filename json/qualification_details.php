<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$qualification_query="SELECT qualificationcd AS QualificationCode, qualification AS QualificationName FROM qualification ORDER BY qualificationcd";
$qualification_result=mysqli_query($DBLink,$qualification_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($qualification_result))
{
	$return[]=$row;
}

echo json_encode($return);
?>
