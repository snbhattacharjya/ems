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

$first_app_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, poststat.poststatus, personnel.mob_no, personnel.mob_no, personnel.epic, personnel.partno, personnel.slno, personnel.acno, personnel.branchcd, personnel.bank_acc_no, office.officecd, office.office, office.address1, block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin, training_venue_adhoc.venuename, CONCAT(training_venue_adhoc.venue_base_name,', ',training_venue_adhoc.venueaddress1), DATE_FORMAT(training_schedule_adhoc.training_dt,'%d-%M-%Y'), training_schedule_adhoc.training_time FROM (((((((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat = personnel.poststat) INNER JOIN personnel_adhoc ON personnel.personcd = personnel_adhoc.personcd) INNER JOIN personnel_training_adhoc ON personnel.personcd = personnel_training_adhoc.personcd) INNER JOIN training_schedule_adhoc ON personnel_training_adhoc.schedule_code = training_schedule_adhoc.schedule_code) INNER JOIN training_venue_adhoc ON training_venue_adhoc.venue_cd = training_schedule_adhoc.training_venue WHERE office.blockormuni_cd = ? ORDER BY office.officecd, personnel.personcd") or die($mysqli->error);
$first_app_query->bind_param("s", $block_muni_code) or die($first_app_query->error);
$first_app_query->execute() or die($first_app_query->error);
$first_app_query->bind_result($personcd, $officer_name, $off_desg, $poststatus, $mob_no, $epic, $partno, $slno, $acno, $branch, $ifsc, $bank_accno, $officecd, $office, $address, $block_muni_name, $postoffice, $subdivision, $policestation, $district, $pin, $venue_name, $venue_address, $training_date, $training_time) or die($first_app_query->error);

$pp_data=array();
while ($first_app_query->fetch()) {
    $pp_data[]=array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "poststatus"=>$poststatus, "mob_no"=>$mob_no, "epic"=>$epic, "partno"=>$partno, "slno"=>$slno, "acno"=>$acno, "branch"=>$branch, "ifsc"=>$ifsc, "bank_accno"=>$bank_accno, "officecd"=>$officecd, "office"=>$office, "address"=>$address, "block_muni_name"=>$block_muni_name, "postoffice"=>$postoffice, "subdivision"=>$subdivision, "policestation"=>$policestation, "district"=>$district, "pin"=>$pin, "venue_name"=>$venue_name, "venue_address" => $venue_address, "training_date"=>$training_date, "training_time"=>$training_time);
}
$first_app_query->close();
//$filepath='../pp_training/qr_img/';
//$filename=$filepath.'emp.png';
for ($i = 0;$i < count($pp_data); $i++) {
    //QRcode::png($pp_data[$i]['personcd'], $filename, 'H', 2, 2);
    //$newfile=$filepath.'emp_'.$pp_data[$i]['personcd'].'.png';
    //rename($filename,$newfile);
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
            Memo No. 143/PP Cell (Dist)/Elec.
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date: 22.04.2019
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
            Sub: <u>Show Cause Notice</u>
        </th>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 20; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WHEREAS, it has been found that in spite of service of 1st order of Appointment for performing duty of <strong><?php echo $pp_data[$i]['poststatus']; ?></strong>  to the Election to the House of People, 2019, vide this office memo No.99/P.P. Cell Dist dated. 03/04/2019, , you have kept yourself absent from attending training on 21/04/2019 at RABINDRA BHAVAN HALL, CHINSURAH HOOGHLY.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOW THEREFORE, you are further directed to attend training, which is scheduled to be held as per following schedule: 
        </td>
    </tr>
    
    <tr>
        <th colspan="2" style="padding-top: 15; text-align: justify; border-style:solid; border-width: thin;">
            <?php echo $pp_data[$i]['venue_name'].', '.$pp_data[$i]['venue_address']; ?>, DATE <?php echo $pp_data[$i]['training_date'].' at '.$pp_data[$i]['training_time']; ?>
        </th>
    </tr>

    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OTHERWISE, you are directed to showcause why legal action will not be taken against you as per provision under section 134 of Representation of People Act, 1951 and your reply must reach to the office of the undersigned within 26/04/2019 without fail.
        </td>
    </tr>

    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Failing either of the action mentioned above, appropriate action will be taken by the undersigned without any further corrospondence.
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
            Memo No. 143/PP Cell (Dist)/Elec.
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date: 22.04.2019
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
            Received Memo No. 143/PP Cell (Dist)/Elec.
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date: 22.04.2019
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
//rename($newfile,$filename);
}
?>
