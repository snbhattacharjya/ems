<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$officecd=$_POST['OfficeCode'];
$officecd_clause='';
for($i = 0; $i < count($officecd); $i++){
    if($officecd[$i] != 'ALL')
            $officecd_clause.="'".$officecd[$i]."',";
    else{
            $officecd_clause='ALL';
            break;
    }
}

$officecd_clause=rtrim($officecd_clause,',');

$emp_query="SELECT personcd, officer_name, off_desg, remarks.remarks, poststat, mob_no FROM personnel INNER JOIN remarks ON personnel.remarks = remarks.remarks_cd WHERE officecd IN($officecd_clause) AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random)";
$emp_result=mysqli_query($DBLink,$emp_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($emp_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
