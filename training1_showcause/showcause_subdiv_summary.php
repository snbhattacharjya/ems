<?php
session_start();
require("../config/config.php");
if (!isset($_SESSION['UserID'])) {
    die("Login Expired!. Please Login again to continue");
}
$subdiv_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, COUNT(personnel_training_absent_handson_total.personcd) FROM (subdivision INNER JOIN personnel ON personnel.subdivisioncd=subdivision.subdivisioncd) INNER JOIN personnel_training_absent_handson_total ON personnel.personcd = personnel_training_absent_handson_total.personcd AND personnel.poststat IN ('PR','P1') WHERE personnel_training_absent_handson_total.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($sub_div_code, $sub_div_name, $sub_div_total) or die($subdiv_query->error);
$subdiv=array();
while ($subdiv_query->fetch()) {
    $subdiv[]=array("SubdivCode"=>$sub_div_code, "SubdivName"=>$sub_div_name, "SubdivTotal"=>$sub_div_total);
}
$subdiv_query->close();

$poststat_query=$mysqli->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnel_training_absent_handson_total.personcd) FROM (poststat INNER JOIN personnel ON poststat.post_stat=personnel.poststat) INNER JOIN personnel_training_absent_handson_total ON personnel.personcd = personnel_training_absent_handson_total.personcd AND personnel.poststat IN ('PR','P1') WHERE personnel_training_absent_handson_total.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);

$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code, $post_stat_name, $post_stat_total) or die($poststat_query->error);
$poststat=array();
while ($poststat_query->fetch()) {
    $poststat[]=array("PostStatCode"=>$post_stat_code, "PostStatName"=>$post_stat_name, "PostStatTotal"=>$post_stat_total);
}
$poststat_query->close();
?>
<div class="text-right margin-bottom">
    <a class="btn btn-default btn-md" href="training1_showcause/showcause_subdiv_summary_print.php" target="_blank">
        <i class="fa fa-print text-red"></i> Print Summary
    </a>
</div>
<table id="subdiv_exempt_summary" class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="success">
            <th class="text-center" colspan="<?php echo count($poststat) + 3; ?>">
                Subdivision wise Show Cause Summary for 1st Training
            </th>
        </tr>
        <tr class="bg-light-blue-gradient">
            <th>Subdivision Name</th>
            <?php
            for ($i = 0; $i < count($poststat); $i++) {
                ?>
            <th><?php echo $poststat[$i]['PostStatCode']." - ".$poststat[$i]['PostStatName']; ?></th>
            <?php
            }
            ?>
            <th>Total</th>
            <th>Show Cause Letter</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $subdiv_exempt_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, personnel.poststat, COUNT(personnel_training_absent_handson_total.personcd) FROM (subdivision INNER JOIN personnel ON subdivision.subdivisioncd=personnel.subdivisioncd) INNER JOIN personnel_training_absent_handson_total ON personnel.personcd=personnel_training_absent_handson_total.personcd AND personnel.poststat IN ('PR','P1') WHERE personnel_training_absent_handson_total.personcd NOT IN (SELECT personcd FROM personnel_exempt_post_random) GROUP BY subdivision.subdivisioncd, personnel.poststat ORDER BY subdivision.subdivisioncd, personnel.poststat") or die($mysqli->error);
        $subdiv_exempt_query->execute() or die($subdiv_exempt_query->error);
        $subdiv_exempt_query->bind_result($sub_div_code, $post_stat_code, $pp_count) or die($subdiv_exempt_query->error);

        $report=array();
        $search_index=array();
        while ($subdiv_exempt_query->fetch()) {
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
            <td class="text-center"><a href="training1_showcause/showcause_letter_print.php?type=subdiv&subdiv=<?php echo $subdiv[$i]['SubdivCode']; ?>&training_type=01" class="btn btn-sm btn-default text-maroon" target="_blank"><i class="fa fa-print"></i></a></td>
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
            for ($i = 0; $i < count($poststat); $i++) {
                $dist_total+=$poststat[$i]['PostStatTotal']; ?>
            <th><?php echo $poststat[$i]['PostStatTotal']; ?></th>
            <?php
            }
            ?>
            <th><?php echo $dist_total; ?></th>
            <th>&nbsp;</th>
        </tr>
        <tr class="danger">
            <th colspan="<?php echo count($poststat) + 3; ?>">
                <?php
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A");
                ?>
            </th>
        </tr>
    </tfoot>
</table>
<script>
    $('.blockmuni-report-btn').click(function(e){
        e.preventDefault();
        var subdiv=$(this).attr('data-subdiv').valueOf().toString();
        loadBlockMuniShowCauseSummary(subdiv);
    });

    function loadBlockMuniShowCauseSummary(subdiv){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "training1_showcause/showcause_blockmuni_summary.php",
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
