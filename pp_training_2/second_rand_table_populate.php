<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$second_app_query=$mysqli->prepare("TRUNCATE second_rand_table") or die($mysqli->error);
$second_app_query->execute() or die($second_app_query->error);
$second_app_query->close();

$second_app_query=$mysqli->prepare("INSERT INTO second_rand_table(personcd, officer_name, off_desg, poststat, poststatus, poststat_order, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni, block_muni_name, postoffice, subdivision, subdivisioncd, policestation, district, districtcd, pin, training_desc, training_sch, venuename, venueaddress, training_dt, training_time, forassembly, forassembly_name, booked, groupid, dc_venue, dc_addr, rc_venue, rc_addr) (SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, personnel.poststat, poststat.poststatus, poststat.poststat_order, personnel.mob_no, personnel.epic, personnel.partno, personnel.slno, personnel.acno, bank.bank_name, personnel.branchname, personnel.branchcd, personnel.bank_acc_no, office.officecd, office.office, CONCAT(office.address1,', ',office.address2), office.blockormuni_cd, block_muni.blockmuni, office.postoffice, subdivision.subdivision, office.subdivisioncd, policestation.policestation, district.district, office.districtcd, office.pin, 'Second Training', '', '', '', '2018-05-06', '11 AM', personnel.forassembly, assembly.assemblyname, personnel.booked, personnel.groupid, dcrcmaster.dc_venue, dcrcmaster.dc_addr, dcrcmaster.rcvenue, dcrcmaster.rc_addr FROM ((((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat) INNER JOIN bank ON personnel.bank_cd = bank.bank_cd) INNER JOIN assembly ON personnel.forassembly = assembly.assemblycd) INNER JOIN dcrcmaster ON assembly.assemblycd = dcrcmaster.assemblycd WHERE personnel.booked IN ('P','R') AND personnel.groupid != 0)") or die(json_encode(array("Status"=>$mysqli->error)));

$second_app_query->execute() or die(json_encode(array("Status"=>$second_app_query->error)));
$rows=$second_app_query->affected_rows;
$second_app_query->close();

echo json_encode(array("Status"=>"Success","RecordCount"=>$rows));
?>
