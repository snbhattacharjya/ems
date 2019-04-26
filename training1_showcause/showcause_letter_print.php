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
$type=$_GET['type'];

/*$env_query=$mysqli->prepare("SELECT environment, distnm_sml, apt1_orderno, apt1_date FROM environment") or die($mysqli->error);
$env_query->execute() or die($env_query->error);
$env_query->bind_result($env,$dist,$apt1_order_no,$apt1_date) or die($env_query->error);
$env_query->fetch() or die($env_query->error);
$env_query->close();
*/
if ($type == 'date_venue') {
    $training_venue=$_GET['training_venue'];
    $training_date=$_GET['training_date'];
    $training_time=$_GET['training_time'];
    $training_type=$_GET['training_type'];
    $blockmuni=$_GET['blockmuni'];

    $first_showcause_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, poststat.poststatus, personnel.mob_no, office.officecd, office.office, office.address1, block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin, training_venue.venuename, DATE_FORMAT(training_schedule.training_dt,'%d-%M-%Y'), training_schedule.training_time, training_venue_mopup_handson.venue_name, training_venue_mopup_handson.venue_address FROM (((((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd) INNER JOIN training_schedule ON personnel_training_absent_handson_total.training_schedule = training_schedule.schedule_code) INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue) INNER JOIN training_venue_mopup_handson ON subdivision.subdivisioncd = training_venue_mopup_handson.subdivisioncd WHERE personnel_training_absent.training_type = ? AND personnel_training_absent.training_date = ? AND personnel_training_absent.training_time = ? AND training_venue.venue_base_name = ? AND office.blockormuni_cd = ? AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) ORDER BY office.officecd, personnel.personcd") or die($mysqli->error);
    $first_showcause_query->bind_param("sssss", $training_type, $training_date, $training_time, $training_venue, $blockmuni) or die($first_showcause_query->error);
}

if ($type == 'subdiv') {
    $subdiv=$_GET['subdiv'];
    $training_type=$_GET['training_type'];

    $first_showcause_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, poststat.poststatus, personnel.mob_no, office.officecd, office.office, office.address1, block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin, training_venue.venuename, DATE_FORMAT(training_schedule.training_dt,'%d-%M-%Y'), training_schedule.training_time, training_venue_mopup_handson.venue_name, training_venue_mopup_handson.venue_address FROM (((((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd) INNER JOIN training_schedule ON personnel_training_absent_handson_total.training_schedule = training_schedule.schedule_code) INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue) INNER JOIN training_venue_mopup_handson ON subdivision.subdivisioncd = training_venue_mopup_handson.subdivisioncd WHERE personnel_training_absent.training_type = ? AND office.subdivisioncd = ? AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) ORDER BY office.officecd, personnel.personcd") or die($mysqli->error);
    $first_showcause_query->bind_param("ss", $training_type, $subdiv) or die($first_showcause_query->error);
}

if ($type == 'blockmuni') {
    //$training_type=$_GET['training_type'];
    $training_type = '02';
    $blockmuni=$_GET['blockmuni'];

    $first_showcause_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, poststat.poststatus, personnel.mob_no, office.officecd, office.office, office.address1, block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin, training_venue.venuename, DATE_FORMAT(training_schedule.training_dt,'%d-%M-%Y'), training_schedule.training_time, training_venue_mopup_handson.venue_name, training_venue_mopup_handson.venue_address FROM (((((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat AND personnel.poststat IN ('PR','P1')) INNER JOIN personnel_training_absent_handson_total ON personnel.personcd = personnel_training_absent_handson_total.personcd) INNER JOIN training_schedule ON personnel_training_absent_handson_total.training_schedule = training_schedule.schedule_code) INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue) INNER JOIN training_venue_mopup_handson ON subdivision.subdivisioncd = training_venue_mopup_handson.subdivisioncd WHERE personnel_training_absent_handson_total.training_type = ? AND office.blockormuni_cd = ? AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) ORDER BY office.officecd, personnel.personcd") or die($mysqli->error);
    $first_showcause_query->bind_param("ss", $training_type, $blockmuni) or die($first_showcause_query->error);
}

$first_showcause_query->execute() or die($first_showcause_query->error);
$first_showcause_query->bind_result($personcd, $officer_name, $off_desg, $poststatus, $mob_no, $officecd, $office, $address, $block_muni_name, $postoffice, $subdivision, $policestation, $district, $pin, $training_venue, $training_date, $training_time, $mopup_venue, $mopup_venue_address) or die($first_showcause_query->error);

$pp_data=array();
while ($first_showcause_query->fetch()) {
    $pp_data[]=array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "poststatus"=>$poststatus, "mob_no"=>$mob_no, "officecd"=>$officecd, "office"=>$office, "address"=>$address, "block_muni_name"=>$block_muni_name, "postoffice"=>$postoffice, "subdivision"=>$subdivision, "policestation"=>$policestation, "district"=>$district, "pin"=>$pin, "training_venue" => $training_venue,"training_date" => $training_date, "training_time"=> $training_time, "mopup_venue" => $mopup_venue, "mopup_venue_address" => $mopup_venue_address);
}
$first_showcause_query->close();
for ($i = 0;$i < count($pp_data); $i++) {
    ?>
<table width="100%" style="font-family: sans-serif; font-size: 12">
    <tr>
        <th colspan="2">
            <!--<img src="../pp_training/indian-symbol4.jpg" alt=""/><br>
            GOVERNMENT OF WEST BENGAL<br> -->
            Office of the District Election Officer & District Magistrate, Hooghly<br>
            District Polling Personnel Cell<br>
            Email: ppcell.hooghly@gmail.com
        </th>
    </tr>
    <tr>
        <td width="50%" style="padding-top: 15;">
            Memo No. 108/PP Cell (Dist)/Elec.
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date: 08.04.2019
        </td>
    </tr>
    <tr>
        <th colspan="2" style="padding-top: 15; text-align: left">
            To<br>
            <?php echo $pp_data[$i]['officer_name']."<br>".$pp_data[$i]['off_desg']."<br>PIN - ".$pp_data[$i]['personcd']; ?><br>
            <?php echo $pp_data[$i]['office']." (".$pp_data[$i]['officecd']."), <br>".$pp_data[$i]['address']." <br>P.O. - ".$pp_data[$i]['postoffice'].", Subdiv - ".$pp_data[$i]['subdivision'].", <br>Block/Municipality: ".$pp_data[$i]['block_muni_name'].", P.S. - ".$pp_data[$i]['policestation'].", <br>Dist - ".$pp_data[$i]['district'].", Pincode - ".$pp_data[$i]['pin']; ?>
        </th>
    </tr>
    <tr>
        <th colspan="2" style="padding-top: 15;">
            Sub: <u>Reminder for Additional hands-on training on EVM and VVPAT</u>
        </th>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 20; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WHEREAS, it has been found that in spite of service of 1st order of Appointment for performing duty of <strong><?php echo $pp_data[$i]['poststatus']; ?></strong>  to the Election to the House of People, 2019, vide this office memo No.61/P.P. Cell Dist dated. 13/03/2019, , you have kept yourself absent from attending training on <?php echo $pp_data[$i]['training_date']; ?> at <?php echo $pp_data[$i]['training_time']; ?> in <?php echo $pp_data[$i]['training_venue']; ?>.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Whereas, it has been observed that an additional hands-on training will be very much required for effective performance of polling duty as <strong><?php echo $pp_data[$i]['poststatus']; ?></strong>.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hence, you are requested to attend the additional training as per schedule given below:
        </td>
    </tr>
    <tr>
        <th colspan="2" style="padding-top: 15; text-align: justify; border-style:solid; border-width: thin;">
            <?php echo $pp_data[$i]['mopup_venue'].', '.$pp_data[$i]['mopup_venue_address']; ?>, DATE - 14-Apr-2019, TIME - 11:00 AM
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
        <th style="padding-top: 20;" colspan="2">
          <hr>
        </th>
    </tr>
    <tr>
        <td width="50%" style="padding-top: 15;">
            Memo No. 108/PP Cell (Dist)/Elec.
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date: 08.04.2019
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 20">
          Copy forwarded for information to:<br>
          1. The Sponsoring Authority with a request to serve the same to the above mentioned employee and direct him to attend additional training on the scheduled date and time without fail.<br>
          2. The Sub-divisional Officer, Arambagh/ Chandannagore/ Serampore/ Sadar for information and taking necessary action.
        </td>
    </tr>
    <tr>
        <th style="padding-top: 20; text-align: right" colspan="2">
            <img src="../pp_training_rectified/dm_sign.jpg" alt="" style="padding-right: 30px" height="40px" width="60px"/><br>
            District Election Officer, &<br>
            District Magistrate Hooghly
        </th>
    </tr>
    <tr>
        <th style="padding-top: 20;" colspan="2">
          <hr>
        </th>
    </tr>
    <tr>
        <td width="50%" style="padding-top: 15;">
            Received Memo No. 108/PP Cell (Dist)/Elec.
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date: 08.04.2019
        </td>
    </tr>
    <tr>
        <th style="padding-top: 40; text-align: right" colspan="2">
            Signature of the Sponsoring Authority with seal
        </th>
    </tr>
</table>
<p style="page-break-after: always"></p>
<?php
}
?>
