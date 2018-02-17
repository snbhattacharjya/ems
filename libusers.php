<?php
session_start();
include "../config/config.php";

function createDEOSDO($Subdivision)
{
$mid_user_query="SELECT CAST(MAX(MID(users.UserID,4,3)) AS SIGNED ) as mid_user
FROM users
INNER JOIN userlogin
ON users.UserID=userlogin.UserID
WHERE userlogin.UserTypeID=3
AND (MID(users.UserID,7,4))=$Subdivision";
$mid=mysql_query($mid_user_query,$DBLink);
$midfetch=mysql_fetch_assoc($mid);
$mid1=$midfetch['mid_user']+1;
$UserId="DEO".str_pad($mid1,3,'0',STR_PAD_LEFT).$Subdivision;

return $UserId;
}

function createSDO($Subdivision)
{
	
}
?>