<?php
session_start();

$session_user_id=$_SESSION['UserID'];
$session_id=session_id();
$session_ip=$_SERVER['REMOTE_ADDR'];


if(isset($_SESSION['Office']))
{
$officecd=$_SESSION['Office'];
$subdiv=$_SESSION['Subdiv'];
}
else
{
	die('Cannot Connect to Server');
}
include("../config/config.php");

$officename=mysqli_real_escape_string(strtoupper($DBLink,$_POST['OfficeName']));

$designation=ucwords(strtolower($_POST['Designation']));
$pts=mysqli_real_escape_string(strtoupper($_POST['Street']));
$officeuniqueid=$_POST['OfficeId'];
$po=strtoupper($_POST['PostOffice']);
$vtm=mysqli_real_escape_string(strtoupper($_POST['Town']));
$polices=$_POST['PoliceStation'];
$bm=$_POST['Municipality'];
$pin=$_POST['PinCode'];
$no=$_POST['NatureOfOffice'];
$dist=$_POST['District'];
$pc_dtls=$_POST['pc_dtls'];
$Assembly_dtls=$_POST['Assembly_dtls'];
$so=$_POST['Statusofoffice'];
$email=strtolower($_POST['EmailId']);
$phn=$_POST['PhoneNumber'];
$mob=$_POST['MobileNumber'];
$fax=$_POST['FaxNo'];

$tms=$_POST['TotalMaleStaffs'];
$tfs=$_POST['TotalFemaleStaffs'];
$tns=$_POST['TotalNumberOfStaffs'];

$exsisting_ps_cd=substr($officecd,0,6);

$newofficecd=str_replace($exsisting_ps_cd,$polices,$officecd);

//Query for Office Update
$update_office_query="UPDATE `office` SET `officecd`='$newofficecd', `officer_desg`='$designation',`office`='$officename',`office_unique_id`='$officeuniqueid',`address1`='$pts',`address2`='$vtm',`postoffice`='$po',`pin`='$pin',`blockormuni_cd`='$bm',`policestn_cd`='$polices',`govt`='$so',`email`='$email',`phone`='$phn',`mobile`='$mob',`fax`='$fax',`tot_staff`='$tns',`male_staff`='$tms',`female_staff`='$tfs',`assemblycd`='$Assembly_dtls',`pccd`='$pc_dtls',`subdivisioncd`='$subdiv',`districtcd`='$dist',`institutecd`='$no',`officetype`='NULL',`usercode`='1',`posted_date`='".date('y-m-d h:i:sa')."',`flag`='Y' WHERE `office`.`officecd` ='$officecd';";

//Query for Personnel Table
$update_office_query.="UPDATE personnel SET personcd=CONCAT(SUBSTRING('$newofficecd',1,6),SUBSTRING(personcd,7,5)), officecd='$newofficecd' WHERE officecd='$officecd';";

//User Table Update
/*
$update_office_query.="UPDATE users SET UserID='$newofficecd', Password='$newofficecd', Designation='$designation', email='$email', mobile='$mob', ChangePassword=1, ModifiedDate=CURRENT_TIMESTAMP WHERE UserID='$officecd';";*/

//Audit for Office Update
$update_office_query.="INSERT INTO application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$session_user_id','$officecd','UPDATE OFFICE','$session_ip','$session_id',CURRENT_TIMESTAMP);";
$mysqli->multi_query($update_office_query) or die(mysql_error());


$timestampp=mysqli_query($DBLink,"SELECT posted_date from office WHERE officecd='$newofficecd'");
$fetch=mysql_fetch_assoc($timestampp);

$posteddate=$fetch['posted_date'];
$_SESSION['Office']=$newofficecd;
if($_SESSION['UserID']==$officecd){
	$_SESSION['UserID']=$newofficecd;
}
echo "Record updated successfully for $officename ($newofficecd) at $posteddate<br>If you are an Office User, kindly note that your password has been reset to '$newofficecd'";


?>
