<?php
session_start();
require("../config/config.php");

$subdiv=$_GET['subdiv'];
$training_venue=$_GET['training_venue'];
$training_date=$_GET['training_date'];
$training_time=$_GET['training_time'];
$training_type=$_GET['training_type'];

$blockmuni_query=$mysqli->prepare("SELECT block_muni.blockminicd, block_muni.blockmuni, COUNT(personnel_training_absent.personcd) FROM (((office INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN block_muni ON office.blockormuni_cd=block_muni.blockminicd) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd) INNER JOIN training_venue ON personnel_training_absent.training_venue = training_venue.venue_cd WHERE office.subdivisioncd = ? AND personnel_training_absent.training_type = ? AND personnel_training_absent.training_date = ? AND personnel_training_absent.training_time = ? AND training_venue.venue_base_name = ? AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) GROUP BY block_muni.blockminicd, block_muni.blockmuni ORDER BY block_muni.blockminicd, block_muni.blockmuni") or die($mysqli->error);
$blockmuni_query->bind_param("sssss",$subdiv,$training_type,$training_date,$training_time,$training_venue) or die($blockmuni_query->error);
$blockmuni_query->execute() or die($blockmuni_query->error);
$blockmuni_query->bind_result($block_muni_code,$block_muni_name,$block_muni_total) or die($blockmuni_query->error);
$blockmuni=array();

while($blockmuni_query->fetch()){
	$blockmuni[]=array("BlockMuniCode"=>$block_muni_code, "BlockMuniName"=>$block_muni_name, "BlockMuniTotal"=>$block_muni_total);
}
$blockmuni_query->close();

$poststat_query=$mysqli->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnel_training_absent.personcd) FROM ((poststat INNER JOIN personnel ON poststat.post_stat=personnel.poststat) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd) INNER JOIN training_venue ON personnel_training_absent.training_venue = training_venue.venue_cd WHERE personnel.subdivisioncd = ? AND personnel_training_absent.training_type = ? AND personnel_training_absent.training_date = ? AND personnel_training_absent.training_time = ? AND training_venue.venue_base_name = ? AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);
$poststat_query->bind_param("sssss",$subdiv,$training_type,$training_date,$training_time,$training_venue) or die($poststat_query->error);
$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();
while($poststat_query->fetch()){
    $poststat[]=array("PostStatCode"=>$post_stat_code, "PostStatName"=>$post_stat_name, "PostStatTotal"=>$post_stat_total);
}
$poststat_query->close();
?>
<table border='1' cellpadding='5' cellspacing='0'>
    <thead>
        <tr>
            <th class="text-center" colspan="<?php echo count($poststat) + 2; ?>">
                Block / Municipality 1st Training Absent Summary (excluding exemptions) for <?php echo $training_venue." on ".date_format(date_create($training_date),"d-M-Y")." at ".$training_time;?>
            </th>
        </tr>
        <tr>
            <th>Block/Municipality Name</th>
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
        $blockmuni_exempt_query=$mysqli->prepare("SELECT block_muni.blockminicd, personnel.poststat, COUNT(personnel_training_absent.personcd) FROM (((office INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN block_muni ON office.blockormuni_cd=block_muni.blockminicd) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd) INNER JOIN training_venue ON personnel_training_absent.training_venue = training_venue.venue_cd WHERE office.subdivisioncd = ? AND personnel_training_absent.training_type = ? AND personnel_training_absent.training_date = ? AND personnel_training_absent.training_time = ? AND training_venue.venue_base_name = ? AND personnel.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) GROUP BY block_muni.blockminicd, personnel.poststat ORDER BY block_muni.blockminicd, personnel.poststat") or die($mysqli->error);
        $blockmuni_exempt_query->bind_param("sssss",$subdiv,$training_type,$training_date,$training_time,$training_venue) or die($blockmuni_exempt_query->error);
        $blockmuni_exempt_query->execute() or die($blockmuni_exempt_query->error);
        $blockmuni_exempt_query->bind_result($block_muni_code,$post_stat_code,$pp_count) or die($blockmuni_exempt_query->error);
        
        $report=array();
        $search_index=array();
        while($blockmuni_exempt_query->fetch()){
            $report[]=array("BlockMuniCode"=>$block_muni_code, "PostStatCode"=>$post_stat_code, "BlockMuniPostTotal"=>$pp_count);
            $search_index[]=array("BlockMuniCode"=>$block_muni_code, "PostStatCode"=>$post_stat_code);
        }
        $blockmuni_exempt_query->close();
        ?>
        <?php
	for($i=0;$i<count($blockmuni);$i++){
        ?>
	<tr>
            <td><?php echo $blockmuni[$i]['BlockMuniName']; ?></td>
        <?php
            for($j=0;$j<count($poststat);$j++){
                $index=array_search(array("BlockMuniCode"=>$blockmuni[$i]['BlockMuniCode'],"PostStatCode"=>$poststat[$j]['PostStatCode']),$search_index);
                if($report[$index]['BlockMuniCode'] == $blockmuni[$i]['BlockMuniCode'] && $report[$index]['PostStatCode'] == $poststat[$j]['PostStatCode']){
                    echo "<td>".$report[$index]['BlockMuniPostTotal']."</td>";
                }
                else
                    echo "<td>0</td>";
            }
        ?>
            <td><?php echo $blockmuni[$i]['BlockMuniTotal']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr class="info">
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
        <tr class="danger">
            <th colspan="<?php echo count($poststat) + 2; ?>">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
        </tr>
    </tfoot>
</table>