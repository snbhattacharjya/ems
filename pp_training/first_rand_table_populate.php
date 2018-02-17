<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$first_app_query=$mysqli->prepare("DELETE FROM first_rand_table") or die($mysqli->error);
$first_app_query->execute() or die($first_app_query->error);
$first_app_query->close();

$first_app_query=$mysqli->prepare("INSERT INTO first_rand_table(personcd, officer_name, off_desg, poststat, poststatus, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni, block_muni_name, postoffice, subdivision, subdivisioncd, policestation, district, districtcd, pin, training_desc, training_sch, venuename, venueaddress, training_dt, training_time) (SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, personnel.poststat, poststat.poststatus, personnel.mob_no, personnel.epic, personnel.partno, personnel.slno, personnel.acno, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, office.officecd, office.office, CONCAT(office.address1,', ',office.address2), office.blockormuni_cd, block_muni.blockmuni, office.postoffice, subdivision.subdivision, office.subdivisioncd, policestation.policestation, district.district, office.districtcd, office.pin, 'First Training', personnel.training1_sch, training_venue.venuename, CONCAT(training_venue.venueaddress1,', ',training_venue.venueaddress2), training_schedule.training_dt, training_schedule.training_time FROM ((((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat) INNER JOIN bank ON personnel.bank_cd = bank.bank_cd) INNER JOIN training_schedule ON personnel.training1_sch = training_schedule.schedule_code) INNER JOIN training_venue ON training_schedule.training_venue = training_venue.venue_cd WHERE personnel.booked IN ('P','R'))") or die(json_encode(array("Status"=>$mysqli->error)));

$first_app_query->execute() or die(json_encode(array("Status"=>$first_app_query->error)));
$rows=$first_app_query->affected_rows;
$first_app_query->close();

echo json_encode(array("Status"=>"Success","RecordCount"=>$rows));
?>