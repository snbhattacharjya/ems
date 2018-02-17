<?php
session_start();
if(isset($_POST['Office']))
{
$office=$_POST['Office'];
}
else
{
	die(json_encode(array("Status"=>"Fail")));	
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$emp_office_query="SELECT personcd AS PersonCode, officer_name AS OfficerName, off_desg AS Desg FROM personnel WHERE officecd='$office' ORDER BY personcd";

$emp_office_result=mysql_query($emp_office_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($emp_office_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>