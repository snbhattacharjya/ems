<?php
session_start();
require("../config/config.php");

$subdiv=$_POST['subdiv'];
$office_query=$mysqli->prepare("SELECT office.officecd, office.office, COUNT(personnel.personcd) FROM office INNER JOIN personnel ON personnel.officecd=office.officecd WHERE office.subdivisioncd = ? GROUP BY office.officecd, office.office ORDER BY office.officecd") or die($mysqli->error);
$office_query->bind_param("s",$subdiv) or die($office_query->error);
$office_query->execute() or die($office_query->error);
$office_query->bind_result($office_code,$office_name,$office_total) or die($office_query->error);
$office=array();
while($office_query->fetch()){
	$office[]=array("OfficeCode"=>$office_code, "OfficeName"=>$office_name, "OfficeTotal"=>$office_total);
}
$office_query->close();

?>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-default back-button pull-right margin-bottom">
            <i class="fa fa-arrow-circle-left text-red"></i> Back
        </button>
    </div>
</div>
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
        for($i=0;$i<count($office);$i++){
        ?>
        <tr>
            <td><?php echo $office[$i]['OfficeCode']; ?></td>
            <td><?php echo $office[$i]['OfficeName']; ?></td>
            <td><?php echo $office[$i]['OfficeTotal']; ?></td>
            <td><a href="police_report/employee_data_office_print.php?officecd=<?php echo $office[$i]['OfficeCode']; ?>" class="btn btn-default text-red" target="_blank">
                    <i class="fa fa-print"></i>
                </a>
            </td>
        </tr>
        <?php
            $dist_total+= $office[$i]['OfficeTotal'];
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
    $('.back-button').click(function(e){
        e.preventDefault();
        loadSubdivPP2Summary();
    });
    
</script>