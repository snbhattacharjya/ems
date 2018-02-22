<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");


$counting_pp_query=$mysqli_countppds->prepare("SELECT personnela.officer_name, personnela.booked, personnela.forassembly, assembly.assemblyname, personnela.mob_no, personnela.groupid FROM personnela INNER JOIN assembly ON assembly.assemblycd = personnela.forassembly WHERE personnela.booked IN ('P','R') ORDER BY personnela.forassembly, personnela.booked, personnela.groupid") or die($mysqli_countppds->error);

$counting_pp_query->execute() or die($counting_pp_query->error);
$counting_pp_query->bind_result($officer_name,$booked,$forassembly,$assemblyname,$mobile,$groupid) or die($counting_pp_query->error);

$return=array();

while($counting_pp_query->fetch()){
	$return[]=array("OfficerName"=>$officer_name, "Booked"=>$booked, "AssemblyCode"=>$forassembly, "AssemblyName"=>$assemblyname, "Mobile"=>$mobile,  "GroupID"=>$groupid);
}
$counting_pp_query->close();

?>
<title>Counting Personnel SMS Data</title>
<h3>
    Counting Personnel SMS Data
</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Mobile Number</th>
            <th>Message</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for($i = 0; $i < count($return); $i++){
        ?>
        <tr>
            <th><?php echo ($i+1); ?></th>
            <td><?php echo $return[$i]['OfficerName']; ?></td>
            <td><?php echo $return[$i]['Mobile']; ?></td>
            <td>
                <?php
                if($return[$i]['Booked'] == 'P'){
                    echo "You have been appointed for ".$return[$i]['AssemblyCode']." - ".$return[$i]['AssemblyName']." AC in Party No. ".$return[$i]['GroupID']." for Counting Duty.";
                }
                else{
                    echo "You have been appointed for ".$return[$i]['AssemblyCode']." - ".$return[$i]['AssemblyName']." AC in Reserve No. ".$return[$i]['GroupID']." for Counting Duty.";
                }
                ?>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        
    </tfoot>
</table>