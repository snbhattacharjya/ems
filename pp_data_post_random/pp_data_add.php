<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

if(isset($_SESSION['UserID'])){
    $session_user_id=$_SESSION['UserID'];
}
else{
    die(json_encode(array("Status"=>"Error!! Please logout and login again.")));
}
$session_id=session_id();
$session_ip=$_SERVER['REMOTE_ADDR'];

$officecd=$_POST['officecd'];
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
$districtcd=substr($officecd,0,2);
$subdivisioncd=substr($officecd,0,4);
$poststat=$_POST['PostStatus'];

$query_check_accno_exsist=mysql_query("SELECT bank_acc_no FROM personnel_org WHERE bank_acc_no='$BankAcNo'",$DBLink) or die(json_encode(array("Status"=>mysql_error())));
if(mysql_num_rows($query_check_accno_exsist)){
    die(json_encode(array("Status"=>"Error!! Employee already exists, with same Bank Account Number")));
}
/*
$pp1_count=0;
$pp2_count=0;

$pp1_query=$mysqli->prepare("SELECT office.tot_staff, count(personnel.personcd) FROM office INNER JOIN personnel ON office.officecd=personnel.officecd WHERE office.officecd = ? GROUP BY office.tot_staff") or die($mysqli->error);
$pp1_query->bind_param("s",$OfficeCd) or die($mysqli->error);
$pp1_query->execute() or die($pp1_query->error);
$pp1_query->bind_result($pp1_count,$pp2_count) or die($pp1_query->error);
$pp1_query->fetch();
$pp1_query->close();

/*if($pp1_count <= $pp2_count && $pp1_count != 0 && $pp2_count != 0)
	die("Error!! PP1 count is lower than PP2 count. Please increase your Total Staff Strength to add New PP. Contact District PP cell in this regard");
*/

$person=mysql_query("SELECT MID(officecd,1,6) AS shortofficecd from office where officecd=$officecd",$DBLink);
$shortofficecd=mysql_fetch_assoc($person);
$ofccd=substr($shortofficecd['shortofficecd'],0,4);
$mxprsncd=mysql_query("SELECT max(MID(personcd,7,5)) as maxpersoncd from personnel_org where officecd like '$ofccd%'",$DBLink);
$maxpersoncd=mysql_fetch_assoc($mxprsncd);

if($maxpersoncd['maxpersoncd']==NULL){
    $personcd=$shortofficecd['shortofficecd']."00001";
}
else{
    $personcode=str_pad($maxpersoncd['maxpersoncd'],5,"0",STR_PAD_LEFT);
    $personcd=$shortofficecd['shortofficecd'].$personcode+1;
}
//Insert into personnel_org
$insertQuery="INSERT INTO personnel_org (personcd ,officecd ,officer_name ,off_desg, adharno,present_addr1 ,present_addr2 ,perm_addr1 ,perm_addr2 ,dateofbirth ,gender ,scale ,basic_pay ,grade_pay ,workingstatus ,email ,resi_no ,mob_no ,qualificationcd ,languagecd ,epic ,acno ,slno ,partno ,assembly_temp ,assembly_off ,assembly_perm ,districtcd ,subdivisioncd ,bank_acc_no ,bank_cd ,branchname ,branchcd ,remarks ,poststat ,posted_date ,f_cd) VALUES ('$personcd', '$officecd', '$EmployeeName', '$Designation', '0', '$PresentAddress1', '$PresentAddress2', '$PermanentAddress1', '$PermanentAddress2', '$DateOfBirth', '$Sex', '$ScaleOfPay', '$BasicPay', '$GradePay', '$WorkExperience', '$EmailId', '$PhoneNumber', '$MobileNumber', '$Qualification', '$LanguageKnown', '$EpicNo', '$Assembly_perm', '$SerialNo', '$PartNo', '$Assembly_temp', '$Assembly_off', '$Assembly_perm', '$districtcd', '$subdivisioncd', '$BankAcNo', '$Bank', '$BranchName', '$BranchIFSCCode', '$Remarks', '$poststat', CURRENT_TIMESTAMP, '0');";

