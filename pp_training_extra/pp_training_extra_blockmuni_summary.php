<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");

if(!isset($_POST['subdiv']))
    $subdiv_param=$_SESSION['Subdiv'];
else
    $subdiv_param=$_POST['subdiv'];

$blockmuni_query=$mysqli->prepare("SELECT block_muni.blockminicd, block_muni.blockmuni, COUNT(personnel_extra.personcd) FROM (office INNER JOIN personnel_extra ON office.officecd=personnel_extra.officecd) INNER JOIN block_muni ON office.blockormuni_cd=block_muni.blockminicd WHERE office.subdivisioncd = ? AND personnel_extra.poststat IN ('PR','P1','P2','P3','PA') AND personnel_extra.booked IN ('P','R') GROUP BY block_muni.blockminicd, block_muni.blockmuni ORDER BY block_muni.blockminicd, block_muni.blockmuni") or die($mysqli->error);
$blockmuni_query->bind_param("s",$subdiv_param) or die($blockmuni_query->error);
$blockmuni_query->execute() or die($blockmuni_query->error);
$blockmuni_query->bind_result($block_muni_code,$block_muni_name,$block_muni_total) or die($blockmuni_query->error);
$blockmuni=array();

while($blockmuni_query->fetch()){
	$blockmuni[]=array("BlockMuniCode"=>$block_muni_code, "BlockMuniName"=>$block_muni_name, "BlockMuniTotal"=>$block_muni_total);
}
$blockmuni_query->close();

$poststat_query=$mysqli->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnel_extra.personcd) FROM poststat INNER JOIN personnel_extra ON poststat.post_stat=personnel_extra.poststat WHERE personnel_extra.poststat IN ('PR','P1','P2','P3','PA') AND personnel_extra.booked IN ('P','R') AND personnel_extra.subdivisioncd = ? GROUP BY poststat.poststat_order, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);
$poststat_query->bind_param("s",$subdiv_param) or die($poststat_query->error);
$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();
?>
<div class="text-center margin-bottom">
    <a class="btn btn-default btn-md" href="pp_training_extra/pp_training_extra_blockmuni_summary_print.php?subdiv=<?php echo $subdiv_param; ?>" target="_blank">
        <i class="fa fa-print text-red"></i> Print Summary
    </a>
</div>
<table id="blockmuni_exempt_summary" class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="bg-light-blue-gradient">
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
            <th>1st Appointment Letter</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $blockmuni_booked_query=$mysqli->prepare("SELECT block_muni.blockminicd, personnel_extra.poststat, COUNT(personnel_extra.personcd) FROM (office INNER JOIN personnel_extra ON office.officecd=personnel_extra.officecd) INNER JOIN block_muni ON office.blockormuni_cd=block_muni.blockminicd WHERE office.subdivisioncd = ? AND personnel_extra.poststat IN ('PR','P1','P2','P3','PA') AND personnel_extra.booked IN ('P','R') GROUP BY block_muni.blockminicd, personnel_extra.poststat ORDER BY block_muni.blockminicd, personnel_extra.poststat") or die($mysqli->error);
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
            <td><?php echo "<a href='#' data-subdiv='".$subdiv_param."' data-blockmuni='".$blockmuni[$i]['BlockMuniCode']."' class='office-pp-report-btn text-bold text-green'>".$blockmuni[$i]['BlockMuniName']."</a>"; ?></td>
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
            <td class="text-center"><a href="pp_training_extra/first_appt_letter_blockmuni_extra.php?block_muni_code=<?php echo $blockmuni[$i]['BlockMuniCode']; ?>" class="btn btn-default btn-sm text-red" target="_blank"><i class="fa fa-print"></i></a></td>
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
<div>
    <a class="btn btn-default btn-md subdiv-summary">
        <i class="fa fa-arrow-circle-left text-red"></i> Back
    </a>
</div>
<script>
    $('.office-pp-report-btn').click(function(e){
        e.preventDefault();
        var subdiv=$(this).attr('data-subdiv').valueOf().toString();
        var blockmuni=$(this).attr('data-blockmuni').valueOf().toString();
        loadOfficePPExtraSummary(subdiv, blockmuni);
    });

    $('.subdiv-summary').click(function(e){
        e.preventDefault();
        loadSubdivPPExtraBookedSummary();
    });

    function loadSubdivPPExtraBookedSummary(){
        $('.ajax-result').empty();
        $('.ajax-loader').show();
        //var data_target=$(this).attr('data-target').valueOf().toString();
        $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "pp_training_extra/pp_training_extra_subdiv_summary.php",
                //type: "POST",
                //data: {
                    //target_url: data_target
                //},
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

    function loadOfficePPExtraSummary(subdiv, blockmuni){
        $('.ajax-result').empty();
        $('.ajax-loader').show();
        $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "pp_training_extra/pp_training_extra_office_summary.php",
                type: "POST",
                data: {
                    subdiv: subdiv,
                    blockmuni: blockmuni
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
