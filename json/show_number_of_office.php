<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
if(isset($_POST['UserType']))
$utype=$_POST['UserType'];
else
die();
if($utype=="ADMIN")
{
$office_details_query="SELECT count(*) as total FROM office WHERE districtcd='13'";
$office_details_result=mysqli_query($DBLink,$office_details_query) or die(mysqli_error());
$return=array();	
	
}
else if($utype=="SDO")
{
$subdiv=$_SESSION['Subdiv'];

$office_details_query="SELECT count(*) as total FROM office WHERE subdivisioncd=".$subdiv;
$office_details_result=mysqli_query($DBLink,$office_details_query) or die(mysqli_error());
$return=array();
}
else if($utype=="DEO")
{
$subdiv=$_SESSION['Subdiv'];

$office_details_query="SELECT count(*) as total FROM office WHERE subdivisioncd=".$subdiv;
$office_details_result=mysqli_query($DBLink,$office_details_query) or die(mysqli_error());
$return=array();
}
else
{
die();		
}

while($row=mysqli_fetch_assoc($office_details_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>