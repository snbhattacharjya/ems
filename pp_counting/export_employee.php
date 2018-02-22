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


$personcd=$_POST['personcd'];
$poststat=$_POST['poststat'];

//Insert into personnel_counting
$insertQuery="INSERT INTO personnel_counting (personcd ,officecd ,officer_name ,off_desg, adharno,present_addr1 ,present_addr2 ,perm_addr1 ,perm_addr2 ,dateofbirth ,gender ,scale ,basic_pay ,grade_pay ,workingstatus ,email ,resi_no ,mob_no ,qualificationcd ,languagecd ,epic ,acno ,slno ,partno ,assembly_temp ,assembly_off ,assembly_perm ,districtcd ,subdivisioncd ,bank_acc_no ,bank_cd ,branchname ,branchcd ,remarks ,poststat ,posted_date ,f_cd) (SELECT personcd ,officecd ,officer_name ,off_desg, adharno,present_addr1 ,present_addr2 ,perm_addr1 ,perm_addr2 ,dateofbirth ,gender ,scale ,basic_pay ,grade_pay ,workingstatus ,email ,resi_no ,mob_no ,qualificationcd ,languagecd ,epic ,acno ,slno ,partno ,assembly_temp ,assembly_off ,assembly_perm ,districtcd ,subdivisioncd ,bank_acc_no ,bank_cd ,branchname ,branchcd ,remarks ,'$poststat' ,CURRENT_TIMESTAMP ,'0' FROM personnel_org WHERE personcd = '$personcd')";


$mysqli->multi_query($insertQuery) or die(json_encode(array("Status"=>$mysqli->error)));

echo json_encode(array("Status"=>"Success"));

?>
