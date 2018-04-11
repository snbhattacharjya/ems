<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$mobile_no=explode(",",$_POST['mobile_no']);
$mobile_no_clause='';
for($i = 0; $i < count($mobile_no); $i++){
    $mobile_no_clause.="'".$mobile_no[$i]."',";
}

$mobile_no_clause=rtrim($mobile_no_clause,',');

$emp_query="SELECT personcd, officer_name, off_desg, remarks.remarks, poststat, mob_no FROM personnel INNER JOIN remarks ON personnel.remarks = remarks.remarks_cd WHERE personnel.mob_no IN ($mobile_no_clause) AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random)";
$emp_result=mysqli_query($DBLink,$emp_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($emp_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
