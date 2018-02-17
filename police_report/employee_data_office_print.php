<?php
session_start();
require("../config/config.php");

$officecd=$_GET['officecd'];
$pp_query=$mysqli->prepare("SELECT office.officecd, office.office, personnel.personcd, personnel.officer_name, personnel.off_desg, personnel.mob_no, personnel.dateofbirth, personnel.gender, personnel.bank_acc_no, personnel.branchname, personnel.branchcd, personnel.epic, personnel.partno, personnel.slno, personnel.acno FROM personnel INNER JOIN office ON office.officecd = personnel.officecd WHERE office.officecd = ? ORDER BY office.officecd, personnel.personcd") or die($mysqli->error);
$pp_query->bind_param("s",$officecd) or die($pp_query->error);
$pp_query->execute() or die($pp_query->error);
$pp_query->bind_result($officecd, $office, $personcd, $officer_name, $off_desg, $mob_no, $dateofbirth, $gender, $bank_acc_no, $branchname, $branchcd, $epic, $partno, $slno, $acno) or die($pp_query->error);
$pp_data=array();
while($pp_query->fetch()){
	$pp_data[]=array("officecd"=>$officecd, "office"=>$office, "personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "mob_no"=>$mob_no, "dateofbirth"=>$dateofbirth, "gender"=>$gender, "bank_acc_no"=>$bank_acc_no, "branchname"=>$branchname, "branchcd"=>$branchcd, "epic"=>$epic, "partno"=>$partno, "slno"=>$slno, "acno"=>$acno);
}
$pp_query->close();

?>
<html>
    <title>
        Police Personnel Office Report
    </title>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>#</th>
            <th>Office Code</th>
            <th>Office Name</th>
            <th>Employee Code</th>
            <th>Employee Name</th>
            <th>Designation</th>
            <th>Mobile</th>
            <th>Date of Birth</th>
            <th>Gender</th>
            <th>Bank Account No</th>
            <th>Branch Name</th>
            <th>IFSC</th>
            <th>AC No</th>
            <th>EPIC</th>
            <th>Part No</th>
            <th>Sl No</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $dist_total=0;
        for($i=0;$i<count($pp_data);$i++){
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $pp_data[$i]['officecd']; ?></td>
            <td><?php echo $pp_data[$i]['office']; ?></td>
            <td><?php echo $pp_data[$i]['personcd']; ?></td>
            <td><?php echo $pp_data[$i]['officer_name']; ?></td>
            <td><?php echo $pp_data[$i]['off_desg']; ?></td>
            <td><?php echo $pp_data[$i]['mob_no']; ?></td>
            <td><?php echo $pp_data[$i]['dateofbirth']; ?></td>
            <td><?php echo $pp_data[$i]['gender']; ?></td>
            <td><?php echo $pp_data[$i]['bank_acc_no']; ?></td>
            <td><?php echo $pp_data[$i]['branchname']; ?></td>
            <td><?php echo $pp_data[$i]['branchcd']; ?></td>
            <td><?php echo $pp_data[$i]['acno']; ?></td>
            <td><?php echo $pp_data[$i]['epic']; ?></td>
            <td><?php echo $pp_data[$i]['partno']; ?></td>
            <td><?php echo $pp_data[$i]['slno']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="16">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
    </tfoot>
</table>