<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$subdiv_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, COUNT(personnel.personcd) FROM subdivision INNER JOIN personnel ON personnel.subdivisioncd=subdivision.subdivisioncd WHERE subdivision.subdivisioncd != '9999' AND personnel.poststat NOT IN ('','MO') AND personnel.gender = 'M' AND personnel.status = 'Y' GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($sub_div_code, $sub_div_name, $sub_div_total) or die($subdiv_query->error);
$subdiv=array();
while ($subdiv_query->fetch()) {
    $subdiv[]=array("SubdivCode"=>$sub_div_code, "SubdivName"=>$sub_div_name, "SubdivTotal"=>$sub_div_total);
}
$subdiv_query->close();

$poststat_query=$mysqli->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnel.personcd) FROM poststat INNER JOIN personnel ON poststat.post_stat=personnel.poststat WHERE personnel.poststat NOT IN ('','MO') AND personnel.gender = 'M' AND personnel.status = 'Y' GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);

$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code, $post_stat_name, $post_stat_total) or die($poststat_query->error);
$poststat=array();
?>
<h3>Net Polling Personnel Availibility Report</h3>
<table id="subdiv_booked_summary" class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="bg-light-blue-gradient">
            <th>Subdivision Name</th>
            <?php
            while ($poststat_query->fetch()) {
                $poststat[]=array("PostStatCode"=>$post_stat_code, "PostStatName"=>$post_stat_name, "PostStatTotal"=>$post_stat_total); ?>
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
        $subdiv_booked_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, personnel.poststat, COUNT(personnel.personcd) FROM subdivision INNER JOIN personnel ON subdivision.subdivisioncd=personnel.subdivisioncd WHERE personnel.poststat NOT IN ('','MO') AND personnel.gender = 'M' AND personnel.status = 'Y' GROUP BY subdivision.subdivisioncd, personnel.poststat ORDER BY subdivision.subdivisioncd, personnel.poststat") or die($mysqli->error);
        $subdiv_booked_query->execute() or die($subdiv_booked_query->error);
        $subdiv_booked_query->bind_result($sub_div_code, $post_stat_code, $pp_count) or die($subdiv_booked_query->error);
        
        $report=array();
        $search_index=array();
        while ($subdiv_booked_query->fetch()) {
            $report[]=array("SubdivCode"=>$sub_div_code, "PostStatCode"=>$post_stat_code, "SubdivPostTotal"=>$pp_count);
            $search_index[]=array("SubdivCode"=>$sub_div_code, "PostStatCode"=>$post_stat_code);
        }
        ?>
        <?php
    for ($i=0;$i<count($subdiv);$i++) {
        ?>
	<tr>
            <td><?php echo "<a href='#' data-subdiv='".$subdiv[$i]['SubdivCode']."' class='blockmuni-report-btn text-bold text-green'>".$subdiv[$i]['SubdivName']."</a>"; ?></td>
        <?php
            for ($j=0;$j<count($poststat);$j++) {
                $index=array_search(array("SubdivCode"=>$subdiv[$i]['SubdivCode'],"PostStatCode"=>$poststat[$j]['PostStatCode']), $search_index);
                if ($report[$index]['SubdivCode'] == $subdiv[$i]['SubdivCode'] && $report[$index]['PostStatCode'] == $poststat[$j]['PostStatCode']) {
                    echo "<td>".$report[$index]['SubdivPostTotal']."</td>";
                } else {
                    echo "<td>0</td>";
                }
            } ?>
            <td><?php echo $subdiv[$i]['SubdivTotal']; ?></td>
        </tr>
        <?php
    }
        ?>
    </tbody>
    <tfoot>
        <tr class="success">
            <th>Total</th>
            <?php
            $dist_total=0;
            for ($i = 0; $i < count($poststat); $i++) {
                $dist_total+=$poststat[$i]['PostStatTotal']; ?>
            <th><?php echo $poststat[$i]['PostStatTotal']; ?></th>
            <?php
            }
            ?>
            <th><?php echo $dist_total; ?></th>
        </tr>
        <tr class="warning">
            <th>% on requirement</th>
            <?php
            
            for ($i = 0; $i < count($poststat); $i++) {
                ?>
            <th><?php echo round(($poststat[$i]['PostStatTotal'] / 5195) * 100); ?></th>
            <?php
            }
            ?>
            <th>&nbsp;</th>
        </tr>
        <tr class="danger">
            <th colspan="<?php echo count($poststat) + 2; ?>">
                <?php
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A")."; <i>The Figures indicated above may change subject to approved exemption from the appropriate authority.</i>";
                ?>
            </th>
    </tfoot>
</table>

<?php
/*$subdiv_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, COUNT(personnel.personcd) FROM subdivision INNER JOIN personnel ON personnel.subdivisioncd=subdivision.subdivisioncd WHERE subdivision.subdivisioncd != '9999' AND personnel.poststat !='' AND personnel.gender = 'F' GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($sub_div_code,$sub_div_name,$sub_div_total) or die($subdiv_query->error);
$subdiv=array();
while($subdiv_query->fetch()){
    $subdiv[]=array("SubdivCode"=>$sub_div_code, "SubdivName"=>$sub_div_name, "SubdivTotal"=>$sub_div_total);
}
$subdiv_query->close();

$poststat_query=$mysqli->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnel.personcd) FROM poststat INNER JOIN personnel ON poststat.post_stat=personnel.poststat WHERE personnel.poststat != '' AND personnel.gender = 'F' GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);

$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();*/
?>
<!-- <h3>Female Report</h3>
<table id="subdiv_booked_summary" class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="bg-light-blue-gradient">
            <th>Subdivision Name</th>
            <?php /*
            while($poststat_query->fetch()){
                $poststat[]=array("PostStatCode"=>$post_stat_code, "PostStatName"=>$post_stat_name, "PostStatTotal"=>$post_stat_total);
            ?>
            <th><?php echo $post_stat_code.' - '.$post_stat_name; ?></th>
            <?php
            }
            $poststat_query->close(); */
            ?>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php /*
        $subdiv_booked_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, personnel.poststat, COUNT(personnel.personcd) FROM subdivision INNER JOIN personnel ON subdivision.subdivisioncd=personnel.subdivisioncd WHERE personnel.poststat != '' AND personnel.gender = 'F' GROUP BY subdivision.subdivisioncd, personnel.poststat ORDER BY subdivision.subdivisioncd, personnel.poststat") or die($mysqli->error);
        $subdiv_booked_query->execute() or die($subdiv_booked_query->error);
        $subdiv_booked_query->bind_result($sub_div_code,$post_stat_code,$pp_count) or die($subdiv_booked_query->error);

        $report=array();
        $search_index=array();
        while($subdiv_booked_query->fetch()){
            $report[]=array("SubdivCode"=>$sub_div_code, "PostStatCode"=>$post_stat_code, "SubdivPostTotal"=>$pp_count);
            $search_index[]=array("SubdivCode"=>$sub_div_code, "PostStatCode"=>$post_stat_code);
        }
        ?>
        <?php
    for($i=0;$i<count($subdiv);$i++){
        ?>
    <tr>
            <td><?php echo "<a href='#' data-subdiv='".$subdiv[$i]['SubdivCode']."' class='blockmuni-report-btn text-bold text-green'>".$subdiv[$i]['SubdivName']."</a>"; ?></td>
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
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A")."; <i>The Figures indicated above may change subject to first randomisation and approved exemption from the appropriate authority.</i>";
               */ ?>
            </th>
    </tfoot>
</table> -->
<script>
       
    
</script>