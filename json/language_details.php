<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");



$language_details_query="SELECT language_cd AS LanguageCode, language AS Language FROM language ORDER BY language_cd";

$language_details_result=mysql_query($language_details_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($language_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>