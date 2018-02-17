<div class="box box-info">
<div class="box-body">
<h4>
<?php
include("../config/config.php");
if(!isset($_POST['accno']))
die("<h3>Error!! Please try agian later.</h3>");

$accno=$_POST['accno'];
?>

<?php

$query_get_accno=mysql_query("select * from personnel where bank_acc_no='$accno'") or die("<h3>Error!! Please try agian later.</h3>");

$res=mysql_fetch_assoc($query_get_accno) or die("<h3>Error!! Please try agian later.</h3>");

$ofccd=$res['officecd'];


$office_name_query="SELECT office AS OfficeName,phone,mobile FROM office WHERE officecd='$ofccd'";

$ofc_name_result=mysql_query($office_name_query,$DBLink) or die(mysql_error());
$ofc_ret=mysql_fetch_assoc($ofc_name_result);

$bank=$res['bank_cd'];
$bank_details_query="SELECT bank_name AS BankName FROM bank where bank_cd='$bank'";

$bank_details_result=mysql_query($bank_details_query,$DBLink) or die(mysql_error());

$row=mysql_fetch_assoc($bank_details_result);

echo "Office: ".$ofc_ret['OfficeName']." (".$ofccd.")<br><br>";
echo "Person: ".$res['officer_name']." (".$res['personcd'].")<br><br>";
echo "Designation: ".$res['off_desg']."<br><br>";
echo "Contact: ".$res['resi_no']."/".$res['mob_no']."<br><br>";
echo "Office Contact: ".$ofc_ret['phone']."/".$ofc_ret['mobile']."<br><br>";
echo "Bank Details: ".$row['BankName']." (".$res['branchname']." Branch)<br><br>";
echo "IFSC: ".$res['branchcd']."<br><br>";
echo "ACCOUNT NUMBER: ".$res['bank_acc_no']."<br>";
?></h4>
</div>
</div>