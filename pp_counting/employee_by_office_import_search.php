<?php
session_start();

$search_val=$_POST['search_val'];
$search_param=$_POST['search_param'];

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

if($search_param == 'id'){
    $personcd=explode(",",$_POST['search_val']);
$personcd_clause='';
    for($i = 0; $i < count($personcd); $i++){
        $personcd_clause.="'".$personcd[$i]."',";
    }

    $personcd_clause=rtrim($personcd_clause,',');
    
    $emp_office_query="SELECT personnel_org.personcd, personnel_org.officer_name, personnel_org.off_desg, personnel_org.gender, personnel_org.mob_no, CONCAT(office.officecd,' - ',office.office,', ',office.address1) AS office_details FROM personnel_org INNER JOIN office ON personnel_org.officecd = office.officecd WHERE personcd IN ($personcd_clause) AND personcd NOT IN (SELECT personcd FROM personnel_counting) ORDER BY personcd";
}
else if($search_param == 'name'){
    $officer_name=explode(",",$_POST['search_val']);
    $officer_name_clause='';
    for($i = 0; $i < count($officer_name); $i++){
        $officer_name_clause.="'".strtoupper($officer_name[$i])."',";
    }

    $officer_name_clause=rtrim($officer_name_clause,',');
    
    $emp_office_query="SELECT personnel_org.personcd, personnel_org.officer_name, personnel_org.off_desg, personnel_org.gender, personnel_org.mob_no, CONCAT(office.officecd,' - ',office.office,', ',office.address1) AS office_details FROM personnel_org INNER JOIN office ON personnel_org.officecd = office.officecd WHERE officer_name IN ($officer_name_clause) AND personcd NOT IN (SELECT personcd FROM personnel_counting) ORDER BY personcd";
    
}
else if($search_param == 'bank'){
    $bank_acc_no=explode(",",$_POST['search_val']);
    $bank_acc_no_clause='';
    for($i = 0; $i < count($bank_acc_no); $i++){
        $bank_acc_no_clause.="'".$bank_acc_no[$i]."',";
    }

    $bank_acc_no_clause=rtrim($bank_acc_no_clause,',');
    
    $emp_office_query="SELECT personnel_org.personcd, personnel_org.officer_name, personnel_org.off_desg, personnel_org.gender, personnel_org.mob_no, CONCAT(office.officecd,' - ',office.office,', ',office.address1) AS office_details FROM personnel_org INNER JOIN office ON personnel_org.officecd = office.officecd WHERE bank_acc_no IN ($bank_acc_no_clause) AND personcd NOT IN (SELECT personcd FROM personnel_counting) ORDER BY personcd";
    
}

$emp_office_result=mysql_query($emp_office_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($emp_office_result))
{
    $return[]=$row;
}
echo json_encode($return);
?>