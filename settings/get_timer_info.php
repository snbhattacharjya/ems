<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$page_name=$_POST['page_name'];
$user_id=$_SESSION['UserID'];

$timer_query="SELECT user_permissions.StartTime, user_permissions.EndTime, user_permissions.PageName, app_pages.PageTitle, user_permissions.TimerFlag, user_permissions.PermitFlag FROM user_permissions INNER JOIN app_pages ON user_permissions.PageName=app_pages.PageName WHERE user_permissions.PageName='$page_name' AND user_permissions.UserID='$user_id'";

$timer_result=mysql_query($timer_query,$DBLink) or die(mysql_error());
$timer_result=mysql_fetch_assoc($timer_result);

//echo $timer_query;
echo json_encode(array('PageTitle'=>$timer_result['PageTitle'],'StartTime'=>date_format(date_create($timer_result['StartTime']),'M d, Y H:i:s'),'EndTime'=>date_format(date_create($timer_result['EndTime']),'M d, Y H:i:s'),'ServerTime'=>date('M d, Y H:i:s'), 'TimerFlag'=>$timer_result['TimerFlag'],'PermitFlag'=>$timer_result['PermitFlag']));

?>