<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");

$opt=$_GET['opt'];
$subdiv=$_GET['subdiv'];

if($opt == 'COUNT_PP'){
$blockmuni_office_query=$mysqli_countppds->prepare("SELECT office.officecd, office.office, office.address1, COUNT(personnela.personcd) FROM office INNER JOIN personnela ON office.officecd=personnela.officecd WHERE personnela.booked IN ('P','R') AND personnela.forsubdivision = ? GROUP BY office.officecd, office.office, office.address1 ORDER BY office.officecd") or die($mysqli_countppds->error);
}
else if($opt == 'COUNT_GRD'){
    $blockmuni_office_query=$mysqli_countgrdppds->prepare("SELECT office.officecd, office.office, office.address1, COUNT(personnela.personcd) FROM office INNER JOIN personnela ON office.officecd=personnela.officecd WHERE personnela.booked IN ('P','R') AND personnela.forsubdivision = ? GROUP BY office.officecd, office.office, office.address1 ORDER BY office.officecd") or die($mysqli_countgrdppds->error);
}
$blockmuni_office_query->bind_param("s",$subdiv) or die($blockmuni_office_query->error);
$blockmuni_office_query->execute() or die($blockmuni_office_query->error);
$blockmuni_office_query->bind_result($officecd,$office,$address1,$office_total) or die($blockmuni_office_query->error);

$blockmuni_office=array();

while($blockmuni_office_query->fetch()){
	$blockmuni_office[]=array("officecd"=>$officecd, "office"=>$office, "address1"=>$address1, "office_total"=>$office_total);
}
$blockmuni_office_query->close();

if($opt == 'COUNT_PP'){
$poststat_query=$mysqli_countppds->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnela.personcd) FROM (office INNER JOIN personnela ON office.officecd=personnela.officecd) INNER JOIN poststat ON poststat.post_stat=personnela.poststat WHERE personnela.booked IN ('P','R') AND personnela.forsubdivision = ? GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);
}
else if($opt == 'COUNT_GRD'){
    $poststat_query=$mysqli_countgrdppds->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnela.personcd) FROM (office INNER JOIN personnela ON office.officecd=personnela.officecd) INNER JOIN poststat ON poststat.post_stat=personnela.poststat WHERE personnela.booked IN ('P','R') AND personnela.forsubdivision = ? GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.post_stat, poststat.poststatus") or die($mysqli->error);
}
$poststat_query->bind_param("s",$subdiv) or die($poststat_query->error);
$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();
?>
<title>Counting Office Summary Print</title>
<h3>
    Counting Personnel Office Summary
</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>#</th>
            <th>Office Code</th>
            <th>Office Name</th>
            <th>Address</th>
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
            <th>Signature</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if($opt == 'COUNT_PP'){
        $blockmuni_office_booked_query=$mysqli_countppds->prepare("SELECT office.officecd, personnela.poststat, COUNT(personnela.personcd) FROM office INNER JOIN personnela ON office.officecd=personnela.officecd WHERE personnela.booked IN ('P','R') AND personnela.forsubdivision = ? GROUP BY office.officecd, personnela.poststat ORDER BY office.officecd, personnela.poststat") or die($mysqli->error);
        }
        else if($opt == 'COUNT_GRD'){
            $blockmuni_office_booked_query=$mysqli_countgrdppds->prepare("SELECT office.officecd, personnela.poststat, COUNT(personnela.personcd) FROM office INNER JOIN personnela ON office.officecd=personnela.officecd WHERE personnela.booked IN ('P','R') AND personnela.forsubdivision = ? GROUP BY office.officecd, personnela.poststat ORDER BY office.officecd, personnela.poststat") or die($mysqli->error);
        }
        $blockmuni_office_booked_query->bind_param("s",$subdiv) or die($blockmuni_office_booked_query->error);
        $blockmuni_office_booked_query->execute() or die($blockmuni_office_booked_query->error);
        $blockmuni_office_booked_query->bind_result($officecd,$post_stat_code,$pp_count) or die($blockmuni_office_booked_query->error);
        
        $report=array();
        $search_index=array();
        while($blockmuni_office_booked_query->fetch()){
            $report[]=array("officecd"=>$officecd, "PostStatCode"=>$post_stat_code, "office_post_total"=>$pp_count);
            $search_index[]=array("officecd"=>$officecd, "PostStatCode"=>$post_stat_code);
        }
        $blockmuni_office_booked_query->close();
        ?>
        <?php
	for($i=0;$i<count($blockmuni_office);$i++){
        ?>
	<tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $blockmuni_office[$i]['officecd']; ?></td>
            <td><?php echo $blockmuni_office[$i]['office']; ?></td>
            <td><?php echo $blockmuni_office[$i]['address1']; ?></td>
        <?php
            for($j=0;$j<count($poststat);$j++){
                $index=array_search(array("officecd"=>$blockmuni_office[$i]['officecd'],"PostStatCode"=>$poststat[$j]['PostStatCode']),$search_index);
                if($report[$index]['officecd'] == $blockmuni_office[$i]['officecd'] && $report[$index]['PostStatCode'] == $poststat[$j]['PostStatCode']){
                    echo "<td>".$report[$index]['office_post_total']."</td>";
                }
                else
                    echo "<td>0</td>";
            }
        ?>
            <td><?php echo $blockmuni_office[$i]['office_total']; ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4">Total</th>
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
        <tr>
            <th colspan="<?php echo count($poststat) + 7; ?>">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
    </tfoot>
</table>