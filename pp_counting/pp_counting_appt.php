<title>
    Deployment Subdivision wise Counting Appointment
</title>
<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");

$opt=$_GET['opt'];
$subdiv=$_GET['subdiv'];

if($opt == 'COUNT_PP'){
    $env_query=$mysqli_countppds->prepare("SELECT environment, distnm_sml, apt1_orderno, apt1_date FROM environment") or die($mysqli->error);
    $env_query->execute() or die($env_query->error);
    $env_query->bind_result($env,$dist,$apt1_order_no,$apt1_date) or die($env_query->error);
    $env_query->fetch() or die($env_query->error);
    $env_query->close();
}
else if($opt == 'COUNT_GRD'){
    $env_query=$mysqli_countgrdppds->prepare("SELECT environment, distnm_sml, apt1_orderno, apt1_date FROM environment") or die($mysqli->error);
    $env_query->execute() or die($env_query->error);
    $env_query->bind_result($env,$dist,$apt1_order_no,$apt1_date) or die($env_query->error);
    $env_query->fetch() or die($env_query->error);
    $env_query->close();
}
if($opt == 'COUNT_PP'){
    $counting_appt_query=$mysqli_countppds->prepare("SELECT personnela.personcd, personnela.officer_name, personnela.off_desg, poststat.poststatus, personnela.mob_no, office.officecd, office.office, CONCAT(office.address1,', ',office.address2), block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin FROM (((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnela ON office.officecd = personnela.officecd) INNER JOIN poststat ON poststat.post_stat = personnela.poststat WHERE personnela.forsubdivision = ? AND personnela.booked IN ('P','R') ORDER BY office.officecd, personnela.personcd") or die($mysqli->error);
    $counting_appt_query->bind_param("s",$subdiv) or die($counting_appt_query->error);
}
else if($opt == 'COUNT_GRD'){
    $counting_appt_query=$mysqli_countgrdppds->prepare("SELECT personnela.personcd, personnela.officer_name, personnela.off_desg, poststat.poststatus, personnela.mob_no, office.officecd, office.office, CONCAT(office.address1,', ',office.address2), block_muni.blockmuni, office.postoffice, subdivision.subdivision, policestation.policestation, district.district, office.pin FROM (((((office INNER JOIN district ON office.districtcd = district.districtcd) INNER JOIN subdivision ON office.subdivisioncd = subdivision.subdivisioncd) INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnela ON office.officecd = personnela.officecd) INNER JOIN poststat ON poststat.post_stat = personnela.poststat WHERE personnela.forsubdivision = ? AND personnela.booked IN ('P','R') ORDER BY office.officecd, personnela.personcd") or die($mysqli->error);
    $counting_appt_query->bind_param("s",$subdiv) or die($counting_appt_query->error);
}

$counting_appt_query->execute() or die($counting_appt_query->error);
$counting_appt_query->bind_result($personcd, $officer_name, $off_desg, $poststatus, $mob_no, $officecd, $office, $address, $block_muni_name, $postoffice, $subdivision, $policestation, $district, $pin) or die($counting_appt_query->error);

