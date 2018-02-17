<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$userid=$_SESSION['UserID'];
require_once("../config/config.php");

$page_name=$_POST['PageName'];
$user_type_id=$_POST['UserType'];

$max_menu_order=1;
	
	$max_menu_query=$mysqli->prepare("SELECT MAX(MenuOrder) FROM user_type_menu WHERE UserTypeID=?") or die($mysqli->error);
	
	$max_menu_query->bind_param("i",$user_type_id) or die($max_menu_query->error);
	
	$max_menu_query->execute();
	
	$max_menu_query->bind_result($max_menu_order);
	
	$max_menu_query->fetch();
	
	$max_menu_query->close();
	
	if(is_null($max_menu_order))
		$max_menu_order=1;
	else
		$max_menu_order=$max_menu_order+1;
	
$add_menu_link_query=$mysqli->prepare("INSERT INTO user_type_menu (PageName, UserTypeID, MenuOrder, MenuType, ModifiedDate) VALUES(?,?,?,1,now())") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));

$add_menu_link_query->bind_param("sii",$page_name,$user_type_id,$max_menu_order) or die(json_encode(array("Status"=>"Error","Message"=>$add_menu_link_query->error)));

$add_menu_link_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$add_menu_link_query->error)));

$add_menu_link_query->close();

//Add PageName for all Users of the given usertype

$add_user_permit_query=$mysqli->prepare("INSERT INTO user_permissions (PageName, UserID, PermitFlag) (SELECT ?, UserID, 1 FROM users WHERE users.UserTypeID=?)")or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));

$add_user_permit_query->bind_param("si",$page_name,$user_type_id) or die(json_encode(array("Status"=>"Error","Message"=>$add_user_permit_query->error)));

$add_user_permit_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$add_user_permit_query->error)));

$add_user_permit_query->close();

echo json_encode(array("Status"=>"Success","Message"=>"Record Added Successfully"));

?>