//Insert into personnel_new
$insertQuery.="INSERT INTO personnel_new (personcd ,officecd ,officer_name ,off_desg, adharno,present_addr1 ,present_addr2 ,perm_addr1 ,perm_addr2 ,dateofbirth ,gender ,scale ,basic_pay ,grade_pay ,workingstatus ,email ,resi_no ,mob_no ,qualificationcd ,languagecd ,epic ,acno ,slno ,partno ,assembly_temp ,assembly_off ,assembly_perm ,districtcd ,subdivisioncd ,bank_acc_no ,bank_cd ,branchname ,branchcd ,remarks ,poststat ,posted_date ,f_cd) VALUES ('$personcd', '$officecd', '$EmployeeName', '$Designation', '0', '$PresentAddress1', '$PresentAddress2', '$PermanentAddress1', '$PermanentAddress2', '$DateOfBirth', '$Sex', '$ScaleOfPay', '$BasicPay', '$GradePay', '$WorkExperience', '$EmailId', '$PhoneNumber', '$MobileNumber', '$Qualification', '$LanguageKnown', '$EpicNo', '$Assembly_perm', '$SerialNo', '$PartNo', '$Assembly_temp', '$Assembly_off', '$Assembly_perm', '$districtcd', '$subdivisioncd', '$BankAcNo', '$Bank', '$BranchName', '$BranchIFSCCode', '$Remarks', '$poststat', CURRENT_TIMESTAMP, '0');";

//Insert into personnel_mopup
$insertQuery.="INSERT INTO personnel_mopup (personcd ,officecd ,officer_name ,off_desg, adharno,present_addr1 ,present_addr2 ,perm_addr1 ,perm_addr2 ,dateofbirth ,gender ,scale ,basic_pay ,grade_pay ,workingstatus ,email ,resi_no ,mob_no ,qualificationcd ,languagecd ,epic ,acno ,slno ,partno ,assembly_temp ,assembly_off ,assembly_perm ,districtcd ,subdivisioncd ,bank_acc_no ,bank_cd ,branchname ,branchcd ,remarks ,poststat ,posted_date ,f_cd) VALUES ('$personcd', '$officecd', '$EmployeeName', '$Designation', '0', '$PresentAddress1', '$PresentAddress2', '$PermanentAddress1', '$PermanentAddress2', '$DateOfBirth', '$Sex', '$ScaleOfPay', '$BasicPay', '$GradePay', '$WorkExperience', '$EmailId', '$PhoneNumber', '$MobileNumber', '$Qualification', '$LanguageKnown', '$EpicNo', '$Assembly_perm', '$SerialNo', '$PartNo', '$Assembly_temp', '$Assembly_off', '$Assembly_perm', '$districtcd', '$subdivisioncd', '$BankAcNo', '$Bank', '$BranchName', '$BranchIFSCCode', '$Remarks', '$poststat', CURRENT_TIMESTAMP, '0');";

//Insert into personnel
$insertQuery.="INSERT INTO personnel (personcd ,officecd ,officer_name ,off_desg, adharno,present_addr1 ,present_addr2 ,perm_addr1 ,perm_addr2 ,dateofbirth ,gender ,scale ,basic_pay ,grade_pay ,workingstatus ,email ,resi_no ,mob_no ,qualificationcd ,languagecd ,epic ,acno ,slno ,partno ,assembly_temp ,assembly_off ,assembly_perm ,districtcd ,subdivisioncd ,bank_acc_no ,bank_cd ,branchname ,branchcd ,remarks ,poststat ,posted_date ,f_cd) VALUES ('$personcd', '$officecd', '$EmployeeName', '$Designation', '0', '$PresentAddress1', '$PresentAddress2', '$PermanentAddress1', '$PermanentAddress2', '$DateOfBirth', '$Sex', '$ScaleOfPay', '$BasicPay', '$GradePay', '$WorkExperience', '$EmailId', '$PhoneNumber', '$MobileNumber', '$Qualification', '$LanguageKnown', '$EpicNo', '$Assembly_perm', '$SerialNo', '$PartNo', '$Assembly_temp', '$Assembly_off', '$Assembly_perm', '$districtcd', '$subdivisioncd', '$BankAcNo', '$Bank', '$BranchName', '$BranchIFSCCode', '$Remarks', '$poststat', CURRENT_TIMESTAMP, '0');";

//Query for Audit
$insertQuery.="INSERT INTO application_audit(UserID, ObjectID, ObjectActivity, RequestIP, SessionID, ActivityTimeStamp) VALUES('$session_user_id','$personcd','ADD EXTRA EMPLOYEE','$session_ip','$session_id',CURRENT_TIMESTAMP)";

$mysqli->multi_query($insertQuery) or die(json_encode(array("Status"=>$mysqli->error)));

echo json_encode(array("Status"=>"Success","Report"=>"Newly added Employee with ID: ".$personcd));

?>
