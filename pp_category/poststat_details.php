<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$post_stat_query="SELECT post_stat AS PostCode, poststatus AS PostName FROM poststat ORDER BY post_stat";

$post_stat_result=mysqli_query($DBLink,$post_stat_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($post_stat_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
