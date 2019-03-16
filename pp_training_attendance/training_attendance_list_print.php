<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$venue_id=$_GET['venue_id'];
$venue_name=$_GET['venue_name'];
$training_date=$_GET['training_date'];
$training_time=$_GET['training_time'];
$no_pp=$_GET['no_pp'];
$no_used=$_GET['no_used'];

$training_attendance_list_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, office.officecd, office.office, office.address1, office.address2, poststat.poststatus, personnel.mob_no FROM ((((personnel INNER JOIN office ON personnel.officecd = office.officecd) INNER JOIN poststat ON personnel.poststat = poststat.post_stat) INNER JOIN personnel_training ON personnel.personcd = personnel_training.personcd) INNER JOIN training_schedule ON personnel_training.schedule_code = training_schedule.schedule_code) INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue AND training_venue.venue_cd = ? AND training_schedule.training_dt = ? AND training_schedule.training_time = ? ORDER BY personnel.officer_name") or die($mysqli->error);
    $training_attendance_list_query->bind_param("sss",$venue_id,$training_date,$training_time) or die($training_attendance_list_query->error);

$training_attendance_list_query->execute() or die($training_attendance_list_query->error);
$training_attendance_list_query->bind_result($personcd,$officer_name,$off_desg,$officecd,$office_name,$address1,$address2,$poststatus,$mobile) or die($training_attendance_list_query->error);
$return=array();
while($training_attendance_list_query->fetch())
{
	$return[]=array("PersonID"=>$personcd,"OfficerName"=>$officer_name,"Designation"=>$off_desg,"OfficeID"=>$officecd,"OfficeName"=>$office_name,"Address1"=>$address1,"Address2"=>$address2,"PostStatus"=>$poststatus,"Mobile"=>$mobile);
}	
?>
<html>
    <title>
        Training Attendance List
    </title>
    <table border="1" cellpadding="5" cellspacing="0" width="100%" style="font-size: 14">
    <thead>
        <tr>
            <th colspan="7">
                <?php echo "Venue Name:- ".$venue_name.', Date of Training:- '.date_format(date_create($training_date),"d-M-Y").', Time:- '.$training_time.', PP Allocated:- '.$no_pp.', PP Occupied:- '.$no_used; ?>
            </th>
        </tr>
        <tr>
            <th>#</th>
            <th>Person ID</th>
            <th>Officer Name</th>
            <th>Designation / Office</th>
            <th>Post Status</th>
            <th>Mobile</th>
            <th>Signature</th>
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
            <td><?php echo "&nbsp;"; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7">
                <strong>Signature of Training Official:-</strong>
            </td>
        </tr>
    </tfoot>
</table>
</html>      