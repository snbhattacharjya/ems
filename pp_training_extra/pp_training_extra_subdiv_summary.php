<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");

$subdiv_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, COUNT(personnel_extra.personcd) FROM subdivision INNER JOIN personnel_extra ON personnel_extra.subdivisioncd=subdivision.subdivisioncd WHERE subdivision.subdivisioncd != '9999' AND personnel_extra.poststat IN ('PR','P1','P2','P3','PA') AND personnel_extra.booked IN ('P','R') GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($sub_div_code,$sub_div_name,$sub_div_total) or die($subdiv_query->error);
$subdiv=array();
while($subdiv_query->fetch()){
	$subdiv[]=array("SubdivCode"=>$sub_div_code, "SubdivName"=>$sub_div_name, "SubdivTotal"=>$sub_div_total);
}
$subdiv_query->close();

$poststat_query=$mysqli->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnel_extra.personcd) FROM poststat INNER JOIN personnel_extra ON poststat.post_stat=personnel_extra.poststat WHERE personnel_extra.poststat IN ('PR','P1','P2','P3','PA') AND personnel_extra.booked IN ('P','R') GROUP BY poststat.poststat_order, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);

$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();
?>
<div class="text-center margin-bottom">
    <a class="btn btn-md btn-flat btn-default text-red" href="pp_training_extra/pp_training_extra_subdiv_summary_print.php" target="_blank"><i class="fa fa-print"></i> Print</a>
</div>
<table id="subdiv_booked_summary" class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="bg-light-blue-gradient">
            <th>Subdivision Name</th>
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
            <th>1st Appointment Letter</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $subdiv_booked_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, personnel_extra.poststat, COUNT(personnel_extra.personcd) FROM subdivision INNER JOIN personnel_extra ON subdivision.subdivisioncd=personnel_extra.subdivisioncd WHERE personnel_extra.poststat IN ('PR','P1','P2','P3','PA') AND personnel_extra.booked IN ('P','R') GROUP BY subdivision.subdivisioncd, personnel_extra.poststat ORDER BY subdivision.subdivisioncd, personnel_extra.poststat") or die($mysqli->error);
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
            <td class="text-center"><a href="pp_training_extra/first_appt_letter_subdiv_extra.php?subdiv_code=<?php echo $subdiv[$i]['SubdivCode']; ?>" class="btn btn-default btn-sm text-red" target="_blank"><i class="fa fa-print"></i></a></td>
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
            <th>&nbsp;</th>
        </tr>
        <tr class="danger">
            <th colspan="<?php echo count($poststat) + 3; ?>">
                <?php
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A");
                ?>
            </th>
    </tfoot>
</table>
<script>
    $('.blockmuni-report-btn').click(function(e){
        e.preventDefault();
        var subdiv=$(this).attr('data-subdiv').valueOf().toString();
        loadBlockMuniExtraSummary(subdiv);
    });

    function loadBlockMuniExtraSummary(subdiv){
        $('.ajax-result').empty();
        $('.ajax-loader').show();
        $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "pp_training_extra/pp_training_extra_blockmuni_summary.php",
                type: "POST",
                data: {
                    subdiv: subdiv
                },
                success: function(data) {
                    $('.ajax-loader').hide();
                    $('.ajax-result').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "html",
                async: false
            });
        }
</script>
