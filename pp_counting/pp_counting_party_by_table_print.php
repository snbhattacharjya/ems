<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");

$opt=$_GET['opt'];
$subdiv=$_GET['subdiv'];

if($opt == 'COUNT_PP'){
$counting_pp_query=$mysqli_countppds->prepare("SELECT assembly.assemblycd, assembly.assemblyname, pollingstation.psno, pollingstation.psname, pollingstation.groupid FROM  pollingstation INNER JOIN assembly ON assembly.assemblycd = pollingstation.forassembly WHERE pollingstation.forsubdivision = ? ORDER BY assembly.assemblycd, pollingstation.psno") or die($mysqli_countppds->error);
}
else if($opt == 'COUNT_GRD'){
    $counting_pp_query=$mysqli_countgrdppds->prepare("SELECT personnela.personcd, personnela.officer_name, personnela.off_desg, office.officecd, office.office, office.address1, office.address2, poststat.poststatus, personnela.mob_no FROM (personnela INNER JOIN office ON personnela.officecd = office.officecd) INNER JOIN poststat ON personnela.poststat = poststat.post_stat WHERE personnela.booked IN ('P','R') AND personnela.forsubdivision = ? ORDER BY personnela.poststat, personnela.personcd") or die($mysqli_countgrdppds->error);
}
$counting_pp_query->bind_param("s",$subdiv) or die($counting_pp_query->error);
$counting_pp_query->execute() or die($counting_pp_query->error);
$counting_pp_query->bind_result($assemblycd,$assemblyname,$psno,$psname,$groupid) or die($counting_pp_query->error);

$return=array();

while($counting_pp_query->fetch()){
	$return[]=array("AssemblyCode"=>$assemblycd,"AssemblyName"=>$assemblyname,"PsNo"=>$psno,"PsName"=>$psname,"GroupID"=>$groupid);
}
$counting_pp_query->close();

?>
<title>Counting Personnel Attendance List</title>
<h3>
    Counting Personnel Attendance List
</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Assembly</th>
            <th>Table No</th>
            <th>Table Name</th>
            <th>Counting Party</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for($i = 0; $i < count($return); $i++){
        ?>
        <tr>
            <td><?php echo $return[$i]['AssemblyCode']." - ".$return[$i]['AssemblyName']; ?></td>
            <td><?php echo $return[$i]['PsNo']; ?></td>
            <td><?php echo $return[$i]['PsName']; ?></td>
            <td><?php echo $return[$i]['GroupID']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        
    </tfoot>
</table>