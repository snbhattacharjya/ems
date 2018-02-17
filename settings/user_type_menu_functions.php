<?php
function getMaxMenuOrder($UserTypeID){
	//$max_menu_order=0;
	
	//$max_menu_query=$mysqli->prepare("SELECT MAX(MenuOrder) FROM user_type_menu WHERE UserTypeID=?") or die($mysqli->error);
	
	/*$max_menu_query->bind_param("i",$UserTypeID) or die($max_menu_query->error);
	
	$max_menu_query->execute();
	
	$max_menu_query->bind_result($max_menu_order);
	
	$max_menu_query->fetch();
	
	$max_menu_query->close();*/
	
	return $max_menu_order;
}

function getMaxSubMenuOrder($UserTypeID){
	$max_sub_menu_order=0;
	
	$max_sub_menu_query=$mysqli->prepare("SELECT MAX(SubMenuOrder) FROM user_type_menu WHERE UserTypeID=? AND MenuType=2") or die($mysqli->error);
	
	$max_sub_menu_query->bind_param("i",$UserTypeID) or die($max_sub_menu_query->error);
	
	$max_sub_menu_query->execute();
	
	$max_sub_menu_query->bind_result($max_sub_menu_order);
	
	$max_sub_menu_query->fetch();
	
	$max_sub_menu_query->close();
	
	return $max_sub_menu_order;
}
?>