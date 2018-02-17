<?php
session_start();
if(isset($_SESSION['UserID']))
{
$session_user_id=$_SESSION['UserID'];
}
else
	die("Error!! Please logout and login again.");
	
$session_id=session_id();
$session_ip=$_SERVER['REMOTE_ADDR'];

$source_office=$_POST['SourceOffice'];
$person=$_POST['Person'];
$new_subdiv=$_POST['NewSubdiv'];
$new_office=$_POST['NewOffice'];

include("../config/config.php");

for($i = 0; $i < count($person); $i++){
    $max_new_personcd_query=$mysqli->prepare("SELECT MAX(CONVERT(MID(personcd,7,5),UNSIGNED INTEGER)) FROM personnel WHERE subdivisioncd= ?") or die(json_encode(array("Status"=>$mysqli->error)));
    $max_new_personcd_query->bind_param("s",$new_subdiv) or die(json_encode(array("Status"=>$max_new_personcd_query->error)));
    $max_new_personcd_query->execute() or die(json_encode(array("Status"=>$max_new_personcd_query->error)));
    $max_new_personcd_query->bind_result($max_new_personcd) or die(json_encode(array("Status"=>$max_new_personcd_query->error)));
    $max_new_personcd_query->fetch() or die(json_encode(array("Status"=>$max_new_personcd_query->error)));
    $max_new_personcd_query->close() or die(json_encode(array("Status"=>$max_new_personcd_query->error)));
    
    if($max_new_personcd == NULL){
        $new_person_code=substr($new_office,0,6)."00001";
    }
    else{
        $new_person_code=substr($new_office,0,6).str_pad(($max_new_personcd+1),5,"0",STR_PAD_LEFT);
    }
    $update_query=$mysqli->prepare("UPDATE personnel SET personcd=?, officecd=?, subdivisioncd=? WHERE personcd=?") or die(json_encode(array("Status"=>$mysqli->error)));
    $update_query->bind_param("ssss",$new_person_code,$new_office,$new_subdiv,$person[$i]) or die(json_encode(array("Status"=>$update_query->error)));
    $update_query->execute() or die(json_encode(array("Status"=>$update_query->error)));
    $update_query->close();

    $audit_query=$mysqli->prepare("INSERT INTO application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$session_user_id','$person[$i]','EMPLOYEE OFFICE TRANSFER INTER SUBDIVISION','$session_ip','$session_id',CURRENT_TIMESTAMP)") or die(json_encode(array("Status"=>$mysqli->error)));
    $audit_query->execute() or  die(json_encode(array("Status"=>$audit_query->error)));
    $audit_query->close();
}

$mysqli->close();
echo json_encode(array("Status"=>"Records Transfer Count: ".count($person)));