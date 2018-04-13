<?php
session_start();
require("../config/config.php");
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
$training_date=$_POST['training_date'];
$training_type='01';

if($training_date != "ALL"){
    $subdiv_date_absent_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, COUNT(personnel.personcd), COUNT(personnel_training_absent.personcd) FROM (((subdivision INNER JOIN training_venue ON subdivision.subdivisioncd = training_venue.subdivisioncd) INNER JOIN training_schedule ON training_venue.venue_cd = training_schedule.training_venue) INNER JOIN personnel ON training_schedule.schedule_code = personnel.training1_sch) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd WHERE personnel_training_absent.training_type = ? AND personnel_training_absent.training_date = ? GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd, subdivision.subdivision") or die($mysqli->error);
    $subdiv_date_absent_query->bind_param("ss",$training_type,$training_date) or die($subdiv_date_absent_query->error);
}
else{
    $subdiv_date_absent_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, COUNT(personnel.personcd), COUNT(personnel_training_absent.personcd) FROM (((subdivision INNER JOIN training_venue ON subdivision.subdivisioncd = training_venue.subdivisioncd) INNER JOIN training_schedule ON training_venue.venue_cd = training_schedule.training_venue) INNER JOIN personnel ON training_schedule.schedule_code = personnel.training1_sch) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd WHERE personnel_training_absent.training_type = ? GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd, subdivision.subdivision") or die($mysqli->error);
    $subdiv_date_absent_query->bind_param("s",$training_type) or die($subdiv_date_absent_query->error);
}
$subdiv_date_absent_query->execute() or die($subdiv_date_absent_query->error);
$subdiv_date_absent_query->bind_result($subdiv_code,$subdiv_name,$subdiv_pp_scheduled,$subdiv_pp_absent) or die($subdiv_date_absent_query->error);
$subdiv_absent=array();
$subdiv_absent_index=array();

while($subdiv_date_absent_query->fetch()){
    $subdiv_absent[]=array("SubdivCode"=>$subdiv_code, "SubdivName"=>$subdiv_name, "PPScheduled"=>$subdiv_pp_scheduled, "PPAbsent"=>$subdiv_pp_absent);
    $subdiv_absent_index[]=array("SubdivCode"=>$subdiv_code);
}
$subdiv_date_absent_query->close();

if($training_date != "ALL"){
    $subdiv_date_schedule_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, SUM(training_schedule.no_used) FROM (subdivision INNER JOIN training_venue ON subdivision.subdivisioncd = training_venue.subdivisioncd) INNER JOIN training_schedule ON training_venue.venue_cd = training_schedule.training_venue WHERE training_schedule.training_type = ? AND DATE(training_schedule.training_dt) = ? GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd, subdivision.subdivision") or die($mysqli->error);
    $subdiv_date_schedule_query->bind_param("ss",$training_type,$training_date) or die($subdiv_date_schedule_query->error);
}
else{
    $subdiv_date_schedule_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, SUM(training_schedule.no_used) FROM (subdivision INNER JOIN training_venue ON subdivision.subdivisioncd = training_venue.subdivisioncd) INNER JOIN training_schedule ON training_venue.venue_cd = training_schedule.training_venue WHERE training_schedule.training_type = ? GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd, subdivision.subdivision") or die($mysqli->error);
    $subdiv_date_schedule_query->bind_param("s",$training_type) or die($subdiv_date_schedule_query->error);
}
$subdiv_date_schedule_query->execute() or die($subdiv_date_schedule_query->error);
$subdiv_date_schedule_query->bind_result($subdiv_code,$subdiv_name,$subdiv_pp_scheduled) or die($subdiv_date_schedule_query->error);
$subdiv_schedule=array();
while($subdiv_date_schedule_query->fetch()){
	$subdiv_schedule[]=array("SubdivCode"=>$subdiv_code, "SubdivName"=>$subdiv_name, "PPScheduled"=>$subdiv_pp_scheduled);
}
$subdiv_date_schedule_query->close();
?>
<div class="text-right margin-bottom">
    <a class="btn btn-default btn-md" href="training1_showcause/subdiv_date_absent_summary_print.php?training_date=<?php echo $training_date; ?>&training_type=<?php echo $training_type; ?>" target="_blank">
        <i class="fa fa-print text-red"></i> Print Summary
    </a>
</div>
<table class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="success">
            <?php
            if($training_date != "ALL"){
            ?>
            <th class="text-center" colspan="4">
                Subdivision wise 1st Training Absent Summary <?php echo "on ".date_format(date_create($training_date),"d-M-Y");?>
            </th>
            <?php
            }
            else{
            ?>
            <th class="text-center" colspan="4">
                Subdivision wise 1st Training Absent Summary <?php echo " as on ".date("d-M-Y");?>
            </th>
            <?php
            }
            ?>
        </tr>
        <tr class="bg-light-blue-gradient">
            <th>Subdivision Name</th>
            <th>PP Scheduled</th>
            <th>PP Present</th>
            <th>PP Absent</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $subdiv_schedule_total=0;
        $subdiv_present_total=0;
        $subdiv_absent_total=0;
	for($i=0;$i<count($subdiv_schedule);$i++){
            $subdiv_schedule_total+=$subdiv_schedule[$i]['PPScheduled'];
        ?>
	<tr>
            <td><?php echo $subdiv_schedule[$i]['SubdivName']; ?></td>
            <td><?php echo $subdiv_schedule[$i]['PPScheduled']; ?></td>
            <?php
            $index=array_search(array("SubdivCode"=>$subdiv_schedule[$i]['SubdivCode']),$subdiv_absent_index);
            if(count($subdiv_absent) > 0 && $subdiv_absent[$index]['SubdivCode'] == $subdiv_schedule[$i]['SubdivCode']){
                echo "<td>".($subdiv_schedule[$i]['PPScheduled'] - $subdiv_absent[$index]['PPAbsent'])."</td><td>".$subdiv_absent[$index]['PPAbsent']."</td>";
                $subdiv_present_total+=($subdiv_schedule[$i]['PPScheduled'] - $subdiv_absent[$index]['PPAbsent']);
                $subdiv_absent_total+=$subdiv_absent[$index]['PPAbsent'];
            }
            else{
                echo "<td>".$subdiv_schedule[$i]['PPScheduled']."</td><td>0</td>";
                $subdiv_present_total+=$subdiv_schedule[$i]['PPScheduled'];
            }
            ?>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr class="info">
            <th>Total</th>
            <th><?php echo $subdiv_schedule_total; ?></th>
            <th><?php echo $subdiv_present_total; ?></th>
            <th><?php echo $subdiv_absent_total; ?></th>
        </tr>
        <tr class="danger">
            <th colspan="4">
                <?php
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A");
                ?>
            </th>
        </tr>
    </tfoot>
</table>
