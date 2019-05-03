<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$assembly_code=$_GET['AssemblyCode'];

$deployed_party_query=$mysqli->prepare("SELECT assembly.assemblycd, assembly.assemblyname, pollingstation.psno, pollingstation.psname, pollingstation.groupid FROM pollingstation INNER JOIN assembly ON pollingstation.forassembly = assembly.assemblycd AND pollingstation.forassembly = ? ORDER BY pollingstation.psno") or die($mysqli_countppds->error);

$deployed_party_query->bind_param("s", $assembly_code) or die($deployed_party_query->error);
$deployed_party_query->execute() or die($deployed_party_query->error);
$deployed_party_query->bind_result($assemblycd, $assemblyname, $psno, $psname, $groupid) or die($deployed_party_query->error);

$return=array();

while ($deployed_party_query->fetch()) {
    $return[]=array("AssemblyCode"=>$assemblycd, "AssemblyName"=>$assemblyname, "psno"=>$psno, "psname"=>$psname, "GroupID"=>$groupid);
}
$deployed_party_query->close();

?>
<title>DCRC PS Party Attendance List</title>
<h3>
    DCRC PS Party Attendance List
</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th rowspan="2">Constituency</th>
            <th rowspan="2">Polling Station No</th>
            <th rowspan="2">Polling Station Name</th>
            <th rowspan="2">Polling Party No</th>
            <th colspan="3">Presiding Officer</th>
            <th colspan="3">1st Polling Officer</th>
            <th colspan="3">2nd Polling Officer</th>
            <th colspan="3">3rd Polling Officer</th>
        </tr>
        <tr>
            <th>Officer Detials</th>
            <th>Signature</th>
            <th>Tagged Reserve No (if any)</th>
            <th>Officer Detials</th>
            <th>Signature</th>
            <th>Tagged Reserve No (if any)</th>
            <th>Officer Detials</th>
            <th>Signature</th>
            <th>Tagged Reserve No (if any)</th>
            <th>Officer Detials</th>
            <th>Signature</th>
            <th>Tagged Reserve No (if any)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for ($i = 0; $i < count($return); $i++) {
            ?>
        <tr>
            <td><?php echo $return[$i]['AssemblyCode']." - ".$return[$i]['AssemblyName']; ?></td>
            <td><?php echo $return[$i]['psno']; ?></td>
            <td><?php echo $return[$i]['psname']; ?></td>
            <td><?php echo $return[$i]['GroupID']; ?></td>
            <?php
            $group_query = $mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, personnel.mob_no FROM personnel INNER JOIN poststat ON personnel.poststat = poststat.post_stat AND personnel.poststat != 'MO' AND personnel.booked = 'P' AND personnel.groupid = ? AND personnel.forassembly = ? ORDER BY poststat.poststat_order") or die($mysqli->error);
            $group_query->bind_param("ss", $return[$i]['GroupID'], $return[$i]['AssemblyCode']) or die($group_query->error);
            $group_query->execute() or die($group_query->error);
            $group_query->bind_result($personcd, $officer_name, $off_desg, $mob_no) or die($group_query->error);
            $group = array();
            while ($group_query->fetch()) {
                $group[] = array("personcd"=>$personcd,"officer_name"=>$officer_name,"off_desg"=>$off_desg,"mob_no"=>$mob_no);
            }
            $group_query->close();
            for ($j = 0; $j < count($group); $j++) {
                ?>
            <td>PIN - <strong><?php echo $group[$j]['personcd']; ?></strong>, NAME - <strong><?php echo $group[$j]['officer_name']; ?></strong>, DESIGNATION - <strong><?php echo $group[$j]['off_desg']; ?></strong>, MOBILE - <strong><?php echo $group[$j]['mob_no']; ?></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <?php
            } ?>
            
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>

    </tfoot>
</table>
