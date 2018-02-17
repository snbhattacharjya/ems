<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once("../config/config.php");

$page_name=$_POST['PageName'];
$user_type=$_POST['utype'];
$user_id=$_POST['uid'];
$permit_flag=$_POST['permit'];
$timer_flag=$_POST['timer'];

$start_time=date ("Y-m-d H:i",strtotime($_POST['start_time']));
$end_time=date ("Y-m-d H:i",strtotime($_POST['end_time']));	

//die(json_encode(array("Status"=>"Error","Message"=>$start_time)));
if($user_id=="All")
{
	$set_timer_query=$mysqli1->prepare("UPDATE user_permissions INNER JOIN users on user_permissions.UserID=users.UserID SET user_permissions.StartTime=?,user_permissions.EndTime=?,user_permissions.TimerFlag=?,user_permissions.PermitFlag=?,user_permissions.ModifiedDate=now() WHERE user_permissions.PageName=? AND users.UserTypeID=?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli1->error)));
		
		$set_timer_query->bind_param("ssiisi",$start_time,$end_time,$timer_flag,$permit_flag,$page_name,$user_type) or die(json_encode(array("Status"=>"Error","Message"=>$set_timer_query->error)));	
		$set_timer_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$set_timer_query->error)));
}
else
{

	$set_timer_query=$mysqli1->prepare("UPDATE user_permissions SET StartTime=?,EndTime=?,TimerFlag=?,PermitFlag=?,ModifiedDate=now() WHERE PageName=? AND UserID=?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli1->error)));
		
		$set_timer_query->bind_param("ssiiss",$start_time,$end_time,$timer_flag,$permit_flag,$page_name,$user_id) or die(json_encode(array("Status"=>"Error","Message"=>$set_timer_query->error)));	
		$set_timer_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$set_timer_query->error)));
	
}	
	echo json_encode(array("Status"=>"Success","Message"=>"Permission and Timer Successfully set"));

?>