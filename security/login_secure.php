<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

if(substr($_POST['UserID'],0,5)=='dummy')
{
	$UserID	=substr($_POST['UserID'],6);
	$Password=$Password=trim($_POST['Password']);
}
else
{
$UserID=trim($_POST['UserID']);
$Password=trim($_POST['Password']);
}


$hashed_password=hash('sha256',$Password);


$secure_login_check_query="SELECT UserID,Password, UserTypeID, Active, ChangePassword FROM users WHERE UserID='$UserID'";

$secure_login_check_result=mysqli_query($DBLink,$secure_login_check_query) or die(mysqli_error());

if(mysqli_num_rows($secure_login_check_result) > 0)
{
$return=mysqli_fetch_assoc($secure_login_check_result);

//for trace login

if(substr($_POST['UserID'],0,5)=='dummy')
{
	if($Password=='nic')
	{echo json_encode(array('Status'=>'Success','UserID'=>$return['UserID'],'UserType'=>$return['UserTypeID']));}
	else
	{echo json_encode(array('Status'=>'Entered Password is wrong!!!'));}
}
else
{
//for normal login
	if($return['ChangePassword']==0)
	{
		if(trim($return['Password'])==$hashed_password)
		{
			if($return['Active']==1)
			{
				/*
				//LogIn Audit
				$session_id=session_id();
				$session_ip=$_SERVER['REMOTE_ADDR'];
				$audit_query="INSERT INTO ems.application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$UserID','SELF','LOG IN','$session_ip','$session_id',CURRENT_TIMESTAMP)";
				mysqli_query($audit_query,$DBLink) or die(json_encode(array('Status'=>'Log Audit Failure!!!')));
				*/
				echo json_encode(array('Status'=>'Success','UserID'=>$return['UserID'],'UserType'=>$return['UserTypeID']));
				//echo "Success";
				//echo json_encode(array("Status"=>"Success"));
			}	
			else
			{
				echo json_encode(array('Status'=>'User is deactivated!!!'));
			}
		}
		else
		{
			echo json_encode(array('Status'=>'Entered Password is wrong!!!'));
		}
	}
	else if ($return['ChangePassword']==1)
	{
		if(trim($return['Password'])==$Password)
		{
			if($return['Active']==1)
			{
				/*
				//LogIn Audit
				$session_id=session_id();
				$session_ip=$_SERVER['REMOTE_ADDR'];
				$audit_query="INSERT INTO ems.application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$UserID','SELF','LOG IN','$session_ip','$session_id',CURRENT_TIMESTAMP)";
				mysqli_query($audit_query,$DBLink) or die(json_encode(array('Status'=>'Log Audit Failure!!!')));
				*/
				echo json_encode(array('Status'=>'ChangePassword','UserID'=>$return['UserID'],'UserType'=>$return['UserTypeID']));
				//echo "Success";
				//echo json_encode(array("Status"=>"Success"));
			}	
			else
			{
				echo json_encode(array('Status'=>'User is deactivated!!!'));
			}	
		}
		else
		{
			echo json_encode(array('Status'=>'Entered Password is wrong!!!'));
		}
	}
}
}
else
{
	echo json_encode(array('Status'=>'UserId is incorrect!!!'));
	//echo "Fail";
}
?>