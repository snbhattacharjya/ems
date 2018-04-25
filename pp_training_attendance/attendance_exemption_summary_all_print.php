<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");


$training_schedule_venue_query=$mysqli->prepare("SELECT training_venue.venue_cd, training_venue.venuename, training_venue.maximumcapacity, training_schedule.post_status, training_schedule.no_pp, training_schedule.no_used, training_schedule.training_dt, training_schedule.training_time, COUNT(personnel_exempted.personcd) FROM (training_schedule INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue) INNER JOIN personnel_exempted ON personnel_exempted.training1_sch = training_schedule.schedule_code GROUP BY training_venue.venue_cd, training_venue.venuename, training_venue.maximumcapacity, training_schedule.post_status, training_schedule.no_pp, training_schedule.no_used, training_schedule.training_dt, training_schedule.training_time ORDER BY  training_venue.venue_cd") or die($mysqli->error);
    //$training_schedule_venue_query->bind_param("ssss",$venue_base_name,$subdiv,$training_date,$training_time) or die($training_schedule_venue_query->error);

$training_schedule_venue_query->execute() or die($training_schedule_venue_query->error);
$training_schedule_venue_query->bind_result($venue_code,$venue_name,$maximum_capacity,$post_status,$no_pp,$no_used,$no_exempted,$training_date,$training_time) or die($training_schedule_venue_query->error);
$return=array();
while($training_schedule_venue_query->fetch())
{
	$return[]=array("VenueID"=>$venue_code,"VenueName"=>$venue_name,"MaximumCapacity"=>$maximum_capacity,"PostStatus"=>$post_status,"NoPP"=>$no_pp,"NoUsed"=>$no_used,"NoExempted"=>$no_exempted,"TrainingDate"=>$training_date,"TrainingTime"=>$training_time);
}
?>
<html>
    <title>
        Training Attendance Summary
    </title>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th colspan="11">
                Training Attendance Summary for Exempted Personnel
            </th>
        </tr>
        <tr>
          <th>#</th>
          <th>Venue ID</th>
          <th>Venue Name</th>
          <th>Training Date</th>
          <th>Training Time</th>
          <th>Maximum Capacity</th>
          <th>Post Status</th>
          <th>PP Allocated</th>
          <th>PP Occupied</th>
          <th>PP Exempted</th>
          <th>Vacancy</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_capacity=0;
        $total_allocated=0;
        $total_occupied=0;
        $total_vacant=0;
        $total_exempted=0;
        for($i = 0; $i < count($return); $i++){
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $return[$i]['VenueID']; ?></td>
            <td><?php echo $return[$i]['VenueName']; ?></td>
            <td><?php echo $return[$i]['TrainingDate']; ?></td>
            <td><?php echo $return[$i]['TrainingTime']; ?></td>
            <td><?php echo $return[$i]['MaximumCapacity']; ?></td>
            <td><?php echo $return[$i]['PostStatus']; ?></td>
            <td><?php echo $return[$i]['NoPP']; ?></td>
            <td><?php echo $return[$i]['NoUsed']; ?></td>
            <td><?php echo $return[$i]['NoExempted']; ?></td>
            <td><?php echo $return[$i]['NoPP'] - ($return[$i]['NoUsed'] - $return[$i]['NoExempted']); ?></td>
        </tr>
        <?php
            $total_capacity+=$return[$i]['MaximumCapacity'];
            $total_allocated+=$return[$i]['NoPP'];
            $total_occupied+=$return[$i]['NoUsed'];
            $total_exempted+=$return[$i]['NoExempted'];
            $total_vacant+=($return[$i]['NoPP'] - ($return[$i]['NoUsed'] - $return[$i]['NoExempted']));
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5">
                Total Occupancy
            </th>
            <th>
                <?php echo $total_capacity; ?>
            </th>
            <th>
                &nbsp;
            </th>
            <th>
                <?php echo $total_allocated; ?>
            </th>
            <th>
                <?php echo $total_occupied; ?>
            </th>
            <th>
                <?php echo $total_exempted; ?>
            </th>
            <th>
                <?php echo $total_vacant; ?>
            </th>
        </tr>
    </tfoot>
</table>
</html>
