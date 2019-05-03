<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$assembly_code=$_GET['AssemblyCode'];

$deployed_party_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, poststat.poststatus, personnel.mob_no, personnel.forassembly, assembly.assemblyname, personnel.groupid 
FROM ((personnel INNER JOIN office ON personnel.officecd = office.officecd) INNER JOIN poststat ON personnel.poststat = poststat.post_stat AND personnel.poststat != 'MO') INNER JOIN assembly ON assembly.assemblycd = personnel.forassembly WHERE personnel.booked IN ('R') AND personnel.forassembly != '' AND personnel.groupid != 0 AND personnel.forassembly = ? ORDER BY personnel.groupid, poststat.poststat_order") or die($mysqli_countppds->error);

$deployed_party_query->bind_param("s", $assembly_code) or die($deployed_party_query->error);
$deployed_party_query->execute() or die($deployed_party_query->error);
$deployed_party_query->bind_result($personcd, $officer_name, $poststatus, $mobile, $forassembly, $assemblyname, $groupid) or die($deployed_party_query->error);

$return=array();

while ($deployed_party_query->fetch()) {
    $return[]=array("PersonID"=>$personcd,"OfficerName"=>$officer_name,"PostStatus"=>$poststatus,"Mobile"=>$mobile, "AssemblyCode"=>$forassembly, "AssemblyName"=>$assemblyname, "GroupID"=>$groupid);
}
$deployed_party_query->close();

?>
<title>DCRC Reserve Attendance List</title>
<h3>
    DCRC Reserve Attendance List
</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Constituency</th>
            <th>Reserve No</th>
            <th>Post Status</th>
            <th>Person ID</th>
            <th>Officer Name</th>
            <th>Mobile</th>
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
            <td><?php echo $return[$i]['Mobile']; ?></td>
            <td><?php echo "&nbsp;"; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>

    </tfoot>
</table>
