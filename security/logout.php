<?php
session_start();
/*require("../config/config.php");

//LogIn Audit
$session_user_id=$_SESSION['UserID'];
$session_id=session_id();
$session_ip=$_SERVER['REMOTE_ADDR'];

$audit_query="INSERT INTO ems.application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$session_user_id','SELF','LOG OUT','$session_ip','$session_id',CURRENT_TIMESTAMP)";

mysql_query($audit_query,$DBLink) or die(json_encode(array('Status'=>'Log Audit Failure!!!')));
*/
session_unset();
session_destroy();
?>