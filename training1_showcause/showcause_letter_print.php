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

    $first_showcause_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, poststat.poststatus, personnel.mob_no, office.officecd, office.office, CONCAT(office.address1,', ',office.address2), block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin FROM ((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd WHERE personnel_training_absent.training_type = ? AND personnel_training_absent.training_date = ? AND personnel_training_absent.training_time = ? AND training_venue.venue_base_name = ? AND office.blockormuni_cd = ? AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) ORDER BY office.officecd, personnel.personcd") or die($mysqli->error);
$first_showcause_query->bind_param("sssss",$training_type,$training_date,$training_time,$training_venue,$blockmuni) or die($first_showcause_query->error);
}

if($type == 'subdiv'){
    $subdiv=$_GET['subdiv'];
    $training_type=$_GET['training_type'];

    $first_showcause_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, poststat.poststatus, personnel.mob_no, office.officecd, office.office, CONCAT(office.address1,', ',office.address2), block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin FROM ((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd WHERE personnel_training_absent.training_type = ? AND office.subdivisioncd = ? AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) ORDER BY office.officecd, personnel.personcd") or die($mysqli->error);
$first_showcause_query->bind_param("ss",$training_type,$subdiv) or die($first_showcause_query->error);
}

if($type == 'blockmuni'){
    $training_type=$_GET['training_type'];
    $blockmuni=$_GET['blockmuni'];

    $first_showcause_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, poststat.poststatus, personnel.mob_no, office.officecd, office.office, CONCAT(office.address1,', ',office.address2), block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin FROM ((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd WHERE personnel_training_absent.training_type = ? AND office.blockormuni_cd = ? AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) ORDER BY office.officecd, personnel.personcd") or die($mysqli->error);
$first_showcause_query->bind_param("ss",$training_type,$blockmuni) or die($first_showcause_query->error);
}

$first_showcause_query->execute() or die($first_showcause_query->error);
$first_showcause_query->bind_result($personcd, $officer_name, $off_desg, $poststatus, $mob_no, $officecd, $office, $address, $block_muni_name, $postoffice, $subdivision, $policestation, $district, $pin) or die($first_showcause_query->error);

$pp_data=array();
while($first_showcause_query->fetch()){
    $pp_data[]=array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "poststatus"=>$poststatus, "mob_no"=>$mob_no, "officecd"=>$officecd, "office"=>$office, "address"=>$address, "block_muni_name"=>$block_muni_name, "postoffice"=>$postoffice, "subdivision"=>$subdivision, "policestation"=>$policestation, "district"=>$district, "pin"=>$pin);
}
$first_showcause_query->close();
for($i = 0;$i < count($pp_data); $i++){
?>
<table width="100%" style="font-family: sans-serif; font-size: 12">
    <tr>
        <th colspan="2">
            <img src="../pp_training/indian-symbol4.jpg" alt=""/><br>
            GOVERNMENT OF WEST BENGAL<br>
            Office of the District Panchayat Election Officer & District Magistrate, Hooghly<br>
            District Polling Personnel Cell<br>
            Email: ppcell.hooghly@gmail.com
        </th>
    </tr>
    <tr>
        <td width="50%" style="padding-top: 15;">
            Memo No. 50(1400) / PP Cell (Dist)
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date: 30.04.2018
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
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WHEREAS, it has been found that inspite of service of appointment letter for performing duty of  <strong><?php echo $pp_data[$i]['poststatus']; ?></strong>  to the Panchayat General Election 2018, under this office Order No.21/P.P. Cell Dist (24525) dated. 09/04/2018, you have intentionally and deliberately kept yourself absent from attending the scheduled Training Programme leading to serious dislocation of the entire election process.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOW, THEREFORE, you are directed to Show-Cause as to why action as per provisions under Section 28A/134 of the Representation of People Act, 1951 will not be taken against you.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your written reply shall have to reach the concerned Sub Divisional Officer within two days from the date of receipt of this letter.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You are further directed to attend the 2nd training programme positively to be held on 06.05.2018 as per training venue attached with the 2nd appointment letter, failing which appropriate penal measure will be taken against you without any further correspondence from this end.
        </td>
    </tr>
    <tr>
        <th style="padding-top: 40; text-align: right" colspan="2">
            <img src="../pp_training/dm-sign1.jpg" alt="" style="padding-right: 30px"/><br>
            District Panchayat Election Officer, &<br>
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
            Memo No. 50/1(2)(1400) / PP Cell (Dist)
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date: 30.04.2018
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 20">
          Copy forwarded for information to:<br>
          1. The Sponsoring Authority to serve the same to the above mentioned employee.  A consolidated reply should reach the concerned subdivision within two days from the date of receipt of this show cause notice.<br>
          2. The Sub-divisional Officer, Arambagh/ Chandannagore/ Serampore/ Sadar for information and taking necessary action.
        </td>
    </tr>
    <tr>
        <th style="padding-top: 40; text-align: right" colspan="2">
            <img src="../pp_training/dm-sign1.jpg" alt="" style="padding-right: 30px"/><br>
            District Panchayat Election Officer, &<br>
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
            Received Memo No. 50/1(2)(1400) / PP Cell (Dist)
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date: 30.04.2018
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
