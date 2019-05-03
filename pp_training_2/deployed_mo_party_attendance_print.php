<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$assembly_code=$_GET['AssemblyCode'];

$deployed_party_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, office.officecd, office.office, office.address1, poststat.poststatus, personnel.mob_no, personnel.forassembly, assembly.assemblyname, personnel.groupid, CONCAT(training_venue_adhoc.venuename,', ',training_venue_adhoc.venue_base_name), DATE_FORMAT(training_schedule_adhoc.training_dt,'%d-%m-%Y'), training_schedule_adhoc.training_time FROM (((((personnel INNER JOIN office ON personnel.officecd = office.officecd) INNER JOIN poststat ON personnel.poststat = poststat.post_stat AND personnel.poststat = 'MO') INNER JOIN assembly ON assembly.assemblycd = personnel.forassembly) INNER JOIN personnel_training_adhoc ON personnel.personcd = personnel_training_adhoc.personcd AND personnel_training_adhoc.training_type = '02') INNER JOIN training_schedule_adhoc ON personnel_training_adhoc.schedule_code = training_schedule_adhoc.schedule_code) INNER JOIN training_venue_adhoc ON training_schedule_adhoc.training_venue = training_venue_adhoc.venue_cd WHERE personnel.booked IN ('P') AND personnel.groupid != 0 AND personnel.forassembly = ? ORDER BY personnel.groupid, poststat.poststat_order") or die($mysqli->error);

$deployed_party_query->bind_param("s", $assembly_code) or die($deployed_party_query->error);
$deployed_party_query->execute() or die($deployed_party_query->error);
$deployed_party_query->bind_result($personcd, $officer_name, $off_desg, $officecd, $office_name, $address1, $poststatus, $mobile, $forassembly, $assemblyname, $groupid, $venuename, $training_dt, $training_time) or die($deployed_party_query->error);

$return=array();

while ($deployed_party_query->fetch()) {
    $return[]=array("PersonID"=>$personcd,"OfficerName"=>$officer_name,"Designation"=>$off_desg,"OfficeID"=>$officecd,"OfficeName"=>$office_name,"Address1"=>$address1, "PostStatus"=>$poststatus,"Mobile"=>$mobile, "AssemblyCode"=>$forassembly, "AssemblyName"=>$assemblyname, "GroupID"=>$groupid, "venuename"=>$venuename, "training_dt"=>$training_dt, "training_time"=>$training_time);
}
$deployed_party_query->close();
?>
<title>Micro Observer Party Attendance List</title>
<h3>
    Micro Observer Party Attendance List
</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Constituency</th>
            <th>Party</th>
            <th>Post Status</th>
            <th>Person ID</th>
            <th>Officer Name</th>
            <th>Designation / Office</th>
            <th>Mobile</th>
            <th>Training Venue</th>
            <th>Training Date</th>
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
            <td><?php echo $return[$i]['venuename'] ; ?></td>
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
