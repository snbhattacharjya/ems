<?php
session_start();

$office=$_POST['officecd'];

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$emp_office_query="SELECT personcd, officer_name, off_desg, gender, mob_no FROM personnel_org WHERE officecd='$office' AND personcd NOT IN (SELECT personcd FROM personnel_counting) ORDER BY personcd";

$emp_office_result=mysql_query($emp_office_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($emp_office_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
