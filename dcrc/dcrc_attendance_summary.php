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
<div class="box box-solid">
    <div class="box-header bg-teal">
        <h3 class="box-title">
            DC RC Attendance
        </h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
        <div class="row">
                <div class="col-md-12 ajax-result">
                <table id="blockmuni_exempt_summary" class="table table-bordered table-condensed table-hover small">
                    <thead>
                        <tr class="bg-light-blue-gradient">
                            <th>Sl No. </th>
                            <th>Deployed Constituency Name</th>
                            <th>Total Polling Stations</th>
                            <th>PS-Party Attendance</th>
                            <th>Reserve Attendance</th>
                            <th>Micro Observer Attendance</th>
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
                            <td class="text-center"><a href="dcrc/dcrc_ps_party_attendance_print.php?AssemblyCode=<?php echo $assembly_party[$i]['AssemblyCode']; ?>" class="text-red" target="_blank"><i class="fa fa-print"></i> Print</a></td>
                            <td class="text-center"><a href="dcrc/dcrc_reserve_attendance_print.php?AssemblyCode=<?php echo $assembly_party[$i]['AssemblyCode']; ?>" class="text-red" target="_blank"><i class="fa fa-print"></i> Print</a></td>
                            <td class="text-center">coming soon!</td>
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
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr class="danger">
                            <th colspan="6">
                                <?php
                                    date_default_timezone_set("Asia/Kolkata");
                                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A");
                                ?>
                            </th>
                    </tfoot>
                </table>

                <script>


                </script>

                </div>
            </div>
        </div><!-- /.box-body -->
</div><!-- /.box -->
