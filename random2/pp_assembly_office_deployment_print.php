<title>
    2nd Randomisation PP Deployment by Assembly
</title>
<?php
session_start();
require("../config/config.php");

$asm_temp_query=$mysqli->prepare("SELECT block_muni.blockminicd, block_muni.blockmuni, COUNT(personnel.personcd) FROM (office INNER JOIN personnel ON office.officecd = personnel.officecd) INNER JOIN block_muni ON block_muni.blockminicd = office.blockormuni_cd WHERE personnel.booked IN ('P','R') AND personnel.forassembly != '' AND personnel.groupid != 0 GROUP BY block_muni.blockminicd, block_muni.blockmuni ORDER BY block_muni.blockminicd, block_muni.blockmuni") or die($mysqli->error);
$asm_temp_query->execute() or die($asm_temp_query->error);
$asm_temp_query->bind_result($asm_temp_code,$asm_temp_name,$asm_temp_total) or die($asm_temp_query->error);
$asm_temp=array();
while($asm_temp_query->fetch()){
	$asm_temp[]=array("AssemblyTempCode"=>$asm_temp_code, "AssemblyTempName"=>$asm_temp_name, "AssemblyTempTotal"=>$asm_temp_total);
}
$asm_temp_query->close();

$for_asm_query=$mysqli->prepare("SELECT assembly.assemblycd, assembly.assemblyname, COUNT(personnel.personcd) FROM assembly INNER JOIN personnel ON personnel.forassembly=assembly.assemblycd WHERE personnel.booked IN ('P','R') AND personnel.forassembly != '' AND personnel.groupid != 0 GROUP BY assembly.assemblycd, assembly.assemblyname ORDER BY assembly.assemblycd, assembly.assemblyname") or die($mysqli->error);

$for_asm_query->execute() or die($for_asm_query->error);
$for_asm_query->bind_result($for_asm_code,$for_asm_name,$for_asm_total) or die($for_asm_query->error);
$for_asm=array();
?>
<h3>
    2nd Randomisation Polling Personnel Deployment Report
</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>From Constituency / Deployed Constituency</th>
            <?php
            while($for_asm_query->fetch()){
                $for_asm[]=array("ForAssemblyCode"=>$for_asm_code, "ForAssemblyName"=>$for_asm_name, "ForAssemblyTotal"=>$for_asm_total);
            ?>
            <th><?php echo $for_asm_code.' - '.$for_asm_name; ?></th>
            <?php
            }
            $for_asm_query->close();
            ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $pp_asm_deployment_query=$mysqli->prepare("SELECT block_muni.blockminicd, personnel.forassembly, COUNT(personnel.personcd) FROM (office INNER JOIN personnel ON office.officecd = personnel.officecd) INNER JOIN block_muni ON block_muni.blockminicd = office.blockormuni_cd WHERE personnel.booked IN ('P','R') AND personnel.forassembly != '' AND personnel.groupid != 0 GROUP BY block_muni.blockminicd, personnel.forassembly ORDER BY block_muni.blockminicd, personnel.forassembly") or die($mysqli->error);
        $pp_asm_deployment_query->execute() or die($pp_asm_deployment_query->error);
        $pp_asm_deployment_query->bind_result($asm_temp_code,$for_asm_code,$pp_count) or die($pp_asm_deployment_query->error);

        $report=array();
        $search_index=array();
        while($pp_asm_deployment_query->fetch()){
            $report[]=array("AssemblyTempCode"=>$asm_temp_code, "ForAssemblyCode"=>$for_asm_code, "AssemblyPPDeployedTotal"=>$pp_count);
            $search_index[]=array("AssemblyTempCode"=>$asm_temp_code, "ForAssemblyCode"=>$for_asm_code);
        }
        $pp_asm_deployment_query->close();
        ?>
        <?php
	for($i=0;$i<count($asm_temp);$i++){
        ?>
	<tr>
            <td><strong><?php echo $asm_temp[$i]['AssemblyTempCode'].' - '.$asm_temp[$i]['AssemblyTempName']; ?></strong></td>
        <?php
            for($j=0;$j<count($for_asm);$j++){
                $index=array_search(array("AssemblyTempCode"=>$asm_temp[$i]['AssemblyTempCode'],"ForAssemblyCode"=>$for_asm[$j]['ForAssemblyCode']),$search_index);
                if($report[$index]['AssemblyTempCode'] == $asm_temp[$i]['AssemblyTempCode'] && $report[$index]['ForAssemblyCode'] == $for_asm[$j]['ForAssemblyCode']){
                    echo "<td>".$report[$index]['AssemblyPPDeployedTotal']."</td>";
                }
                else
                    echo "<td>0</td>";
            }
        ?>
            <td><?php echo $asm_temp[$i]['AssemblyTempTotal']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Total</th>
            <?php
            $dist_total=0;
            for($i = 0; $i < count($for_asm); $i++){
                $dist_total+=$for_asm[$i]['ForAssemblyTotal'];
            ?>
            <th><?php echo $for_asm[$i]['ForAssemblyTotal']; ?></th>
            <?php
            }
            ?>
            <th><?php echo $dist_total; ?></th>
        </tr>
        <tr>
            <th colspan="<?php echo count($for_asm) + 2; ?>">
                <?php
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A");
                    $mysqli->close();
                ?>
            </th>
    </tfoot>
</table>
