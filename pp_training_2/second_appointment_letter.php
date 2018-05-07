<title>
    2nd Appointment Letter - Party
</title>
<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");
include "../phpqrcode/qrlib.php";
$opt=$_GET['opt'];

$env_query=$mysqli->prepare("SELECT environment, distnm_sml, apt1_orderno, apt1_date FROM environment") or die($mysqli->error);
$env_query->execute() or die($env_query->error);
$env_query->bind_result($env,$dist,$apt1_order_no,$apt1_date) or die($env_query->error);
$env_query->fetch() or die($env_query->error);
$env_query->close();

if($opt == 'SUBDIVISION'){
  $subdiv_code = $_GET['subdiv_code'];
  $second_app_query=$mysqli->prepare("SELECT personcd, officer_name, off_desg, poststatus, poststat, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni_name, postoffice, subdivision, policestation, district, pin, training_desc, venuename, venueaddress, training_dt, training_time, forassembly, forassembly_name, booked, groupid, dc_venue, dc_addr, rc_venue, rc_addr, second_appt_memo, DATE_FORMAT(second_appt_date,'%d-%m-%Y') FROM second_rand_table WHERE subdivisioncd = ? ORDER BY officecd, personcd") or die($mysqli->error);
  $second_app_query->bind_param("s",$subdiv_code) or die($second_app_query->error);
}
if($opt == 'BLOCKMUNI'){
  $block_muni_code = $_GET['block_muni_code'];
  $second_app_query=$mysqli->prepare("SELECT personcd, officer_name, off_desg, poststatus, poststat, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni_name, postoffice, subdivision, policestation, district, pin, training_desc, venuename, venueaddress, training_dt, training_time, forassembly, forassembly_name, booked, groupid, dc_venue, dc_addr, rc_venue, rc_addr, second_appt_memo, DATE_FORMAT(second_appt_date,'%d-%m-%Y') FROM second_rand_table WHERE block_muni = ? ORDER BY officecd, personcd") or die($mysqli->error);
  $second_app_query->bind_param("s",$block_muni_code) or die($second_app_query->error);
}
if($opt == 'OFFICE'){
  $office_code = $_GET['office_code'];
  $second_app_query=$mysqli->prepare("SELECT personcd, officer_name, off_desg, poststatus, poststat, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni_name, postoffice, subdivision, policestation, district, pin, training_desc, venuename, venueaddress, training_dt, training_time, forassembly, forassembly_name, booked, groupid, dc_venue, dc_addr, rc_venue, rc_addr, second_appt_memo, DATE_FORMAT(second_appt_date,'%d-%m-%Y') FROM second_rand_table WHERE officecd = ? ORDER BY officecd, personcd") or die($mysqli->error);
  $second_app_query->bind_param("s",$office_code) or die($second_app_query->error);
}
if($opt == 'PERSON'){
  $person_code = $_GET['person_code'];
  $second_app_query=$mysqli->prepare("SELECT personcd, officer_name, off_desg, poststatus, poststat, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni_name, postoffice, subdivision, policestation, district, pin, training_desc, venuename, venueaddress, training_dt, training_time, forassembly, forassembly_name, booked, groupid, dc_venue, dc_addr, rc_venue, rc_addr, second_appt_memo, DATE_FORMAT(second_appt_date,'%d-%m-%Y') FROM second_rand_table WHERE personcd = ? ORDER BY officecd, personcd") or die($mysqli->error);
  $second_app_query->bind_param("s",$person_code) or die($second_app_query->error);
}
if($opt == 'ASSEMBLY_PARTY'){
  $assembly_code = $_GET['AssemblyCode'];
  $second_app_query=$mysqli->prepare("SELECT personcd, officer_name, off_desg, poststatus, poststat, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni_name, postoffice, subdivision, policestation, district, pin, training_desc, venuename, venueaddress, training_dt, training_time, forassembly, forassembly_name, booked, groupid, dc_venue, dc_addr, rc_venue, rc_addr, second_appt_memo, DATE_FORMAT(second_appt_date,'%d-%m-%Y') FROM second_rand_table WHERE forassembly = ? AND booked = 'P' AND poststat = 'PR' ORDER BY groupid") or die($mysqli->error);
  $second_app_query->bind_param("s",$assembly_code) or die($second_app_query->error);
}
if($opt == 'ASSEMBLY_RESERVE'){
  $assembly_code = $_GET['AssemblyCode'];
  $second_app_query=$mysqli->prepare("SELECT personcd, officer_name, off_desg, poststatus, poststat, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni_name, postoffice, subdivision, policestation, district, pin, training_desc, venuename, venueaddress, training_dt, training_time, forassembly, forassembly_name, booked, groupid, dc_venue, dc_addr, rc_venue, rc_addr, second_appt_memo, DATE_FORMAT(second_appt_date,'%d-%m-%Y') FROM second_rand_table WHERE forassembly = ? AND booked = 'R' ORDER BY groupid") or die($mysqli->error);
  $second_app_query->bind_param("s",$assembly_code) or die($second_app_query->error);
}

