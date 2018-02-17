<?php
session_start();

$session_user_id=$_SESSION['UserID'];
$session_id=session_id();
$session_ip=$_SERVER['REMOTE_ADDR'];

//$sdoid=$_SESSION['UserID'];
if(isset($_SESSION['Subdiv']))
{
$subdiv=$_SESSION['Subdiv'];
}
else
{
	die('Cannot Connect to Server');	
}
include("../config/config.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$officename=mysql_real_escape_string(strtoupper($_POST['OfficeName']));
$designation=ucwords(strtolower($_POST['Designation']));
$officeuniqueid=$_POST['OfficeId'];
$pts=mysql_real_escape_string(strtoupper($_POST['Street']));
$po=strtoupper($_POST['PostOffice']);
$polices=$_POST['PoliceStation'];
$vtm=mysql_real_escape_string(strtoupper($_POST['Town']));
$bm=$_POST['Municipality'];
$pin=$_POST['PinCode'];
$pc_dtls=$_POST['pc_dtls'];
$Assembly_dtls=$_POST['Assembly_dtls'];
$no=$_POST['NatureOfOffice'];
$dist=$_POST['District'];
$so=$_POST['Statusofoffice'];
$email=strtolower($_POST['EmailId']);
$phn=$_POST['PhoneNumber'];
$mob=$_POST['MobileNumber'];
$fax=$_POST['FaxNo'];
$tms=$_POST['TotalMaleStaffs'];
$tfs=$_POST['TotalFemaleStaffs'];
$tns=$_POST['TotalNumberOfStaffs'];
$sql=$mysqli->prepare("SELECT MAX(MID(officecd,7,4)) AS shortofficecd FROM office WHERE subdivisioncd=?") or die($sql->error);

$sql->bind_param("s",$subdiv) or die($sql->error);
$sql->execute() or die($sql->error);
$sql->bind_result($shortofficecd) or die($sql->error);

$sql->fetch();

if($shortofficecd!=null)
{
	$nextmaxfetch=$polices.$shortofficecd;
	$nextmaxfetch=$nextmaxfetch+1;
}
else
{
	$nextmaxfetch=str_pad($polices,10,"0",STR_PAD_RIGHT);
	$nextmaxfetch=$nextmaxfetch+1;
}

//Query for Office Add
$insert_office_query="INSERT INTO `ems`.`office` (
`officecd` ,
`officer_desg` ,
`office` ,
`office_unique_id`,
`address1` ,
`address2` ,
`postoffice` ,
`pin` ,
`blockormuni_cd` ,
`policestn_cd` ,
`govt` ,
`email` ,
`phone` ,
`mobile` ,
`fax` ,
`tot_staff` ,
`male_staff` ,
`female_staff` ,
`assemblycd` ,
`pccd` ,
`subdivisioncd` ,
`districtcd` ,
`institutecd` ,
`officetype` ,
`usercode` ,
`posted_date` ,
`flag`
)
VALUES (
'$nextmaxfetch', '$designation', '$officename', '$officeuniqueid','$vtm','$pts', '$po','$pin','$bm', '$polices','$so','$email','$phn','$mob','$fax','$tns','$tms','$tfs','$Assembly_dtls','$pc_dtls','$subdiv','$dist','$no','1', '1', CURRENT_TIMESTAMP, 'N'
);";
$sql->close();
//Audit for Office Add
$insert_office_query.="INSERT INTO ems.application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$session_user_id','$nextmaxfetch','ADD OFFICE','$session_ip','$session_id',CURRENT_TIMESTAMP);";

//Query for Office User
$insert_office_query.="INSERT INTO `ems`.`users` (`UserTypeID`, `UserID`,`UserName`,`Designation`, `Email`,`Mobile`,`ModifiedDate`,`Password`, `Active`, `ChangePassword`, `LastLoginDate`) VALUES ('2', '$nextmaxfetch','OFFICER-IN-CHARGE','$designation','$email','$mob','0000-00-00 00:00:00','$nextmaxfetch', '1', '1', CURRENT_TIMESTAMP);";

//Audit for Office User
$insert_office_query.="INSERT INTO ems.application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$session_user_id','$nextmaxfetch','ADD OFFICE USER','$session_ip','$session_id',CURRENT_TIMESTAMP);";

$mysqli->multi_query($insert_office_query) or die("error ".$mysqli->error);
 
echo "Office Added Successfully with Office Code $nextmaxfetch";
?>
