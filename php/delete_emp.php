<?php
session_start();

$session_user_id=$_SESSION['UserID'];
$session_id=session_id();
$session_ip=$_SERVER['REMOTE_ADDR'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
if(!isset($_POST['emp']))
echo die(json_encode("Error!!"));
$empid=$_POST['emp'];

$copy_emp_query=mysqli_query($DBLink,"INSERT INTO personnel_deleted SELECT * FROM personnel WHERE personcd='$empid'") or die(json_encode(mysqli_error($DBLink,)));


$update_time_query=mysqli_query($DBLink,"UPDATE personnel_deleted SET posted_date=now() WHERE personcd='$empid'") or die(json_encode(mysqli_error($DBLink,)));

$del_emp_query="DELETE FROM personnel WHERE personcd='$empid'";


mysqli_query($DBLink,$del_emp_query) or die(json_encode(mysqli_error()));
$insert_office_query=mysqli_query($DBLink,"INSERT INTO application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$session_user_id','$empid','DELETE EMPLOYEE','$session_ip','$session_id',CURRENT_TIMESTAMP);")or die(json_encode(mysqli_error()));
echo json_encode("Employee Successfully Removed...");
?>
