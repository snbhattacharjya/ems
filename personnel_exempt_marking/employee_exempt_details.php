<?php
session_start();
$user_id=$_SESSION['UserID'];
$block_code=substr($user_id,3,6);
if(isset($_SESSION['Subdiv']))
{
    $subdiv=$_SESSION['Subdiv'];
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");


$employee_exempt_query="SELECT office.officecd, office.office, personnel.personcd, personnel.officer_name, personnel.off_desg, personnel.mob_no, remarks.remarks, personnel_exempt_marked.reason FROM ((office INNER JOIN personnel ON office.officecd = personnel.officecd) INNER JOIN remarks ON personnel.remarks = remarks.remarks_cd) INNER JOIN personnel_exempt_marked ON personnel.personcd = personnel_exempt_marked.personcd WHERE personnel_exempt_marked.UserID = '$user_id' ORDER BY office.officecd, personnel.officer_name";

$employee_exempt_result=mysqli_query($DBLink,$employee_exempt_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($employee_exempt_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
