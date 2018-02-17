<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$mysqli->query("UPDATE pp_post_rules SET RecordsAffected = 0, AppliedDate = '0000-00-00 00:00:00', RecordsRevoked = 0, RevokedDate = '0000-00-00 00:00:00'") or die(json_encode(array("Status"=>$mysqli->error)));
$rules_affected=$mysqli->affected_rows;

$mysqli->query("UPDATE personnel SET poststat=''") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_affected=$mysqli->affected_rows;

$mysqli->close();

echo json_encode(array("Status"=>"Rules = ".$rules_affected.", Personnel = ".$pp_affected));
?>