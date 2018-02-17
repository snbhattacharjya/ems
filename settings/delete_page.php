<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$userid=$_SESSION['UserID'];
require_once("../config/config.php");

$page_name=$_POST['PageName'];

if(file_exists("../".$page_name)){
	$delete_page_query=$mysqli->prepare("DELETE FROM app_pages WHERE PageName=?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
	
	$delete_page_query->bind_param("s",$page_name) or die(json_encode(array("Status"=>"Error","Message"=>$delete_page_query->error)));
	
	$delete_page_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$delete_page_query->error)));
	
	echo json_encode(array("Status"=>"Success","Message"=>"Record Deleted Successfully"));
}
else
{
	echo json_encode(array("Status"=>"Error","Message"=>"File Not Found"));
}
?>