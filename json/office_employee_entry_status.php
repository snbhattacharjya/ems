<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$officecode=$_POST['officecode'];
$empcount_details_query="SELECT office.tot_staff AS TotalStaff, COUNT(personnel.personcd) AS EntryStaff, (office.tot_staff -  COUNT(personnel.personcd)) AS DiffStaff FROM office LEFT JOIN personnel ON office.officecd=personnel.officecd  WHERE office.officecd='$officecode' GROUP BY office.tot_staff";
$empcount_details_result=mysql_query($empcount_details_query,$DBLink) or die(mysql_error());
$row=mysql_fetch_assoc($empcount_details_result);
echo json_encode($row);
?>