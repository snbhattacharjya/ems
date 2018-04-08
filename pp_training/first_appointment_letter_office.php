<title>
    Office wise - 1st Appointment Letter
</title>
<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");
//include "../phpqrcode/qrlib.php";
$office_code=$_GET['office_code'];

$env_query=$mysqli->prepare("SELECT environment, distnm_sml, apt1_orderno, apt1_date FROM environment") or die($mysqli->error);
$env_query->execute() or die($env_query->error);
$env_query->bind_result($env,$dist,$apt1_order_no,$apt1_date) or die($env_query->error);
$env_query->fetch() or die($env_query->error);
$env_query->close();

$first_app_query=$mysqli->prepare("SELECT personcd, officer_name, off_desg, poststatus, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni_name, postoffice, subdivision, policestation, district, pin, training_desc, venuename, venueaddress, training_dt, training_time FROM first_rand_table WHERE officecd = ? ORDER BY officecd, personcd") or die($mysqli->error);
$first_app_query->bind_param("s",$office_code) or die($first_app_query->error);
$first_app_query->execute() or die($first_app_query->error);
$first_app_query->bind_result($personcd, $officer_name, $off_desg, $poststatus, $mob_no, $epic, $partno, $slno, $acno, $bank, $branch, $ifsc, $bank_accno, $officecd, $office, $address, $block_muni_name, $postoffice, $subdivision, $policestation, $district, $pin, $training_desc, $venuename, $venueaddress, $training_dt, $training_time) or die($first_app_query->error);

$pp_data=array();
while($first_app_query->fetch()){
    $pp_data[]=array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "poststatus"=>$poststatus, "mob_no"=>$mob_no, "epic"=>$epic, "partno"=>$partno, "slno"=>$slno, "acno"=>$acno, "bank"=>$bank, "branch"=>$branch, "ifsc"=>$ifsc, "bank_accno"=>$bank_accno, "officecd"=>$officecd, "office"=>$office, "address"=>$address, "block_muni_name"=>$block_muni_name, "postoffice"=>$postoffice, "subdivision"=>$subdivision, "policestation"=>$policestation, "district"=>$district, "pin"=>$pin, "training_desc"=>$training_desc, "venuename"=>$venuename, "venueaddress"=>$venueaddress, "training_dt"=>$training_dt, "training_time"=>$training_time);
}
$first_app_query->close();
//$filepath='../pp_training/qr_img/';
//$filename=$filepath.'emp.png';
for($i = 0;$i < count($pp_data); $i++){
    //QRcode::png($pp_data[$i]['personcd'], $filename, 'H', 2, 2);
    //$newfile=$filepath.'emp_'.$pp_data[$i]['personcd'].'.png';
    //rename($filename,$newfile) or die('Error in rename');
?>
<table width="100%" style="font-family: sans-serif; font-size: 11">
    <tr>
        <th width="20%">&nbsp;Election Urgent </th>
        <th width="60%">
            <img src="../pp_training/indian-symbol4.jpg" alt=""/><br>
            ORDER OF APPOINTMENT FOR TRAINING<br>
            <?php echo $env.", ".$dist; ?>
        </th>
        <th width="20%">&nbsp;</th>
    </tr>
    <tr>
        <th width="20%">Memo No: 21/PP CELL Dist(24525) </th>
      <th width="60%">&nbsp;

        </th>
        <th width="20%">Dated: 09/04/2018</th>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp; In exercise of the power conferred upon vide Section 26 of the R. P. Act, 1951 read with sub section(5) of section 6 of West Bengal State Election Commission Act 1994 (WB Act VIII of 1994) read with section 28 of the West Bengal Panchayat Election Act 2003, I do hereby appoint the officer specified below as Polling Officer for undergoing training in connection with the conduct of West Bengal Panchayat Election, 2018 in district of Hooghly.</td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15;">
            <table width="98%" border="1" align="center" cellpadding="5" cellspacing="0" style="font-family: sans-serif; font-size: 11">
                <tr>
                    <th width="25%">Polling Officer</th>
                    <th width="50%">Office Address</th>
                    <th width="25%">Post Status</th>
                </tr>
                <tr>
                    <th align="left"><?php echo $pp_data[$i]['officer_name']."<br>".$pp_data[$i]['off_desg']."<br>PIN - ".$pp_data[$i]['personcd']; ?></th>
                    <td align="left"><strong><?php echo $pp_data[$i]['office']." (".$pp_data[$i]['officecd']."), </strong>".$pp_data[$i]['address']." P.O. - ".$pp_data[$i]['postoffice'].", Subdiv - ".$pp_data[$i]['subdivision'].", P.S. - ".$pp_data[$i]['policestation'].", Dist - ".$pp_data[$i]['district'].", Pincode - ".$pp_data[$i]['pin']; ?></td>
                    <th align="center"><?php echo $pp_data[$i]['poststatus']; ?></th>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 10;">
            The Officer should report for Training as per following Schedule:
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 10;">
            <table width="98%" border="1" align="center" cellpadding="5" cellspacing="0" style="font-family: sans-serif; font-size: 11">
                <tr>
                    <th colspan="3">
                        Training Schedule
                    </th>
                </tr>
                <tr>
                    <th width="25%">Training</th>
                    <th width="50%">Venue & Address</th>
                    <th width="25%">Date and Time</th>
                </tr>
                <tr>
                    <th align="center"><?php echo $pp_data[$i]['training_desc']; ?></th>
                    <th align="left"><?php echo $pp_data[$i]['venuename'].", ".$pp_data[$i]['venueaddress']; ?></th>
                    <th align="center"><?php echo date_format(date_create_from_format("Y-m-d H:i:s",$pp_data[$i]['training_dt']),"d/m/Y").", ".$pp_data[$i]['training_time']; ?></th>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 10; text-align: justify">This is a compulsory duty on your part to attend the said programme,as per the provisions of the Representation of the People's Act, 1951, remaining absent in attending training and performing subsequent duties will invite strict penal action. </td>
    </tr>
    <tr>
        <td style="padding-top: 10; text-align: justify">
            Place: Hooghly<br>
            Date: <?php echo date_format(date_create_from_format("Y-m-d",$apt1_date),"d/m/Y"); ?>
        </td>
        <th style="padding-top: 10; text-align: justify">&nbsp;</th>
        <td style="padding-top: 10; text-align: justify">
            <img src="../pp_training/dm-sign1.jpg" alt=""/><br>
            District Panchayat Election Officer<br>
            District Hooghly
        </td>
    </tr>
    <tr>
        <th colspan="3">
            <hr>
        </th>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 5; text-align: justify">
            NB <br>
            <ol>
                <li>
                Please check your electoral data and bank details given below. For any inconsistency please inform the authority. <strong><br>
                EPIC N0. - <?php echo $pp_data[$i]['epic']; ?>, Assembly - <?php echo $pp_data[$i]['acno']; ?>, Part No. - <?php echo $pp_data[$i]['partno']; ?>, Sl. No.- <?php echo $pp_data[$i]['slno']; ?> <br>Bank - <?php echo $pp_data[$i]['bank']; ?>, Branch - <?php echo $pp_data[$i]['branch']; ?> <br>A/c No.- <?php echo $pp_data[$i]['bank_accno']; ?>, IFS Code- <?php echo $pp_data[$i]['ifsc']; ?></strong></li>
            </ol>
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
}/*
for($i = 0; $i < count($pp_data); $i++){
    unlink('../pp_training/emp_'.$pp_data[$i]['personcd'].'.png');
}*/
?>
