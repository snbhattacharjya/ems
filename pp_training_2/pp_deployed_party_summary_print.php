<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");


$assembly_query=$mysqli->prepare("SELECT assembly.assemblycd, assembly.assemblyname, MAX(personnel.groupid) FROM assembly INNER JOIN personnel ON assembly.assemblycd = personnel.forassembly WHERE personnel.poststat IN ('PR','P1','P2','P3','PA') AND personnel.booked = 'P' AND personnel.forassembly != '' AND personnel.groupid != 0 GROUP BY assembly.assemblycd, assembly.assemblyname ORDER BY assembly.assemblycd, assembly.assemblyname") or die($mysqli->error);
//$assembly_query->bind_param("s",$subdiv_param) or die($assembly_query->error);
$assembly_query->execute() or die($assembly_query->error);
$assembly_query->bind_result($assembly_code,$assembly_name,$party_total) or die($assembly_query->error);
$assembly_party=array();

while($assembly_query->fetch()){
	$assembly_party[]=array("AssemblyCode"=>$assembly_code, "AssemblyName"=>$assembly_name, "PartyTotal"=>$party_total);
}
$assembly_query->close();

?>

<table id="blockmuni_exempt_summary" class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="bg-light-blue-gradient">
            <th>Sl No. </th>
            <th>Deployed Constituency Name</th>
            <th>Party Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $dist_total = 0;
	for($i=0;$i<count($assembly_party);$i++){
        ?>
	       <tr>
            <td><?php echo $i + 1; ?></td>
            <td><?php echo $assembly_party[$i]['AssemblyName']; ?></td>
            <td><?php echo $assembly_party[$i]['PartyTotal']; ?></td>
        </tr>
        <?php
          $dist_total += $assembly_party[$i]['PartyTotal'];
        }
        ?>
    </tbody>
    <tfoot>
        <tr class="info">
            <th colspan="2">Total</th>
            <th><?php echo $dist_total; ?></th>
        </tr>
        <tr class="danger">
            <th colspan="3">
                <?php
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A");
                ?>
            </th>
    </tfoot>
</table>

<script>


</script>
