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
        <th width="20%">
            <img src="../img/ECI-Logo-LMI.jpg" alt="" height="50" width="50"/><br>
            Election Urgent
        </th>
        <th width="60%">
            <img src="../pp_training/indian-symbol4.jpg" alt=""/><br>
            ORDER OF APPOINTMENT FOR TRAINING<br>
            <?php //echo $env.", ".$dist; ?>
            GENERAL ELECTION TO THE HOUSE OF PEOPLE, 2019
        </th>
        <th width="20%">&nbsp;</th>
    </tr>
    <tr>
        <th width="20%">Memo No: 65/PP CELL Dist(711) </th>
      <th width="60%">&nbsp;

        </th>
        <th width="20%">Dated: 15/03/2019</th>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; In pursuance of section 26 of the Representation pf the People Act 1951 I do hereby appoint the officer specified below as <?php echo $pp_data[$i]['poststatus']; ?> for the polling station to be informed later in connection with the conduct of General Election to the House of People, 2019
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
                <!-- Loop for Trainings -->
                <?php
                    $training_query=$mysqli->prepare("SELECT personnel_training.training_type, training_venue.venuename, training_venue.venueaddress1, training_schedule.training_dt, training_schedule.training_time FROM ((personnel_rectified INNER JOIN personnel_training ON personnel_rectified.personcd = personnel_training.personcd) INNER JOIN training_schedule ON personnel_training.schedule_code = training_schedule.schedule_code) INNER JOIN training_venue ON training_schedule.training_venue = training_venue.venue_cd WHERE personnel_rectified.personcd = ?") or die($mysqli->error);
                    $training_query->bind_param("s",$pp_data[$i]['personcd']) or die($training_query->error);
                    $training_query->execute() or die($training_query->error);
                    $training_query->bind_result($training_type, $venuename, $venue_address, $training_date, $training_time) or die($training_query->error);

                    $training_data=array();
                    while($training_query->fetch()){
                        $training_data[]=array("training_type"=>$training_type, "venue_name" => $venuename, "venue_address" => $venue_address, "training_date"=> $training_date, "training_time" => $training_time);
                    }
                    $training_query->close();

                    for($j = 0;$j < count($training_data); $j++){ 
                ?>
                <tr>
                    <th align="center"><?php echo $training_data[$j]['training_type'] == '01' ? 'First Training (General)' : 'Second Training (General)'; ?></th>
                    <th align="left"><?php echo $training_data[$j]['venue_name'].", ".$training_data[$j]['venue_address']; ?></th>
                    <th align="center"><?php echo date_format(date_create_from_format("Y-m-d H:i:s",$training_data[$j]['training_date']),"d/m/Y").", ".$training_data[$j]['training_time']; ?></th>
                </tr>
                <?php
                    }
                ?>
                <!-- End Loop for Trainings -->
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 10; text-align: justify">Now the officer shall be under control, superintendence and discipline of the Election Commission of India till election is over as per provision of the Section 28A of RP Act 1951. <br>The officer should comply the under noted instruction.</td>
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
            Date: 15/03/2019
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
                    Please fillup Form 12 & 12A (for postal ballot/EDC) annexed herewith and submit at the Training Venue on the 1st day of Training along with the duplicate copy of your appintment letter and a copy of EPIC.
                </li>
                <li>
                    Please indicate your PIN Number as given in your appointment letter on the body of Form 12/12A to help us locate you for delivery of postal ballot. Also indicate your EPIC Number on the body of Form 12/12A for verification of your Electoral roll entry.
                </li>
                <li>
                    Please fill up the blank identity card sent herewith and paste your recent colour photograph and bring it at training venue for attestation.
                </li>
                <li>
                    Please check your mobile number, electoral data and bank account details given below. If any correction is needed, correct with red ink in the remarks column of attendance sheet, provided at the training venue. <strong><br>
                    <ol style="list-style-type: lower-alpha;">
                        <li>Mobile Number - <?php echo $pp_data[$i]['mob_no']; ?></li>
                        <li>EPIC N0. - <?php echo $pp_data[$i]['epic']; ?>, Assembly - <?php echo $pp_data[$i]['acno']; ?>, Part No. - <?php echo $pp_data[$i]['partno']; ?>, Sl. No.- <?php echo $pp_data[$i]['slno']; ?></li>
                        <li>A/c No.- <?php echo $pp_data[$i]['bank_accno']; ?>, IFSC - <?php echo $pp_data[$i]['ifsc']; ?></li>  
                    </ol>
                    </strong>
                </li>
                <li>
                    Please check your Bank account details given above carefully as remuneration will be transferred directly to this bank account.
                </li>
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
