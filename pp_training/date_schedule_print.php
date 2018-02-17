<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$training_date=$_GET['training_date'];

if(!isset($_SESSION['Subdiv'])){
    $training_schedule_venue_query=$mysqli->prepare("SELECT training_venue.venue_cd, training_venue.venuename, training_schedule.training_dt, training_schedule.training_time, training_schedule.post_status, training_schedule.no_pp FROM training_schedule INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue WHERE training_venue.venue_base_name = ? ORDER BY  training_venue.venue_cd") or die($mysqli->error);
    $training_schedule_venue_query->bind_param("s",$training_date) or die($training_schedule_venue_query->error);
}
else{
    $training_schedule_venue_query=$mysqli->prepare("SELECT training_venue.venue_cd, training_venue.venuename, training_schedule.training_dt, training_schedule.training_time, training_schedule.post_status, training_schedule.no_pp FROM training_schedule INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue WHERE training_venue.venue_base_name = ? AND training_venue.subdivisioncd = ? ORDER BY  training_venue.venue_cd") or die($mysqli->error);
    $training_schedule_venue_query->bind_param("ss",$training_date, $_SESSION['Subdiv']) or die($training_schedule_venue_query->error);
}

$training_schedule_venue_query->execute() or die($training_schedule_venue_query->error);
$training_schedule_venue_query->bind_result($venue_code,$venue_name,$training_date,$training_time,$post_status,$no_pp) or die($training_schedule_venue_query->error);
$return=array();
while($training_schedule_venue_query->fetch())
{
	$return[]=array("VenueID"=>$venue_code,"VenueName"=>$venue_name,"TrainingDate"=>$training_date,"TrainingTime"=>$training_time,"PostStatus"=>$post_status,"PPCount"=>$no_pp);
}	
?>
<html>
    <title>
        Training Schedule Date Wise
    </title>
<table border="1" cellpadding="5" cellspacing="0" width="80%" align="center">
    <thead>

        <tr>
            <th>#</th>
            <th>Venue ID</th>
            <th>Venue Name</th>
            <th>Training Date</th>
            <th>Training Time</th>
            <th>Post Status</th>
            <th>Personnel Count</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_occupancy=0;
        for($i = 0; $i < count($return); $i++){
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $return[$i]['VenueID']; ?></td>
            <td><?php echo $return[$i]['VenueName']; ?></td>
            <td><?php echo $return[$i]['TrainingDate']; ?></td>
            <td><?php echo $return[$i]['TrainingTime']; ?></td>
            <td><?php echo $return[$i]['PostStatus']; ?></td>
            <td><?php echo $return[$i]['PPCount']; ?></td>
        </tr>
        <?php
            $total_occupancy+=$return[$i]['PPCount'];
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6">
                Total Occupancy
            </th>
            <th>
                <?php echo $total_occupancy; ?>
            </th>
        </tr>
    </tfoot>
</table>
</html>      