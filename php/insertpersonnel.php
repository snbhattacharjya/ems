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


include "../config/config.php";
if($_POST['request_type']==1)
{
if(isset($_SESSION['Office']))
{
$OfficeCd=$_SESSION['Office'];
}
else
die("Error!! Please logout and login again.");

$EmployeeName=strtoupper($_POST['EmployeeName']);
$Designation=strtoupper($_POST['Designation']);
$DateOfBirth=$_POST['DateOfBirth'];
$Sex=$_POST['Sex'];
$ScaleOfPay=$_POST['ScaleOfPay'];
$BasicPay=$_POST['BasicPay'];
$GradePay=$_POST['GradePay'];
$Group=$_POST['Group'];
$PresentAddress1=mysqli_real_escape_string($DBLink,$_POST['PresentAddress1']);
$PresentAddress2=mysqli_real_escape_string($DBLink,$_POST['PresentAddress2']);
$PermanentAddress1=mysqli_real_escape_string($DBLink,$_POST['PermanentAddress1']);
$PermanentAddress2=mysqli_real_escape_string($DBLink,$_POST['PermanentAddress2']);
$EmailId=$_POST['EmailId'];
$PhoneNumber=$_POST['PhoneNumber'];
$MobileNumber=$_POST['MobileNumber'];
$Bank=$_POST['Bank'];
$BranchName=$_POST['BranchName'];
$BankAcNo=$_POST['BankAcNo'];
$BranchIFSCCode=$_POST['BranchIFSCCode'];
$EpicNo=strtoupper($_POST['EpicNo']);
$PartNo=$_POST['PartNo'];
$Remarks=$_POST['Remarks'];
$SerialNo=$_POST['SerialNo'];

$Assembly_perm=$_POST['Assembly_perm'];
$Assembly_temp=$_POST['Assembly_temp'];
$Assembly_off=$_POST['Assembly_off'];

$BlockMuni_perm=$_POST['BlockMuni_perm'];
$BlockMuni_temp=$_POST['BlockMuni_temp'];
$BlockMuni_off=$_POST['BlockMuni_off'];

$Qualification=$_POST['Qualification'];
$LanguageKnown=$_POST['LanguageKnown'];
$WorkExperience=$_POST['WorkExperience'];
$districtcd=substr($_SESSION['Subdiv'],0,2);
$subdivisioncd=$_SESSION['Subdiv'];
//$photo=$_POST['Photo'];
$query_check_accno_exsist=mysqli_query($DBLink,"SELECT bank_acc_no FROM personnel WHERE bank_acc_no='$BankAcNo'") or die(mysqli_error());
if(mysqli_num_rows($query_check_accno_exsist))
die("Error!! Employee already exsist.");

$pp1_count=0;
$pp2_count=0;

$pp1_query=$mysqli->prepare("SELECT office.tot_staff, count(personnel.personcd) FROM office INNER JOIN personnel ON office.officecd=personnel.officecd WHERE office.officecd = ? GROUP BY office.tot_staff") or die($mysqli->error);
$pp1_query->bind_param("s",$OfficeCd) or die($mysqli->error);
$pp1_query->execute() or die($pp1_query->error);
$pp1_query->bind_result($pp1_count,$pp2_count) or die($pp1_query->error);
$pp1_query->fetch();
$pp1_query->close();

//if($pp1_count <= $pp2_count && $pp1_count != 0 && $pp2_count != 0)
	//die("Error!! PP1 count is lower than PP2 count. Please increase your Total Staff Strength to add New PP. Contact District PP cell in this regard");

$person=mysqli_query($DBLink,"SELECT MID(officecd,1,6) AS shortofficecd from office where officecd=$OfficeCd");
$shortofficecd=mysqli_fetch_assoc($person);
$ofccd=substr($shortofficecd['shortofficecd'],0,4);
$mxprsncd=mysqli_query($DBLink,"SELECT max(MID(personcd,7,5)) as maxpersoncd from personnel where officecd like '$ofccd%'");
$maxpersoncd=mysqli_fetch_assoc($mxprsncd);
if($maxpersoncd['maxpersoncd']==NULL)
{
	$personcd=$shortofficecd['shortofficecd']."00001";
}
else
{
	$personcode=str_pad($maxpersoncd['maxpersoncd'],5,"0",STR_PAD_LEFT);
	$personcd=$shortofficecd['shortofficecd'].$personcode+1;
}
date_default_timezone_set("Asia/Kolkata");
$insertQuery="INSERT INTO `personnel` (
`personcd` ,`officecd` ,`officer_name` ,`off_desg`, `adharno`,`present_addr1` ,`present_addr2` ,`perm_addr1` ,`perm_addr2` ,`dateofbirth` ,
`gender` ,
`scale` ,
`basic_pay` ,
`grade_pay` ,`workingstatus` ,`emp_group` ,
`email` ,`resi_no` ,
`mob_no` ,`qualificationcd` ,
`languagecd` ,
`epic` ,
`acno` ,
`slno` ,
`partno` ,
`poststat` ,
`assembly_temp` ,
`assembly_off` ,
`assembly_perm` ,
`blockmuni_temp` ,
`blockmuni_off` ,
`blockmuni_perm` ,
`districtcd` ,
`subdivisioncd` ,`bank_acc_no` ,`bank_cd`,`branchname` ,`branchcd` ,`remarks` ,`pgroup` ,`upload_file`,`usercode` ,`posted_date` ,`f_cd`,`image`
)
VALUES (
'$personcd', '$OfficeCd', '$EmployeeName', '$Designation', '0', '$PresentAddress1', '$PresentAddress2', '$PermanentAddress1', '$PermanentAddress2', '$DateOfBirth', '$Sex', '$ScaleOfPay', '$BasicPay', '$GradePay', '$WorkExperience', '$Group',  '$EmailId', '$PhoneNumber', '$MobileNumber', '$Qualification', '$LanguageKnown', '$EpicNo', '$Assembly_perm', '$SerialNo', '$PartNo', '', '$Assembly_temp', '$Assembly_off', '$Assembly_perm', '$BlockMuni_temp', '$BlockMuni_off', '$BlockMuni_perm', '$districtcd', '$subdivisioncd', '$BankAcNo', '$Bank', '$BranchName', '$BranchIFSCCode', '$Remarks', '1', '1', '1',CURRENT_TIMESTAMP, '1','');
";
//Query for Audit
//$insertQuery.="INSERT INTO application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$session_user_id','$personcd','ADD EMPLOYEE','$session_ip','$session_id',CURRENT_TIMESTAMP)";

$mysqli->multi_query($insertQuery) or die($mysqli->error);
    echo "Newly added Employee ".$personcd;
}
elseif($_POST['type']==2)
{
$AdharNumber=$_POST['AdharNumber'];

}
?>
