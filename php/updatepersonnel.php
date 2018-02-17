<?php
session_start();

$session_id=session_id();
$session_ip=$_SERVER['REMOTE_ADDR'];


//$userid=$_SESSION['UserID'];
include("../config/config.php");
if(!isset($_POST['request_type']))
die("Error!! Please logout and login again.");
if($_POST['request_type']==1)
{
$EmpCd=$_POST['EmployeeCd'];
if(isset($_SESSION['Office']))
{
$OfficeCd=$_SESSION['Office'];
}
else
{die("Error!! Please logout and login again.");}
$EmployeeName=strtoupper($_POST['EmployeeName']);
$Designation=strtoupper($_POST['Designation']);
$DateOfBirth=$_POST['DateOfBirth'];
$Sex=$_POST['Sex'];
$ScaleOfPay=$_POST['ScaleOfPay'];
$BasicPay=$_POST['BasicPay'];
$GradePay=$_POST['GradePay'];
$PresentAddress1=mysql_real_escape_string($_POST['PresentAddress1']);
$PresentAddress2=mysql_real_escape_string($_POST['PresentAddress2']);
$PermanentAddress1=mysql_real_escape_string($_POST['PermanentAddress1']);
$PermanentAddress2=mysql_real_escape_string($_POST['PermanentAddress2']);
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

$Qualification=$_POST['Qualification'];
$LanguageKnown=$_POST['LanguageKnown'];
$WorkExperience=$_POST['WorkExperience'];


$updateQuery="UPDATE `personnel` SET `officecd`='$OfficeCd',`officer_name` = '$EmployeeName',
`off_desg` = '$Designation',
`present_addr1` = '$PresentAddress1',
`present_addr2` = '$PresentAddress2',
`perm_addr1` = '$PermanentAddress1',
`perm_addr2` = '$PermanentAddress2',
`dateofbirth` = '$DateOfBirth',
`gender` = '$Sex',
`scale` = '$ScaleOfPay',
`basic_pay` = '$BasicPay',
`grade_pay` = '$GradePay',
`workingstatus` = '$WorkExperience',
`email` = '$EmailId',
`resi_no` = '$PhoneNumber',
`mob_no` = '$MobileNumber',
`qualificationcd` = '$Qualification',
`languagecd` = '$LanguageKnown',
`epic` = '$EpicNo',
`acno` = '$Assembly_perm',
`slno` = '$SerialNo',
`partno` = '$PartNo',
`poststat` = '',
`assembly_temp` = '$Assembly_temp',
`assembly_off` = '$Assembly_off',
`assembly_perm` = '$Assembly_perm',
`bank_acc_no` = '$BankAcNo',
`bank_cd` = '$Bank',
`branchname` = '$BranchName',
`branchcd` = '$BranchIFSCCode',
`remarks` = '$Remarks',
`pgroup` = '',
`upload_file` = '',
`usercode` = '',
`f_cd` = '' WHERE `personnel`.`personcd` = '$EmpCd';";

//Query for Audit
$updateQuery.="INSERT INTO application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$session_user_id','$EmpCd','UPDATE EMPLOYEE','$session_ip','$session_id',CURRENT_TIMESTAMP)";

$mysqli->multi_query($updateQuery) or die($mysqli->error);

    echo "Record updated successfully with Employee Code: $EmpCd";
}
elseif($_POST['type']==2)
{
$AdharNumber=$_POST['AdharNumber'];	
	
}
?>
