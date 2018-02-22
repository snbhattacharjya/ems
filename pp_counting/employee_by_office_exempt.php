<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$emp_office_query="SELECT personcd AS PersonCode, officer_name AS OfficerName, off_desg AS Desg, gender AS Gender, mob_no AS Mobile,  bank_acc_no AS BankAccNo, poststat AS PostStat, CONCAT(office.officecd,' - ',office.office,', ',office.address1) AS office_details, subdivision AS ForSubdivision FROM (countppds.personnela INNER JOIN countppds.office ON personnela.officecd = office.officecd) INNER JOIN countppds.subdivision ON personnela.forsubdivision = subdivision.subdivisioncd WHERE personnela.booked = 'C' ORDER BY personcd";

$emp_office_result=mysql_query($emp_office_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($emp_office_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>