<?php
session_start();
$UserTypeID=$_POST['UserTypeID'];
$UserID=$_POST['UserID'];
$_SESSION['UserTypeID']=$UserTypeID;
switch($UserTypeID)
{
	case 1: //For Admin Type Users
		$_SESSION['UserID']=$UserID;
		break;
	case 2: //For Office Type Users
		$_SESSION['UserID']=$UserID;
		$_SESSION['Office']=$UserID;
		$_SESSION['Subdiv']=substr($UserID,0,4);
		break;
	case 3://For DEO SDO Type Users
		$_SESSION['UserID']=$UserID;
		$_SESSION['Subdiv']=substr($UserID,3,4);
		break;
	case 4://For SDO Type Users
		$_SESSION['UserID']=$UserID;
		$_SESSION['Subdiv']=substr($UserID,-4);
		break;
	case 6:// For BDO Users
		$_SESSION['UserID']=$UserID;
		$_SESSION['Subdiv']=substr($UserID,3,4);
                $_SESSION['BlockMuni']=substr($UserID,-6);
	default:
		$_SESSION['UserID']=$UserID;	
}
?>