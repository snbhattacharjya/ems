<title>
    Block/Municipality wise - 1st Appointment Letter
</title>
<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");
//include "../phpqrcode/qrlib.php";
$block_muni_code=$_GET['block_muni_code'];

$first_app_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, poststat.poststatus, personnel.mob_no, personnel.mob_no, personnel.epic, personnel.partno, personnel.slno, personnel.acno, personnel.branchcd, personnel.bank_acc_no, office.officecd, office.office, office.address1, block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin, training_venue_adhoc.venuename, CONCAT(training_venue_adhoc.venue_base_name,', ',training_venue_adhoc.venueaddress1), DATE_FORMAT(training_schedule_adhoc.training_dt,'%d-%M-%Y'), training_schedule_adhoc.training_time, personnel.groupid, assembly.assemblycd, assembly.assemblyname, pc.pccd, pc.pcname, dcrcmaster.dc_venue, dcrcmaster.dc_address, dcrcmaster.rc_venue, dcrcmaster.rc_address FROM (((((((((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat) INNER JOIN personnel_adhoc ON personnel.personcd = personnel_adhoc.personcd) INNER JOIN personnel_training_adhoc ON personnel.personcd = personnel_training_adhoc.personcd AND personnel_training_adhoc.training_type = '02') INNER JOIN training_schedule_adhoc ON personnel_training_adhoc.schedule_code = training_schedule_adhoc.schedule_code) INNER JOIN training_venue_adhoc ON training_venue_adhoc.venue_cd = training_schedule_adhoc.training_venue) INNER JOIN assembly ON personnel.forassembly = assembly.assemblycd) INNER JOIN pc ON assembly.pccd = pc.pccd) INNER JOIN dcrc_party ON assembly.assemblycd = dcrc_party.assemblycd) INNER JOIN dcrcmaster ON dcrc_party.dcrcgrp = dcrcmaster.dcrcgrp WHERE office.blockormuni_cd = ? ORDER BY office.officecd, personnel.personcd") or die($mysqli->error);
$first_app_query->bind_param("s", $block_muni_code) or die($first_app_query->error);
$first_app_query->execute() or die($first_app_query->error);
$first_app_query->bind_result($personcd, $officer_name, $off_desg, $poststatus, $mob_no, $epic, $partno, $slno, $acno, $branch, $ifsc, $bank_accno, $officecd, $office, $address, $block_muni_name, $postoffice, $subdivision, $policestation, $district, $pin, $venue_name, $venue_address, $training_date, $training_time, $groupid, $assemblycd, $assembly_name, $pccd, $pc_name, $dc_venue, $dc_address, $rc_venue, $rc_address) or die($first_app_query->error);

$pp_data=array();
while ($first_app_query->fetch()) {
    $pp_data[]=array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "poststatus"=>$poststatus, "mob_no"=>$mob_no, "epic"=>$epic, "partno"=>$partno, "slno"=>$slno, "acno"=>$acno, "branch"=>$branch, "ifsc"=>$ifsc, "bank_accno"=>$bank_accno, "officecd"=>$officecd, "office"=>$office, "address"=>$address, "block_muni_name"=>$block_muni_name, "postoffice"=>$postoffice, "subdivision"=>$subdivision, "policestation"=>$policestation, "district"=>$district, "pin"=>$pin, "venue_name"=>$venue_name, "venue_address" => $venue_address, "training_date"=>$training_date, "training_time"=>$training_time, "groupid"=>$groupid, "assemblycd"=>$assemblycd, "assembly_name"=>$assembly_name, "pccd"=>$pccd, "pc_name"=>$pc_name, "dc_venue"=>$dc_venue, "dc_address"=>$dc_address, "rc_venue"=>$rc_venue, "rc_address"=>$rc_address);
}
//$filepath='../pp_training/qr_img/';
//$filename=$filepath.'emp.png';
for ($i = 0;$i < count($pp_data); $i++) {
    //QRcode::png($pp_data[$i]['personcd'], $filename, 'H', 2, 2);
    //$newfile=$filepath.'emp_'.$pp_data[$i]['personcd'].'.png';
    //rename($filename,$newfile);
?>
<table width="100%" style="font-family: sans-serif; font-size: 11">
    <tr>
        <th width="20%">
            <!-- <img src="../img/ECI-Logo-LMI.jpg" alt="" height="50" width="50"/><br> -->
            Election Urgent
        </th>
        <th width="60%">
            <!-- <img src="../pp_training/indian-symbol4.jpg" alt=""/><br> -->
            ORDER OF APPOINTMENT FOR POLLING DUTIES<br>
            <?php //echo $env.", ".$dist;?>
            GENERAL ELECTION TO THE HOUSE OF PEOPLE, 2019
        </th>
        <th width="20%">&nbsp;</th>
    </tr>
    <tr>
        <th width="20%">Memo No: 164/PP CELL(Dist)/Elec </th>
      <th width="60%">&nbsp;

        </th>
        <th width="20%">Dated: 26/04/2019</th>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; In pursuance of section 26 of the Representation pf the People Act 1951 I do hereby appoint the officer specified below as <strong><?php echo $pp_data[$i]['poststatus']; ?> for the <?php echo $pp_data[$i]['assemblycd'].' - '.$pp_data[$i]['assembly_name']; ?> L.A. Constituency forming part of <?php echo $pp_data[$i]['pccd'].' - '.$pp_data[$i]['pc_name']; ?> Parliamentary Constituency</strong> in connection with the conduct of General Election to the House of People, 2019 and attend the 2nd training as per training schedule mentioned below:
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15;">
            <table width="98%" border="1" align="center" cellpadding="5" cellspacing="0" style="font-family: sans-serif; font-size: 11">
                <tr>
                    <th width="10%">Party No</th>
                    <th width="50%">Name of the Micro Observer</th>
                    <th width="40%">Training Schedule</th>
                </tr>
                <tr>
                    <th align="center"><?php echo $pp_data[$i]['groupid']; ?></th>
                    <td align="left"><strong><?php echo $pp_data[$i]['officer_name']."<br>".$pp_data[$i]['off_desg']."<br>PIN - ".$pp_data[$i]['personcd']; ?></strong>, <strong><?php echo $pp_data[$i]['office']." (".$pp_data[$i]['officecd']."), </strong>".$pp_data[$i]['address']." P.O. - ".$pp_data[$i]['postoffice'].", Subdiv - ".$pp_data[$i]['subdivision'].", P.S. - ".$pp_data[$i]['policestation'].", Dist - ".$pp_data[$i]['district'].", Pincode - ".$pp_data[$i]['pin']; ?><br>Mobile No - <?php echo $pp_data[$i]['mob_no']; ?></td>
                    <th align="center"><?php echo $pp_data[$i]['venue_name'].', '.$pp_data[$i]['venue_address']; ?>, DATE <?php echo $pp_data[$i]['training_date'].' at '.$pp_data[$i]['training_time']; ?></th>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 10;">
            The Officer should report for Distribution and Receiving Centre as per following schedule:
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 10;">
            <table width="98%" border="1" align="center" cellpadding="5" cellspacing="0" style="font-family: sans-serif; font-size: 11">
                <tr>
                    <th width="20%">Date and Time of Poll</th>
                    <th width="30%">Distribution Centre</th>
                    <th width="30%">Receiving Centre</th>
                </tr>
                <tr>
                    <td width="20%">The Poll will be taken on 06/05/2019 during the hours between 7 AM - 6 PM.</td>
                    <td width="30%"><?php echo $pp_data[$i]['dc_venue'].', '.$pp_data[$i]['dc_address'].', Date - 05/05/2019, Time - 8 AM'; ?></td>
                    <td width="30%"><?php echo $pp_data[$i]['dc_venue'].', '.$pp_data[$i]['dc_address']; ?></td>
                </tr>
                </table>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 10; text-align: justify">
            Place: Hooghly<br>
            District: Hooghly
        </td>
        <th style="padding-top: 10; text-align: justify">&nbsp;</th>
        <td style="padding-top: 10; text-align: justify">
            <img src="../pp_training_rectified/dm_sign.jpg" alt=""/><br>
            District Election Officer<br>
            Date: 22/04/2019
        </td>
    </tr>
    
    <tr>
        <th colspan="3" style="padding-top: 10; text-align: justify">
            <hr style="border-style: dashed">
        </th>
    </tr>
    <tr>
        <th colspan="3" style="padding-top: 5; text-align: justify">
            Copy to DDO / Head of Office to serve the Letter and Letter and submit the service return.
        </th>
    </tr>
    <tr>
        <th colspan="3" style="padding-top: 5; text-align: justify">
            <hr style="border-style: dashed">
        </th>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 50">
            <table width="100%" style="font-family: sans-serif; font-size: 11">
                <tr>
                    <td width="33%">
                        Receipt of Appointment Letter
                    </td>
                    <td width="33%" align="center">
                        Block/Municipality: <br>
                        <strong><?php echo $pp_data[$i]['block_muni_name']; ?></strong>
                    </td>
                    <td width="33%">
                        Signature of the Recipient<br>
                        Date:
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<p style="page-break-after: always"></p>
<?php
//rename($newfile,$filename);
}
?>
