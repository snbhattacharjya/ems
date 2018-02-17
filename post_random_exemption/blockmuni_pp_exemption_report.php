<?php
session_start();
require("../config/config.php");

$subdiv_param=$_POST['subdiv'];
$blockmuni_param=$_POST['blockmuni'];

$blockmuni_pp_query=$mysqli->prepare("SELECT office.officecd, office.office, personnel.personcd, personnel.officer_name, personnel.off_desg, personnel.mob_no, remarks.remarks, personnel_exempt_marked.reason FROM ((office INNER JOIN personnel ON office.officecd = personnel.officecd) INNER JOIN remarks ON personnel.remarks = remarks.remarks_cd) INNER JOIN personnel_exempt_marked ON personnel.personcd = personnel_exempt_marked.personcd WHERE office.blockormuni_cd = ? ORDER BY office.officecd, personnel.officer_name") or die($mysqli->error);
$blockmuni_pp_query->bind_param("s",$blockmuni_param) or die($blockmuni_pp_query->error);
$blockmuni_pp_query->execute() or die($blockmuni_pp_query->error);
$blockmuni_pp_query->bind_result($officecd, $office, $personcd, $officer_name, $off_desg, $mob_no, $remarks, $reason) or die($blockmuni_pp_query->error);
$blockmuni=array();

while($blockmuni_pp_query->fetch()){
	$blockmuni[]=array("officecd"=>$officecd, "office"=>$office, "personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "mob_no"=>$mob_no, "remarks"=>$remarks, "reason"=>$reason);
}
$blockmuni_pp_query->close();
?>
<table id="employee_exempt_details" class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="bg-light-blue-gradient">
            <th>#</th>
            <th>Office ID</th>
            <th>Office Name</th>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Designation</th>
            <th>Mobile</th>
            <th>Remarks</th>
            <th>Reason for Exemption</th>
            <th>Approve</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for($i = 0; $i < count($blockmuni); $i++){
            echo "<tr>";
            echo "<td>".($i+1)."</td>";
            echo "<td>".$blockmuni[$i]['officecd']."</td>";
            echo "<td>".$blockmuni[$i]['office']."</td>";
            echo "<td>".$blockmuni[$i]['personcd']."</td>";
            echo "<td>".$blockmuni[$i]['officer_name']."</td>";
            echo "<td>".$blockmuni[$i]['off_desg']."</td>";
            echo "<td>".$blockmuni[$i]['mob_no']."</td>";
            echo "<td>".$blockmuni[$i]['remarks']."</td>";
            echo "<td>".$blockmuni[$i]['reason']."</td>";
            echo "<td>upcoming</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
    <tfoot>
        <tr class="danger">
            <th colspan="10">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
         </tr>
    </tfoot>
</table>
<div>
    <a class="btn btn-default btn-md blockmuni-summary" data-subdiv='<?php echo $subdiv_param; ?>'>
        <i class="fa fa-arrow-circle-left text-red"></i> Back
    </a>
</div>
<script>
    $('.blockmuni-summary').click(function(e){
        e.preventDefault();
        var subdiv=$(this).attr('data-subdiv').valueOf().toString();
        loadBlockMuniExemptionSummary(subdiv);
    });
    
    function loadBlockMuniExemptionSummary(subdiv){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "personnel_exemption_manage/blockmuni_exemption_summary.php",
            type: "POST",
            data: {
                subdiv: subdiv
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