<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$userid=$_SESSION['UserID'];
require_once("../config/config.php");
if(isset($_POST['UserType']))
$user_type_id=$_POST['UserType'];
else
$user_type_id="";
if($user_type_id!=""){
	$app_page_query=$mysqli->prepare("SELECT app_pages.PageName, app_pages.PageTitle, app_pages.ModifiedDate FROM app_pages INNER JOIN user_type_menu ON app_pages.PageName=user_type_menu.PageName WHERE user_type_menu.UserTypeID=? ORDER BY user_type_menu.MenuOrder, user_type_menu.SubMenuOrder") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
	
	$app_page_query->bind_param("i",$user_type_id)or die(json_encode(array("Status"=>"Error","Message"=>$app_page_query->error)));
}
else{
	$app_page_query=$mysqli->prepare("SELECT PageName, PageTitle, ModifiedDate FROM app_pages ORDER BY PageName") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
}

$app_page_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$app_page_query->error)));

$app_page_query->bind_result($page_name, $page_title, $modified_date) or die(json_encode(array("Status"=>"Error","Message"=>$app_page_query->error)));

$return=array();
while($app_page_query->fetch()){
	$return[]=array("PageName"=>$page_name,"PageTitle"=>$page_title,"ModifiedDate"=>$modified_date);
}

echo json_encode($return);
?>