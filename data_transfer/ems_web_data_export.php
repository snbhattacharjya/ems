<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$personnel_export_query=$mysqli->prepare("SELECT personnel.personcd,personnel.booked,personnel.forassembly,personnel.training1_sch,personnel.training2_sch,personnel.groupid FROM personnel WHERE personnel.booked != ''") or die($mysqli->error);

$personnel_export_query->execute() or die($personnel_export_query->error);
$personnel_export_query->bind_result($personcd,$booked,$forassembly,$training1_sch,$training2_sch,$groupid) or die($personnel_export_query->error);

$return=array();
while($personnel_export_query->fetch())
{
    $return[]=array("personcd"=>$personcd, "booked"=>$booked, "forassembly"=>$forassembly, "training1_sch"=>$training1_sch, "training2_sch"=>$training2_sch, "groupid"=>$groupid);
}	
echo json_encode($return);
?>
