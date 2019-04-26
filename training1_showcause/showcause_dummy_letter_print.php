<title>
    Block/Municipality wise - 1st Training Show Cause
</title>
<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");
//include "../phpqrcode/qrlib.php";
//$type=$_GET['type'];

/*$env_query=$mysqli->prepare("SELECT environment, distnm_sml, apt1_orderno, apt1_date FROM environment") or die($mysqli->error);
$env_query->execute() or die($env_query->error);
$env_query->bind_result($env,$dist,$apt1_order_no,$apt1_date) or die($env_query->error);
$env_query->fetch() or die($env_query->error);
$env_query->close();

if($type == 'date_venue'){
    $training_venue=$_GET['training_venue'];
    $training_date=$_GET['training_date'];
    $training_time=$_GET['training_time'];
    $training_type=$_GET['training_type'];
    $blockmuni=$_GET['blockmuni'];

    $first_showcause_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, poststat.poststatus, personnel.mob_no, office.officecd, office.office, CONCAT(office.address1,', ',office.address2), block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin, training_venue.venuename, CONCAT(training_venue.venueaddress1,', ',training_venue.venueaddress2), training_schedule.training_dt, training_schedule.training_time, show_cause_memo.memo_no, show_cause_memo.memo_date FROM (((((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat) INNER JOIN training_schedule ON personnel.training1_sch = training_schedule.schedule_code) INNER JOIN training_venue ON training_schedule.training_venue = training_venue.venue_cd) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd) INNER JOIN show_cause_memo ON DATE(training_schedule.training_dt) = show_cause_memo.training_date WHERE personnel_training_absent.training_type = ? AND personnel_training_absent.training_date = ? AND personnel_training_absent.training_time = ? AND training_venue.venue_base_name = ? AND office.blockormuni_cd = ? AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) ORDER BY office.officecd, personnel.personcd") or die($mysqli->error);
$first_showcause_query->bind_param("sssss",$training_type,$training_date,$training_time,$training_venue,$blockmuni) or die($first_showcause_query->error);
}

if($type == 'subdiv'){
    $subdiv=$_GET['subdiv'];
    $training_type=$_GET['training_type'];

    $first_showcause_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, poststat.poststatus, personnel.mob_no, office.officecd, office.office, CONCAT(office.address1,', ',office.address2), block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin, training_venue.venuename, CONCAT(training_venue.venueaddress1,', ',training_venue.venueaddress2), training_schedule.training_dt, training_schedule.training_time, show_cause_memo.memo_no, show_cause_memo.memo_date FROM (((((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat) INNER JOIN training_schedule ON personnel.training1_sch = training_schedule.schedule_code) INNER JOIN training_venue ON training_schedule.training_venue = training_venue.venue_cd) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd) INNER JOIN show_cause_memo ON DATE(training_schedule.training_dt) = show_cause_memo.training_date WHERE personnel_training_absent.training_type = ? AND office.subdivisioncd = ? AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) ORDER BY office.officecd, personnel.personcd") or die($mysqli->error);
$first_showcause_query->bind_param("ss",$training_type,$subdiv) or die($first_showcause_query->error);
}

if($type == 'blockmuni'){
    $training_type=$_GET['training_type'];
    $blockmuni=$_GET['blockmuni'];

    $first_showcause_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, poststat.poststatus, personnel.mob_no, office.officecd, office.office, CONCAT(office.address1,', ',office.address2), block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin, training_venue.venuename, CONCAT(training_venue.venueaddress1,', ',training_venue.venueaddress2), training_schedule.training_dt, training_schedule.training_time, show_cause_memo.memo_no, show_cause_memo.memo_date FROM (((((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat) INNER JOIN training_schedule ON personnel.training1_sch = training_schedule.schedule_code) INNER JOIN training_venue ON training_schedule.training_venue = training_venue.venue_cd) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd) INNER JOIN show_cause_memo ON DATE(training_schedule.training_dt) = show_cause_memo.training_date WHERE personnel_training_absent.training_type = ? AND office.blockormuni_cd = ? AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) ORDER BY office.officecd, personnel.personcd") or die($mysqli->error);
$first_showcause_query->bind_param("ss",$training_type,$blockmuni) or die($first_showcause_query->error);
}

$first_showcause_query->execute() or die($first_showcause_query->error);
$first_showcause_query->bind_result($personcd, $officer_name, $off_desg, $poststatus, $mob_no, $officecd, $office, $address, $block_muni_name, $postoffice, $subdivision, $policestation, $district, $pin, $venuename, $venueaddress, $training_dt, $training_time,$memo_no,$memo_date) or die($first_showcause_query->error);

$pp_data=array();
while($first_showcause_query->fetch()){
    $pp_data[]=array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "poststatus"=>$poststatus, "mob_no"=>$mob_no, "officecd"=>$officecd, "office"=>$office, "address"=>$address, "block_muni_name"=>$block_muni_name, "postoffice"=>$postoffice, "subdivision"=>$subdivision, "policestation"=>$policestation, "district"=>$district, "pin"=>$pin, "venuename"=>$venuename, "venueaddress"=>$venueaddress, "training_dt"=>$training_dt, "training_time"=>$training_time,"memo_no"=>$memo_no,"memo_date"=>$memo_date);
}
$first_showcause_query->close();
for($i = 0;$i < count($pp_data); $i++){*/
?>
<table width="100%" style="font-family: sans-serif; font-size: 12">
    <tr>
        <th colspan="2">
            <!-- <img src="../pp_training/indian-symbol4.jpg" alt=""/><br>
            GOVERNMENT OF WEST BENGAL<br> -->
            Office of the District Election Officer & District Magistrate, Hooghly<br>
            District Polling Personnel Cell<br>
            Email: ppcell.hooghly@gmail.com<br>
        </th>
    </tr>
    <tr>
        <td width="50%" style="padding-top: 15;">
            No. xxx/PPCell(Dist)
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date:
        </td>
    </tr>
    <tr>
        <th colspan="2" style="padding-top: 15; text-align: left">
            To<br>
            xxxx<br>
            xxxxxxx<br>
            xxxxxxxxxx<br>

        </th>
    </tr>
    <tr>
        <th colspan="2" style="padding-top: 15;">
            Sub: <u>Reminder for Additional hands-on training on EVM and VVPAT</u>
        </th>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 20; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WHEREAS, it has been found that in spite of service of 1st order of Appointment for performing duty of <strong> PRESIDING OFFICER</strong>  to the Election to the House of People, 2019 vide this office memo no. 61/P.P. Cell Dist dated 13/03/2019, you have kept yourself absent from attending training on <strong>07/04/2019</strong> at <strong>09:00 AM</strong> in <strong>HETC</strong>.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Whereas, it has been observed that an additional hands-on training will be very much required for effective performance of polling duty as <strong> PRESIDING OFFICER</strong>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hence, you are requested to attend the additional training as per schedule given below:
        </td>
    </tr>
    <tr>
        <th colspan="2" style="padding-top: 15; text-align: justify; border-style:solid; border-width: thin;">
            TRAINING VENUE NAME AND ADDRESS with TRAINING DATE and TIME
        </th>
    </tr>
    <tr>
        <th style="padding-top: 20; text-align: right" colspan="2">
            <img src="../pp_training_rectified/dm_sign.jpg" alt="" style="padding-right: 30px" height="40px" width="60px"/><br>
            District Election Officer, &<br>
            District Magistrate Hooghly
        </th>
    </tr>
    <tr>
        <td width="50%" style="padding-top: 15;">
            No. xxx/PPCell(Dist)
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date:
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 20">
            1.	The Sponsoring Authority with a request to serve the same to the above mentioned employee and direct him to attend additional training on the scheduled date and time without fail.
        </td>
    </tr>
    <tr>
        <th style="padding-top: 20; text-align: right" colspan="2">
            <img src="../pp_training_rectified/dm_sign.jpg" alt="" style="padding-right: 30px" height="40px" width="60px"/><br>
            District Election Officer, &<br>
            District Magistrate Hooghly
        </th>
    </tr>
</table>
<p style="page-break-after: always"></p>
<?php
//}
?>
