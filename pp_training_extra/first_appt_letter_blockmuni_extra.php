<title>
    Block/Municipality wise - 1st Appointment Letter
</title>
<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");
include "../phpqrcode/qrlib.php"; 
$block_muni_code=$_GET['block_muni_code'];

$env_query=$mysqli->prepare("SELECT environment, distnm_sml, apt1_orderno, apt1_date FROM environment") or die($mysqli->error);
$env_query->execute() or die($env_query->error);
$env_query->bind_result($env,$dist,$apt1_order_no,$apt1_date) or die($env_query->error);
$env_query->fetch() or die($env_query->error);
$env_query->close();

$first_app_query=$mysqli->prepare("SELECT personcd, officer_name, off_desg, poststatus, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni_name, postoffice, subdivision, policestation, district, pin, training_desc FROM first_rand_table_extra WHERE block_muni = ? ORDER BY officecd, personcd") or die($mysqli->error);
$first_app_query->bind_param("s",$block_muni_code) or die($first_app_query->error);
$first_app_query->execute() or die($first_app_query->error);
$first_app_query->bind_result($personcd, $officer_name, $off_desg, $poststatus, $mob_no, $epic, $partno, $slno, $acno, $bank, $branch, $ifsc, $bank_accno, $officecd, $office, $address, $block_muni_name, $postoffice, $subdivision, $policestation, $district, $pin, $training_desc) or die($first_app_query->error);

$pp_data=array();
while($first_app_query->fetch()){
    $pp_data[]=array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "poststatus"=>$poststatus, "mob_no"=>$mob_no, "epic"=>$epic, "partno"=>$partno, "slno"=>$slno, "acno"=>$acno, "bank"=>$bank, "branch"=>$branch, "ifsc"=>$ifsc, "bank_accno"=>$bank_accno, "officecd"=>$officecd, "office"=>$office, "address"=>$address, "block_muni_name"=>$block_muni_name, "postoffice"=>$postoffice, "subdivision"=>$subdivision, "policestation"=>$policestation, "district"=>$district, "pin"=>$pin, "training_desc"=>$training_desc);
}
$first_app_query->close();
$filepath='../pp_training/qr_img/';
$filename=$filepath.'emp.png';
for($i = 0;$i < count($pp_data); $i++){
    QRcode::png($pp_data[$i]['personcd'], $filename, 'H', 2, 2);
    $newfile=$filepath.'emp_'.$pp_data[$i]['personcd'].'.png';
    rename($filename,$newfile);
?>
<table width="100%" style="font-family: sans-serif; font-size: 11">
    <tr>
        <th width="20%">
            <img src="../img/ECI-Logo-LMI.jpg" alt="" height="50" width="50"/><br>
            Election Urgent
        </th>
        <th width="60%">
            <img src="../pp_training/indian-symbol4.jpg" alt=""/><br>
            ORDER OF APPOINTMENT FOR TRAINING<br>
            <?php echo $env.", ".$dist."<br>No ($apt1_order_no), Date: ".date_format(date_create_from_format("Y-m-d",$apt1_date),"d/m/Y"); ?>
        </th>
        <th width="20%">
            <img src="<?php echo $newfile; ?>" alt=""/><br>
            QR code
        </th>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; In exercise of the power conferred upon vide Section 26 of the R. P. Act, 1951, I do hereby appoint the officer specified below as Polling Officer for undergoing training in connection with the conduct of General Assembly Election of West Bengal, 2016.
        </td>
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
        <th colspan="3" style="padding-top: 10;">
            The Officer should report for Training as per Training Schedule attached with this Order of Appointment.
        </th>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 10; text-align: justify">
            This is a compulsory duty on your part to attend the said programme,as per the provisions of the Representation of the People Act, 1951. You are directed to bring a copy of your Elector's Photo Identity Card (EPIC) or any other proof of Identity.
        </td>
    </tr>
    <tr>
        <td style="padding-top: 10; text-align: justify">
            Place: Hooghly<br>
            Date: <?php echo date_format(date_create_from_format("Y-m-d",$apt1_date),"d/m/Y"); ?>
        </td>
        <th style="padding-top: 10; text-align: justify">&nbsp;</th>
        <td style="padding-top: 10; text-align: justify">
            <img src="../pp_training/dm-sign1.jpg" alt=""/><br>
            District Election Officer<br>
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
                <li>Sign the pre-filled Form 12 (enclosed), after checking thoroughly for every information and if corrections are needed in current Part No / Serial No. Address need not to be filled. </li>
                <li>
                    Please submit duly signed Form 12 along with duplicate copy of appointment letter at training venue on the first day of training.
                </li>
                <li>
                    Please write particulars on the supplied blank Identity Card and also affix your colour passport size photograph on it. Please bring it to training venue for attestation.
                </li>
                <li>
                Please check your electoral data and bank details given below. For any inconsistency please inform the authority. <strong><br> EPIC N0. - <?php echo $pp_data[$i]['epic']; ?>, Assembly - <?php echo $pp_data[$i]['acno']; ?>, Part No. - <?php echo $pp_data[$i]['partno']; ?>, Sl. No.- <?php echo $pp_data[$i]['slno']; ?> <br>Bank - <?php echo $pp_data[$i]['bank']; ?>, Branch - <?php echo $pp_data[$i]['branch']; ?> <br>A/c No.- <?php echo $pp_data[$i]['bank_accno']; ?>, IFS Code- <?php echo $pp_data[$i]['ifsc']; ?></strong></li>
                <li>Please verify your Electoral details given above with the latest elctoral roll. You may know your AC no. / Part no. / Sl no. by sending your EPIC no. through SMS at CEO helpline number in the following text format <em>WBELEC&lt;space&gt;Your EPIC Card no to 9002481874</em> or <em>WB&lt;space&gt;EC&lt;space&gt;Your EPIC Card no to 51969.</em></li>
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
//rename($newfile,$filename);
}
?>