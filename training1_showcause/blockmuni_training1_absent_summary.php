<?php
session_start();
require("../config/config.php");

$subdiv_param=$_POST['subdiv'];

$blockmuni_query=$mysqli->prepare("SELECT block_muni.blockminicd, block_muni.blockmuni, COUNT(personnel_training_absent.personcd) FROM ((office INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN block_muni ON office.blockormuni_cd=block_muni.blockminicd) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd WHERE office.subdivisioncd = ? GROUP BY block_muni.blockminicd, block_muni.blockmuni ORDER BY block_muni.blockminicd, block_muni.blockmuni") or die($mysqli->error);
$blockmuni_query->bind_param("s",$subdiv_param) or die($blockmuni_query->error);
$blockmuni_query->execute() or die($blockmuni_query->error);
$blockmuni_query->bind_result($block_muni_code,$block_muni_name,$block_muni_total) or die($blockmuni_query->error);
$blockmuni=array();

while($blockmuni_query->fetch()){
	$blockmuni[]=array("BlockMuniCode"=>$block_muni_code, "BlockMuniName"=>$block_muni_name, "BlockMuniTotal"=>$block_muni_total);
}
$blockmuni_query->close();

$poststat_query=$mysqli->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnel_training_absent.personcd) FROM (poststat INNER JOIN personnel ON poststat.post_stat=personnel.poststat) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd WHERE personnel.subdivisioncd = ? GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);
$poststat_query->bind_param("s",$subdiv_param) or die($poststat_query->error);
$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();
while($poststat_query->fetch()){
    $poststat[]=array("PostStatCode"=>$post_stat_code, "PostStatName"=>$post_stat_name, "PostStatTotal"=>$post_stat_total);
}
$poststat_query->close();
?>
<div class="text-right margin-bottom">
    <a class="btn btn-default btn-md" href="pp_training/pp_training_office_summary_print.php?blockmuni=<?php echo $blockmuni_param; ?>" target="_blank">
        <i class="fa fa-print text-red"></i> Print Summary
    </a>
</div>
<table id="blockmuni_exempt_summary" class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="success">
            <th class="text-center" colspan="<?php echo count($poststat) + 2; ?>">
                Block / Municipality Absent Summary
            </th>
        </tr>
        <tr class="bg-light-blue-gradient">
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
        $blockmuni_exempt_query=$mysqli->prepare("SELECT block_muni.blockminicd, personnel.poststat, COUNT(personnel_training_absent.personcd) FROM ((office INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN block_muni ON office.blockormuni_cd=block_muni.blockminicd) INNER JOIN personnel_training_absent ON personnel.personcd = personnel_training_absent.personcd WHERE office.subdivisioncd = ? GROUP BY block_muni.blockminicd, personnel.poststat ORDER BY block_muni.blockminicd, personnel.poststat") or die($mysqli->error);
        $blockmuni_exempt_query->bind_param("s",$subdiv_param) or die($blockmuni_exempt_query->error);
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
        loadOfficeAbsentSummary(subdiv, blockmuni);
    });
    
    $('.subdiv-summary').click(function(e){
        e.preventDefault();
        loadSubdivAbsentSummary();
    });
    
    function loadSubdivAbsentSummary(){
        $('#ajax-result').empty();
        $('.ajax-loader').show();
        $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "training1_showcause/subdiv_training1_absent_summary.php",
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
    
    function loadOfficeAbsentSummary(subdiv, blockmuni){
        $('#ajax-result').empty();
        $('.ajax-loader').show();
        $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "training1_showcause/office_training1_absent_summary.php",
                type: "POST",
                data: {
                    subdiv: subdiv,
                    blockmuni: blockmuni
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