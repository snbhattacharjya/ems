<?php
session_start();
$user_id=$_SESSION['UserID'];
$block_code=substr($user_id,3,6);
if(isset($_SESSION['Subdiv']))
{
    $subdiv=$_SESSION['Subdiv'];
}

require("../config/config.php");

if(substr($user_id,0,3) == 'SDO'){
    $office_blockmuni_query="SELECT office.officecd, office.office, CONCAT(office.address1,', ',office.address2) AS address, office.phone, office.mobile, office.tot_staff AS pp1_count, COUNT(personnel.personcd) AS pp2_count, COUNT(personnel_exempt_post_random.personcd) AS exempt_count FROM (office INNER JOIN personnel ON office.officecd = personnel.officecd) INNER JOIN personnel_exempt_post_random ON personnel.personcd = personnel_exempt_post_random.personcd WHERE office.subdivisioncd='$subdiv' GROUP BY office.officecd, office.office, CONCAT(office.address1,', ',office.address2), office.phone, office.mobile, office.tot_staff ORDER BY office.officecd";
}

else if(substr($user_id,0,3) == 'BDO'){
	$office_blockmuni_query="SELECT office.officecd, office.office, CONCAT(office.address1,', ',office.address2) AS address, office.phone, office.mobile, office.tot_staff AS pp1_count, COUNT(personnel.personcd) AS pp2_count, COUNT(personnel_exempt_post_random.personcd) AS exempt_count FROM (office INNER JOIN personnel ON office.officecd = personnel.officecd) INNER JOIN personnel_exempt_post_random ON personnel.personcd = personnel_exempt_post_random.personcd WHERE office.subdivisioncd='$subdiv' AND office.blockormuni_cd='$block_code' GROUP BY office.officecd, office.office, CONCAT(office.address1,', ',office.address2), office.phone, office.mobile, office.tot_staff ORDER BY office.officecd";
}

else {
    $office_blockmuni_query="SELECT office.officecd, office.office, CONCAT(office.address1,', ',office.address2) AS address, office.phone, office.mobile, office.tot_staff AS pp1_count, COUNT(personnel.personcd) AS pp2_count, COUNT(personnel_exempt_post_random.personcd) AS exempt_count FROM (office INNER JOIN personnel ON office.officecd = personnel.officecd) INNER JOIN personnel_exempt_post_random ON personnel.personcd = personnel_exempt_post_random.personcd GROUP BY office.officecd, office.office, CONCAT(office.address1,', ',office.address2), office.phone, office.mobile, office.tot_staff ORDER BY office.officecd";
}
$office_blockmuni_result=mysqli_query($DBLink,$office_blockmuni_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($office_blockmuni_result))
{
	$return[]=$row;
}
?>
<html>
    <title>
        Office Exemption Summary
    </title>
    <body>
        <h3>
            Post Randomisation Office wise Exemption Summary
        </h3>
        <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr class="bg-light-blue-gradient">
                        <th>#</th>
                        <th>Office ID</th>
                        <th>Office Name</th>
                        <th>Address</th>
                        <th>Contact No</th>
                        <th>Mobile No</th>
                        <th>Marked for Exemption</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dist_total=0;
                    for($i=0; $i<count($return);$i++){
                    ?>
                    <tr>
                        <td><?php echo ($i+1); ?></td>
                        <td><?php echo $return[$i]['officecd']; ?></td>
                        <td><?php echo $return[$i]['office']; ?></td>
                        <td><?php echo $return[$i]['address']; ?></td>
                        <td><?php echo $return[$i]['phone']; ?></td>
                        <td><?php echo $return[$i]['mobile']; ?></td>
                        <td><?php echo $return[$i]['exempt_count']; ?></td>
                    </tr>
                    <?php
                        $dist_total+=$return[$i]['exempt_count'];
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6">
                            Total
                        </th>
                        <th><?php echo $dist_total; ?></th>
                    </tr>
                    <tr>
                        <th colspan="7">
                            <?php
                                date_default_timezone_set("Asia/Kolkata");
                                echo "Report Compiled as on: ".date("d-M-Y H:i:s A");
                            ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
    </body>
</html>
