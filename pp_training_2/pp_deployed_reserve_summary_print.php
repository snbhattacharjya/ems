<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");

$assembly_query=$mysqli->prepare("SELECT assembly.assemblycd, assembly.assemblyname, COUNT(personnel.personcd) FROM assembly INNER JOIN personnel ON assembly.assemblycd = personnel.forassembly WHERE personnel.poststat IN ('PR','P1','P2','P3','PA') AND personnel.booked = 'R' AND personnel.forassembly != '' AND personnel.groupid != 0 GROUP BY assembly.assemblycd, assembly.assemblyname ORDER BY assembly.assemblycd, assembly.assemblyname") or die($mysqli->error);
//$assembly_query->bind_param("s",$subdiv_param) or die($assembly_query->error);
$assembly_query->execute() or die($assembly_query->error);
$assembly_query->bind_result($assembly_code,$assembly_name,$reserve_total) or die($assembly_query->error);
$assembly_reserve=array();

while($assembly_query->fetch()){
	$assembly_reserve[]=array("AssemblyCode"=>$assembly_code, "AssemblyName"=>$assembly_name, "ReserveTotal"=>$reserve_total);
}
$assembly_query->close();

$poststat_query=$mysqli->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnel.personcd) FROM poststat INNER JOIN personnel ON poststat.post_stat=personnel.poststat WHERE personnel.poststat IN ('PR','P1','P2','P3','PA') AND personnel.booked = 'R' AND personnel.forassembly != '' AND personnel.groupid != 0 GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.poststat_order, poststat.poststatus") or die($mysqli->error);
//$poststat_query->bind_param("s",$subdiv_param) or die($poststat_query->error);
$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();
?>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr class="bg-light-blue-gradient">
            <th>Sl No.</th>
            <th>Deployed Constituency Name</th>
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
        $assembly_reserve_query=$mysqli->prepare("SELECT assembly.assemblycd, personnel.poststat, COUNT(personnel.personcd) FROM assembly INNER JOIN personnel ON assembly.assemblycd=personnel.forassembly WHERE personnel.poststat IN ('PR','P1','P2','P3','PA') AND personnel.booked = 'R' AND personnel.forassembly != '' AND personnel.groupid != 0 GROUP BY assembly.assemblycd, personnel.poststat ORDER BY assembly.assemblycd, personnel.poststat") or die($mysqli->error);
        //$assembly_reserve_query->bind_param("s",$subdiv_param) or die($assembly_reserve_query->error);
        $assembly_reserve_query->execute() or die($assembly_reserve_query->error);
        $assembly_reserve_query->bind_result($assembly_code,$post_stat_code,$pp_count) or die($assembly_reserve_query->error);

        $report=array();
        $search_index=array();
        while($assembly_reserve_query->fetch()){
            $report[]=array("AssemblyCode"=>$assembly_code, "PostStatCode"=>$post_stat_code, "AssemblyPostTotal"=>$pp_count);
            $search_index[]=array("AssemblyCode"=>$assembly_code, "PostStatCode"=>$post_stat_code);
        }
        $assembly_reserve_query->close();
        ?>
        <?php
	for($i=0;$i<count($assembly_reserve);$i++){
        ?>
	<tr>
            <td><?php echo $i + 1; ?></td>
            <td><?php echo $assembly_reserve[$i]['AssemblyName']."</a>"; ?></td>
        <?php
            for($j=0;$j<count($poststat);$j++){
                $index=array_search(array("AssemblyCode"=>$assembly_reserve[$i]['AssemblyCode'],"PostStatCode"=>$poststat[$j]['PostStatCode']),$search_index);
                if($report[$index]['AssemblyCode'] == $assembly_reserve[$i]['AssemblyCode'] && $report[$index]['PostStatCode'] == $poststat[$j]['PostStatCode']){
                    echo "<td>".$report[$index]['AssemblyPostTotal']."</td>";
                }
                else
                    echo "<td>0</td>";
            }
        ?>
            <td><?php echo $assembly_reserve[$i]['ReserveTotal']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr class="info">
            <th colspan="2">Total</th>
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
            <th colspan="<?php echo count($poststat) + 3; ?>">
                <?php
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A");
                ?>
            </th>
    </tfoot>
</table>

<script>


</script>
