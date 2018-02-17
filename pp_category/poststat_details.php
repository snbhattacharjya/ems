<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$post_stat_query="SELECT post_stat AS PostCode, poststatus AS PostName FROM poststat ORDER BY post_stat";

$post_stat_result=mysql_query($post_stat_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($post_stat_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>