<title>
    Subdivision Postal Ballot Summary
</title>
<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$subdiv=$_GET['subdiv'];
$training_date=$_GET['training_date'];

$assembly_query=$mysqli->prepare("SELECT assembly.assemblycd, assembly.assemblyname, COUNT(personnel.personcd) FROM ((personnel INNER JOIN assembly ON personnel.assembly_temp = assembly.assemblycd) INNER JOIN training_schedule ON personnel.training1_sch = training_schedule.schedule_code) INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue WHERE personnel.personcd NOT IN (SELECT personcd FROM personnel_training_absent) AND training_venue.subdivisioncd = ? AND training_schedule.training_dt = ? GROUP BY assembly.assemblycd, assembly.assemblyname ORDER BY assembly.assemblycd") or die($mysqli->error);
$assembly_query->bind_param("ss",$subdiv,$training_date) or die($assembly_query->error);
$assembly_query->execute() or die($assembly_query->error);
$assembly_query->bind_result($assembly_code,$assembly_name,$pp_count) or die($assembly_query->error);
$return=array();
while($assembly_query->fetch())
{
    $return[]=array("AssemblyCode"=>$assembly_code,"AssemblyName"=>$assembly_name,"PPCount"=>$pp_count);
}
$assembly_query->close();

$subdiv_query=$mysqli->prepare("SELECT subdivision.subdivision FROM subdivision WHERE subdivision.subdivisioncd = ?") or die($mysqli->error);
$subdiv_query->bind_param("s",$subdiv) or die($subdiv_query->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($subdiv_name) or die($subdiv_query->error);
$subdiv_query->fetch() or die($subdiv_query->error);
$subdiv_query->close();
?>
<table id="table_report" border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th colspan="4">
                Postal Ballot Summary for Subdivision - <?php echo $subdiv_name; ?> for 1st Training Date: <?php echo date_format(date_create($training_date),"d-M-Y"); ?>
            </th>
        </tr>
        
        <tr class="bg-blue-active">
            <th>#</th>
            <th>Assembly Code</th>
            <th>Assembly Name</th>
            <th>Personnel Count</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_pp_count=0;
        for($i=0;$i<count($return);$i++){
            $total_pp_count+=$return[$i]['PPCount'];
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $return[$i]['AssemblyCode']; ?></td>
            <td><?php echo $return[$i]['AssemblyName']; ?></td>
            <td><?php echo $return[$i]['PPCount']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total</th>
            <th><?php echo $total_pp_count; ?></th>
        </tr>
        <tr>
            <th colspan="4">
                <?php
                date_default_timezone_set("Asia/Kolkata");
                echo "Report Compiled as on - ".date("d/m/Y H:i:s A");
                ?>
            </th>
        </tr>
    </tfoot>
  </table> 