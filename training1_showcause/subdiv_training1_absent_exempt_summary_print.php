<title>
    Exempt Absent Summary
</title>
<?php
session_start();
require("../config/config.php");

$training_type='01';
$subdiv_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, COUNT(personnel_training_absent.personcd) FROM ((subdivision INNER JOIN personnel ON personnel.subdivisioncd=subdivision.subdivisioncd) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd) INNER JOIN personnel_exempt_post_random ON personnel_training_absent.personcd = personnel_exempt_post_random.personcd WHERE personnel_training_absent.training_type = ? GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
$subdiv_query->bind_param("s",$training_type) or die($subdiv_query->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($sub_div_code,$sub_div_name,$sub_div_total) or die($subdiv_query->error);
$subdiv=array();
while($subdiv_query->fetch()){
	$subdiv[]=array("SubdivCode"=>$sub_div_code, "SubdivName"=>$sub_div_name, "SubdivTotal"=>$sub_div_total);
}
$subdiv_query->close();

$poststat_query=$mysqli->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnel_training_absent.personcd) FROM ((poststat INNER JOIN personnel ON poststat.post_stat=personnel.poststat) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd) INNER JOIN personnel_exempt_post_random ON personnel_training_absent.personcd = personnel_exempt_post_random.personcd WHERE personnel_training_absent.training_type = ? GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);
$poststat_query->bind_param("s",$training_type) or die($poststat_query->error);
$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();
while($poststat_query->fetch()){
    $poststat[]=array("PostStatCode"=>$post_stat_code, "PostStatName"=>$post_stat_name, "PostStatTotal"=>$post_stat_total);
}
$poststat_query->close();
?>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th colspan="<?php echo count($poststat) + 2; ?>">
                Subdivision Summary for Exemption among Absentee Personnel
            </th>
        </tr>
        <tr>
            <th>Subdivision Name</th>
            <?php
            for($i = 0; $i < count($poststat); $i++){
            ?>
            <th><?php echo $poststat[$i]['PostStatCode']." - ".$poststat[$i]['PostStatName']; ?></th>
            <?php
            }
            ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $subdiv_exempt_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, personnel.poststat, COUNT(personnel_training_absent.personcd) FROM ((subdivision INNER JOIN personnel ON subdivision.subdivisioncd=personnel.subdivisioncd) INNER JOIN personnel_training_absent ON personnel.personcd=personnel_training_absent.personcd) INNER JOIN personnel_exempt_post_random ON personnel_training_absent.personcd = personnel_exempt_post_random.personcd WHERE personnel_training_absent.training_type = ? GROUP BY subdivision.subdivisioncd, personnel.poststat ORDER BY subdivision.subdivisioncd, personnel.poststat") or die($mysqli->error);
        $subdiv_exempt_query->bind_param("s",$training_type) or die($subdiv_exempt_query->error);
        $subdiv_exempt_query->execute() or die($subdiv_exempt_query->error);
        $subdiv_exempt_query->bind_result($sub_div_code,$post_stat_code,$pp_count) or die($subdiv_exempt_query->error);
        
        $report=array();
        $search_index=array();
        while($subdiv_exempt_query->fetch()){
            $report[]=array("SubdivCode"=>$sub_div_code, "PostStatCode"=>$post_stat_code, "SubdivPostTotal"=>$pp_count);
            $search_index[]=array("SubdivCode"=>$sub_div_code, "PostStatCode"=>$post_stat_code);
        }
        ?>
        <?php
	for($i=0;$i<count($subdiv);$i++){
        ?>
	<tr>
            <td><?php echo "<label class='text-green'>".$subdiv[$i]['SubdivName']."</label>"; ?></td>
        <?php
            for($j=0;$j<count($poststat);$j++){
                $index=array_search(array("SubdivCode"=>$subdiv[$i]['SubdivCode'],"PostStatCode"=>$poststat[$j]['PostStatCode']),$search_index);
                if($report[$index]['SubdivCode'] == $subdiv[$i]['SubdivCode'] && $report[$index]['PostStatCode'] == $poststat[$j]['PostStatCode']){
                    echo "<td>".$report[$index]['SubdivPostTotal']."</td>";
                }
                else
                    echo "<td>0</td>";
            }
        ?>
            <td><?php echo $subdiv[$i]['SubdivTotal']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Total</th>
            <?php
            $dist_total=0;
            for($i = 0; $i < count($poststat); $i++){
                $dist_total+=$poststat[$i]['PostStatTotal'];
            ?>
            <th><?php echo $poststat[$i]['PostStatTotal']; ?></th>
            <?php
            }
            ?>
            <th><?php echo $dist_total; ?></th>
        </tr>
        <tr>
            <th colspan="<?php echo count($poststat) + 2; ?>">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
        </tr>
    </tfoot>
</table>