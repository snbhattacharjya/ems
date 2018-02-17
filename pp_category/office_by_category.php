<?php
session_start();
$govt=$_POST['govt'];

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

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

if($govt_clause == 'ALL'){
$office_govt_query="SELECT officecd AS OfficeCode, office AS OfficeName FROM office ORDER BY officecd";
}
else{
$office_govt_query="SELECT officecd AS OfficeCode, office AS OfficeName FROM office WHERE govt IN ($govt_clause) ORDER BY officecd";	
}

$office_govt_result=mysql_query($office_govt_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($office_govt_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>