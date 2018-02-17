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

if(substr($user_id,0,3) == 'SDO'){
    $office_blockmuni_query="SELECT office.officecd, office.office, CONCAT(office.address1,', ',office.address2) AS address, office.phone, office.mobile, office.tot_staff AS pp1_count, COUNT(personnel.personcd) AS pp2_count, COUNT(personnel_exempt_post_random.personcd) AS exempt_count FROM (office INNER JOIN personnel ON office.officecd = personnel.officecd) INNER JOIN personnel_exempt_post_random ON personnel.personcd = personnel_exempt_post_random.personcd WHERE office.subdivisioncd='$subdiv' GROUP BY office.officecd, office.office, CONCAT(office.address1,', ',office.address2), office.phone, office.mobile, office.tot_staff ORDER BY office.officecd";
}

else if(substr($user_id,0,3) == 'BDO'){
	$office_blockmuni_query="SELECT office.officecd, office.office, CONCAT(office.address1,', ',office.address2) AS address, office.phone, office.mobile, office.tot_staff AS pp1_count, COUNT(personnel.personcd) AS pp2_count, COUNT(personnel_exempt_post_random.personcd) AS exempt_count FROM (office INNER JOIN personnel ON office.officecd = personnel.officecd) INNER JOIN personnel_exempt_post_random ON personnel.personcd = personnel_exempt_post_random.personcd WHERE office.subdivisioncd='$subdiv' AND office.blockormuni_cd='$block_code' GROUP BY office.officecd, office.office, CONCAT(office.address1,', ',office.address2), office.phone, office.mobile, office.tot_staff ORDER BY office.officecd";
}

else {
    $office_blockmuni_query="SELECT office.officecd, office.office, CONCAT(office.address1,', ',office.address2) AS address, office.phone, office.mobile, office.tot_staff AS pp1_count, COUNT(personnel.personcd) AS pp2_count, COUNT(personnel_exempt_post_random.personcd) AS exempt_count FROM (office INNER JOIN personnel ON office.officecd = personnel.officecd) INNER JOIN personnel_exempt_post_random ON personnel.personcd = personnel_exempt_post_random.personcd GROUP BY office.officecd, office.office, CONCAT(office.address1,', ',office.address2), office.phone, office.mobile, office.tot_staff ORDER BY office.officecd";
}
$office_blockmuni_result=mysql_query($office_blockmuni_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($office_blockmuni_result))
{
	$return[]=$row;
}	
echo json_encode($return);
?>

