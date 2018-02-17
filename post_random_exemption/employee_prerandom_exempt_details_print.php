<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
$user_id=$_SESSION['UserID'];
require("../config/config.php");

$employee_exempt_query="SELECT office.officecd, office.office, personnel_exempt.personcd, personnel_exempt.officer_name, personnel_exempt.off_desg, personnel_exempt.mob_no, remarks.remarks, personnel_exempt_marked.reason FROM ((office INNER JOIN personnel_exempt ON office.officecd = personnel_exempt.officecd) INNER JOIN remarks ON personnel_exempt.remarks = remarks.remarks_cd) INNER JOIN personnel_exempt_marked ON personnel_exempt.personcd = personnel_exempt_marked.personcd ORDER BY office.officecd, personnel_exempt.officer_name";

$employee_exempt_result=mysql_query($employee_exempt_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($employee_exempt_result))
{
	$return[]=$row;
}	
?>
<html>
    <title>
        Employee Exemption List
    </title>
    <body>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <?php
                if($exempt_date != "ALL"){
                ?>
                <tr>
                    <th colspan="9">
                        Exemptions Processed on <?php echo date_format(date_create($exempt_date),"d-M-Y"); ?>
                    </th>
                </tr>
                <?php
                }
                else{
                ?>
                <tr>
                    <th colspan="9">
                        Total Exemptions Processed as on <?php echo date("d-M-Y"); ?>
                    </th>
                </tr>
                <?php
                }
                ?>
                <tr class="bg-light-blue-gradient">
                    <th>#</th>
                    <th>Office ID</th>
                    <th>Office Name</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Designation</th>
                    <th>Mobile</th>
                    <th>Remarks</th>
                    <th>Reason for Exemption</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for($i=0; $i<count($return);$i++){
                ?>
                <tr>
                    <td><?php echo ($i+1); ?></td>
                    <td><?php echo $return[$i]['officecd']; ?></td>
                    <td><?php echo $return[$i]['office']; ?></td>
                    <td><?php echo $return[$i]['personcd']; ?></td>
                    <td><?php echo $return[$i]['officer_name']; ?></td>
                    <td><?php echo $return[$i]['off_desg']; ?></td>
                    <td><?php echo $return[$i]['mob_no']; ?></td>
                    <td><?php echo $return[$i]['remarks']; ?></td>
                    <td><?php echo $return[$i]['reason']; ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr class="danger">
                    <th colspan="9">
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

