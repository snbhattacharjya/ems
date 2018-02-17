<?php
session_start();
include("../config/config.php");

$municipality_details_query="SELECT blockminicd AS BlockmuniCode FROM block_muni";


$municipality_details_result=mysql_query($municipality_details_query,$DBLink) or die(mysql_error());

while($row=mysql_fetch_assoc($municipality_details_result))
{
	$userid="BDO".$row['BlockmuniCode'];
	
	mysql_query("insert into users values('$userid',6,'','BDO','','','','$userid','1','1','')") or die(mysql_error());
	
}
?>
