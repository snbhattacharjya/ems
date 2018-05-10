<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$block_muni_code = $_GET['code'];
$block_muni_name = $_GET['block_name'];

$counitng_personnel_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, office.officecd, office.office, office.address1, office.address2, personnel.mob_no, personnel.scale, personnel.basic_pay, personnel.grade_pay, personnel.emp_group, remarks.remarks, present_addr1, present_addr2, perm_addr1, perm_addr2, DATE_FORMAT(dateofbirth,'%d-%m-%Y') FROM (personnel INNER JOIN office ON personnel.officecd = office.officecd) INNER JOIN remarks ON personnel.remarks = remarks.remarks_cd WHERE office.blockormuni_cd = ? AND personnel.gender = 'M' AND personnel.remarks NOT IN ('05','91','94','96','97') AND DATE_FORMAT(personnel.posted_date,'%Y') = 2018 ORDER BY personnel.personcd") or die($mysqli->error);

$counitng_personnel_query->bind_param("s",$block_muni_code) or die($counitng_personnel_query->error);

$counitng_personnel_query->execute() or die($counitng_personnel_query->error);
$counitng_personnel_query->bind_result($personcd,$officer_name,$off_desg,$officecd,$office_name,$address1,$address2,$mobile,$scale,$basic_pay,$grade_pay,$group,$remarks,$present_addr1,$present_addr2,$perm_addr1,$perm_addr2,$dob) or die($counitng_personnel_query->error);
$return=array();
while($counitng_personnel_query->fetch())
{
	$return[]=array("PersonID"=>$personcd,"OfficerName"=>$officer_name,"Designation"=>$off_desg,"OfficeID"=>$officecd,"OfficeName"=>$office_name,"Address1"=>$address1,"Address2"=>$address2,"Mobile"=>$mobile, "ScaleOfPay"=>$scale, "BasicPay"=>$basic_pay, "GradePay"=>$grade_pay, "Group"=>$group, "Remarks"=>$remarks, "PresentAddr1"=>$present_addr1, "PresentAddr1"=>$present_addr2, "PermAddr1"=>$perm_addr1, "PermAddr2"=>$perm_addr2, "Dob"=>$dob);
}
?>
<html>
    <title>
        Counting Personnel List
    </title>
    <table border="1" cellpadding="5" cellspacing="0" width="100%" style="font-size: 14">
    <thead>
        <tr>
            <th colspan="16">
                Counting Personnel List for Block - <strong><?php echo $block_muni_name; ?></strong>
            </th>
        </tr>
        <tr>
            <th>#</th>
            <th>Person ID</th>
            <th>Officer Name</th>
            <th>Designation</th>
            <th>Group</th>
            <th>Scale of Pay</th>
            <th>Basic Pay</th>
            <th>Grade Pay</th>
            <th>Present Addr 1</th>
            <th>Present Addr 2</th>
            <th>Permanent Addr 1</th>
            <th>Permanent Addr 2</th>
            <th>Date of Birth</th>
            <th>Office</th>
            <th>Mobile</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for($i = 0; $i < count($return); $i++){
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $return[$i]['PersonID']; ?></td>
            <td><?php echo $return[$i]['OfficerName']; ?></td>
            <td><?php echo $return[$i]['Designation']; ?></td>
            <td><?php echo $return[$i]['Group']; ?></td>
            <td><?php echo $return[$i]['ScaleOfPay']; ?></td>
            <td><?php echo $return[$i]['BasicPay']; ?></td>
            <td><?php echo $return[$i]['GradePay']; ?></td>
            <td><?php echo $return[$i]['PresentAddr1']; ?></td>
            <td><?php echo $return[$i]['PresentAddr2']; ?></td>
            <td><?php echo $return[$i]['PermAddr1']; ?></td>
            <td><?php echo $return[$i]['PermAddr1']; ?></td>
            <td><?php echo $return[$i]['Dob']; ?></td>
            <td><?php echo $return[$i]['OfficeName']." - ".$return[$i]['Address1'].", ".$return[$i]['Address2']." (".$return[$i]['OfficeID'].")"; ?></td>
            <td><?php echo $return[$i]['Mobile']; ?></td>
            <td><?php echo $return[$i]['Remarks']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <!--<tfoot>
        <tr>
            <td colspan="7">
                <strong>Signature of Training Official:-</strong>
            </td>
        </tr>
    </tfoot>-->
</table>
</html>