$pp_data=array();
while($counting_appt_query->fetch()){
    $pp_data[]=array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "poststatus"=>$poststatus, "mob_no"=>$mob_no, "officecd"=>$officecd, "office"=>$office, "address"=>$address, "block_muni_name"=>$block_muni_name, "postoffice"=>$postoffice, "subdivision"=>$subdivision, "policestation"=>$policestation, "district"=>$district, "pin"=>$pin);
}
$counting_appt_query->close();
for($i = 0;$i < count($pp_data); $i++){
?>
<table width="100%" style="font-family: sans-serif; font-size: 12">
    <tr>
        <th colspan="2">
            APPOINTMENT OF COUNTING MICRO OBSERVER/COUNTING SUPERVISOR/COUNTING ASSISTANTS
        </th>
    </tr>
    <tr>
        <th width="50%" align="right" style="padding-top: 15;">
            ORDER
        </th>
        <th width="50%" align="right" style="padding-top: 15;">
            ELECTION URGENT
        </th>
    </tr>
    <tr>
        <td width="50%" style="padding-top: 15;">
            No. <?php echo $apt1_order_no; ?>
        </td>
        <td width="50%" align="right" style="padding-top: 15;">
            Date: <?php echo date_format(date_create($apt1_date),"d/m/Y"); ?>
        </td>
    </tr>
    <tr>
        <th colspan="2" style="padding-top: 15;">
            Election to the West Bengal Legislative Assembly, 2016.   
        </th>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 20; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I, Smt. Mukta Arya, I.A.S. District Election Officer appoint the person whose name is specified below to act as <strong><?php echo $pp_data[$i]['poststatus']; ?></strong> for the purpose of assisting in the counting of votes at the said election.
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15">
            <table cellpadding="5" cellspacing="0" border="1" width="100%" style="font-family: sans-serif; font-size: 12">
                <tr>
                    <th>
                        APPOINTMENT OF COUNTING OFFICIAL
                    </th>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellpadding="5" cellspacing="0" style="font-family: sans-serif; font-size: 12">
                            <tr>
                                <td>NAME: </td>
                                <td><?php echo $pp_data[$i]['officer_name']; ?></td>
                            </tr>
                            <tr>
                                <td>DESIGNATION: </td>
                                <td><?php echo $pp_data[$i]['off_desg']; ?></td>
                            </tr>
                            <tr>
                                <td>PIN: </td>
                                <td><?php echo $pp_data[$i]['personcd']; ?></td>
                            </tr>
                            <tr>
                                <td>POST STATUS: </td>
                                <td><?php echo $pp_data[$i]['poststatus']; ?></td>
                            </tr>
                            <tr>
                                <td>NAME OF OFFICE: </td>
                                <td><?php echo $pp_data[$i]['office']." (".$pp_data[$i]['officecd']."), <br>".$pp_data[$i]['address']." <br>P.O. - ".$pp_data[$i]['postoffice'].", Subdiv - ".$pp_data[$i]['subdivision'].", <br>P.S. - ".$pp_data[$i]['policestation'].", <br>Dist - ".$pp_data[$i]['district'].", Pincode - ".$pp_data[$i]['pin']; ?></td>
                            </tr>
                            <tr>
                                <td>MOBILE NO: </td>
                                <td><?php echo $pp_data[$i]['mob_no']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The Counting Official should report for training as per the attached schedule, along with his photo identity proof and two copies of latest passport size photographs.<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is a compulsory duty on your part to attend the said programme, as per the provisions of  the Representation of the People Act, 1951.

        </td>
    </tr>
    <tr>
        <td width="50%" style="padding-top: 40;">
            Place: Hooghly<br>
            Date: <?php echo date_format(date_create($apt1_date),"d/m/Y"); ?>
        </td>
        <td style="padding-top: 40; text-align: right">
            <img src="../pp_training/dm-sign1.jpg" alt="" style="padding-right: 30px"/><br>
            District Election Officer &<br>
            District Magistrate Hooghly
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 20; text-align: justify">
            <hr>
            1.  The personnel named above is requested to verify his / her mobile number given in the Appointment Letter.If any discrepancy is noticed, then the same to be brought to the notice of the District Counting Personnel Cell, Hooghly immediately. Contact no. - 033 2680 0390 / 9836822270 / 9433643837, Email - ppcell.hooghly@gmail.com.<br><br>
            2.  Please, refer to PIN while making any communication.<br><br>
            3.  On the day before counting, reporting venue as well as reporting Assembly Constituency will be informed through SMS. On the day of counting, specific table no. will be informed. Reporting on the counting venue must be within 7.00 a.m. on 19.05.2016.
        </td>
    </tr>
</table>
<p style="page-break-after: always"></p>
<?php
}
?>