<?php
session_start();
require("../config/config.php");
$target_url=$_POST['target_url'];

$blockmuni_query=$mysqli_ppds->prepare("SELECT block_muni.blockminicd, block_muni.blockmuni, COUNT(personnela.personcd) FROM (office INNER JOIN personnela ON office.officecd=personnela.officecd) INNER JOIN block_muni ON office.blockormuni_cd=block_muni.blockminicd WHERE personnela.poststat IN ('PR','P1','P2','P3') AND personnela.booked IN ('P','R','C') GROUP BY block_muni.blockminicd, block_muni.blockmuni ORDER BY block_muni.blockminicd, block_muni.blockmuni") or die($mysqli_ppds->error);

$blockmuni_query->execute() or die($blockmuni_query->error);
$blockmuni_query->bind_result($block_muni_code,$block_muni_name,$block_muni_total) or die($blockmuni_query->error);
$blockmuni=array();

while($blockmuni_query->fetch()){
	$blockmuni[]=array("BlockMuniCode"=>$block_muni_code, "BlockMuniName"=>$block_muni_name, "BlockMuniTotal"=>$block_muni_total);
}
$blockmuni_query->close();

$poststat_query=$mysqli_ppds->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnela.personcd) FROM poststat INNER JOIN personnela ON poststat.post_stat=personnela.poststat WHERE personnela.poststat IN ('PR','P1','P2','P3') AND personnela.booked IN ('P','R','C') GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli_ppds->error);
$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();
?>
<span class="target-url" style="display: none">
    <?php echo $target_url; ?>
</span>
<table id="blockmuni_booked_summary" class="table table-bordered table-condensed table-hover small">
    <thead>
        <tr class="bg-black-gradient">
            <th>Block/Municipality Code</th>
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
            <th>Progress</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $blockmuni_booked_query=$mysqli_ppds->prepare("SELECT block_muni.blockminicd, personnela.poststat, COUNT(personnela.personcd) FROM (office INNER JOIN personnela ON office.officecd=personnela.officecd) INNER JOIN block_muni ON office.blockormuni_cd=block_muni.blockminicd WHERE personnela.poststat IN ('PR','P1','P2','P3') AND personnela.booked IN ('P','R','C') GROUP BY block_muni.blockminicd, personnela.poststat ORDER BY block_muni.blockminicd, personnela.poststat") or die($mysqli_ppds->error);
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
            <td class="blockormuni_cd"><?php echo $blockmuni[$i]['BlockMuniCode']; ?></td>
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
            <td class="progress text-center">&nbsp;</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr class="info">
            <th colspan="2" class="text-center">Total</th>
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
            <th colspan="<?php echo count($poststat) + 4; ?>">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
    </tfoot>
</table>
<script>
$(function(){
    var rows=$('#blockmuni_booked_summary tbody').find('tr');
    $.each(rows,function(){
        var row=$(this);
        $(row).addClass('warning');
        var block_muni_code=$(row).find('.blockormuni_cd').html().toString();
        var target_url=$('.target-url').html().toString();
        $(row).find('.progress').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
        var result;
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "data_transfer/ppds_pp_booked_blockmuni.php",
            type: "POST",
            data: {
                blockmuni : block_muni_code
            },
            success: function(data) {
                result=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
	});
        var update_count=1;
        $.each(result,function(i){
            var update_result;
            $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: target_url,
                type: "POST",
                data: {
                    personcd: result[i].personcd,
                    forassembly : result[i].forassembly,
                    booked: result[i].booked,
                    training1_sch: result[i].training1_sch
                },
                success: function(data) {
                    update_result=JSON.parse(JSON.stringify(data));
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "json",
                async: false
            });
            if(update_result.Status  == 'Success'){
                $(row).find('.progress').html("<span class='text-bold text-center'>"+update_count+"</span>");
                update_count+=1;
            }
        });
        $(row).removeClass('warning').addClass('success');
        if((update_count - 1) == result.length)
            $(row).find('.progress').append(" <i class='fa fa-check-square text-blue'></i>");
        else
            $(row).find('.progress').append(" <i class='fa fa-warning text-red'></i>");
    });
});
</script>