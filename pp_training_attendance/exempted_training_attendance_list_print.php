<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

/*$venue_id=$_GET['venue_id'];
$venue_name=$_GET['venue_name'];
$training_date=$_GET['training_date'];
$training_time=$_GET['training_time'];
$no_pp=$_GET['no_pp'];
$no_used=$_GET['no_used'];*/

$training_attendance_list_query=$mysqli->prepare("SELECT personnel_exempted.personcd, personnel_exempted.officer_name, personnel_exempted.off_desg, office.officecd, office.office, office.address1, office.address2, poststat.poststatus, personnel_exempted.mob_no, training_venue.venuename, training_schedule.training_dt, training_schedule.training_time FROM (((personnel_exempted INNER JOIN office ON personnel_exempted.officecd = office.officecd) INNER JOIN poststat ON personnel_exempted.poststat = poststat.post_stat) INNER JOIN training_schedule ON personnel_exempted.training1_sch = training_schedule.schedule_code) INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue ORDER BY poststat.poststatus, personnel_exempted.personcd") or die($mysqli->error);
    //$training_attendance_list_query->bind_param("sss",$venue_id,$training_date,$training_time) or die($training_attendance_list_query->error);

$training_attendance_list_query->execute() or die($training_attendance_list_query->error);
$training_attendance_list_query->bind_result($personcd,$officer_name,$off_desg,$officecd,$office_name,$address1,$address2,$poststatus,$mobile,$training_venue,$training_date,$training_time) or die($training_attendance_list_query->error);
$return=array();
while($training_attendance_list_query->fetch())
{
	$return[]=array("PersonID"=>$personcd,"OfficerName"=>$officer_name,"Designation"=>$off_desg,"OfficeID"=>$officecd,"OfficeName"=>$office_name,"Address1"=>$address1,"Address2"=>$address2,"PostStatus"=>$poststatus,"Mobile"=>$mobile,"VenueName"=>$training_venue,"TrainingDate"=>$training_date,"TrainingTime"=>$training_time);
}
?>
<html>
    <title>
        Training Attendance List
    </title>
    <table border="1" cellpadding="5" cellspacing="0" width="100%" style="font-size: 14">
    <thead>
        <tr>
            <th colspan="9">
                Attendance List for Exempted Personnel
            </th>
        </tr>
        <tr>
            <th>#</th>
            <th>Person ID</th>
            <th>Officer Name</th>
            <th>Designation / Office</th>
            <th>Post Status</th>
            <th>Mobile</th>
            <th>Training Venue</th>
            <th>Training Date</th>
            <th>Training Time</th>
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
            <td><?php echo $return[$i]['VenueName']; ?></td>
            <td><?php echo $return[$i]['TrainingDate']; ?></td>
            <td><?php echo $return[$i]['TrainingTime']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <!--<tfoot>
        <tr>
            <td colspan="7">
                <strong>Signature of Training Official:-</strong>
            </td>
        </tr>
    </tfoot>-->
</table>
</html>
