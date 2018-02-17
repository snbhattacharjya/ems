<?php
session_start();
if(isset($_SESSION['UserID']))
{
$session_user_id=$_SESSION['UserID'];
}
else
	die("Error!! Please logout and login again.");
	
$session_id=session_id();
$session_ip=$_SERVER['REMOTE_ADDR'];

$source_office=$_POST['SourceOffice'];
$person=$_POST['Person'];
$new_office=$_POST['NewOffice'];

include("../config/config.php");

for($i = 0; $i < count($person); $i++){
	$new_person_code=substr($new_office,0,6).substr($person[$i],-5);
	$update_query=$mysqli->prepare("UPDATE personnel SET personcd=?, officecd=? WHERE personcd=?") or die(json_encode(array("Status"=>$mysqli->error)));
	$update_query->bind_param("sss",$new_person_code,$new_office,$person[$i]) or die(json_encode(array("Status"=>$update_query->error)));
	$update_query->execute() or die(json_encode(array("Status"=>$update_query->error)));
	$update_query->close();
	
	$audit_query=$mysqli->prepare("INSERT INTO application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$session_user_id','$person[$i]','EMPLOYEE OFFICE TRANSFER','$session_ip','$session_id',CURRENT_TIMESTAMP)") or die(json_encode(array("Status"=>$mysqli->error)));
	$audit_query->execute() or  die(json_encode(array("Status"=>$audit_query->error)));
	$audit_query->close();
}

$mysqli->close();
echo json_encode(array("Status"=>"Records Transfer Count: ".count($person)));