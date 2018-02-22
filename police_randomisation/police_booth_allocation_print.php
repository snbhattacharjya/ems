<?php
session_start();
require("../config/config.php");

$policestationcd = $_GET['policestationcd'];

if($policestationcd != 'ALL'){
    $police_personnel_query=$mysqli->prepare("SELECT policestationcd, policestation, assemblycd, assemblyname, psno, psname, personcd, officer_name FROM policestation_booth_personnel WHERE policestationcd = ? ORDER BY assemblycd, psno") or die($mysqli->error);
    $police_personnel_query->bind_param("s",$policestationcd) or die($police_personnel_query->error);
}
else{
    $police_personnel_query=$mysqli->prepare("SELECT policestationcd, policestation, assemblycd, assemblyname, psno, psname, personcd, officer_name FROM policestation_booth_personnel ORDER BY policestationcd, assemblycd, psno") or die($mysqli->error);
}
$police_personnel_query->execute() or die($police_personnel_query->error);
$police_personnel_query->bind_result($policestationcd, $policestation, $assemblycd, $assemblyname, $psno, $psname, $personcd, $officer_name) or die($police_personnel_query->error);
$police_personnel=array();

while($police_personnel_query->fetch()){
	$police_personnel[]=array("policestationcd"=>$policestationcd, "policestation"=>$policestation, "assemblycd"=>$assemblycd, "assemblyname"=>$assemblyname, "psno"=>$psno, "psname"=>$psname, "personcd"=>$personcd, "officer_name"=>$officer_name);
}
$police_personnel_query->close();
?>
<title>
    Police Booth Allocation Report
</title>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>#</th>
            <th>Police Station</th>
            <th>Assembly</th>
            <th>Polling Station</th>
            <th>Police Personnel</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for($i = 0; $i < count($police_personnel); $i++){
            echo "<tr>";
            echo "<td>".($i+1)."</td>";
            echo "<td>".$police_personnel[$i]['policestationcd']." - ".$police_personnel[$i]['policestation']."</td>";
            echo "<td>".$police_personnel[$i]['assemblycd']." - ".$police_personnel[$i]['assemblyname']."</td>";
            echo "<td>".$police_personnel[$i]['psno']." - ".$police_personnel[$i]['psname']."</td>";
            echo "<td>".$police_personnel[$i]['personcd']." - ".$police_personnel[$i]['officer_name']."</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
         </tr>
    </tfoot>
</table>