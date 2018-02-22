<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$assembly_query=$mysqli->prepare("SELECT assembly.assemblycd, assembly.assemblyname, COUNT(personnel.personcd) FROM personnel INNER JOIN assembly ON personnel.acno = assembly.assemblycd WHERE personnel.personcd NOT IN (SELECT personcd FROM personnel_training_absent) AND personnel.booked IN ('P','R') GROUP BY assembly.assemblycd, assembly.assemblyname ORDER BY assembly.assemblycd") or die($mysqli->error);

$assembly_query->execute() or die($assembly_query->error);
$assembly_query->bind_result($assembly_code,$assembly_name,$pp_count) or die($assembly_query->error);
$return=array();
while($assembly_query->fetch())
{
    $return[]=array("AssemblyCode"=>$assembly_code,"AssemblyName"=>$assembly_name,"PPCount"=>$pp_count);
}
$assembly_query->close();
?>
<table id="table_report" class="table table-bordered table-condensed small">
    <thead>
        <tr class="bg-blue-active">
            <th>#</th>
            <th>Assembly Code</th>
            <th>Assembly Name</th>
            <th>Personnel Count</th>
            <th>1st Appointment</th>
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
            <td class="text-center"><a class="btn btn-default text-red" href="postal_ballot/first_appt_acno.php?acno=<?php echo $return[$i]['AssemblyCode']; ?> " target="_blank"><i class="fa fa-print"></i></a></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total</th>
            <th><?php echo $total_pp_count; ?></th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th colspan="5">
                <?php
                date_default_timezone_set("Asia/Kolkata");
                echo "Report Compiled as on - ".date("d/m/Y H:i:s A");
                ?>
            </th>
        </tr>
    </tfoot>
  </table> 