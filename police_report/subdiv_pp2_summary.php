<?php
session_start();
require("../config/config.php");

$subdiv_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, COUNT(personnel.personcd) FROM subdivision INNER JOIN personnel ON personnel.subdivisioncd=subdivision.subdivisioncd WHERE subdivision.subdivisioncd != '9999' GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($sub_div_code,$sub_div_name,$sub_div_total) or die($subdiv_query->error);
$subdiv=array();
while($subdiv_query->fetch()){
	$subdiv[]=array("SubdivCode"=>$sub_div_code, "SubdivName"=>$sub_div_name, "SubdivTotal"=>$sub_div_total);
}
$subdiv_query->close();

?>

<table id="subdiv_exempt_summary" class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="bg-light-blue-gradient">
            <th>Subdivision Code</th>
            <th>Subdivision Name</th>
            <th>PP2 Count</th>
            <th>Print Report</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $dist_total=0;
        for($i=0;$i<count($subdiv);$i++){
        ?>
        <tr>
            <td><?php echo "<a href='#' data-subdiv='".$subdiv[$i]['SubdivCode']."' class='office-report-btn text-bold text-green'>".$subdiv[$i]['SubdivCode']."</a>"; ?></td>
            <td><?php echo "<a href='#' data-subdiv='".$subdiv[$i]['SubdivCode']."' class='office-report-btn text-bold text-green'>".$subdiv[$i]['SubdivName']."</a>"; ?></td>
            <td><?php echo $subdiv[$i]['SubdivTotal']; ?></td>
            <td><a href="police_report/employee_data_subdiv_print.php?subdiv=<?php echo $subdiv[$i]['SubdivCode']; ?>" class="btn btn-default text-red" target="_blank">
                    <i class="fa fa-print"></i>
                </a>
            </td>
        </tr>
        <?php
            $dist_total+= $subdiv[$i]['SubdivTotal'];
        }
        ?>
    </tbody>
    <tfoot>
        <tr class="info">
            <th colspan="2" class="text-center">Total</th>
            <th class="text-center"><?php echo $dist_total; ?></th>
            <th class="text-center">&nbsp;</th>
        </tr>
        <tr class="danger">
            <th colspan="4">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
    </tfoot>
</table>
<script>
    $('.office-report-btn').click(function(e){
        e.preventDefault();
        var subdiv=$(this).attr('data-subdiv').valueOf().toString();
        loadOfficePP2Summary(subdiv);
    });
    
    function loadOfficePP2Summary(subdiv){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "police_report/office_pp2_summary.php",
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