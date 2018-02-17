<title>
    Block/Municipality wise - 1st Training Show Cause
</title>
<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");
//include "../phpqrcode/qrlib.php"; 
$type=$_GET['type'];

$env_query=$mysqli->prepare("SELECT environment, distnm_sml, apt1_orderno, apt1_date FROM environment") or die($mysqli->error);
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
for($i = 0;$i < count($pp_data); $i++){
?>
<table width="100%" style="font-family: sans-serif; font-size: 12">
    <tr>
        <th colspan="2">
            <img src="../pp_training/indian-symbol4.jpg" alt=""/><br>
            GOVERNMENT OF WEST BENGAL<br>
            Office of the District Election Officer & District Magistrate, Hooghly<br>
            District Polling Personnel Cell<br>
        </th>
    </tr>
    <tr>
        <td width="50%" style="padding-top: 15;">
            No. <?php echo $pp_data[$i]['memo_no']; ?>/PPCell(Dist)
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date: <?php echo date_format(date_create($pp_data[$i]['memo_date']),"d/m/Y"); ?>
        </td>
    </tr>
    <tr>
        <th colspan="2" style="padding-top: 15; text-align: left">
            To<br>
            <?php echo $pp_data[$i]['officer_name']."<br>".$pp_data[$i]['off_desg']."<br>PIN - ".$pp_data[$i]['personcd']; ?><br>
            <?php echo $pp_data[$i]['office']." (".$pp_data[$i]['officecd']."), <br>".$pp_data[$i]['address']." <br>P.O. - ".$pp_data[$i]['postoffice'].", Subdiv - ".$pp_data[$i]['subdivision'].", <br>P.S. - ".$pp_data[$i]['policestation'].", <br>Dist - ".$pp_data[$i]['district'].", Pincode - ".$pp_data[$i]['pin']; ?>   
        </th>
    </tr>
    <tr>
        <th colspan="2" style="padding-top: 15;">
            Sub: <u>Show Cause Notice</u>
        </th>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 20; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WHEREAS, it has been found that in spite of service of 1st order of Appointment for performing duty of <strong><?php echo $pp_data[$i]['poststatus']; ?></strong>  to the Assembly General Election, 2016 under this office order no. 65/PPcell/HOOG(24907) dated. 12/03/2016, you have intentionally and deliberately kept yourself absent in the Training Venue - <strong><?php echo $pp_data[$i]['venuename']; ?></strong> on <strong><?php echo date_format(date_create($pp_data[$i]['training_dt']),"d-M-Y"); ?></strong> at <strong><?php echo $pp_data[$i]['training_time']; ?></strong>.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOW THEREFORE, you are directed to show-cause as to why disciplinary action as per provisions under Section 28A/134 of the Representation of People Act' 1951 will not be taken against you in consultation with your administrative department.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your written reply should reach the undersigned within 03 (three) days from the date of receipt of this letter.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You are further directed to attend Mop-Up training as per training schedule attached, failing which appropriate penal measure will be taken against you without any further correspondence from this end.
        </td>
    </tr>
    <tr>
        <th style="padding-top: 40; text-align: right" colspan="2">
            <img src="../pp_training/dm-sign1.jpg" alt="" style="padding-right: 30px"/><br>
            District Election Officer &<br>
            District Magistrate Hooghly
        </th>
    </tr>
    <tr>
        <td width="50%" style="padding-top: 15;">
            No. <?php echo $pp_data[$i]['memo_no']; ?>/PPCell(Dist)
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date: <?php echo date_format(date_create($pp_data[$i]['memo_date']),"d/m/Y"); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 20">
            1.	The Sponsoring Authority with a request to serve the same to the above mentioned employee and direct him to submit reply within stipulated time and attend mop-up training on the scheduled date and time without fail.
        </td>
    </tr>
    <tr>
        <th style="padding-top: 40; text-align: right" colspan="2">
            <img src="../pp_training/dm-sign1.jpg" alt="" style="padding-right: 30px"/><br>
            District Election Officer &<br>
            District Magistrate Hooghly
        </th>
    </tr>
</table>
<p style="page-break-after: always"></p>
<?php
}
?>