$second_app_query->execute() or die($second_app_query->error);
$second_app_query->bind_result($personcd, $officer_name, $off_desg, $poststatus, $poststat, $mob_no, $epic, $partno, $slno, $acno, $bank, $branch, $ifsc, $bank_accno, $officecd, $office, $address, $block_muni_name, $postoffice, $subdivision, $policestation, $district, $pin, $training_desc, $venuename, $venueaddress, $training_dt, $training_time, $forassembly, $forassembly_name, $booked, $groupid, $dc_venue, $dc_addr, $rc_venue, $rc_addr, $memo, $date) or die($second_app_query->error);

$pp_data=array();
while($second_app_query->fetch()){
    if($booked == 'P'){
      $pp_data[]=array("personcd"=>$personcd, "block_muni_name"=>$block_muni_name, "forassembly"=>$forassembly, "forassembly_name"=>$forassembly_name, "booked"=>$booked, "groupid"=>$groupid, "dc_venue"=>$dc_venue, "dc_addr"=>$dc_addr, "rc_venue"=>$rc_venue, "rc_addr"=>$rc_addr, "memo"=>$memo, "date"=>$date);
    }
    else {
      $pp_data[]= array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "poststatus"=>$poststatus, "poststat"=>$poststat, "mob_no"=>$mob_no, "epic"=>$epic, "partno"=>$partno, "slno"=>$slno, "acno"=>$acno, "bank"=>$bank, "branch"=>$branch, "ifsc"=>$ifsc, "bank_accno"=>$bank_accno, "officecd"=>$officecd, "office"=>$office, "address"=>$address, "block_muni_name"=>$block_muni_name, "postoffice"=>$postoffice, "subdivision"=>$subdivision, "policestation"=>$policestation, "district"=>$district, "pin"=>$pin, "training_desc"=>$training_desc, "venuename"=>$venuename, "venueaddress"=>$venueaddress, "training_dt"=>$training_dt, "training_time"=>$training_time, "forassembly"=>$forassembly, "forassembly_name"=>$forassembly_name, "booked"=>$booked, "groupid"=>$groupid, "dc_venue"=>$dc_venue, "dc_addr"=>$dc_addr, "rc_venue"=>$rc_venue, "rc_addr"=>$rc_addr, "memo"=>$memo, "date"=>$date);
    }
}
$second_app_query->close();
//$filepath='../pp_training/qr_img/';
//$filename=$filepath.'emp.png';
$old_group = 0;
for($i = 0;$i < count($pp_data); $i++){
    //QRcode::png($pp_data[$i]['personcd'], $filename, 'H', 2, 2);
    //$newfile=$filepath.'emp_'.$pp_data[$i]['personcd'].'.png';
    //rename($filename,$newfile);
    if($pp_data[$i]['booked'] == 'P'){
      $second_app_group_query=$mysqli->prepare("SELECT personcd, officer_name, off_desg, poststatus, poststat_order, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni_name, postoffice, subdivision, policestation, district, pin FROM second_rand_table  WHERE forassembly = ? AND groupid = ? AND booked = ? ORDER BY poststat_order") or die($mysqli->error);
      $second_app_group_query->bind_param("sis",$pp_data[$i]['forassembly'],$pp_data[$i]['groupid'],$pp_data[$i]['booked']) or die($second_app_group_query->error);
      $second_app_group_query->execute() or die($second_app_group_query->error);
      $second_app_group_query->bind_result($personcd, $officer_name, $off_desg, $poststatus, $poststat_order, $mob_no, $epic, $partno, $slno, $acno, $bank, $branch, $ifsc, $bank_accno, $officecd, $office, $address, $block_muni_name, $postoffice, $subdivision, $policestation, $district, $pin) or die($second_app_query->error);

      $grp_pp_data=array();
      while($second_app_group_query->fetch()){
        $grp_pp_data[] = array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "poststatus"=>$poststatus, "poststat_order"=>$poststat_order, "mob_no"=>$mob_no, "epic"=>$epic, "partno"=>$partno, "slno"=>$slno, "acno"=>$acno, "bank"=>$bank, "branch"=>$branch, "ifsc"=>$ifsc, "bank_accno"=>$bank_accno, "officecd"=>$officecd, "office"=>$office, "address"=>$address, "block_muni_name"=>$block_muni_name, "postoffice"=>$postoffice, "subdivision"=>$subdivision, "policestation"=>$policestation, "district"=>$district, "pin"=>$pin);
      }
      $second_app_group_query->close();
    }

