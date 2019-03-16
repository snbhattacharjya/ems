<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$venue_base_name=$_GET['training_venue'];
$subdiv=$_GET['subdiv'];
$training_date=$_GET['training_date'];
$training_time=$_GET['training_time'];

$training_schedule_venue_query=$mysqli->prepare("SELECT training_venue.venue_cd, training_venue.venuename FROM training_schedule INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue WHERE training_venue.venue_base_name = ? AND training_venue.subdivisioncd = ? AND training_schedule.training_dt = ? AND training_schedule.training_time = ? ORDER BY  training_venue.venue_cd") or die($mysqli->error);
    $training_schedule_venue_query->bind_param("ssss",$venue_base_name,$subdiv,$training_date,$training_time) or die($training_schedule_venue_query->error);

$training_schedule_venue_query->execute() or die($training_schedule_venue_query->error);
$training_schedule_venue_query->bind_result($venue_code,$venue_name) or die($training_schedule_venue_query->error);
$return=array();
while($training_schedule_venue_query->fetch())
{
	$return[]=array("VenueID"=>$venue_code,"VenueName"=>$venue_name);
}	
?>
<html>
    <title>
        Training Attendance Summary
    </title>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th colspan="8">
                <?php echo $venue_base_name.', Date: '.date_format(date_create($training_date),"d-M-Y").', Time: '.$training_time; ?>
            </th>
        </tr>
        <tr>
            <th>#</th>
            <th>Venue ID</th>
            <th>Venue Name</th>
            <th>Minimum Person</th>
            <th>Maximum Person</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for($i = 0; $i < count($return); $i++){
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $Venue_ID=$return[$i]['VenueID']; ?></td>
            <?php
                
 
            ?>
            <td><?php echo $return[$i]['VenueName']; ?></td>
            
              <?php
                $venuesql="SELECT MIN(personnel_training.personcd)AS min_person, MAX(personnel_training.personcd)AS max_person, COUNT(*) AS Count FROM training_schedule INNER JOIN personnel_training ON personnel_training.schedule_code= training_schedule.schedule_code WHERE training_schedule.training_venue= '$Venue_ID' AND training_schedule.training_dt = '$training_date' AND training_schedule.training_time = '$training_time'";
                $venuequery=mysqli_query($mysqli,$venuesql);
                while($row=mysqli_fetch_array($venuequery))
                    {
                       $min_personnel= $row['min_person'];
                       $max_personnel= $row['max_person'];
                       $Count= $row['Count'];
                   }
                     
            ?>
            <td><?php echo $min_personnel; ?></td>

            
            <td><?php echo $max_personnel ?></td>
            
            
            <td><?php echo $Count; ?></td>
            
        </tr>
        <?php
            
        }
        ?>
    </tbody>
</table>
</html>      