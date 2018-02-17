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

$copy_emp_query=mysql_query("INSERT INTO personnel_deleted SELECT * FROM personnel WHERE personcd='$empid'") or die(json_encode(mysql_error()));


$update_time_query=mysql_query("UPDATE personnel_deleted SET posted_date=now() WHERE personcd='$empid'") or die(json_encode(mysql_error()));

$del_emp_query="DELETE FROM personnel WHERE personcd='$empid'";


mysql_query($del_emp_query,$DBLink) or die(json_encode(mysql_error()));	
$insert_office_query=mysql_query("INSERT INTO application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$session_user_id','$empid','DELETE EMPLOYEE','$session_ip','$session_id',CURRENT_TIMESTAMP);")or die(json_encode(mysql_error()));
echo json_encode("Employee Successfully Removed...");
?>