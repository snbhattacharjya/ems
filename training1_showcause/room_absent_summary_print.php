<?php
session_start();
require("../config/config.php");

$subdiv=$_GET['subdiv'];
$training_venue=$_GET['training_venue'];
$training_date=$_GET['training_date'];
$training_time=$_GET['training_time'];
$training_type=$_GET['training_type'];

$room_absent_query=$mysqli->prepare("SELECT training_venue.venue_cd, training_venue.venuename, training_schedule.no_used, COUNT(personnel_training_absent.personcd), (training_schedule.no_used - COUNT(personnel_training_absent.personcd)) FROM ((training_venue INNER JOIN training_schedule ON training_venue.venue_cd = training_schedule.training_venue) INNER JOIN personnel ON training_schedule.schedule_code = personnel.training1_sch) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd WHERE training_venue.subdivisioncd = ? AND personnel_training_absent.training_type = ? AND personnel_training_absent.training_date = ? AND personnel_training_absent.training_time = ? AND training_venue.venue_base_name = ? GROUP BY training_venue.venue_cd, training_venue.venuename, training_schedule.no_used ORDER BY training_venue.venue_cd, training_venue.venuename") or die($mysqli->error);
$room_absent_query->bind_param("sssss",$subdiv,$training_type,$training_date,$training_time,$training_venue) or die($room_absent_query->error);
$room_absent_query->execute() or die($room_absent_query->error);
$room_absent_query->bind_result($training_venue_code,$training_venue_name,$room_pp_scheduled,$room_pp_absent,$room_pp_present) or die($room_absent_query->error);
$rooms=array();

while($room_absent_query->fetch()){
	$rooms[]=array("RoomCode"=>$training_venue_code, "RoomName"=>$training_venue_name, "PPScheduled"=>$room_pp_scheduled,"PPAbsent"=>$room_pp_absent,"PPPresent"=>$room_pp_present);
}
$room_absent_query->close();
?>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
           <th colspan="4">
                Room wise 1st Training Absent Summary for <?php echo $training_venue." on ".date_format(date_create($training_date),"d-M-Y")." at ".$training_time;?>
            </th>
        </tr>
        <tr>
            <th>Room Name</th>
            <th>PP Scheduled</th>
            <th>PP Present</th>
            <th>PP Absent</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $venue_schedule_total=0;
        $venue_present_total=0;
        $venue_absent_total=0;        
	for($i=0;$i<count($rooms);$i++){
            $venue_schedule_total+=$rooms[$i]['PPScheduled'];
            $venue_present_total+=$rooms[$i]['PPPresent'];
            $venue_absent_total+=$rooms[$i]['PPAbsent']; 
        ?>
	<tr>
            <td><?php echo $rooms[$i]['RoomName']; ?></td>
            <td><?php echo $rooms[$i]['PPScheduled']; ?></td>
            <td><?php echo $rooms[$i]['PPPresent']; ?></td>
            <td><?php echo $rooms[$i]['PPAbsent']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Total</th>
            <th><?php echo $venue_schedule_total; ?></th>
            <th><?php echo $venue_present_total; ?></th>
            <th><?php echo $venue_absent_total; ?></th>
        </tr>
        <tr>
            <th colspan="4">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
        </tr>
    </tfoot>
</table>