//die(count($pp_data));
?>
<table width="100%" style="font-family: sans-serif; font-size: 11">
    <tr>
        <th width="20%">&nbsp;Election Urgent </th>
        <th width="60%">
            <img src="../pp_training_2/indian-symbol4.jpg" alt=""/><br>
            ORDER OF APPOINTMENT FOR PRESIDING AND POLLING OFFICERS<br>
            General Election to the Gram Panchayats, Panchayat Samitis and Zilla Parishad, 2018<br>

        </th>
        <th width="20%">&nbsp;</th>
    </tr>
    <tr>
        <th width="20%">Memo No: <?php echo $pp_data[$i]['memo']; ?> </th>
        <th width="60%">&nbsp;

        </th>
        <th width="20%">Dated: <?php echo $pp_data[$i]['date']; ?></th>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; In persuance of sub-section(5) of section 6 of the West Bengal State Election Commision Act, 1994 (West Bengal Act VIII of 1994) read with Section 28 of the West Bengal Panchayat Election Act, 2003. I hereby appoint the officers specified in column (2) and (3) of the table below as Presiding Officer and Polling Officers respectively for Gram Panchayat / Panchayat Samiti / Zilla Parishad Contituencies of <strong><?php echo $pp_data[$i]['forassembly_name']; ?> Block</strong>.
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I also authorise the Polling Officer specified in column (4) of the table against that entry to perform the functions of the Presiding Pfficer during the unavaoidable absence, if any, of the Presiding Officer.
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15;">
            <table width="98%" border="1" align="center" cellpadding="5" cellspacing="0" style="font-family: sans-serif; font-size: 9">
              <?php
                if($pp_data[$i]['booked'] == 'P'){
               ?>
                <tr>
                    <th width="10%">Party No.</th>
                    <th width="30%">Name of the Presiding Officer</th>
                    <th width="30%">Name of the Polling Officers</th>
                    <th width="30%">Polling Officer authorised to perform the functions of the Presiding Officer in the latter's absence</th>
                </tr>
                <?php
              }
              else{
              ?>
              <tr>
                  <th width="10%">Reserve Party No.</th>
                  <th width="30%">Name of the Presiding Officer (Reserve)</th>
                  <th width="30%">Name of the Polling Officers (Reserve)</th>
                  <th width="30%">Polling Officer authorised to perform the functions of the Presiding Officer in the latter's absence</th>
              </tr>
              <?php
              }
                 ?>
                <tr>
                    <th width="10%">(1)</th>
                    <th width="30%">(2)</th>
                    <th width="30%">(3)</th>
                    <th width="30%">(4)</th>
                </tr>
                <?php
                  if($pp_data[$i]['booked'] == 'P'){
                 ?>
                      <tr>
                        <th><?php echo $pp_data[$i]['groupid']; ?></th>
                        <td>
                          <?php echo $grp_pp_data[0]['officer_name']; ?>
                          <?php if($grp_pp_data[0]['personcd'] == $pp_data[$i]['personcd'] && $opt != 'ASSEMBLY_PARTY')
                            echo "<img src='../pp_training_2/black-check-mark.png' alt='' height = 20 width = 20/>";
                          ?><br>
                          <?php echo $grp_pp_data[0]['off_desg']; ?><br>
                          <?php echo $grp_pp_data[0]['poststatus']." PIN - ".$grp_pp_data[0]['personcd']; ?><br>
                          <?php echo $grp_pp_data[0]['office']." (".$grp_pp_data[0]['officecd']."), </strong>".$grp_pp_data[0]['address']." P.O. - ".$grp_pp_data[0]['postoffice'].", Subdiv - ".$grp_pp_data[0]['subdivision'].", P.S. - ".$grp_pp_data[0]['policestation'].", Dist - ".$grp_pp_data[0]['district'].", Pincode - ".$grp_pp_data[0]['pin']; ?><br>
                          Mob: <?php echo $grp_pp_data[0]['mob_no']; ?><br>
                        </td>
                        <td>
                          <?php
                              for($j = 1; $j < count($grp_pp_data); $j++){
                          ?>
                              <?php echo $grp_pp_data[$j]['officer_name']; ?>
                              <?php if($grp_pp_data[$j]['personcd'] == $pp_data[$i]['personcd'] && $opt != 'ASSEMBLY_PARTY')
                                echo "<img src='../pp_training_2/black-check-mark.png' alt='' height = 20 width = 20/>";
                              ?><br>
                              <?php echo $grp_pp_data[$j]['off_desg']; ?><br>
                              <?php echo $grp_pp_data[$j]['poststatus']." PIN - ".$grp_pp_data[$j]['personcd']; ?><br>
                              <?php echo $grp_pp_data[$j]['office']." (".$grp_pp_data[$j]['officecd']."), </strong>".$grp_pp_data[$j]['address']." P.O. - ".$grp_pp_data[$j]['postoffice'].", Subdiv - ".$grp_pp_data[$j]['subdivision'].", P.S. - ".$grp_pp_data[$j]['policestation'].", Dist - ".$grp_pp_data[$j]['district'].", Pincode - ".$grp_pp_data[$j]['pin']; ?><br>
                              Mob: <?php echo $grp_pp_data[$j]['mob_no']; ?><br><br>
                          <?php
                              }
                           ?>
                        </td>
                        <td>
                          <?php echo $grp_pp_data[1]['officer_name']; ?><br>
                          <?php echo $grp_pp_data[1]['off_desg']; ?><br>
                          <?php echo $grp_pp_data[1]['poststatus']." PIN - ".$grp_pp_data[1]['personcd']; ?><br>
                          <?php echo $grp_pp_data[1]['office']." (".$grp_pp_data[1]['officecd']."), </strong>".$grp_pp_data[1]['address']." P.O. - ".$grp_pp_data[1]['postoffice'].", Subdiv - ".$grp_pp_data[1]['subdivision'].", P.S. - ".$grp_pp_data[1]['policestation'].", Dist - ".$grp_pp_data[1]['district'].", Pincode - ".$grp_pp_data[1]['pin']; ?><br>
                          Mob: <?php echo $grp_pp_data[1]['mob_no']; ?><br>
                        </td>
                      </tr>
                <?php
              }
              else{
              ?>
                    <tr>
                        <th><?php echo $pp_data[$i]['groupid']; ?></th>
                        <td>
                          <?php
                            if($pp_data[$i]['poststat'] == 'PR'){
                          ?>
                              <?php echo $pp_data[$i]['officer_name']; ?><br>
                              <?php echo $pp_data[$i]['off_desg']; ?><br>
                              <?php echo $pp_data[$i]['poststatus']." PIN - ".$pp_data[$i]['personcd']; ?><br>
                              <?php echo $pp_data[$i]['office']." (".$pp_data[$i]['officecd']."), </strong>".$pp_data[$i]['address']." P.O. - ".$pp_data[$i]['postoffice'].", Subdiv - ".$pp_data[$i]['subdivision'].", P.S. - ".$pp_data[$i]['policestation'].", Dist - ".$pp_data[$i]['district'].", Pincode - ".$pp_data[$i]['pin']; ?><br>
                              Mob: <?php echo $pp_data[$i]['mob_no']; ?><br>
                          <?php
                            }
                            else{
                          ?>
                              &nbsp;
                          <?php
                            }
                          ?>
                        </td>
                        <td>
                          <?php
                            if($pp_data[$i]['poststat'] != 'PR'){
                          ?>
                              <?php echo $pp_data[$i]['officer_name']; ?><br>
                              <?php echo $pp_data[$i]['off_desg']; ?><br>
                              <?php echo $pp_data[$i]['poststatus']." PIN - ".$pp_data[$i]['personcd']; ?><br>
                              <?php echo $pp_data[$i]['office']." (".$pp_data[$i]['officecd']."), </strong>".$pp_data[$i]['address']." P.O. - ".$pp_data[$i]['postoffice'].", Subdiv - ".$pp_data[$i]['subdivision'].", P.S. - ".$pp_data[$i]['policestation'].", Dist - ".$pp_data[$i]['district'].", Pincode - ".$pp_data[$i]['pin']; ?><br>
                              Mob: <?php echo $pp_data[$i]['mob_no']; ?><br>
                          <?php
                            }
                            else{
                          ?>
                              &nbsp;
                          <?php
                            }
                          ?>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
              <?php
              }
                 ?>
            </table>
        </td>
    </tr>
    <tr>
          <td colspan="3" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; The Poll will be taken on 14/05/2018 during the hours 7 AM to 5 PM. The Presiding Officer should arrange to collect the Polling Materials from the Distribution Centre at <strong><?php echo $pp_data[$i]['dc_venue'].', '.$pp_data[$i]['dc_addr']; ?> Block</strong> on 13/05/2018 at 8 AM and after completion of Poll, polled ballot boxes, ballot paper accounts and other statutory forms duly filled in and sealed in prescribed manner should be returned to the reception centre at <strong><?php echo $pp_data[$i]['rc_venue'].', '.$pp_data[$i]['rc_addr']; ?> Block</strong>. Polling Station No. and particulars of its location will be intimated on the day of distribution of polling materials.
        </td>
    </tr>


    <tr>
        <td style="padding-top: 10; text-align: justify">
            Place: Hooghly<br>
            Date: <?php echo $pp_data[$i]['date']; ?>
        </td>
        <th style="padding-top: 10; text-align: justify">&nbsp;</th>
        <td style="padding-top: 10; text-align: center">
            <img src="../pp_training_2/ro/<?php echo $pp_data[$i]['forassembly'].'.jpg'?>" alt=""/><br>
            Panchayat Returning Officer<br>
            Gram Panchayat <strong><?php echo $pp_data[$i]['forassembly_name']; ?></strong> Panchayat Samiti<br>
            Contituencies and APRO, Hooghly Zilla Parishad Constituency
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
            You are requested to attend 2nd Training at <strong><?php echo $pp_data[$i]['venuename']; ?></strong> on <strong><?php echo $pp_data[$i]['training_dt'];?></strong> from <strong><?php echo $pp_data[$i]['training_time'];?></strong>
        </td>
    </tr>

    <tr>
        <td colspan="3" style="padding-top: 50; text-align: center">

            Block/Municipality: <br>
            <strong><?php echo $pp_data[$i]['block_muni_name']; ?></strong>

        </td>
    </tr>
</table>
<p style="page-break-after: always"></p>
<?php
//rename($newfile,$filename);
}
?>
