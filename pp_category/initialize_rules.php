<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$init_rule_query="DELETE FROM pp_post_rules";

$mysqli->query($init_rule_query) or die(json_encode(array("Status"=>$mysqli->error)));
$rules_affected=$mysqli->affected_rows;

$mysqli->query("UPDATE personnel SET poststat=''") or die(json_encode(array("Status"=>$mysqli->error)));
$pp_affected=$mysqli->affected_rows;

$mysqli->close();

echo json_encode(array("Status"=>"Rules = ".$rules_affected.", Personnel = ".$pp_affected));
?>