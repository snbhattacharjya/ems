<?php
session_start();
$user_id=$_SESSION['UserID'];
$block_code=substr($user_id,3,6);
if(isset($_SESSION['Subdiv']))
{
    $subdiv=$_SESSION['Subdiv'];
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");


    $office_blockmuni_query="SELECT office.officecd, office.office, CONCAT(office.address1,', ',office.address2) AS address, office.phone, office.mobile, office.tot_staff AS pp1_count, COUNT(personnel_exempt.personcd) AS exempt_count FROM office INNER JOIN personnel_exempt ON office.officecd = personnel_exempt.officecd GROUP BY office.officecd, office.office, CONCAT(office.address1,', ',office.address2), office.phone, office.mobile, office.tot_staff ORDER BY office.officecd";

$office_blockmuni_result=mysql_query($office_blockmuni_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($office_blockmuni_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>

