<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");
$opt=$_GET['opt'];

if($opt == 'COUNT_PP'){
    $subdiv_query=$mysqli_countppds->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, COUNT(personnela.personcd) FROM subdivision INNER JOIN personnela ON personnela.forsubdivision=subdivision.subdivisioncd WHERE personnela.booked IN ('P','R') GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
    
}
else if($opt == 'COUNT_GRD'){
    $subdiv_query=$mysqli_countgrdppds->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, COUNT(personnela.personcd) FROM subdivision INNER JOIN personnela ON personnela.forsubdivision=subdivision.subdivisioncd WHERE personnela.booked IN ('P','R') GROUP BY subdivision.subdivisioncd, subdivision.subdivision ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
}
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($sub_div_code,$sub_div_name,$sub_div_total) or die($subdiv_query->error);
$subdiv=array();
while($subdiv_query->fetch()){
	$subdiv[]=array("SubdivCode"=>$sub_div_code, "SubdivName"=>$sub_div_name, "SubdivTotal"=>$sub_div_total);
}
$subdiv_query->close();

if($opt == 'COUNT_PP'){
    $poststat_query=$mysqli_countppds->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnela.personcd) FROM poststat INNER JOIN personnela ON poststat.post_stat=personnela.poststat WHERE personnela.booked IN ('P','R') GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);
}
else if($opt == 'COUNT_GRD'){
    $poststat_query=$mysqli_countgrdppds->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnela.personcd) FROM poststat INNER JOIN personnela ON poststat.post_stat=personnela.poststat WHERE personnela.booked IN ('P','R') GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);
}
$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();
?>

<h3>
    Counting Personnel Deployment Summary
</h3>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
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
        </tr>
    </thead>
    <tbody>
        <?php
        if($opt == 'COUNT_PP'){
            $subdiv_booked_query=$mysqli_countppds->prepare("SELECT subdivision.subdivisioncd, personnela.poststat, COUNT(personnela.personcd) FROM subdivision INNER JOIN personnela ON subdivision.subdivisioncd=personnela.forsubdivision WHERE personnela.booked IN ('P','R') GROUP BY subdivision.subdivisioncd, personnela.poststat ORDER BY subdivision.subdivisioncd, personnela.poststat") or die($mysqli->error);
        }
        else if($opt == 'COUNT_GRD'){
            $subdiv_booked_query=$mysqli_countgrdppds->prepare("SELECT subdivision.subdivisioncd, personnela.poststat, COUNT(personnela.personcd) FROM subdivision INNER JOIN personnela ON subdivision.subdivisioncd=personnela.forsubdivision WHERE personnela.booked IN ('P','R') GROUP BY subdivision.subdivisioncd, personnela.poststat ORDER BY subdivision.subdivisioncd, personnela.poststat") or die($mysqli->error);
        }
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
            <td><?php echo $subdiv[$i]['SubdivName']; ?></td>
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