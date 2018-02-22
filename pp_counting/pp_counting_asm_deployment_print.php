<title>
    Counting PP Deployment by Residing Assembly
</title>
<?php
session_start();
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");

$subdiv_query=$mysqli_countppds->prepare("SELECT assembly.assemblycd, assembly.assemblyname, COUNT(personnela.personcd) FROM assembly INNER JOIN personnela ON assembly.assemblycd=personnela.assembly_temp WHERE personnela.booked IN ('P','R') GROUP BY assembly.assemblycd, assembly.assemblyname ORDER BY assembly.assemblycd, assembly.assemblyname") or die($mysqli_countppds->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($subdiv_code,$subdiv_name,$subdiv_total) or die($subdiv_query->error);
$subdiv=array();
while($subdiv_query->fetch()){
	$subdiv[]=array("SubdivCode"=>$subdiv_code, "SubdivName"=>$subdiv_name, "SubdivTotal"=>$subdiv_total);
}
$subdiv_query->close();

$for_subdiv_query=$mysqli_countppds->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, COUNT(personnela.personcd) FROM subdivision INNER JOIN personnela ON subdivision.subdivisioncd=personnela.forsubdivision WHERE personnela.booked IN ('P','R') GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd, subdivision.subdivision") or die($mysqli_countppds->error);

$for_subdiv_query->execute() or die($for_subdiv_query->error);
$for_subdiv_query->bind_result($for_subdiv_code,$for_subdiv_name,$for_subdiv_total) or die($for_subdiv_query->error);
$for_subdiv=array();
?>
<h3>
    Counting PP Deployment by Residing Assembly
</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>From Residing Assembly / Deployed Subdivision</th>
            <?php
            while($for_subdiv_query->fetch()){
                $for_subdiv[]=array("ForSubdivCode"=>$for_subdiv_code, "ForSubdivName"=>$for_subdiv_name, "ForSubdivTotal"=>$for_subdiv_total);
            ?>
            <th><?php echo $for_subdiv_code.' - '.$for_subdiv_name; ?></th>
            <?php
            }
            $for_subdiv_query->close();
            ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $pp_subdiv_deployment_query=$mysqli_countppds->prepare("SELECT personnela.assembly_temp, personnela.forsubdivision, COUNT(personnela.personcd) FROM personnela WHERE personnela.booked IN ('P','R') GROUP BY personnela.assembly_temp, personnela.forsubdivision ORDER BY personnela.subdivisioncd, personnela.forsubdivision") or die($mysqli_countppds->error);
        $pp_subdiv_deployment_query->execute() or die($pp_subdiv_deployment_query->error);
        $pp_subdiv_deployment_query->bind_result($subdiv_code,$for_subdiv_code,$pp_count) or die($pp_subdiv_deployment_query->error);
        
        $report=array();
        $search_index=array();
        while($pp_subdiv_deployment_query->fetch()){
            $report[]=array("SubdivCode"=>$subdiv_code, "ForSubdivCode"=>$for_subdiv_code, "SubdivPPDeployedTotal"=>$pp_count);
            $search_index[]=array("SubdivCode"=>$subdiv_code, "ForSubdivCode"=>$for_subdiv_code);
        }
        $pp_subdiv_deployment_query->close();
        ?>
        <?php
	for($i=0;$i<count($subdiv);$i++){
        ?>
	<tr>
            <td><strong><?php echo $subdiv[$i]['SubdivCode'].' - '.$subdiv[$i]['SubdivName']; ?></strong></td>
        <?php
            for($j=0;$j<count($for_subdiv);$j++){
                $index=array_search(array("SubdivCode"=>$subdiv[$i]['SubdivCode'],"ForSubdivCode"=>$for_subdiv[$j]['ForSubdivCode']),$search_index);
                if($report[$index]['SubdivCode'] == $subdiv[$i]['SubdivCode'] && $report[$index]['ForSubdivCode'] == $for_subdiv[$j]['ForSubdivCode']){
                    echo "<td>".$report[$index]['SubdivPPDeployedTotal']."</td>";
                }
                else
                    echo "<td>0</td>";
            }
        ?>
            <td><?php echo $subdiv[$i]['SubdivTotal']; ?></td>
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
            for($i = 0; $i < count($for_subdiv); $i++){
                $dist_total+=$for_subdiv[$i]['ForSubdivTotal'];
            ?>
            <th><?php echo $for_subdiv[$i]['ForSubdivTotal']; ?></th>
            <?php
            }
            ?>
            <th><?php echo $dist_total; ?></th>
        </tr>
        <tr>
            <th colspan="<?php echo count($for_subdiv) + 2; ?>">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                    $mysqli_countppds->close();
                ?>
            </th>
    </tfoot>
</table>