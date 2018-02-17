<title>
    Personnel Absent List
</title>
<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$subdiv_param=$_GET['subdiv'];
$training_venue_param=$_GET['training_venue'];
$training_date_param=$_GET['training_date'];
$training_time_param=$_GET['training_time'];
$training_type_param=$_GET['training_type'];

$training_absent_list_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, office.officecd, office.office, office.address1, office.address2, poststat.poststatus, personnel.mob_no, training_venue.venuename, DATE_FORMAT(DATE(training_schedule.training_dt),'%D-%b-%Y (%a)'), training_schedule.training_time FROM (((personnel INNER JOIN office ON personnel.officecd = office.officecd) INNER JOIN poststat ON personnel.poststat = poststat.post_stat) INNER JOIN training_schedule ON personnel.training1_sch = training_schedule.schedule_code) INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue AND training_venue.subdivisioncd = ? AND training_venue.venue_base_name = ? AND training_schedule.training_dt = ? AND training_schedule.training_time = ? AND personnel.personcd IN (SELECT personcd FROM personnel_training_absent WHERE training_type = ?) ORDER BY training_venue.venuename, training_schedule.training_dt, training_schedule.training_time, personnel.officer_name") or die($mysqli->error);
    $training_absent_list_query->bind_param("sssss",$subdiv_param,$training_venue_param,$training_date_param,$training_time_param,$training_type_param) or die($training_absent_list_query->error);

$training_absent_list_query->execute() or die($training_absent_list_query->error);
$training_absent_list_query->bind_result($personcd,$officer_name,$off_desg,$officecd,$office_name,$address1,$address2,$poststatus,$mobile,$training_venue,$training_date,$training_time) or die($training_absent_list_query->error);
$return=array();
while($training_absent_list_query->fetch())
{
	$return[]=array("PersonID"=>$personcd,"OfficerName"=>$officer_name,"Designation"=>$off_desg,"OfficeID"=>$officecd,"OfficeName"=>$office_name,"Address1"=>$address1,"Address2"=>$address2,"PostStatus"=>$poststatus,"Mobile"=>$mobile,"TrainingVenue"=>$training_venue,"TrainingDate"=>$training_date,"TrainingTime"=>$training_time);
}	
?>
<table border='1' cellpadding='5' cellspacing='0'>
    <thead>
        <tr>
            <th colspan="8">
                Personnel Training Absent List for <?php echo $training_venue_param." on ".date_format(date_create($training_date_param),"d-M-Y")." at ".$training_time_param;?>
            </th>
        </tr>
        <tr>
            <th>#</th>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Designation / Office</th>
            <th>Post Status</th>
            <th>Mobile No</th>
            <th>Training Venue</th>
            <th>Training Date and Time</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for($i = 0; $i < count($return); $i++){
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $return[$i]['PersonID']; ?></td>
            <td><?php echo $return[$i]['OfficerName']; ?></td>
            <td><?php echo $return[$i]['Designation'].", ".$return[$i]['OfficeName']." - ".$return[$i]['Address1'].", ".$return[$i]['Address2']." (".$return[$i]['OfficeID'].")"; ?></td>
            <td><?php echo $return[$i]['PostStatus']; ?></td>
            <td><?php echo $return[$i]['Mobile']; ?></td>
            <td><?php echo $return[$i]['TrainingVenue']; ?></td>
            <td><?php echo $return[$i]['TrainingDate'].", ".$return[$i]['TrainingTime']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="8">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
        </tr>
    </tfoot>
  </table>
