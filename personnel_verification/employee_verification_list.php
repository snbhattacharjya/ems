<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$officecd=$_POST['officecd'];

$emp_query="SELECT personcd, officer_name, gender, off_desg, mob_no, epic, acno, partno, slno, bank.bank_name, branchname, branchcd, bank_acc_no FROM personnel INNER JOIN bank ON personnel.bank_cd = bank.bank_cd WHERE officecd ='$officecd'";
$emp_result=mysql_query($emp_query,$DBLink) or die(mysql_error());
?>
<table border="1" width="100%">
    <tr>
        <th>Sl No</th>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th>Gender</th>
        <th>Designation</th>
        <th>Mobile No</th>
        <th>EPIC</th>
        <th>AC No</th>
        <th>Part No</th>
        <th>Serial No</th>
        <th>Bank</th>
        <th>Branch</th>
        <th>IFSC</th>
        <th>Bank Account No</th>
    </tr>
    <?php
    $count=1;
    while($row=mysql_fetch_assoc($emp_result))
    {
    ?>
    <tr>
        <td><?php echo $count++; ?></td>
        <td><?php echo $row['personcd']; ?></td>
        <td><?php echo $row['officer_name']; ?></td>
        <td><?php echo $row['gender']; ?></td>
        <td><?php echo $row['off_desg']; ?></td>
        <td><?php echo $row['mob_no']; ?></td>
        <td><?php echo $row['epic']; ?></td>
        <td><?php echo $row['acno']; ?></td>
        <td><?php echo $row['partno']; ?></td>
        <td><?php echo $row['slno']; ?></td>
        <td><?php echo $row['bank_name']; ?></td>
        <td><?php echo $row['branchname']; ?></td>
        <td><?php echo $row['branchcd']; ?></td>
        <td><?php echo $row['bank_acc_no']; ?></td>
    </tr>
    <?php
    }
    ?>
</table>

