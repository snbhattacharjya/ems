<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");



$language_details_query="SELECT language_cd AS LanguageCode, language AS Language FROM language ORDER BY language_cd";

$language_details_result=mysqli_query($DBLink,$language_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($language_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
