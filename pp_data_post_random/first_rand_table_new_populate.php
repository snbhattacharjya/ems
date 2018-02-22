<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$first_app_query=$mysqli->prepare("DELETE FROM first_rand_table_new") or die($mysqli->error);
$first_app_query->execute() or die($first_app_query->error);
$first_app_query->close();

$first_app_query=$mysqli->prepare("INSERT INTO first_rand_table_new(personcd, officer_name, off_desg, poststat, poststatus, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni, block_muni_name, postoffice, subdivision, subdivisioncd, policestation, district, districtcd, pin, training_desc, posted_date) (SELECT personnel_new.personcd, personnel_new.officer_name, personnel_new.off_desg, personnel_new.poststat, poststat.poststatus, personnel_new.mob_no, personnel_new.epic, personnel_new.partno, personnel_new.slno, personnel_new.acno, bank.bank_name, personnel_new.branchname, personnel_new.branchcd, personnel_new.bank_acc_no, office.officecd, office.office, CONCAT(office.address1,', ',office.address2), office.blockormuni_cd, block_muni.blockmuni, office.postoffice, subdivision.subdivision, office.subdivisioncd, policestation.policestation, district.district, office.districtcd, office.pin, 'First Training', personnel_new.posted_date FROM ((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel_new ON office.officecd=personnel_new.officecd) INNER JOIN poststat ON poststat.post_stat = personnel_new.poststat) INNER JOIN bank ON personnel_new.bank_cd = bank.bank_cd)") or die(json_encode(array("Status"=>$mysqli->error)));

$first_app_query->execute() or die(json_encode(array("Status"=>$first_app_query->error)));
$rows=$first_app_query->affected_rows;
$first_app_query->close();

echo json_encode(array("Status"=>"Success","RecordCount"=>$rows));
?>