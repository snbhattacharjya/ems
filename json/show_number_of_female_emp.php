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
$emp_details_query="SELECT count(*) as total FROM personnel WHERE districtcd='13' AND gender='F'";
$emp_details_result=mysqli_query($DBLink,$emp_details_query) or die(mysqli_error($DBLink));
$return=array();

}
else if($utype=="SDO")
{
$subdiv=$_SESSION['Subdiv'];

$emp_details_query="SELECT count(*) as total FROM personnel WHERE subdivisioncd=".$subdiv." AND gender='F'";
$emp_details_result=mysqli_query($DBLink,$emp_details_query) or die(mysqli_error($DBLink));
$return=array();
}
else if($utype=="DEO")
{
$subdiv=$_SESSION['Subdiv'];

$emp_details_query="SELECT count(*) as total FROM personnel WHERE subdivisioncd=".$subdiv." AND gender='F'";
$emp_details_result=mysqli_query($DBLink,$emp_details_query) or die(mysqli_error($DBLink));
$return=array();
}
else if($utype=="OFFICE")
{
$officecd=$_SESSION['Office'];
$emp_details_query="SELECT count(*) as total FROM personnel WHERE officecd=".$officecd." AND gender='F'";
$emp_details_result=mysqli_query($DBLink,$emp_details_query) or die(mysqli_error($DBLink));
$return=array();
}
else
die();

while($row=mysqli_fetch_assoc($emp_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
