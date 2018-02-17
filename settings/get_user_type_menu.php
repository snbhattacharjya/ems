<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$user_type_id=$_POST['UserType'];
require_once("../config/config.php");
$user_type_id=$_POST['UserType'];

$user_type_menu_query=$mysqli->prepare("SELECT user_type_menu.PageName, app_pages.PageTitle, MenuType, MenuOrder, SubMenuOrder, MultiMenuTitle, MultiMenuIcon, app_pages.PageIcon, user_type_menu.ModifiedDate FROM app_pages INNER JOIN user_type_menu ON app_pages.PageName=user_type_menu.PageName WHERE user_type_menu.UserTypeID=? ORDER BY MenuOrder, SubMenuOrder") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));

$user_type_menu_query->bind_param("i",$user_type_id) or die(json_encode(array("Status"=>"Error","Message"=>$user_type_menu_query->error)));

$user_type_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$user_type_menu_query->error)));

$user_type_menu_query->bind_result($page_name,$page_title,$menu_type,$menu_order,$sub_menu_order,$multi_menu_title,$multi_menu_icon, $page_icon,$modified_date) or die(json_encode(array("Status"=>"Error","Message"=>$user_type_menu_query->error)));

$return=array();
while($user_type_menu_query->fetch()){
	$return[]=array("PageName"=>$page_name,"PageTitle"=>$page_title,"MenuType"=>$menu_type,"MenuOrder"=>$menu_order,"SubMenuOrder"=>$sub_menu_order,"MultiMenuTitle"=>$multi_menu_title,"MultiMenuIcon"=>$multi_menu_icon,"PageIcon"=>$page_icon,"ModifiedDate"=>$modified_date);
}

echo json_encode($return);
?>