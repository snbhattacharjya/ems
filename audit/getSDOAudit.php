<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$subdiv=$_SESSION['Subdiv'];
require_once("../config/config.php");

$audit_query=$mysqli->prepare("SELECT application_audit.UserID, users.UserName, users.Designation, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp FROM application_audit INNER JOIN users ON application_audit.UserID=users.UserID AND users.UserTypeID=4 AND MID(users.UserID,4,4)=? ORDER BY ActivityTimeStamp DESC") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));

$audit_query->bind_param("s",$subdiv) or die(json_encode(array("Status"=>"Error","Message"=>$audit_query->error)));

$audit_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$audit_query->error)));

$audit_query->bind_result($user_id, $user_name, $user_desg, $object_id, $object_activity, $request_ip, $session_id, $activity_timestamp) or die(json_encode(array("Status"=>"Error","Message"=>$audit_query->error)));

$return=array();
while($audit_query->fetch()){
	$return[]=array("UserID"=>$user_id,"UserName"=>$user_name,"Designation"=>$user_desg,"ObjectID"=>$object_id,"ObjectActivity"=>$object_activity,"RequestIP"=>$request_ip,"SessionID"=>$session_id,"ActivityTimeStamp"=>$activity_timestamp);
}

echo json_encode($return);
?>