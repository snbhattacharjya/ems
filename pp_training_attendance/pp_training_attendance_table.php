<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$venue_base_name=$_POST['training_venue'];
$subdiv=$_POST['subdiv'];
$training_date=$_POST['training_date'];
$training_time=$_POST['training_time'];

$training_schedule_venue_query=$mysqli->prepare("SELECT training_venue.venue_cd, training_venue.venuename, training_venue.maximumcapacity, training_schedule.post_status, training_schedule.no_pp, training_schedule.no_used FROM training_schedule INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue WHERE training_venue.venue_base_name = ? AND training_venue.subdivisioncd = ? AND training_schedule.training_dt = ? AND training_schedule.training_time = ? ORDER BY  training_venue.venue_cd") or die($mysqli->error);
    $training_schedule_venue_query->bind_param("ssss",$venue_base_name,$subdiv,$training_date,$training_time) or die($training_schedule_venue_query->error);

$training_schedule_venue_query->execute() or die($training_schedule_venue_query->error);
$training_schedule_venue_query->bind_result($venue_code,$venue_name,$maximum_capacity,$post_status,$no_pp,$no_used) or die($training_schedule_venue_query->error);
$return=array();
while($training_schedule_venue_query->fetch())
{
	$return[]=array("VenueID"=>$venue_code,"VenueName"=>$venue_name,"MaximumCapacity"=>$maximum_capacity,"PostStatus"=>$post_status,"NoPP"=>$no_pp,"NoUsed"=>$no_used);
}	
?>
<div class="pull-right margin-bottom">
    <a href="pp_training_attendance/attendance_summary_print.php?subdiv=<?php echo $subdiv; ?>&training_venue=<?php echo $venue_base_name; ?>&training_date=<?php echo $training_date; ?>&training_time=<?php echo $training_time; ?>" class="btn btn-default btn-md text-red" target="_blank">
        <i class="fa fa-print"></i> Print Summary
    </a>
</div>
<table id="training_schedule_table" class="table table-bordered table-condensed small">
    <thead>
        <tr>
            <th class="bg-aqua text-center" colspan="10">
                <?php echo $venue_base_name.', Date: '.date_format(date_create($training_date),"d-M-Y").', Time: '.$training_time; ?>
            </th>
        </tr>
        <tr class="bg-red-gradient">
            <th>#</th>
            <th>Venue ID</th>
            <th>Venue Name</th>
            <th>Maximum Capacity</th>
            <th>Post Status</th>
            <th>PP Allocated</th>
            <th>PP Occupied</th>
            <th>Vacancy</th>
            <th>Attendance List</th>
            <th>Absent Marking</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_capacity=0;
        $total_allocated=0;
        $total_occupied=0;
        $total_vacant=0;
        for($i = 0; $i < count($return); $i++){
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $return[$i]['VenueID']; ?></td>
            <td><?php echo $return[$i]['VenueName']; ?></td>
            <td><?php echo $return[$i]['MaximumCapacity']; ?></td>
            <td><?php echo $return[$i]['PostStatus']; ?></td>
            <td><?php echo $return[$i]['NoPP']; ?></td>
            <td><?php echo $return[$i]['NoUsed']; ?></td>
            <td><?php echo $return[$i]['NoPP'] - $return[$i]['NoUsed']; ?></td>
            <td class="text-center"><a href="pp_training_attendance/training_attendance_list_print.php?venue_id=<?php echo $return[$i]['VenueID']; ?>&venue_name=<?php echo $return[$i]['VenueName']; ?>&training_date=<?php echo $training_date; ?>&training_time=<?php echo $training_time; ?>&no_pp=<?php echo $return[$i]['NoPP']; ?>&no_used=<?php echo $return[$i]['NoUsed']; ?>" class="btn btn-default btn-md text-red" target="_blank"><i class="fa fa-print"></i></a></td>
            <td class="text-center"><a href="#" class="btn btn-default btn-md text-blue"><i class="fa fa-user-times"></i></a></td>
        </tr>
        <?php
            $total_capacity+=$return[$i]['MaximumCapacity'];
            $total_allocated+=$return[$i]['NoPP'];
            $total_occupied+=$return[$i]['NoUsed'];
            $total_vacant+=($return[$i]['NoPP'] - $return[$i]['NoUsed']);
        }
        ?>
    </tbody>
    <tfoot>
        <tr class="success">
            <th colspan="3" class="text-center">
                Total Occupancy 
            </th>
            <th class="text-center">
                <?php echo $total_capacity; ?>
            </th>
            <th class="text-center">
                &nbsp;
            </th>
            <th class="text-center">
                <?php echo $total_allocated; ?>
            </th>
            <th class="text-center">
                <?php echo $total_occupied; ?>
            </th>
            <th class="text-center">
                <?php echo $total_vacant; ?>
            </th>
            <th class="text-center">
                &nbsp;
            </th>
            <th class="text-center">
                &nbsp;
            </th>
        </tr>
    </tfoot>
</table>     