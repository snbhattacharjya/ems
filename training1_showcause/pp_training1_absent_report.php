<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$subdiv=$_POST['subdiv'];
$blockmuni=$_POST['blockmuni'];
$officecd=$_POST['officecd'];
$training_type='01';

$training_absent_list_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, office.officecd, office.office, office.address1, office.address2, poststat.poststatus, personnel.mob_no, training_venue.venuename, DATE_FORMAT(DATE(training_schedule.training_dt),'%D-%b-%Y (%a)'), training_schedule.training_time FROM (((personnel INNER JOIN office ON personnel.officecd = office.officecd) INNER JOIN poststat ON personnel.poststat = poststat.post_stat) INNER JOIN training_schedule ON personnel.training1_sch = training_schedule.schedule_code) INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue WHERE office.officecd = ? AND personnel.personcd IN (SELECT personcd FROM personnel_training_absent WHERE training_type = ?) ORDER BY personnel.officer_name") or die($mysqli->error);
    $training_absent_list_query->bind_param("ss",$officecd,$training_type) or die($training_absent_list_query->error);

$training_absent_list_query->execute() or die($training_absent_list_query->error);
$training_absent_list_query->bind_result($personcd,$officer_name,$off_desg,$officecd,$office_name,$address1,$address2,$poststatus,$mobile,$training_venue,$training_date,$training_time) or die($training_absent_list_query->error);
$return=array();
while($training_absent_list_query->fetch())
{
	$return[]=array("PersonID"=>$personcd,"OfficerName"=>$officer_name,"Designation"=>$off_desg,"OfficeID"=>$officecd,"OfficeName"=>$office_name,"Address1"=>$address1,"Address2"=>$address2,"PostStatus"=>$poststatus,"Mobile"=>$mobile,"TrainingVenue"=>$training_venue,"TrainingDate"=>$training_date,"TrainingTime"=>$training_time);
}	
?>
<div class="margin-bottom text-center">
    <a class="btn btn-default btn-md" href="pp_training/pp_training_office_summary_print.php?blockmuni=<?php echo $blockmuni_param; ?>" target="_blank">
        <i class="fa fa-print text-red"></i> Print Summary
    </a>
</div>
<table id="table_employee" class="table table-bordered table-condensed small">
    <thead>
        <tr class="danger">
            <th colspan="8">
                Employee Absent Report for Office
                <input type="text" class="input-sm pull-right" placeholder="Search Employee" id="search-text">
            </th>
        </tr>
        <tr class="bg-blue-active">
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
            <td class="personcd"><?php echo $return[$i]['PersonID']; ?></td>
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
        <tr class="danger">
            <th colspan="8">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
        </tr>
    </tfoot>
  </table>
<div>
    <a class="btn btn-default btn-md office-summary" data-subdiv="<?php echo $subdiv; ?>" data-blockmuni="<?php echo $blockmuni; ?>">
        <i class="fa fa-arrow-circle-left text-red"></i> Back
    </a>
</div>
<script>
    
    $(function(){ 
        $("#search-text").keyup(function(){
            if (this.value.length < 1) {
                $("#table_employee tbody tr").css("display", "");
            } 
            else {
                $("#table_employee tbody tr:not(:contains('"+$(this).val().toUpperCase()+"'))").css("display", "none");
                $("#table_employee tbody tr:contains('"+$(this).val().toUpperCase()+"')").css("display", "");
            }    
        });
        
        $('.office-summary').click(function(e){
            e.preventDefault();
            var blockmuni=$(this).attr('data-blockmuni').valueOf().toString();
            var subdiv=$(this).attr('data-subdiv').valueOf().toString();
            loadOfficeAbsentSummary(subdiv,blockmuni);
        });
    });
    
    function loadOfficeAbsentSummary(subdiv, blockmuni){
        $('#ajax-result').empty();
        $('.ajax-loader').show();
        $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "training1_showcause/office_training1_absent_summary.php",
                type: "POST",
                data: {
                    subdiv: subdiv,
                    blockmuni: blockmuni
                },
                success: function(data) {
                    $('.ajax-loader').hide();
                    $('#ajax-result').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "html",
                async: false
            });
    }
    
</script>


