<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
$subdiv=$_SESSION['Subdiv'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$venue_cd=$_POST['venue_cd'];
$pr_count=$_POST['pr_count'];
$p1_count=$_POST['p1_count'];
$p2_count=$_POST['p2_count'];
$p3_count=$_POST['p3_count'];
$p4_count=$_POST['p4_count'];
$training_date=$_POST['training_date'];
$training_time=$_POST['training_time'];

$max_schedule_query=$mysqli->prepare("SELECT MAX(CONVERT(MID(schedule_code,-3), UNSIGNED INTEGER)) FROM training_schedule WHERE training_venue = ?") or die(json_encode(array("Status"=>$mysqli->error)));
$max_schedule_query->bind_param("s",$venue_cd) or die(json_encode(array("Status"=>$max_schedule_query->error)));
$max_schedule_query->execute() or die(json_encode(array("Status"=>$max_schedule_query->error)));
$max_schedule_query->bind_result($max_id) or die(json_encode(array("Status"=>$$max_schedule_query->error)));
$max_schedule_query->fetch() or die(json_encode(array("Status"=>$max_schedule_query->error)));
$max_schedule_query->close();

if(isset($max_id)){
    $schedule_id=$venue_cd.str_pad(($max_id+1), 3, '0', STR_PAD_LEFT);
}
else{
    $schedule_id=$venue_cd.'001';
}
$forsubdiv="1300";
$training_type="01";
$no_used=0;
$choice_type="S";
$usercode=5;
if($pr_count > 0){
    $poststat="PR";
    $add_schedule_query=$mysqli->prepare("INSERT INTO training_schedule (schedule_code, training_venue, forsubdiv, training_type, training_dt, training_time, post_status, no_pp, no_used, choice_type, choice_area, usercode) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)") or die(json_encode(array("Status"=>$mysqli->error)));
    $add_schedule_query->bind_param("sssssssiissi",$schedule_id,$venue_cd,$forsubdiv,$training_type,$training_date,$training_time,$poststat,$pr_count,$no_used,$choice_type,$subdiv,$usercode) or die(json_encode(array("Status"=>$add_schedule_query->error)));
    $add_schedule_query->execute() or die(json_encode(array("Status"=>$add_schedule_query->error)));
    $add_schedule_query->close();
    $schedule_id+=1;
}
if($p1_count > 0){
    $poststat="P1";
    $add_schedule_query=$mysqli->prepare("INSERT INTO training_schedule (schedule_code, training_venue, forsubdiv, training_type, training_dt, training_time, post_status, no_pp, no_used, choice_type, choice_area, usercode) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)") or die(json_encode(array("Status"=>$mysqli->error)));
    $add_schedule_query->bind_param("sssssssiissi",$schedule_id,$venue_cd,$forsubdiv,$training_type,$training_date,$training_time,$poststat,$p1_count,$no_used,$choice_type,$subdiv,$usercode) or die(json_encode(array("Status"=>$add_schedule_query->error)));
    $add_schedule_query->execute() or die(json_encode(array("Status"=>$add_schedule_query->error)));
    $add_schedule_query->close();
    $schedule_id+=1;
}
if($p2_count > 0){
    $poststat="P2";
    $add_schedule_query=$mysqli->prepare("INSERT INTO training_schedule (schedule_code, training_venue, forsubdiv, training_type, training_dt, training_time, post_status, no_pp, no_used, choice_type, choice_area, usercode) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)") or die(json_encode(array("Status"=>$mysqli->error)));
    $add_schedule_query->bind_param("sssssssiissi",$schedule_id,$venue_cd,$forsubdiv,$training_type,$training_date,$training_time,$poststat,$p2_count,$no_used,$choice_type,$subdiv,$usercode) or die(json_encode(array("Status"=>$add_schedule_query->error)));
    $add_schedule_query->execute() or die(json_encode(array("Status"=>$add_schedule_query->error)));
    $add_schedule_query->close();
    $schedule_id+=1;
}
if($p3_count > 0){
    $poststat="PA";
    $add_schedule_query=$mysqli->prepare("INSERT INTO training_schedule (schedule_code, training_venue, forsubdiv, training_type, training_dt, training_time, post_status, no_pp, no_used, choice_type, choice_area, usercode) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)") or die(json_encode(array("Status"=>$mysqli->error)));
    $add_schedule_query->bind_param("sssssssiissi",$schedule_id,$venue_cd,$forsubdiv,$training_type,$training_date,$training_time,$poststat,$p3_count,$no_used,$choice_type,$subdiv,$usercode) or die(json_encode(array("Status"=>$add_schedule_query->error)));
    $add_schedule_query->execute() or die(json_encode(array("Status"=>$add_schedule_query->error)));
    $add_schedule_query->close();
    $schedule_id+=1;
}
if($p4_count > 0){
    $poststat="P3";
    $add_schedule_query=$mysqli->prepare("INSERT INTO training_schedule (schedule_code, training_venue, forsubdiv, training_type, training_dt, training_time, post_status, no_pp, no_used, choice_type, choice_area, usercode) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)") or die(json_encode(array("Status"=>$mysqli->error)));
    $add_schedule_query->bind_param("sssssssiissi",$schedule_id,$venue_cd,$forsubdiv,$training_type,$training_date,$training_time,$poststat,$p4_count,$no_used,$choice_type,$subdiv,$usercode) or die(json_encode(array("Status"=>$add_schedule_query->error)));
    $add_schedule_query->execute() or die(json_encode(array("Status"=>$add_schedule_query->error)));
    $add_schedule_query->close();
    $schedule_id+=1;
}

echo json_encode(array("Status"=>"Success"));
?>
