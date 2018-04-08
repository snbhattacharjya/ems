<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");

$blockmuni_param=$_GET['blockmuni'];

$blockmuni_office_query=$mysqli->prepare("SELECT office.officecd, office.office, office.address1, COUNT(personnel.personcd) FROM office INNER JOIN personnel ON office.officecd=personnel.officecd WHERE office.blockormuni_cd = ? AND personnel.poststat IN ('PR','P1','P2','P3','PA') AND personnel.booked IN ('P','R') GROUP BY office.officecd, office.office, office.address1 ORDER BY office.officecd") or die($mysqli->error);
$blockmuni_office_query->bind_param("s",$blockmuni_param) or die($blockmuni_office_query->error);
$blockmuni_office_query->execute() or die($blockmuni_office_query->error);
$blockmuni_office_query->bind_result($officecd,$office,$address1,$office_total) or die($blockmuni_office_query->error);

$blockmuni_office=array();

while($blockmuni_office_query->fetch()){
	$blockmuni_office[]=array("officecd"=>$officecd, "office"=>$office, "address1"=>$address1, "office_total"=>$office_total);
}
$blockmuni_office_query->close();

$poststat_query=$mysqli->prepare("SELECT poststat.post_stat, poststat.poststatus, COUNT(personnel.personcd) FROM (office INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN poststat ON poststat.post_stat=personnel.poststat WHERE personnel.poststat IN ('PR','P1','P2','P3','PA') AND personnel.booked IN ('P','R') AND office.blockormuni_cd = ? GROUP BY poststat.post_stat, poststat.poststatus ORDER BY poststat.poststat_order, poststat.poststatus") or die($mysqli->error);
$poststat_query->bind_param("s",$blockmuni_param) or die($poststat_query->error);
$poststat_query->execute() or die($poststat_query->error);
$poststat_query->bind_result($post_stat_code,$post_stat_name,$post_stat_total) or die($poststat_query->error);
$poststat=array();
?>
<title>Appointment Office Summary Print</title>

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
        </tr>
    </thead>
    <tbody>
        <?php
        $blockmuni_office_booked_query=$mysqli->prepare("SELECT office.officecd, personnel.poststat, COUNT(personnel.personcd) FROM office INNER JOIN personnel ON office.officecd=personnel.officecd WHERE office.blockormuni_cd = ? AND personnel.poststat IN ('PR','P1','P2','P3','PA') AND personnel.booked IN ('P','R') GROUP BY office.officecd, personnel.poststat ORDER BY office.officecd, personnel.poststat") or die($mysqli->error);
        $blockmuni_office_booked_query->bind_param("s",$blockmuni_param) or die($blockmuni_office_booked_query->error);
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
        </tr>
        <tr>
            <th colspan="<?php echo count($poststat) + 6; ?>">
                <?php
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A");
                ?>
            </th>
    </tfoot>
</table>
