<?php
session_start();
require("../config/config.php");
?>
<div class="row">

	<div class="col-sm-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
            	<h3 class="box-title">Remarks wise Distribution of Polling Personnel 
                </h3>              
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->



			<div class="box-body">
    
    
<table class="table table-bordered table-hover table-condensed" id="pp2_table">
<?php
$user_id=$_SESSION['UserID'];

$remarks_names=array();
$remarks_query=$mysqli->prepare("SELECT remarks.remarks_cd, remarks.remarks, COUNT(personnel.personcd) FROM personnel INNER JOIN remarks ON personnel.remarks=remarks.remarks_cd GROUP BY remarks.remarks_cd, remarks.remarks ORDER BY remarks.remarks_cd") or die($mysqli->error);
$remarks_query->execute() or die($remarks_query->error);
$remarks_query->bind_result($remarks_code,$remarks_name,$tot_remarks_count) or die($remarks_query->error);
while($remarks_query->fetch()){
	$remarks_names[]=array("RemarksCode"=>$remarks_code,"RemarksName"=>$remarks_name,"TotalRemarksCount"=>$tot_remarks_count);
}
$remarks_query->close();

$subdiv_names=array();
$subdiv_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, COUNT(personnel.personcd) FROM personnel INNER JOIN subdivision ON personnel.subdivisioncd=subdivision.subdivisioncd GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($subdiv_code,$subdiv_name,$tot_subdiv_count) or die($subdiv_query->error);
while($subdiv_query->fetch()){
	$subdiv_names[]=array("SubDivCode"=>$subdiv_code,"SubDivName"=>$subdiv_name,"TotalSubDivCount"=>$tot_subdiv_count);
}
$subdiv_query->close();

$report_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, remarks.remarks_cd, COUNT(personnel.personcd) FROM (personnel INNER JOIN subdivision ON personnel.subdivisioncd=subdivision.subdivisioncd) INNER JOIN remarks ON personnel.remarks=remarks.remarks_cd GROUP BY subdivision.subdivisioncd, remarks.remarks_cd ORDER BY subdivision.subdivisioncd, remarks.remarks_cd") or die($mysqli->error);
$report_query->execute() or die($report_query->error);
$report_query->bind_result($subdiv_code,$remarks_code,$total_count) or die($report_query->error);

$report=array();
$search_index=array();
while($report_query->fetch()){
	$report[]=array("SubDivCode"=>$subdiv_code,"RemarksCode"=>$remarks_code,"TotalCount"=>$total_count);
	$search_index[]=array("SubDivCode"=>$subdiv_code,"RemarksCode"=>$remarks_code);
}

?>
<thead>
<tr class="bg-teal-gradient">
<th>REMARKS</th>
<?php
	for($i=0;$i<count($subdiv_names);$i++){
?>
	<th><?php echo $subdiv_names[$i]['SubDivName']; ?></th>
<?php
}
?>
<th>TOTAL</th>
</tr>
</thead>
<tbody>
<?php
	for($i=0;$i<count($remarks_names);$i++){
?>
	<tr>
    	<td><?php echo $remarks_names[$i]['RemarksName']; ?></td>
        <?php
		for($j=0;$j<count($subdiv_names);$j++){
                    $index=array_search(array("SubDivCode"=>$subdiv_names[$j]['SubDivCode'],"RemarksCode"=>$remarks_names[$i]['RemarksCode']),$search_index);
                    if($report[$index]['SubDivCode'] == $subdiv_names[$j]['SubDivCode'] && $report[$index]['RemarksCode'] == $remarks_names[$i]['RemarksCode']){
					echo "<td>".$report[$index]['TotalCount']."</td>";
				}
				else
					echo "<td>0</td>";
		}
		?>
        <td><?php echo $remarks_names[$i]['TotalRemarksCount']; ?></td>
    </tr>
<?php
}
?>
</tbody>
<tfoot>
<tr class="info">
	<th>TOTAL</th>
    <?php
	$dist_total=0;
	for($j=0;$j<count($subdiv_names);$j++){	
		$dist_total+=$subdiv_names[$j]['TotalSubDivCount'];
	?>
    <th><?php echo $subdiv_names[$j]['TotalSubDivCount']; ?></th>
    <?php
	}
	?>
	<th><?php echo $dist_total; ?></th>
</tr>
</tfoot>
</table>
			</div><!-- /.box-body -->
       	</div><!-- /.box -->
  	</div><!-- /.col -->
</div><!-- /.row -->   
<script>
table=$('#pp2_table').DataTable({
		"paging": false,
	 	"lengthChange": true,
	  	"searching": true,
	  	"ordering": true,
	  	"info": true,
	  	"autoWidth": true
		}); 
</script>