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

	$add_page_query=$mysqli->prepare("INSERT INTO app_pages (PageName, PageTitle, PageIcon, ModifiedDate) VALUES(?,?,?,now())") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
	
	$add_page_query->bind_param("sss",$page_name,$page_title,$page_icon) or die(json_encode(array("Status"=>"Error","Message"=>$add_page_query->error)));
	
	$add_page_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$add_page_query->error)));
	
	echo json_encode(array("Status"=>"Success","Message"=>"Record Added Successfully"));
}
else
{
	echo json_encode(array("Status"=>"Error","Message"=>"File Not Found"));
}
?>