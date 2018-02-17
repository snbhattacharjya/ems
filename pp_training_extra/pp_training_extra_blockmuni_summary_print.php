<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");

$subdiv_param=$_GET['subdiv'];

$blockmuni_query=$mysqli->prepare("SELECT block_muni.blockminicd, block_muni.blockmuni, COUNT(personnel_extra.personcd) FROM (office INNER JOIN personnel_extra ON office.officecd=personnel_extra.officecd) INNER JOIN block_muni ON office.blockormuni_cd=block_muni.blockminicd WHERE office.subdivisioncd = ? AND personnel_extra.poststat IN ('PR','P1','P2','P3') AND personnel_extra.booked IN ('P','R') GROUP BY block_muni.blockminicd, block_muni.blockmuni ORDER BY block_muni.blockminicd, block_muni.blockmuni") or die($mysqli->error);
$blockmuni_query->bind_param("s",$subdiv_param) or die($blockmuni_query->error);
$blockmuni_query->execute() or die($blockmuni_query->error);
$blockmuni_query->bind_result($block_muni_code,$block_muni_name,$block_muni_total) or die($blockmuni_query->error);
$blockmuni=array();

while($blockmuni_query->fetch()){
	$blockmuni[]=array("BlockMuniCode"=>$block_muni_code, "BlockMuniName"=>$block_muni_name, "BlockMuniTotal"=>$block_muni_total);
}
$blockmuni_query->close();

$poststat_query=$mysqli->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnel_extra.personcd) FROM poststat INNER JOIN personnel_extra ON poststat.post_stat=personnel_extra.poststat WHERE personnel_extra.poststat IN ('PR','P1','P2','P3') AND personnel_extra.booked IN ('P','R') AND personnel_extra.subdivisioncd = ? GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);
$poststat_query->bind_param("s",$subdiv_param) or die($poststat_query->error);
$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();
?>
<title>Appointment Blockmuni Summary Print</title>
<h3>
    Block / Municipality wise Extra PP Summary
</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Block/Municipality Name</th>
            <?php
            while($poststat_query->fetch()){
                $poststat[]=array("PostStatCode"=>$post_stat_code, "PostStatName"=>$post_stat_name, "PostStatTotal"=>$post_stat_total);
            ?>
            <th><?php echo $post_stat_code.' - '.$post_stat_name; ?></th>
            <?php
            }
            $poststat_query->close();
            ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $blockmuni_booked_query=$mysqli->prepare("SELECT block_muni.blockminicd, personnel_extra.poststat, COUNT(personnel_extra.personcd) FROM (office INNER JOIN personnel_extra ON office.officecd=personnel_extra.officecd) INNER JOIN block_muni ON office.blockormuni_cd=block_muni.blockminicd WHERE office.subdivisioncd = ? AND personnel_extra.poststat IN ('PR','P1','P2','P3') AND personnel_extra.booked IN ('P','R') GROUP BY block_muni.blockminicd, personnel_extra.poststat ORDER BY block_muni.blockminicd, personnel_extra.poststat") or die($mysqli->error);
        $blockmuni_booked_query->bind_param("s",$subdiv_param) or die($blockmuni_booked_query->error);
        $blockmuni_booked_query->execute() or die($blockmuni_booked_query->error);
        $blockmuni_booked_query->bind_result($block_muni_code,$post_stat_code,$pp_count) or die($blockmuni_booked_query->error);
        
        $report=array();
        $search_index=array();
        while($blockmuni_booked_query->fetch()){
            $report[]=array("BlockMuniCode"=>$block_muni_code, "PostStatCode"=>$post_stat_code, "BlockMuniPostTotal"=>$pp_count);
            $search_index[]=array("BlockMuniCode"=>$block_muni_code, "PostStatCode"=>$post_stat_code);
        }
        $blockmuni_booked_query->close();
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
    </tfoot>
</table>