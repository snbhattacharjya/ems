<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$assembly_code=$_GET['AssemblyCode'];

$deployed_party_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, office.officecd, office.office, office.address1, poststat.poststatus, personnel.mob_no, personnel.forassembly, assembly.assemblyname, personnel.groupid, second_training_venue.venuename, second_training_date_time.training_dt, second_training_date_time.training_time, second_training_subvenue.subvenue 
FROM ((((((personnel INNER JOIN office ON personnel.officecd = office.officecd) INNER JOIN poststat ON personnel.poststat = poststat.post_stat AND personnel.poststat != 'MO') INNER JOIN assembly ON assembly.assemblycd = personnel.forassembly) 
LEFT JOIN second_training_schedule ON personnel.training2_sch = second_training_schedule.schedule_code) LEFT JOIN second_training_subvenue ON second_training_schedule.tr_subvenue_cd = second_training_subvenue.subvenue_cd) LEFT JOIN second_training_venue ON second_training_subvenue.venue_cd = second_training_venue.venue_cd) LEFT JOIN second_training_date_time ON second_training_schedule.datetimecd = second_training_date_time.datetime_cd WHERE personnel.booked IN ('R') AND personnel.forassembly != '' AND personnel.groupid != 0 AND personnel.forassembly = ? ORDER BY personnel.groupid, poststat.poststat_order") or die($mysqli_countppds->error);

$deployed_party_query->bind_param("s", $assembly_code) or die($deployed_party_query->error);
$deployed_party_query->execute() or die($deployed_party_query->error);
$deployed_party_query->bind_result($personcd, $officer_name, $off_desg, $officecd, $office_name, $address1, $poststatus, $mobile, $forassembly, $assemblyname, $groupid, $venuename, $training_dt, $training_time, $subvenue) or die($deployed_party_query->error);

$return=array();

while ($deployed_party_query->fetch()) {
    $return[]=array("PersonID"=>$personcd,"OfficerName"=>$officer_name,"Designation"=>$off_desg,"OfficeID"=>$officecd,"OfficeName"=>$office_name,"Address1"=>$address1,"PostStatus"=>$poststatus,"Mobile"=>$mobile, "AssemblyCode"=>$forassembly, "AssemblyName"=>$assemblyname, "GroupID"=>$groupid, "venuename"=>$venuename, "training_dt"=>$training_dt, "training_time"=>$training_time, "subvenue"=>$subvenue);
}
$deployed_party_query->close();

?>
<title>Polling Reserve Attendance List</title>
<h3>
    Polling Reserve Attendance List
</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Constituency</th>
            <th>Reserve No</th>
            <th>Post Status</th>
            <th>Person ID</th>
            <th>Officer Name</th>
            <th>Designation / Office</th>
            <th>Mobile</th>
            <th>Training Date</th>
            <th>Training Venue</th>
            <th>Training Time</th>
            <th>Signature</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for ($i = 0; $i < count($return); $i++) {
            ?>
        <tr>
            <td><?php echo $return[$i]['AssemblyCode']." - ".$return[$i]['AssemblyName']; ?></td>
            <td><?php echo $return[$i]['GroupID']; ?></td>
            <td><?php echo $return[$i]['PostStatus']; ?></td>
            <td><?php echo $return[$i]['PersonID']; ?></td>
            <td><?php echo $return[$i]['OfficerName']; ?></td>
            <td><?php echo $return[$i]['Designation'].", ".$return[$i]['OfficeName']." - ".$return[$i]['Address1']." (".$return[$i]['OfficeID'].")"; ?></td>
            <td><?php echo $return[$i]['Mobile']; ?></td>
            <td><?php echo $return[$i]['venuename'].', '.$return[$i]['subvenue'] ; ?></td>
            <td><?php echo $return[$i]['training_dt']; ?></td>
            <td><?php echo $return[$i]['training_time']; ?></td>
            <td><?php echo "&nbsp;"; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>

    </tfoot>
</table>
