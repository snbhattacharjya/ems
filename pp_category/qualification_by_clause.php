<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$subdiv=$_POST['subdiv'];
$govt=$_POST['govt'];
$officecd=$_POST['officecd'];

$govt_clause='';
for($i = 0; $i < count($govt); $i++){
	if($govt[$i] != 'ALL')
		$govt_clause.="'".$govt[$i]."',";
	else{
		$govt_clause='ALL';
		break;
	}
}

$govt_clause=rtrim($govt_clause,',');

$officecd_clause='';
for($i = 0; $i < count($officecd); $i++){
	if($officecd[$i] != 'ALL')
		$officecd_clause.="'".$officecd[$i]."',";
	else{
		$officecd_clause='ALL';
		break;
	}
}

$officecd_clause=rtrim($officecd_clause,',');

$clause="personnel.personcd != ''";

if($subdiv != 'ALL')
	$clause=$clause." AND personnel.subdivisioncd='".$subdiv."'";
if($govt_clause != 'ALL')
	$clause=$clause." AND office.govt IN ($govt_clause)";
if($officecd_clause != 'ALL')
	$clause=$clause." AND office.officecd IN ($officecd_clause)";
	
$qualification_query="SELECT qualificationcd AS QualificationCode, qualification AS QualificationName FROM qualification WHERE qualificationcd IN (SELECT DISTINCT(qualificationcd) FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE $clause) ORDER BY qualificationcd";

$qualification_result=mysql_query($qualification_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($qualification_result))
{
	$return[]=$row;
}

echo json_encode($return);
?>