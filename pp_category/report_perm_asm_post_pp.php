<?php
session_start();
require("../config/config.php");

$perm_asm_query=$mysqli->prepare("SELECT assembly.assemblycd, assembly.assemblyname, COUNT(personnel.personcd) FROM assembly LEFT JOIN personnel ON personnel.assembly_perm=assembly.assemblycd GROUP BY assembly.assemblycd, assembly.assemblyname ORDER BY assembly.assemblycd, assembly.assemblyname") or die($mysqli->error);
$perm_asm_query->execute() or die($perm_asm_query->error);
$perm_asm_query->bind_result($perm_asm_code,$perm_asm_name,$perm_asm_total) or die($perm_asm_query->error);
$perm_arm=array();
while($perm_asm_query->fetch()){
	$perm_asm[]=array("PermAsmCode"=>$perm_asm_code, "PermAsmName"=>$perm_asm_name, "PermAsmTotal"=>$perm_asm_total);
}
$perm_asm_query->close();

$poststat_query=$mysqli->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnel.personcd) FROM poststat INNER JOIN personnel ON poststat.post_stat=personnel.poststat WHERE poststat.post_stat != '' GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);

$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();
?>
<table id="perm_asm_pp_summary" class="table table-bordered table-condensed table-striped small">
    <thead>
        <tr class="bg-light-blue-gradient">
            <th>Assembly Name</th>
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
        $perm_asm_pp_query=$mysqli->prepare("SELECT personnel.assembly_perm, personnel.poststat, COUNT(*) FROM personnel GROUP BY personnel.assembly_perm, personnel.poststat ORDER BY personnel.assembly_perm, personnel.poststat") or die($mysqli->error);
        $perm_asm_pp_query->execute() or die($perm_asm_pp_query->error);
        $perm_asm_pp_query->bind_result($pp_perm_asm_code,$post_stat_code,$pp_count) or die($perm_asm_pp_query->error);
        
        $report=array();
        $search_index=array();
        while($perm_asm_pp_query->fetch()){
            $report[]=array("PermAsmCode"=>$pp_perm_asm_code, "PostStatCode"=>$post_stat_code, "PermAsmPostTotal"=>$pp_count);
            $search_index[]=array("PermAsmCode"=>$pp_perm_asm_code, "PostStatCode"=>$post_stat_code);
        }
        ?>
        <?php
	for($i=0;$i<count($perm_asm);$i++){
        ?>
	<tr>
            <td><?php echo $perm_asm[$i]['PermAsmCode'].' - '.$perm_asm[$i]['PermAsmName']; ?></td>
        <?php
            for($j=0;$j<count($poststat);$j++){
                $index=array_search(array("PermAsmCode"=>$perm_asm[$i]['PermAsmCode'],"PostStatCode"=>$poststat[$j]['PostStatCode']),$search_index);
                if($report[$index]['PermAsmCode'] == $perm_asm[$i]['PermAsmCode'] && $report[$index]['PostStatCode'] == $poststat[$j]['PostStatCode']){
                    echo "<td>".$report[$index]['PermAsmPostTotal']."</td>";
                }
                else
                    echo "<td>0</td>";
            }
        ?>
            <td><?php echo $perm_asm[$i]['PermAsmTotal']; ?></td>
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
    </tfoot>
</table>