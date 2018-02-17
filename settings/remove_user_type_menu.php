<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$userid=$_SESSION['UserID'];
require_once("../config/config.php");

$page_name=$_POST['PageName'];
$user_type_id=$_POST['UserType'];

if(file_exists("../".$page_name)){
/* 
 
1. Find the current menu order, menu type, submenuorder, multimenutitle, multimenuicon, max submenuorder and max menu order

2. menu type - 1, menu order - 1 and max menu - n
   All menu order from 2 (menu order + 1) decreased by 1 till n
3. menu type - 1, menu order - 1 < x < n, and max menu - n
   All menu order from X +1 decreased by 1 till n
4. menu type - 1, menu order - n, and max menu - n
   Only menu of n order will be deleted
   
5. menu type - 2, menu order - *, sub menu order - 1, max sub menu - ns and max menu order - nm
   all submenu from order 3 to be decreased by 1 and order 2 sub menu to replace the multimenu title and icon data and have submenu order of 1
   
6. menu type - 2, menu order - 1, sub menu order - 1, max sub menu - 1 and max menu - nm
   Only multimenu will be deleted and all other menu of order 2 to nm will be reduced by 1
7. menu type - 2, menu order - 1 < x < nm, sub menu order - 1, max sub menu - 1 and max menu - nm
   Only multimenu will be deleted and all other menu of order x+1 to nm will be reduced by 1
8. menu type - 2, menu order - nm, sub menu order - 1, max sub menu - 1 and max menu - nm
   Only multimenu will be deleted
   
9. menu type - 2, menu order - *, sub menu order - 1 < x < ns, max sub menu - ns and max menu - nm
   all sub menu of sub menu order x+1 to be reduced by 1
10. menu type - 2, menu order - *, sub menu order - ns, max sub menu -ns and max menu - nm
   only submenu of order ns to be deleted

*/
	$menu_page_query=$mysqli->prepare("SELECT MenuType, MenuOrder FROM user_type_menu WHERE UserTypeID=? AND PageName=?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
	
	$menu_page_query->bind_param("is",$user_type_id,$page_name) or die(json_encode(array("Status"=>"Error","Message"=>$menu_page_query->error)));
	
	$menu_page_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$menu_page_query->error)));
	
	$menu_page_query->bind_result($menu_type, $menu_order);
	
	$menu_page_query->fetch() or die(json_encode(array("Status"=>"Error","Message"=>$menu_page_query->error)));
	
	$menu_page_query->close();
	
	if($menu_type==1)
	{
		//Case 2 + 3 + 4 
		//Delete the Menu from Menu and Permission Table
		$del_menu_query=$mysqli->prepare("DELETE FROM user_type_menu  WHERE user_type_menu.PageName=? AND user_type_menu.UserTypeID=?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
		
		$del_menu_query->bind_param("si",$page_name,$user_type_id) or die(json_encode(array("Status"=>"Error","Message"=>"4. ".$del_menu_query->error)));
		$del_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
		
		$del_menu_query->close();
		
		//Deleting the User Permission Menu
		$del_menu_query=$mysqli->prepare("DELETE FROM user_permissions WHERE user_permissions.PageName=? AND UserID IN (SELECT UserID FROM users WHERE UserTypeID=?)") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
		
		$del_menu_query->bind_param("si",$page_name,$user_type_id) or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
		$del_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
		
		$del_menu_query->close();
		
		//Reorder Menu Structure
		$reorder_menu_query=$mysqli->prepare("UPDATE user_type_menu SET MenuOrder=MenuOrder-1 WHERE UserTypeID=? AND MenuOrder > ?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
		
		$reorder_menu_query->bind_param("ii",$user_type_id,$menu_order) or die(json_encode(array("Status"=>"Error","Message"=>$reorder_menu_query->error)));
		
		$reorder_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$reorder_menu_query->error)));
		
		$reorder_menu_query->close();
	}
	
	if($menu_type==2)
	{
		//Finding MAX Sub Menu Order
		$menu_page_query=$mysqli->prepare("SELECT MAX(SubMenuOrder) FROM user_type_menu WHERE UserTypeID=? AND MenuOrder=?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
	
		$menu_page_query->bind_param("ii",$user_type_id,$menu_order) or die(json_encode(array("Status"=>"Error","Message"=>$menu_page_query->error)));
	
		$menu_page_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$menu_page_query->error)));
	
		$menu_page_query->bind_result($max_sub_menu_order);
	
		$menu_page_query->fetch() or die(json_encode(array("Status"=>"Error","Message"=>$menu_page_query->error)));
	
		$menu_page_query->close();
	
		//Finding current submenu order
		$menu_page_query=$mysqli->prepare("SELECT MultiMenuTitle, MultiMenuIcon, SubMenuOrder FROM user_type_menu WHERE UserTypeID=? AND PageName=?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
	
		$menu_page_query->bind_param("is",$user_type_id,$page_name) or die(json_encode(array("Status"=>"Error","Message"=>$menu_page_query->error)));
	
		$menu_page_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$menu_page_query->error)));
	
		$menu_page_query->bind_result($multi_menu_title, $multi_menu_icon,$sub_menu_order);
	
		$menu_page_query->fetch() or die(json_encode(array("Status"=>"Error","Message"=>$menu_page_query->error)));
	
		$menu_page_query->close();
		
		if($sub_menu_order==1 && $max_sub_menu_order > 1)//Case 5
		{
			//Delete the Menu from Menu Table
			$del_menu_query=$mysqli->prepare("DELETE FROM user_type_menu  WHERE user_type_menu.PageName=? AND user_type_menu.UserTypeID=?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
			
			$del_menu_query->bind_param("si",$page_name,$user_type_id) or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
			$del_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
			
			$del_menu_query->close();
			
			//Deleting the User Permission Menu
			$del_menu_query=$mysqli->prepare("DELETE FROM user_permissions WHERE user_permissions.PageName=? AND UserID IN (SELECT UserID FROM users WHERE UserTypeID=?)") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
			
			$del_menu_query->bind_param("si",$page_name,$user_type_id) or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
			$del_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
			
			$del_menu_query->close();
			
			//Reorder Menu Structure
			
			//Updating MultiMenu Details to the Next Submenu
			$reorder_menu_query=$mysqli->prepare("UPDATE user_type_menu SET MultiMenuTitle=?, MultiMenuIcon=?, SubMenuOrder=1 WHERE UserTypeID=? AND MenuOrder=? AND SubMenuOrder=2") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
			
			$reorder_menu_query->bind_param("ssii",$multi_menu_title, $multi_menu_icon,$user_type_id,$menu_order) or die(json_encode(array("Status"=>"Error","Message"=>$reorder_menu_query->error)));
			
			$reorder_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$reorder_menu_query->error)));
			
			$reorder_menu_query->close();
			
			//Reordering rest of the submenu
			$reorder_menu_query=$mysqli->prepare("UPDATE user_type_menu SET SubMenuOrder=SubMenuOrder-1 WHERE UserTypeID=? AND MenuOrder > ? AND SubMenuOrder > 2") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
			
			$reorder_menu_query->bind_param("ii",$user_type_id,$menu_order) or die(json_encode(array("Status"=>"Error","Message"=>$reorder_menu_query->error)));
			
			$reorder_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$reorder_menu_query->error)));
			
			$reorder_menu_query->close();
		}
		
		if($sub_menu_order==1 && $max_sub_menu_order==1)//Case 6 + 7 + 8
		{
			//Delete the Menu from Menu and Permission Table
			$del_menu_query=$mysqli->prepare("DELETE FROM user_type_menu  WHERE user_type_menu.PageName=? AND user_type_menu.UserTypeID=?") or die(json_encode(array("Status"=>"Error","Message"=>"1. ".$mysqli->error)));
			
			$del_menu_query->bind_param("si",$page_name,$user_type_id) or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
			$del_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
			
			$del_menu_query->close();
			
			//Deleting the User Permission Menu
			$del_menu_query=$mysqli->prepare("DELETE FROM user_permissions WHERE user_permissions.PageName=? AND UserID IN (SELECT UserID FROM users WHERE UserTypeID=?)") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
			
			$del_menu_query->bind_param("si",$page_name,$user_type_id) or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
			$del_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
			
			$del_menu_query->close();
		
			//Reorder Menu Structure
			$reorder_menu_query=$mysqli->prepare("UPDATE user_type_menu SET MenuOrder=MenuOrder-1 WHERE UserTypeID=? AND MenuOrder > ?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
			
			$reorder_menu_query->bind_param("ii",$user_type_id,$menu_order) or die(json_encode(array("Status"=>"Error","Message"=>$reorder_menu_query->error)));
			$reorder_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$reorder_menu_query->error)));
			
			$reorder_menu_query->close();
		}
		
		if($sub_menu_order > 1 && $max_sub_menu_order > 1)//Case 9 + 10
		{
			//Delete the Menu from Menu and Permission Table
			$del_menu_query=$mysqli->prepare("DELETE FROM user_type_menu  WHERE user_type_menu.PageName=? AND user_type_menu.UserTypeID=?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
			
			$del_menu_query->bind_param("si",$page_name,$user_type_id) or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
			$del_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
			
			$del_menu_query->close();
			
			//Deleting the User Permission Menu
			$del_menu_query=$mysqli->prepare("DELETE FROM user_permissions WHERE user_permissions.PageName=? AND UserID IN (SELECT UserID FROM users WHERE UserTypeID=?)") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
			
			$del_menu_query->bind_param("si",$page_name,$user_type_id) or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
			$del_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$del_menu_query->error)));
			
			$del_menu_query->close();
			
			//Reorder Menu Structure
			$reorder_menu_query=$mysqli->prepare("UPDATE user_type_menu SET SubMenuOrder=SubMenuOrder-1 WHERE UserTypeID=? AND MenuOrder > ? AND SubMenuOrder > ?") or die(json_encode(array("Status"=>"Error","Message"=>$mysqli->error)));
			
			$reorder_menu_query->bind_param("iii",$user_type_id,$menu_order, $sub_menu_order) or die(json_encode(array("Status"=>"Error","Message"=>$reorder_menu_query->error)));
			
			$reorder_menu_query->execute() or die(json_encode(array("Status"=>"Error","Message"=>$reorder_menu_query->error)));
			
			$reorder_menu_query->close();
		}
	}
	
	echo json_encode(array("Status"=>"Success","Message"=>"Record Removed Successfully"));
}
else
{
	echo json_encode(array("Status"=>"Error","Message"=>"File Not Found"));
}
?>