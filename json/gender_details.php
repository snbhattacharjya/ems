<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$officecd=$_SESSION['UserID'];
$gender_details_query="select count(*) as malepp from personnel WHERE gender='M' AND officecd='$officecd'";
$gender_details_result=mysqli_query($DBLink,$gender_details_query) or die(mysqli_error());
$malepp=mysqli_fetch_assoc($gender_details_result);

$gender_details_query="select count(*) as femalepp from personnel WHERE gender='F' AND officecd='$officecd'";
$gender_details_result=mysqli_query($DBLink,$gender_details_query) or die(mysqli_error());
$femalepp=mysqli_fetch_assoc($gender_details_result);

//echo $malepp['malepp']." - ".$femalepp['femalepp'];

$result=array('MalePP'=>$malepp['malepp'],'FemalePP'=>$femalepp['femalepp']);
echo json_encode($result);

?>