<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$personcd=explode(",",$_POST['personcd']);
$personcd_clause='';
for($i = 0; $i < count($personcd); $i++){
    $personcd_clause.="'".$personcd[$i]."',";
}

$personcd_clause=rtrim($personcd_clause,',');

$emp_query="SELECT personcd, officer_name, off_desg, remarks.remarks, poststat, mob_no FROM personnel INNER JOIN remarks ON personnel.remarks = remarks.remarks_cd WHERE personnel.personcd IN ($personcd_clause) AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random)";
$emp_result=mysqli_query($DBLink,$emp_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($emp_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
