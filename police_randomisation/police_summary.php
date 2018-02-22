<?php
session_start();
require("../config/config.php");

$police_personnel_query=$mysqli->prepare("SELECT policestation.policestationcd, policestation.policestation, COUNT(*) FROM policestation INNER JOIN policestation_personnel ON policestation.policestationcd = policestation_personnel.policestationcd GROUP BY policestation.policestationcd, policestation.policestation") or die($mysqli->error);
$police_personnel_query->execute() or die($police_personnel_query->error);
$police_personnel_query->bind_result($policestationcd, $policestation, $pp_count) or die($police_personnel_query->error);
$police_personnel=array();

$dist_total=0;
while($police_personnel_query->fetch()){
	$police_personnel[]=array("policestationcd"=>$policestationcd, "policestation"=>$policestation, "pp_count"=>$pp_count);
        $dist_total += $pp_count;
}
$police_personnel_query->close();
?>
<table id="employee_exempt_details" class="table table-bordered table-condensed table-striped small">
    <thead>
        <tr class="bg-light-blue-gradient">
            <th>#</th>
            <th>Police Station Code</th>
            <th>Police Station Name</th>
            <th>Personnel Count</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for($i = 0; $i < count($police_personnel); $i++){
            echo "<tr>";
            echo "<td>".($i+1)."</td>";
            echo "<td>".$police_personnel[$i]['policestationcd']."</td>";
            echo "<td>".$police_personnel[$i]['policestation']."</td>";
            echo "<td>".$police_personnel[$i]['pp_count']."</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
    <tfoot>
        <tr class="danger">
            <th colspan="3" class="text-center">
                Total
            </th>
            <th class="text-center">
                <?php 
                    echo $dist_total; 
                ?>
            </th>
         </tr>
        <tr class="info">
            <th colspan="4">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
         </tr>
    </tfoot>
</table>