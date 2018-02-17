<?php
session_start();
include "../config/config.php";
$session_user_id=$_SESSION['UserID'];
$session_id=session_id();
$session_ip=$_SERVER['REMOTE_ADDR'];

$mid=0;
$UserTypeID=$_POST['UserType'];
$Subdivision=$_SESSION['Subdiv'];
$UserName=$_POST['UserName'];
$Designation=$_POST['Designation'];
$EmailId=$_POST['EmailId'];
$Mobile=$_POST['MobileNumber'];
if($UserTypeID=="DEO")
{
$mid_user_query="SELECT MAX(MID(users.UserID,8,3)) as mid_user
FROM users
WHERE UserTypeID=3
AND (MID(users.UserID,4,4))=$Subdivision";
$mid=mysql_query($mid_user_query,$DBLink);
$midfetch=mysql_fetch_assoc($mid);
$mid1=$midfetch['mid_user']+1;
$UserTypeID=3;
$UserId="DEO".$Subdivision.str_pad($mid1,3,'0',STR_PAD_LEFT);

}



else if($UserTypeID=="SDO")
{
	$UserId="SDO".$Subdivision;
	$UserTypeID=4;
	$query_get_sdo=mysql_query("SELECT * FROM users WHERE UserID='$UserId'") or die(mysql_error());
	//TO CHECK WHETHER THIS SDO IS ALREADY CREATED
	
	if(mysql_num_rows($query_get_sdo)!=0)
	{
		die(json_encode(array("UserID"=>"THIS SDO ALREADY EXSISTS!!! ".$mysqli->error,"Password"=>"NOT CREATED")));	
	}

}


$pswd=rand(1,9).chr(rand(65,90)).chr(rand(97,122)).chr(rand(65,90)).chr(rand(97,122)).rand(1,9).chr(rand(97,122));

$insert="INSERT INTO `ems`.`users` (`UserID`,`UserTypeID`,`UserName`,`Designation`,`Email`,`Mobile`,`ModifiedDate`,`Password`,`Active`,`ChangePassword`) VALUES ('$UserId','$UserTypeID', '$UserName','$Designation' , '$EmailId', '$Mobile', CURRENT_TIMESTAMP,'$pswd',1,1);";

//Query for User Permissions
$insert.="INSERT INTO ems.user_permissions (UserID, PageName) SELECT '$UserId', user_type_menu.PageName FROM user_type_menu WHERE user_type_menu.UserTypeID=$UserTypeID;";

//die(json_encode(array("UserID"=>$insert,"Password"=>"NOT CREATED")));

//Query for Audit
$insert.="INSERT INTO ems.application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$session_user_id','$UserId','ADD USER DEO','$session_ip','$session_id',CURRENT_TIMESTAMP)";

$mysqli->multi_query($insert) or die(json_encode(array("UserID"=>"ERROR!!! ".$mysqli->error,"Password"=>"NOT CREATED")));

$return=array("UserID"=>$UserId,"Password"=>$pswd);

echo json_encode($return);
?>