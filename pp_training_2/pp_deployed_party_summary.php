<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");


$assembly_query=$mysqli->prepare("SELECT assembly.assemblycd, assembly.assemblyname, MAX(CASE WHEN personnel.poststat != 'MO' THEN personnel.groupid END), COUNT(CASE WHEN personnel.poststat = 'MO' AND personnel.status = 'Y' THEN 1 END) FROM assembly INNER JOIN personnel ON assembly.assemblycd = personnel.forassembly WHERE personnel.poststat IN ('MO','PR','P1','P2','P3','PA') AND personnel.booked = 'P' AND personnel.forassembly != '' AND personnel.groupid != 0 GROUP BY assembly.assemblycd, assembly.assemblyname ORDER BY assembly.assemblycd, assembly.assemblyname") or die($mysqli->error);
//$assembly_query->bind_param("s",$subdiv_param) or die($assembly_query->error);
$assembly_query->execute() or die($assembly_query->error);
$assembly_query->bind_result($assembly_code, $assembly_name, $party_total, $mo_total) or die($assembly_query->error);
$assembly_party=array();

while ($assembly_query->fetch()) {
    $assembly_party[]=array("AssemblyCode"=>$assembly_code, "AssemblyName"=>$assembly_name, "PartyTotal"=>$party_total, "MOTotal"=>$mo_total);
}
$assembly_query->close();

?>
<div class="text-center margin-bottom">
    <a class="btn btn-default btn-md" href="pp_training_2/pp_deployed_party_summary_print.php" target="_blank">
        <i class="fa fa-print text-red"></i> Print Summary
    </a>
</div>
<table id="blockmuni_exempt_summary" class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="bg-light-blue-gradient">
            <th>Sl No. </th>
            <th>Deployed Constituency Name</th>
            <th>Party Total</th>
            <th>MO Total</th>
            <th>Appointment</th>
            <th>PP Attendance</th>
            <th>MO Attendance</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $dist_mo_total = 0;
        $dist_total = 0;
    for ($i=0;$i<count($assembly_party);$i++) {
        ?>
	       <tr>
            <td><?php echo $i + 1; ?></td>
            <td><?php echo $assembly_party[$i]['AssemblyName']; ?></td>
            <td><?php echo $assembly_party[$i]['PartyTotal']; ?></td>
            <td><?php echo $assembly_party[$i]['MOTotal']; ?></td>
            <td class="text-center"><a href="pp_training_2/second_appointment_letter.php?opt=ASSEMBLY_PARTY&AssemblyCode=<?php echo $assembly_party[$i]['AssemblyCode']; ?>" class="text-red" target="_blank"><i class="fa fa-print"></i> Print</a></td>
            <td class="text-center"><a href="pp_training_2/deployed_party_attendance_print.php?AssemblyCode=<?php echo $assembly_party[$i]['AssemblyCode']; ?>" class="text-red" target="_blank"><i class="fa fa-print"></i> Print</a></td>
            <td class="text-center"><a href="pp_training_2/deployed_mo_party_attendance_print.php?AssemblyCode=<?php echo $assembly_party[$i]['AssemblyCode']; ?>" class="text-red" target="_blank"><i class="fa fa-print"></i> Print</a></td>
        </tr>
        <?php
          $dist_mo_total += $assembly_party[$i]['MOTotal'];
        $dist_total += $assembly_party[$i]['PartyTotal'];
    }
        ?>
    </tbody>
    <tfoot>
        <tr class="info">
            <th colspan="2">Total</th>
            <th><?php echo $dist_total; ?></th>
            <th><?php echo $dist_mo_total; ?></th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr class="danger">
            <th colspan="7">
                <?php
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A");
                ?>
            </th>
    </tfoot>
</table>

<script>


</script>
