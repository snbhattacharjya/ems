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

$first_app_query=$mysqli->prepare("SELECT first_rand_table_adhoc.personcd, first_rand_table_adhoc.officer_name, first_rand_table_adhoc.off_desg, first_rand_table_adhoc.poststatus, first_rand_table_adhoc.mob_no, first_rand_table_adhoc.epic, first_rand_table_adhoc.partno, first_rand_table_adhoc.slno, first_rand_table_adhoc.acno, first_rand_table_adhoc.bank, first_rand_table_adhoc.branch, first_rand_table_adhoc.ifsc, first_rand_table_adhoc.bank_accno, first_rand_table_adhoc.officecd, first_rand_table_adhoc.office, first_rand_table_adhoc.address, first_rand_table_adhoc.block_muni_name, first_rand_table_adhoc.postoffice, first_rand_table_adhoc.subdivision, first_rand_table_adhoc.policestation, first_rand_table_adhoc.district, first_rand_table_adhoc.pin, pc.pccd, CONCAT(pc.pccd,' - ',pc.pcname), CONCAT(assembly.assemblycd, ' - ', assembly.assemblyname), assembly_party.counting_venue_name FROM (((first_rand_table_adhoc INNER JOIN personnel_adhoc ON first_rand_table_adhoc.personcd = personnel_adhoc.personcd) INNER JOIN assembly_party ON personnel_adhoc.forassembly = assembly_party.assemblycd) INNER JOIN assembly ON assembly_party.assemblycd = assembly.assemblycd) INNER JOIN pc ON assembly.pccd = pc.pccd WHERE first_rand_table_adhoc.block_muni = ? ORDER BY first_rand_table_adhoc.officecd, first_rand_table_adhoc.personcd") or die($mysqli->error);
$first_app_query->bind_param("s", $block_muni_code) or die($first_app_query->error);
$first_app_query->execute() or die($first_app_query->error);
$first_app_query->bind_result($personcd, $officer_name, $off_desg, $poststatus, $mob_no, $epic, $partno, $slno, $acno, $bank, $branch, $ifsc, $bank_accno, $officecd, $office, $address, $block_muni_name, $postoffice, $subdivision, $policestation, $district, $pin, $pccd, $pcname, $assemblyname, $counting_venue_name) or die($first_app_query->error);

$pp_data=array();
while ($first_app_query->fetch()) {
    $pp_data[]=array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "poststatus"=>$poststatus, "mob_no"=>$mob_no, "epic"=>$epic, "partno"=>$partno, "slno"=>$slno, "acno"=>$acno, "bank"=>$bank, "branch"=>$branch, "ifsc"=>$ifsc, "bank_accno"=>$bank_accno, "officecd"=>$officecd, "office"=>$office, "address"=>$address, "block_muni_name"=>$block_muni_name, "postoffice"=>$postoffice, "subdivision"=>$subdivision, "policestation"=>$policestation, "district"=>$district, "pin"=>$pin, "pccd" => $pccd, "pcname" => $pcname, "assemblyname" => $assemblyname, "counting_venue_name" => $counting_venue_name);
}
$first_app_query->close();
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
            LETTER OF APPOINTMENT FOR POSTAL BALLOT COUNTING PERSONNEL<br>
            <?php //echo $env.", ".$dist;?>
            GENERAL ELECTION TO THE HOUSE OF PEOPLE, 2019
        </th>
        <th width="20%">&nbsp;</th>
    </tr>
    <tr>
        <th width="20%">Memo No: 215/PP CELL(Dist)/Elec </th>
      <th width="60%">&nbsp;

        </th>
        <th width="20%">Dated: 20/05/2019</th>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; In connection with the GENERAL ELECTION TO THE HOUSE OF PEOPLE, 2019 for <strong><?php echo $pp_data[$i]['pcname']; ?> PC</strong> and in exercise of the power conferred upon me vide section 26 of the R. P. Act, 1951, I do hereby appoint the following officer for performing counting duty.
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15;">
            <table width="98%" border="1" align="center" cellpadding="5" cellspacing="0" style="font-family: sans-serif; font-size: 11">
                <tr>
                    <th width="25%">Counting Officer</th>
                    <th width="50%">Office Address</th>
                    <th width="25%">Counting Post Status</th>
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
            The Officer should report for Counting POSTAL BALLOT as per following schedule:
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 10;">
            <table width="98%" border="1" align="center" cellpadding="5" cellspacing="0" style="font-family: sans-serif; font-size: 11">
                <tr>
                    <th width="50%">Counting Venue & Address</th>
                    <th width="50%">Date and Time</th>
                </tr>
               
                <tr>
                        
                    <td align="left"><?php echo $pp_data[$i]['counting_venue_name']; ?></td>
                    <td align="center">23/05/2019 at 6:00 AM </td>
                       
                </tr>
               
                <!-- End Loop for Trainings -->
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 10; text-align: justify">Now the officer shall be under control, superintendence and discipline of the Election Commission of India till counting is over as per provision of the Section 28A of RP Act 1951. <br>The officer should comply the under noted instruction. and report to the Counting Venue as mentioned above.</strong></td>
    </tr>
    <tr>
        <td style="padding-top: 10; text-align: justify">
            Place: Hooghly<br>
            District: Hooghly
        </td>
        <th style="padding-top: 10; text-align: justify">&nbsp;</th>
        <td style="padding-top: 10; text-align: justify">
            <img src="ro_signs/<?php echo $pp_data[$i]['pccd']; ?>.JPG" alt=""/><br>
           Returning Officer<br>
           <?php echo $pp_data[$i]['pcname']; ?><br>
            Date: 20/05/2019
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
                    Please bring your photo identity card issued by DEO Hooghly at the counting venue positively.
                </li>
                
                <li>
                    MOBILE PHONES ARE NOT ALLOWED IN THE COUNTING VENUE. So you are requested not to bring any mobile phone or any electronic devices on the day of counting.
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
            DDO/Head of Office is directed to deliver immediately intimation letter to the Counting Supervisor/Assistant/Micro Observer after getting the signature of the incumbent on service return. He/She is further directed to ensure that all personnel under his institution/office shall attend the training as per direction and counting duty without fail and in time.
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
