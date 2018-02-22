<?php
session_start();
$userid=$_SESSION['UserID'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");

//die(json_encode(array("Status"=>"Fail")));
$police_stn_query=$mysqli->prepare("SELECT policestationcd FROM policestation WHERE policestationcd != '999901' ORDER BY policestationcd") or die(json_encode(array("Status"=>$mysqli->error)));
$police_stn_query->execute() or die(json_encode(array("Status"=>$police_stn_query->error)));
$police_stn_query->bind_result($police_stn_cd) or die(json_encode(array("Status"=>$police_stn_query->error)));

$police_stn=array();
while($police_stn_query->fetch()){
    $police_stn[]=array("policestationcd"=>$police_stn_cd);
}
$police_stn_query->close();
$booth_person=array();

for($i=0; $i < count($police_stn); $i++){
    $ps_query=$mysqli->prepare("SELECT psno, assemblycd FROM policestation_booth WHERE policestationcd = ? ORDER BY rand()") or die(json_encode(array("Status"=>$mysqli->error)));
    $ps_query->bind_param("s",$police_stn[$i]['policestationcd']) or die(json_encode(array("Status"=>$ps_query->error)));
    $ps_query->execute() or die(json_encode(array("Status"=>$ps_query->error)));
    $ps_query->bind_result($psno,$assemblycd) or die(json_encode(array("Status"=>$ps_query->error)));
    
    $ps=array();
    while($ps_query->fetch()){
        $ps[]=array("psno"=>$psno,"assemblycd"=>$assemblycd);
    }
    $ps_query->close();
    
    $person_query=$mysqli->prepare("SELECT policestationcd, personcd FROM policestation_personnel WHERE policestationcd = ? ORDER BY rand()") or die(json_encode(array("Status"=>$mysqli->error)));
    $person_query->bind_param("s",$police_stn[$i]['policestationcd']) or die(json_encode(array("Status"=>$person_query->error)));
    $person_query->execute() or die(json_encode(array("Status"=>$person_query->error)));
    $person_query->bind_result($policestationcd,$personcd) or die(json_encode(array("Status"=>$person_query->error)));
    
    $person=array();
    while($person_query->fetch()){
        $person[]=array("policestationcd"=>$policestationcd,"personcd"=>$personcd);
    }
    $person_query->close();
    
    if(count($ps) <= count($person)){
        for($j=0; $j < count($ps); $j++){
            $booth_person[]=array("policestationcd"=>$person[$j]['policestationcd'],"personcd"=>$person[$j]['personcd'],"assemblycd"=>$ps[$j]['assemblycd'],"psno"=>$ps[$j]['psno']);
        }
    }
    else{
        die(json_encode(array("Status"=>"Fail")));
    }
}
$delete_booth_person_query=$mysqli->prepare("DELETE FROM policestation_booth_personnel") or die(json_encode(array("Status"=>$mysqli->error)));
$delete_booth_person_query->execute() or die(json_encode(array("Status"=>$delete_booth_person_query->error)));
$delete_booth_person_query->close() or die(json_encode(array("Status"=>$delete_booth_person_query->error)));

for($j=0; $j < count($booth_person); $j++){
    $insert_booth_person_query=$mysqli->prepare("INSERT INTO policestation_booth_personnel (policestationcd, personcd, assemblycd, psno) VALUES (?,?,?,?)") or die(json_encode(array("Status"=>$mysqli->error)));
    $insert_booth_person_query->bind_param("ssss",$booth_person[$j]['policestationcd'],$booth_person[$j]['personcd'],$booth_person[$j]['assemblycd'],$booth_person[$j]['psno']) or die(json_encode(array("Status"=>$insert_booth_person_query->error)));
    $insert_booth_person_query->execute() or die(json_encode(array("Status"=>$insert_booth_person_query->error)));
    $insert_booth_person_query->close() or die(json_encode(array("Status"=>$insert_booth_person_query->error)));
}

$mysqli->close();	
echo json_encode(array("Status"=>"Success"));
?>