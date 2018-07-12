<?php
session_start();
ob_start();
require("../config/config.php");
$counter=1;
$ofccd=$_SESSION['Office'];
$person_details_query="SELECT * FROM personnel WHERE officecd='$ofccd'";

$person_details_result=mysqli_query($DBLink,$person_details_query) or die(mysqli_error($DBLink));

$office_name_query="SELECT office AS OfficeName FROM office WHERE officecd='$ofccd'";

$ofc_name_result=mysqli_query($DBLink,$office_name_query) or die(mysqli_error($DBLink));
$ofc_ret=mysqli_fetch_assoc($ofc_name_result);

echo "<b>".$ofc_ret['OfficeName']." (".$ofccd.")</b>";

while($return=mysqli_fetch_assoc($person_details_result))
{
	echo "<table border='1'>";
	echo "<tr>";
	echo "<td><b>(".$counter.") EMP ID: ".$return['personcd']."</b></td>";
	echo "<td colspan='2'><b>NAME: ".$return['officer_name']."</b></td>";
	echo "<td><b>DESG: ".$return['off_desg']."</b></td>";
	
	echo "</tr>";
	echo "<tr>";
	
	echo "<td colspan='2'><b>PR.ADDR:</b> ".$return['present_addr1'].",".$return['present_addr2']."</td>";
	echo "<td colspan='2'><b>PERM.ADDR:</b> ".$return['perm_addr1'].",".$return['perm_addr2']."</td>";
	
	echo "</tr>";
	echo "<tr>";
	
	echo "<td><b>DOB:</b> ".$return['dateofbirth']."</td>";
	echo "<td><b>SEX:</b> ".$return['gender']."</td>";
	echo "<td><b>SCALE:</b> ".$return['scale']."</td>";
	echo "<td><b>BP: </b>".$return['basic_pay']."</td>";
	
	echo "</tr>";
	echo "<tr>";
	
	echo "<td><b>GP:</b> ".$return['grade_pay']."</td>";
	echo "<td><b>E-MAIL:</b> ".$return['email']."</td>";
	echo "<td><b>PH(R): </b>".$return['resi_no']."</td>";
	echo "<td><b>PH(M):</b> ".$return['mob_no']."</td>";
	
	echo "</tr>";
	echo "<tr>";
	
	echo "<td colspan='2'><b>Working for more than 3 Years: </b>".$return['workingstatus']."</td>";
	$ql=$return['qualificationcd'];
$qualification_query="SELECT qualification AS QualificationName FROM qualification where qualificationcd='$ql'";
$qualification_result=mysqli_query($DBLink,$qualification_query) or die(mysqli_error($DBLink));
$row=mysqli_fetch_assoc($qualification_result);
	
	
	echo "<td><b>QL:</b> ".$row['QualificationName']."</td>";
	$lang=$return['languagecd'];
$language_details_query="SELECT language AS Language FROM language where language_cd='$lang'";

$language_details_result=mysqli_query($DBLink,$language_details_query) or die(mysqli_error($DBLink));
$row=mysqli_fetch_assoc($language_details_result);

	echo "<td><b>LANG: </b>".$row['Language']."</td>";
	
	echo "</tr>";
	echo "<tr>";
	
	echo "<td><b>EPIC:</b> ".$return['epic']."</td>";
	echo "<td><b>PART NO:</b> ".$return['partno']."</td>";
	echo "<td><b>SL.NO: </b>".$return['slno']."</td>";
	$temp=$return['assembly_temp'];
$assembly_details_query="SELECT assemblyname AS AssemblyName FROM assembly where assemblycd='$temp'";

$assembly_details_result=mysqli_query($DBLink,$assembly_details_query) or die(mysqli_error($DBLink));
$row=mysqli_fetch_assoc($assembly_details_result);
	echo "<td><b>TEMP ASMBLY:</b> ".$row['AssemblyName']."</td>";
	
	echo "</tr>";
	echo "<tr>";
	
	$off=$return['assembly_off'];
$assembly_details_query="SELECT assemblyname AS AssemblyName FROM assembly where assemblycd='$off'";

$assembly_details_result=mysqli_query($DBLink,$assembly_details_query) or die(mysqli_error($DBLink));
$row=mysqli_fetch_assoc($assembly_details_result);	
	echo "<td><b>OFC ASMBLY: </b>".$row['AssemblyName']."</td>";
	
	
	$perm=$return['assembly_perm'];
$assembly_details_query="SELECT assemblyname AS AssemblyName FROM assembly where assemblycd='$perm'";

$assembly_details_result=mysqli_query($DBLink,$assembly_details_query) or die(mysqli_error($DBLink));
$row=mysqli_fetch_assoc($assembly_details_result);	
	
	echo "<td><b>PERM ASMBLY:</b> ".$row['AssemblyName']."</td>";
	$re=$return['remarks'];
$remarks_details_query="SELECT remarks AS RemarksName FROM remarks WHERE remarks_cd='$re'";

$remarks_details_result=mysqli_query($DBLink,$remarks_details_query) or die(mysqli_error($DBLink));
$row=mysqli_fetch_assoc($remarks_details_result);
	echo "<td colspan='2'><b>REMARKS: </b>".$row['RemarksName']."</td>";
	
	echo "</tr>";
	echo "<tr>";
	$bank=$return['bank_cd'];
$bank_details_query="SELECT bank_name AS BankName FROM bank where bank_cd='$bank'";

$bank_details_result=mysqli_query($DBLink,$bank_details_query) or die(mysqli_error($DBLink));

$row=mysqli_fetch_assoc($bank_details_result);
	
	echo "<td><b>BANK NAME:</b> ".$row['BankName']."</td>";
	echo "<td><b>BRNCH NAME:</b> ".$return['branchname']."</td>";
	echo "<td><b>IFSC: </b> ".$return['branchcd']."</td>";
	echo "<td><b>ACC NO:</b> ".$return['bank_acc_no']."</b></td>";

	
	echo "</tr></table>";	
	$counter++;
}
$return="";
$_SESSION['content'] = ob_get_contents();
$_SESSION['file_name']='PP2 DETAILS';
header("Location: pdf_form.php");
ob_flush();
exit(0);
?>