<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$userid=$_SESSION['UserID'];
require_once("../config/config.php");

$page_name=$_POST['PageName'];
$page_title=$_POST['PageTitle'];
$page_icon=$_POST['PageIcon'];

if(file_exists("../".$page_name)){
	$update_page_query=$mysqli->prepare("UPDATE app_pages SET PageTitle=?, PageIcon=?, ModifiedDate=now() WHERE PageName=?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
	
	$update_page_query->bind_param("sss",$page_title,$page_icon,$page_name) or die(json_encode(array("Status"=>"Error","Message"=>$update_page_query->error)));
	
	$update_page_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$update_page_query->error)));
	
	echo json_encode(array("Status"=>"Success","Message"=>"Record Updated Successfully"));
}
else
{
	echo json_encode(array("Status"=>"Error","Message"=>"File Not Found"));
}
?>