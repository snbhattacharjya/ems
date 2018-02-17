<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$ems_update_query=$mysqli->prepare("UPDATE personnel SET booked = '', forassembly='', training1_sch=''") or die(json_encode(array("Status"=>$mysqli->error)));
$ems_update_query->execute() or die(json_encode(array("Status"=>$ems_update_query->error)));
$rows=$ems_update_query->affected_rows;
$ems_update_query->close();

$ems_update_query=$mysqli->prepare("UPDATE (ems.personnel INNER JOIN ppds.personnela ON personnel.personcd = personnela.personcd) INNER JOIN ppds.training_pp ON personnela.personcd = training_pp.per_code SET personnel.booked=personnela.booked, personnel.training1_sch = training_pp.training_sch WHERE personnela.booked != ''") or die(json_encode(array("Status"=>$mysqli->error)));
$ems_update_query->execute() or die(json_encode(array("Status"=>$ems_update_query->error)));
$rows=$ems_update_query->affected_rows;
$ems_update_query->close();
    
$mysqli->close();
echo json_encode(array("Status"=>"Success","RecordsCount"=>$rows));
?>