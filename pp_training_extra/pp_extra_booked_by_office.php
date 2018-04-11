<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");

if(!isset($_POST['officecd']))
    $office_param=$_SESSION['UserID'];
else
    $office_param=$_POST['officecd'];
$blockmuni_param=$_POST['blockmuni'];
$subdiv_param=$_POST['subdiv'];
$pp_office_query=$mysqli->prepare("SELECT personnel_extra.personcd, personnel_extra.officer_name, personnel_extra.off_desg, personnel_extra.mob_no, personnel_extra.booked, personnel_extra.poststat FROM personnel_extra WHERE personnel_extra.officecd = ?") or die($mysqli->error);
$pp_office_query->bind_param("s",$office_param) or die($pp_office_query->error);
$pp_office_query->execute() or die($pp_office_query->error);
$pp_office_query->bind_result($personcd,$officer_name,$off_desg,$mob_no,$booked,$poststat) or die($pp_office_query->error);

$pp_office=array();

while($pp_office_query->fetch()){
    if($booked == 'P' || $booked == 'R')
        $booked_status="Appointed";
    if($booked == 'C')
        $booked_status="Exempted";
    if($booked == '')
        $booked_status="Not Appointed";

    if($poststat == 'PR')
        $post_status="Presiding Officer";
    if($poststat == 'P1')
        $post_status="1st Polling Officer";
    if($poststat == 'P2')
        $post_status="2nd Polling Officer";
    if($poststat == 'P3')
        $post_status="4th Polling Officer";
    if($poststat == 'PA')
        $post_status="3rd Polling Officer";
    if($poststat == 'MO')
        $post_status="Micro Observer";

    $pp_office[]=array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "mob_no"=>$mob_no,"booked_status"=>$booked_status,"post_status"=>$post_status);
}
$pp_office_query->close();

?>
<table id="pp_office_report" class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="bg-light-blue-gradient">
            <th>#</th>
            <th>Employee Code (PIN)</th>
            <th>Officer Name</th>
            <th>Designation</th>
            <th>Mobile No</th>
            <th>Post Status</th>
            <th>Polling Duty</th>
            <th>1st Appointment Letter</th>
        </tr>
    </thead>
    <tbody>
        <?php

	for($i=0;$i<count($pp_office);$i++){
        ?>
	<tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $pp_office[$i]['personcd']; ?></td>
            <td><?php echo $pp_office[$i]['officer_name']; ?></td>
            <td><?php echo $pp_office[$i]['off_desg']; ?></td>
            <td><?php echo $pp_office[$i]['mob_no']; ?></td>
            <td><?php echo $pp_office[$i]['post_status']; ?></td>
            <td><?php echo $pp_office[$i]['booked_status']; ?></td>
            <?php
            if($pp_office[$i]['booked_status'] == "Appointed"){
            ?>
            <td class="text-center"><a href="pp_training_extra/first_appointment_letter_pp_extra.php?person_code=<?php echo $pp_office[$i]['personcd']; ?>" class="text-red" target="_blank"><i class="fa fa-print"></i> Print</a></td>
            <?php
            }
            else{
                echo "<td>&nbsp;</td>";
            }
            ?>
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
    </tfoot>
</table>
<div>
    <a class="btn btn-default btn-md office-summary" data-blockmuni="<?php echo $blockmuni_param; ?>" data-subdiv="<?php echo $subdiv_param; ?>">
        <i class="fa fa-arrow-circle-left text-red"></i> Back
    </a>
</div>
<script>
    $(function(){
        var table=$('#pp_office_report').DataTable({
            paging: false
        });
    });

    $('.office-summary').click(function(e){
        e.preventDefault();
        var subdiv=$(this).attr('data-subdiv').valueOf().toString();
        var blockmuni=$(this).attr('data-blockmuni').valueOf().toString();
        loadOfficePPExtraSummary(subdiv, blockmuni);
    });

     function loadOfficePPExtraSummary(subdiv, blockmuni){
        $('.ajax-result').empty();
        $('.ajax-loader').show();
        $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "pp_training_extra/pp_training_extra_office_summary.php",
                type: "POST",
                data: {
                    subdiv: subdiv,
                    blockmuni: blockmuni
                },
                success: function(data) {
                    $('.ajax-loader').hide();
                    $('.ajax-result').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "html",
                async: false
            });
    }
</script>
