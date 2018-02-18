<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$officecode=$_POST['officecode'];
$empcount_details_query="SELECT office.tot_staff AS TotalStaff, COUNT(personnel.personcd) AS EntryStaff, (office.tot_staff -  COUNT(personnel.personcd)) AS DiffStaff FROM office LEFT JOIN personnel ON office.officecd=personnel.officecd  WHERE office.officecd='$officecode' GROUP BY office.tot_staff";
$empcount_details_result=mysqli_query($DBLink,$empcount_details_query) or die(mysqli_error());
$row=mysqli_fetch_assoc($empcount_details_result);
echo json_encode($row);
?>