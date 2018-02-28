<?php
session_start();
if(isset($_SESSION['Office']))
$ofccd=$_SESSION['Office'];
else
die(json_encode("NOTELIGIBLE"));
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$query_get_emp_frm_office=mysqli_query($DBLink,"SELECT tot_staff FROM office WHERE officecd='$ofccd'") or die(mysqli_error($DBLink));
$res=mysqli_fetch_assoc($query_get_emp_frm_office);
$totalemp=$res['tot_staff'];

$query_get_emp_frm_personel=mysqli_query($DBLink,"SELECT COUNT(personcd) AS total FROM personnel WHERE officecd='$ofccd'") or die(mysqli_error($DBLink));	
$res1=mysqli_fetch_assoc($query_get_emp_frm_personel);
$totalemp1=$res1['total'];

if($totalemp==$totalemp1)
{
	$query_get_flag_frm_personel=mysqli_query($DBLink,"SELECT dc_flag FROM office WHERE officecd='$ofccd'") or die(mysqli_error($DBLink));
	$res2=mysqli_fetch_assoc($query_get_flag_frm_personel);
	if($res2['dc_flag']==1)
	 	$return="TRUE";
	else
		$return="FALSE";

}
else
{
	$return="NOTELIGIBLE";
}

echo json_encode($return);
?>
