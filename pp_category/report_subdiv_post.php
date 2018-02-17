<?php
session_start();
require("../config/config.php");
?>
    
<table class="table table-bordered" id="subdiv_post_table">
<thead>
<tr class="info">
<th>Post Status</th>
<th>PP Count</th>
<?php
$subdiv_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, SUM(assembly_booth.booth_count) FROM subdivision INNER JOIN assembly_booth ON subdivision.subdivisioncd = assembly_booth.subdivisioncd WHERE subdivision.subdivisioncd != '9999' GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd") or die();
$subdiv_query->execute() or die();
$subdiv_query->bind_result($sub_div_code, $sub_div_name, $booth_count) or die();
$subdiv=array();
while($subdiv_query->fetch()){
	$subdiv[]=array("SubdivCode"=>$sub_div_code, "SubdivName"=>$sub_div_name, "BoothCount"=>$booth_count);
?>
<th><?php echo $sub_div_name; ?></th>
<?php
}
	$subdiv_query->close();
?>
<th>Total</th>
</tr>
</thead>
<tbody>
<?php
	$reserve_percent=20;
        $reserve_percent_new=25;
	$post_stat_query="SELECT post_stat, poststatus FROM poststat WHERE post_stat IN ('PR','P1','P2','P3') ORDER BY post_stat";
	$post_stat_result=$mysqli->query($post_stat_query);
	
	$post_status=array();
	while($row = $post_stat_result->fetch_assoc()){
		$post_status[]=array("PostCode"=>$row['post_stat'],"PostName"=>$row['poststatus']);
	}
	$post_stat_result->close();
	
	for($i = 0 ; $i < count($post_status) ; $i++){

?>
        <tr>
        <th rowspan="7"><?php echo $post_status[$i]['PostCode'] . ' - ' . $post_status[$i]['PostName'] ; ?></th>
        </tr>
        <tr>
        <th>Actual</th>
        <?php
		$total_actual=0;
        for($j = 0 ; $j < count($subdiv) ; $j++){
			$subdiv_actual=$subdiv[$j]['BoothCount'];;
			$total_actual+=$subdiv_actual;
        ?>
        <td><?php echo $subdiv_actual; ?></td>
        <?php
        }
        ?>
        <th><?php echo $total_actual; ?></th>
        </tr>
        <tr>
        <th>Reserve @ (<?php echo $reserve_percent; ?>%)</th>
        <?php
		$total_reserve=0;
        for($j = 0 ; $j < count($subdiv) ; $j++){
			$subdiv_reserve=round(($subdiv[$j]['BoothCount'] * $reserve_percent / 100),0);
			$total_reserve+=$subdiv_reserve;
        ?>
        <td><?php echo $subdiv_reserve; ?></td>
        <?php
        }
        ?>
        <th><?php echo $total_reserve; ?></th>
        </tr>
        <tr>
        <th>Reserve @ (<?php echo $reserve_percent_new; ?>%)</th>
        <?php
		$total_reserve=0;
        for($j = 0 ; $j < count($subdiv) ; $j++){
			$subdiv_reserve=round(($subdiv[$j]['BoothCount'] * $reserve_percent_new / 100),0);
			$total_reserve+=$subdiv_reserve;
        ?>
        <td><?php echo $subdiv_reserve; ?></td>
        <?php
        }
        ?>
        <th><?php echo $total_reserve; ?></th>
        </tr>
        <tr>
        <th>Total Requirement (Actual + Reserve @ <?php echo $reserve_percent; ?>%)</th>
        <?php
		$total_requirement=0;
        for($j = 0 ; $j < count($subdiv) ; $j++){
			$subdiv_requirement=$subdiv[$j]['BoothCount'] + round(($subdiv[$j]['BoothCount'] * $reserve_percent / 100),0);
			$total_requirement+=$subdiv_requirement;
        ?>
        <td><?php echo  $subdiv_requirement; ?></td>
        <?php
        }
        ?>
        <th><?php echo $total_requirement; ?></th>
        </tr>
        <tr>
        <th>Total Requirement (Actual + Reserve @ <?php echo $reserve_percent_new; ?>%)</th>
        <?php
		$total_requirement=0;
        for($j = 0 ; $j < count($subdiv) ; $j++){
			$subdiv_requirement=$subdiv[$j]['BoothCount'] + round(($subdiv[$j]['BoothCount'] * $reserve_percent_new / 100),0);
			$total_requirement+=$subdiv_requirement;
        ?>
        <td><?php echo  $subdiv_requirement; ?></td>
        <?php
        }
        ?>
        <th><?php echo $total_requirement; ?></th>
        </tr>
        <tr>
        <th>Total Available</th>
        <?php
		$total_available=0;
        for($j = 0 ; $j < count($subdiv) ; $j++){
        ?>
        <td>
		<?php  
			$pp_count_query=$mysqli->prepare("SELECT COUNT(personcd) FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE personnel.poststat = ? AND personnel.subdivisioncd = ?") or die();
			$pp_count_query->bind_param("ss",$post_status[$i]['PostCode'],$subdiv[$j]['SubdivCode']) or die();
			$pp_count_query->execute() or die();
			$pp_count_query->bind_result($pp_count) or die();
			$pp_count_query->fetch() or die();
			
			$pp_count_query->close();
			$total_available+=$pp_count;
			echo $pp_count;
		?>
        </td>
        <?php
        }
        ?>
        <th><?php echo $total_available; ?></th>
        </tr>
	<?php 
    }
    ?>
</tbody>
<tfoot>
	<tr class="danger">
    	<th colspan="<?php echo count($subdiv) + 3; ?>">
        	<?php 
			date_default_timezone_set("Asia/Kolkata");
			echo "<i class='fa fa-info'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); ?>
        </th>
    </tr>
</tfoot>
</table>
